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
		$template = new Template(dirname(__FILE__) . '/NotesPanel.phtml');
		$template->registerFilter(new LatteFilter());

		return $template;
	}

	public function getTab() {
		$count = $this->model->getCount();

		return '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0
U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAGGSURBVDjLxZO/alRBFMZ/c6MmomKhBLv4
AIJiYekjCFopKSzyCnkGW99BbMTOQhsrBcFKsLCJhRYBNYYsWXNn5s6Z81nMGu+626XwFDOHge/P
mfkmSOIk1XHCOvWn0ZdXsulPpAFZQbUgG5BlVDOURLWELEJJXLz3JMwTVOP0tfsLChIEmC2A4OD5
g0UHebLLWQl5bAcBJAcC4i9D6FZRiUtGMMOHb9j0PXhGGtruA3hCnpBHzly+i5d+CUHNgCFPoDID
jcEJeQ8yNCxxYL/2m+U55Yh7mpFE8NhE7GiRwGsi7bzF8meoA8io6ZC1jfWm7AnVCPLld1DjPna4
y/kbm4Djw1emH56h2oN6VFNzIKOOCI6DFCTKj48cvN6m9jtQC64yAjcXrjrnoBu/94VbDymTPSZv
Hs/A6RgsT0gZqC1M/46AJcJKx7mbW8RPL5m+e8HKpeusXbmNI1AFDHBkmZHzFpO9p3fkJSNLqEQs
fgc6uhCQJRgy7qlF2ypXHynMEfy33/gbubc6XKsT2+MAAAAASUVORK5CYII=" />Notes (' . $count . ')';
	}

	public function setModel(INotesPanelModel $model) {
		$this->model = $model;
	}
	
}
