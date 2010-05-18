<?php

/**
 * Description of NotesPanel
 *
 * @author Ondřej Brejla
 */
class NotesPanel extends Object implements IDebugPanel {

	/** @var INotesPanelModel */
	private $model = NULL;

	public function  __construct() {
		$this->model = new NotesPanelModel();
	}

	public function getId() {
		return __CLASS__;
	}

	public function getPanel() {

	}

	public function getTab() {
		return 'Notes (' . $this->model->getCount() . ')';
	}

	public function setModel(INotesPanelModel $model) {
		$this->model = $model;
	}
	
}
