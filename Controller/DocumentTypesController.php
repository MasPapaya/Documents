<?php

App::uses('AppController', 'Controller');

/**
 * DocumentTypes Controller
 *
 * @property DocumentType $DocumentType
 */
class DocumentTypesController extends DocumentsAppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->DocumentType->recursive = 0;
		$this->set('documentTypes', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->DocumentType->exists($id)) {
			throw new NotFoundException(__('Invalid document type'), 'flash/warning');
		}
		$options = array('conditions' => array('DocumentType.' . $this->DocumentType->primaryKey => $id));
		$this->set('documentType', $this->DocumentType->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->DocumentType->create();
			if ($this->DocumentType->save($this->request->data)) {
				$this->Session->setFlash(__('The document type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The document type could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$entities = $this->DocumentType->Entity->find('list');
		$this->set(compact('entities'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (!$this->DocumentType->exists($id)) {
			throw new NotFoundException(__('Invalid document type'), 'flash/warning');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->DocumentType->save($this->request->data)) {
				$this->Session->setFlash(__('The document type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The document type could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$options = array('conditions' => array('DocumentType.' . $this->DocumentType->primaryKey => $id));
			$this->request->data = $this->DocumentType->find('first', $options);
		}
		$entities = $this->DocumentType->Entity->find('list');
		$this->set(compact('entities'));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->DocumentType->id = $id;
		if (!$this->DocumentType->exists()) {
			throw new NotFoundException(__('Invalid document type'), 'flash/warning');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DocumentType->delete()) {
			$this->Session->setFlash(__('Document type deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Document type was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

}
