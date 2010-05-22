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
 * Interface for the NotesPanel models.
 *
 * @author Ondřej Brejla <ondrej@brejla.cz>
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

