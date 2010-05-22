<?php

/**
 * Description of NotesPanelModel
 *
 * @author Ondřej Brejla
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

		//$this->cache = Environment::getCache(self::CACHE_NAMESPACE);
	}

	public function add($pageId, $description) {
		$this->db->insert('notes', array(
			'page_id' => $pageId,
			'description' => $description,
		))->execute();
/*
		$this->cache->clean(array(
			Cache::ALL => TRUE,
		));*/
	}

	public function get($pageId = NULL) {
		if (is_null($pageId)) {
			/*
			if (!isset($this->cache['getAll'])) {
				$this->cache['getAll'] = $this->db->select('id, description, page_id')->from('notes')->fetchAll();
			}

			return $this->cache['getAll'];*/
			return $this->db->select('id, description, page_id')->from('notes')->fetchAll();
		} else {
			/*if (!isset($this->cache['getCurrent'])) {
				$this->cache['getCurrent'] = $this->db->select('id, description')->from('notes')->where('page_id LIKE %s', $pageId)->fetchAll();
			}*/

			//return $this->cache['getCurrent'];
			return $this->db->select('id, description')->from('notes')->where('page_id LIKE %s', $pageId)->fetchAll();
		}
	}
	
	public function delete($noteId = NULL) {
		if (is_null($noteId)) {
			$this->db->delete('notes')->execute();
		} else {
			$this->db->delete('notes')->where('id = %i', $noteId)->execute();
		}

	}

	public function getCount($pageId = NULL) {
		$fluent = $this->db->select('COUNT(*)')->from('notes');
		
		if (is_null($pageId)) {/*
			if (!isset($this->cache['getCountAll'])) {
				$this->cache['getCountAll'] = $fluent->fetchSingle();
			}

			return $this->cache['getCountAll'];*/
			return $fluent->fetchSingle();
		} else {/*
			if (!isset($this->cache['getCountCurrent'])) {
				$this->cache['getCountCurrent'] = $fluent->where('page_id LIKE %s', $pageId)->fetchSingle();
			}

			return $this->cache['getCountCurrent'];*/
			return $fluent->where('page_id LIKE %s', $pageId)->fetchSingle();
		}
	}

}
