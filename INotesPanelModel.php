<?php

/**
 * Description of INotesPanelModel
 *
 * @author Ondřej Brejla
 */
interface INotesPanelModel {

	public function add($pageId, $description);

	public function get($pageId = NULL);

	public function delete($noteId = NULL);

	public function getCount($pageId = NULL);

}

