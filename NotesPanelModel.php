<?php

/**
 * Copyright (c) 2010 Ondřej Brejla <ondrej@brejla.cz>
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * Model for the NotesPanel.
 *
 * @author Ondřej Brejla <ondrej@brejla.cz>
 */
class NotesPanelModel implements INotesPanelModel {

	/** @var string */
	const CACHE_NAMESPACE = 'NotesPanel';

	/** @var DibiConnection */
	private $db = NULL;

	/** @var Cache */
	private $cache = NULL;

	public function __construct() {
		$this->db = new DibiConnection(array(
			'driver' => 'sqlite3',
			'database' => dirname(__FILE__) . '/notes-panel.sdb',
		));

		$this->cache = Environment::getCache(self::CACHE_NAMESPACE);
	}

	/**
	 * @see INotesPanelModel::add($pageId, $description)
	 */
	public function add($pageId, $description) {
		$this->db->insert('notes', array(
			'page_id' => $pageId,
			'description' => $description,
		))->execute();

		$this->cleanCache($pageId);
	}

	/**
	 * @see INotesPanelModel::get($pageId)
	 */
	public function get($pageId = NULL) {
		if (is_null($pageId)) {
			
			if (!isset($this->cache['getAll'])) {
				$this->cache['getAll'] = $this->db->select('id, description, page_id')->from('notes')->fetchAll();
			}

			return $this->cache['getAll'];
		} else {
			if (!isset($this->cache['getCurrent-' . $pageId])) {
				$this->cache['getCurrent-' . $pageId] = $this->db->select('id, description')->from('notes')->where('page_id LIKE %s', $pageId)->fetchAll();
			}

			return $this->cache['getCurrent-' . $pageId];
		}
	}

	/**
	 * @see INotesPanelModel::delete($noteId)
	 */
	public function delete($noteId = NULL) {
		if (is_null($noteId)) {
			$this->db->delete('notes')->execute();
		} else {
			$this->db->delete('notes')->where('id = %i', $noteId)->execute();
		}

		$this->cleanCache();
	}

	/**
	 * @see INotesPanelModel::getCount($pageId)
	 */
	public function getCount($pageId = NULL) {
		$fluent = $this->db->select('COUNT(*)')->from('notes');
		
		if (is_null($pageId)) {
			if (!isset($this->cache['getCountAll'])) {
				$this->cache['getCountAll'] = $fluent->fetchSingle();
			}

			return $this->cache['getCountAll'];
		} else {
			if (!isset($this->cache['getCountCurrent-' . $pageId])) {
				$this->cache['getCountCurrent-' . $pageId] = $fluent->where('page_id LIKE %s', $pageId)->fetchSingle();
			}

			return $this->cache['getCountCurrent-' . $pageId];
		}
	}

	/**
	 * Cleans cache.
	 *
	 * @param mixed $pageId
	 */
	private function cleanCache($pageId = NULL) {
		if (is_null($pageId)) {
			$this->cache->clean(array(
				Cache::ALL => TRUE,
			));
		} else {
			unset($this->cache['getAll']);
			unset($this->cache['getCountAll']);
			unset($this->cache['getCurrent-' . $pageId]);
			unset($this->cache['getCountCurrent-' . $pageId]);
		}
	}

}
