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
 * Panel for the Nette DebugBar. It allows you to write notes for each site of your web pages.
 *
 * @author Ondřej Brejla <ondrej@brejla.cz>
 */
class NotesPanel extends Control implements IDebugPanel {

	/** @var INotesPanelModel */
	private $model = NULL;

	/** @var IHttpRequest */
	private $httpRequest = NULL;

	/** @var Texy */
	private $texy = NULL;

	/**
	 * Adds NotesPanel into DebugBar.
	 */
	public function register() {
		Debug::addPanel($this);
	}

	/**
	 * Factory for creation of insert form.
	 *
	 * @return AppForm
	 */
	public function createComponentInsertForm() {
		$form = new AppForm();

		$renderer = $form->getRenderer();
		$renderer->wrappers['controls']['container'] = '';
		$renderer->wrappers['pair']['container'] = 'div';
		$renderer->wrappers['control']['container'] = '';
		$renderer->wrappers['label']['container'] = 'div';

		$form->addTextArea('description', 'Description:', 80, 3);
		$form->addHidden('pageId');
		$form->addSubmit('insert', 'Add note');

		$form->setDefaults(array(
			'pageId' => (string) $this->getHttpRequest()->getUri(),
		));

		$form->onSubmit[] = callback($this, 'insertFormSubmitted');

		return $form;
	}

	/**
	 * Insert form onSubmit[] callback.
	 *
	 * @param AppForm $form
	 */
	public function insertFormSubmitted(AppForm $form) {
		$values = $form->getValues();

		$this->getModel()->add($values['pageId'], $values['description']);

		$this->redirect('this');
	}

	/**
	 * Processing of delete signal.
	 *
	 * @param int $noteId
	 */
	public function handleDelete($noteId = NULL) {
		$this->getModel()->delete($noteId);

		$this->redirect('this');
	}

	/**
	 * @see IDebugPanel::getId()
	 */
	public function getId() {
		return __CLASS__;
	}

	/**
	 * @see IDebugPanel::getPanel()
	 */
	public function getPanel() {
		$template = $this->createTemplate();
		$template->setFile(dirname(__FILE__) . '/NotesPanel.panel.phtml');

		if (!is_null($this->texy)) {
			$template->registerHelper('texy', callback($this->texy, 'process'));
			$template->isTexy = TRUE;
		} else {
			$template->isTexy = FALSE;
		}
		
		$template->currentNotes = $this->getModel()->get((string) $this->getHttpRequest()->getUri());
		$template->allNotes = $this->getModel()->get();

		return $template;
	}

	/**
	 * @see IDebugPanel::getTab()
	 */
	public function getTab() {
		$template = $this->createTemplate();
		$template->setFile(dirname(__FILE__) . '/NotesPanel.tab.phtml');

		$template->currentCount = $this->getModel()->getCount((string) $this->getHttpRequest()->getUri());
		$template->allCount = $this->getModel()->getCount();

		return $template;
	}

	/**
	 * Sets model.
	 *
	 * @param INotesPanelModel $model
	 */
	public function setModel(INotesPanelModel $model) {
		$this->model = $model;
	}

	/**
	 * Returns model.
	 *
	 * @return INotesPanelModel
	 */
	private function getModel() {
		if (is_null($this->model)) {
			$this->model = new NotesPanelModel();
		}

		return $this->model;
	}

	/**
	 * Sets http request.
	 *
	 * @param IHttpRequest $httpRequest
	 */
	public function setHttpRequest(IHttpRequest $httpRequest) {
		$this->httpRequest = $httpRequest;
	}

	/**
	 * Returns http request.
	 *
	 * @return IHttpRequest
	 */
	private function getHttpRequest() {
		if (is_null($this->httpRequest)) {
			throw new InvalidStateException('No HttpRequest. HttpRequest was not set.');
		}

		return $this->httpRequest;
	}

	/**
	 * Sets Texy!.
	 *
	 * @param Texy $texy
	 */
	public function setTexy(Texy $texy) {
		$this->texy = $texy;
	}
	
}
