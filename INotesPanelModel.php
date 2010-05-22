<?php

/**
 * Description of INotesPanelModel
 *
 * @author Ondřej Brejla
 */
interface INotesPanelModel {

	/**
	 * Adds note.
	 *
	 * @param mixed $pageId
	 * @param string $description
	 */
	public function add($pageId, $description);

	/**
	 * Returns all notes. When $pageId is specified, notes for a specified page are returned.
	 *
	 * @param mixed $pageId
	 */
	public function get($pageId = NULL);

	/**
	 * Deletes all notes. When $noteId is specified, a specified note is deleted.
	 *
	 * @param mixed $noteId
	 */
	public function delete($noteId = NULL);

	/**
	 * Returns count of all notes. When $pageId is specified, count for a specified page is returned.
	 *
	 * @param mixed $pageId
	 */
	public function getCount($pageId = NULL);

}

