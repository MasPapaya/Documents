<?php

App::uses('AppController', 'Controller');

/**
 * Documents Controller
 *
 * @property Document $Document
 */
class DocumentsController extends DocumentsAppController {

	public function beforeFilter() {
		parent::beforeFilter();
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index($document_type_id = null, $parent_entityid = null) {

		if (is_null($parent_entityid) && !is_numeric($parent_entityid)) {
			throw new MethodNotAllowedException();
			return false;
		}
		$this->loadModel('DocumentType');
		$this->DocumentType->recursive = 0;
		$documentType = $this->DocumentType->read(NULL, $document_type_id);
		$this->set(compact('documentType'));

		if (!$documentType['DocumentType']['is_multiple']) {
			$this->Language->recursive = 0;
			$count_language = $this->Language->find('count');

			$count_documents = $this->Document->find('count', array(
				'conditions' => array(
					'Document.document_type_id' => $document_type_id,
					'Document.parent_entityid' => $parent_entityid,
					'Document.deleted' => Configure::read('zero_datetime'),
				)));

			if ($count_language == $count_documents) {
				$this->set('disable_button', true);
			}
		}


		$conditions = array(
			'Document.deleted' => Configure::read('zero_datetime'),
			'Document.document_type_id' => $document_type_id
		);
		if ($this->authuser['Group']['name'] != 'superadmin') {
			$conditions['Document.parent_entityid'] = $parent_entityid;
			if ($documentType['DocumentType']['use_user_id'] === TRUE) {
				$conditions['Document.user_id'] = $this->authuser['id'];
			}
		}
		$this->paginate = array(
			'limit' => '10',
			'order' => array('Document.id' => 'desc'),
			'conditions' => $conditions,
		);

		if (CakePlugin::loaded('Resources')) {
			$this->helpers[] = 'Resources.Frame';
		}

		$this->Document->recursive = 1;
		$this->set('documents', $this->paginate());

		$this->set(compact('document_type_id', 'parent_entityid'));
	}

	public function admin_index_detail($document_type_id = NULL) {
		$this->loadModel('DocumentType');
		if (!$this->DocumentType->exists($document_type_id)) {
			throw new NotFoundException(__('Invalid document type'), 'flash/warning');
		}

		$this->set('document_type', $this->DocumentType->read(null, $document_type_id));

		$this->paginate = array(
			'limit' => '10',
			'order' => array('Document.id' => 'desc'),
			'conditions' => array(
				'Document.deleted ' => Configure::read('zero_datetime'),
				'Document.document_type_id' => $document_type_id
			),
		);
		$this->set('documents', $this->paginate());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null, $parent_entityid = null) {
		$this->Document->recursive = 1;
		$this->Document->id = $id;
		if (!$this->Document->exists()) {
			throw new NotFoundException(__('Invalid document'));
		}

		$this->set('document', $this->Document->read(null, $id));
		$this->set(compact('parent_entityid'));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add($document_type_id = null, $parent_entityid = null) {
		$this->loadModel('DocumentType');
		$this->DocumentType->bindModel(
			array(
				'belongsTo' => array('Entity')
			)
		);
		$this->DocumentType->recursive = 1;
		$documentType = $this->DocumentType->read(NULL, $document_type_id);
		if (!empty($documentType)) {
			$this->loadModel('Language');
			$list_document = $this->Document->find('list', array(
				'fields' => array('Document.language_id'),
				'group' => array('Document.language_id'),
				'conditions' => array('Document.document_type_id' => $document_type_id, 'Document.parent_entityid' => $parent_entityid),
				'Document.deleted ' => Configure::read('zero_datetime'),
				));
			$conditions_language=array();
			foreach ($list_document as $document) {
				$conditions_language[] = 'Language.id != ' . $document;
			}

			$languages = $this->Language->find('list', array(
				'conditions' => $conditions_language
				));
			if (!empty($this->request->data)) {
				if ($documentType['DocumentType']['use_user_id'] === TRUE) {
					$this->request->data['Document']['user_id'] = $this->authuser['id'];
				}
				$this->request->data['Document']['document_type_id'] = $document_type_id;
				$this->request->data['Document']['published'] = Configure::read('zero_datetime');
				$this->request->data['Document']['deleted'] = Configure::read('zero_datetime');
				$this->Document->create();
				$this->Document->set($this->request->data);
				if ($this->Document->save($this->request->data)) {
					$this->Session->setFlash(__('The document has been saved'), 'flash/success');
					$this->redirect(array('action' => 'admin_index', $document_type_id, $parent_entityid));
				} else {
					$this->Session->setFlash(__('The document could not be saved. Please, try again.'), 'flash/error');
				}
			}

			$this->set(compact('languages'));
		} else {
			throw new NotFoundException(__('DocumentType not defined'));
		}

		if ($this->authuser['Group']['name'] == 'superadmin') {
			$this->loadModel('User');
			$this->set('users', $this->User->find('list', array(
					'fields' => array('User.username', 'User.username'),
					'recursive' => 0,
					'conditions' => array('User.deleted' => '0000-00-00 00:00:00', 'User.activated !=' => '0000-00-00 00:00:00', 'User.banned' => '0000-00-00 00:00:00')
				)));
		}


		$this->set(compact('documentType'));
		$this->set(compact('document_type_id', 'parent_entityid'));
	}

	/**
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null, $document_type_id = null, $parent_entityid = null) {
		if ($this->request->is('ajax')) {

			$this->Document->id = $id;
			if (!$this->Document->exists()) {
				throw new NotFoundException(__('Invalid document'));
			}

			$document = $this->Document->read(null, $id);
			if ($this->authuser['Group']['name'] != 'superadmin') {
				if ($document['DocumentType']['use_user_id'] === TRUE) {
					if ($document['Document']['user_id'] != $this->authuser['id']) {
						$this->Session->setFlash(__('Upss'), 'flash/success');
						//$this->redirect(array('plugin' => 'accounts', 'controller' => 'Users', 'action' => 'welcome', 'admin' => false), null, true);
						$this->set('error', 'intruder');
					}
				}
			}

			if ($this->request->is('post') || $this->request->is('put')) {
				if ($this->Document->save($this->request->data)) {
					$this->Session->setFlash(__('The document has been saved'), 'flash/success');
					$this->redirect(array('action' => 'index', $document_type_id, $parent_entityid));
				} else {
					$this->Session->setFlash(__('The document could not be saved. Please, try again.'), 'flash/error');
				}
			} else {
				$this->request->data = $document;
			}

			$languages = $this->Document->Language->find('list');

			if ($this->authuser['Group']['name'] == 'superadmin') {
				$this->loadModel('User');
				$this->set('users', $this->User->find('list', array(
						'fields' => array('User.username', 'User.username'),
						'recursive' => 0,
						'conditions' => array('User.deleted' => '0000-00-00 00:00:00', 'User.activated !=' => '0000-00-00 00:00:00', 'User.banned' => '0000-00-00 00:00:00')
					)));
			}

			$this->set(compact('document'));
			$this->set(compact('document_type_id', 'parent_entity_id', 'id', 'languages'));
//			$this->set(compact('documentTypes'));
		} else {
			throw new NotFoundException(__('Expected ajax request'));
		}
	}

	public function admin_empty() {
		
	}

	/**
	 * admin_delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null, $entity = null, $parent_entityid = null) {
//		if (!$this->request->is('post')) {
//			throw new MethodNotAllowedException();
//		}
		$this->Document->id = $id;

		if (!$this->Document->exists()) {
			throw new NotFoundException(__('Invalid document'), 'flash/warning');
		}
		$query = $this->Document->updateAll(
			array('Document.deleted' => "'" . date('Y-m-d H:i:s') . "'"), array('Document.id' => $id)
		);
		if ($query == 1) {
			$this->Session->setFlash(__('Document deleted.'), 'flash/success');
		} else {
			$this->Session->setFlash(__('Invalid deleted'), 'flash/error');
		}
		$this->redirect(array('action' => 'admin_index', $entity, $parent_entityid));
	}

	public function admin_published($id = null, $document_type_id = null, $parent_entityid = null) {
		if ($this->request->is('ajax')) {
			$this->Document->id = $id;
			if (!$this->Document->exists()) {
				throw new NotFoundException(__('Invalid Document'));
			}
			$document = $this->Document->read(null, $id);
			if ($document['Document']['published'] == Configure::read('zero_datetime')) {
				$this->Document->updateAll(array('Document.published' => "'" . date('Y-m-d H:i:s') . "'"), array('Document.id' => $id));
			} else {
				$this->Document->updateAll(array('Document.published' => "'" . Configure::read('zero_datetime') . "'"), array('Document.id' => $id));
			}
			$document = $this->Document->read(null, $id);

			$this->loadModel('DocumentType');
			$documentType = $this->DocumentType->read(NULL, $document_type_id);

			$this->set(compact('document', 'documentType', 'document_type_id', 'parent_entityid'));

			//$this->redirect(array('action' => 'index', $document_type_id, $parent_entityid));
		} else {
			throw new NotFoundException(__('Expected ajax request'));
		}
	}

	public function admin_upload_file() {
		
	}

	/*	 * Funciones para que el usuario regular pueda crear un documento* */

	public function index($document_type_id = null, $parent_entityid = null) {
		if (is_null($parent_entityid) && !is_numeric($parent_entityid)) {
			throw new MethodNotAllowedException();
			return false;
		}

		$this->loadModel('DocumentType');
		$this->DocumentType->recursive = 0;
		$documentType = $this->DocumentType->read(NULL, $document_type_id);
		$this->set(compact('documentType'));

		$this->paginate = array(
			'limit' => '10',
			'order' => array('Document.id' => 'desc'),
			'conditions' => array(
				'Document.deleted' => Configure::read('zero_datetime'),
				'Document.parent_entityid' => $parent_entityid,
				'Document.document_type_id' => $document_type_id,
				'Document.user_id' => $this->Session->read('Auth.User.id')
//				'Document.user_id' => '1'
			),
		);

		$this->Document->recursive = 1;
		$this->set('documents', $this->paginate());
		$this->set(compact('document_type_id', 'parent_entityid'));
	}

	public function add($document_type_id = null, $parent_entityid = null) {

		if ($this->request->is('ajax')) {

			$this->loadModel('DocumentType');

			$doc_user_id = $this->DocumentType->find('first', array(
				'fields' => array('DocumentType.use_user_id'),
				'conditions' => array('DocumentType.id' => $document_type_id)
				));

			if ($doc_user_id['DocumentType']['use_user_id']) {

				$this->loadModel('DocumentType');
				$this->DocumentType->bindModel(
					array(
						'belongsTo' => array('Entity')
					)
				);
				$this->DocumentType->recursive = 1;
				$documentType = $this->DocumentType->read(NULL, $document_type_id);

				if (!empty($documentType)) {
					$this->loadModel('Language');
					$languages = $this->Language->find('list');
					if (!empty($this->request->data)) {
						$this->request->data['Document']['document_type_id'] = $document_type_id;
						$this->request->data['Document']['published'] = Configure::read('zero_datetime');
						$this->request->data['Document']['deleted'] = Configure::read('zero_datetime');
						$this->request->data['Document']['user_id'] = $this->Session->read('Auth.User.id');
//						$this->request->data['Document']['user_id'] = 1;
						$this->Document->create();
						if ($this->Document->save($this->request->data)) {
							$this->Session->setFlash(__('The document has been saved'), 'flash/success');
							$this->redirect(array('action' => 'index', $document_type_id, $parent_entityid));
						} else {
							$this->Session->setFlash(__('The document could not be saved. Please, try again.'), 'flash/error');
						}
					}
					$this->set(compact('languages'));
				} else {
					throw new NotFoundException(__('DocumentType not defined'));
				}
				$this->set(compact('documentType'));
			} else {

				$this->Session->setFlash(__('Sorry, you can not create a document of this type. Please try later'), 'flash/error');
			}
		} else {
			throw new NotFoundException(__('Expected ajax request'));
		}
		$this->set(compact('document_type_id', 'parent_entityid'));
	}

	public function edit($id = null, $document_type_id = null, $parent_entityid = null) {

		$this->Document->id = $id;
		if (!$this->Document->exists()) {
			throw new NotFoundException(__('Invalid document'));
		}
		$document = $this->Document->read(null, $id);
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Document->save($this->request->data)) {
				$this->Session->setFlash(__('The document has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index', $document_type_id, $parent_entityid));
			} else {
				$this->Session->setFlash(__('The document could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$this->request->data = $document;
		}

		$languages = $this->Document->Language->find('list');

		$this->set(compact('document'));
		$this->set(compact('document_type_id', 'parent_entity_id', 'id', 'languages'));

		$this->set(compact('document_type_id', 'parent_entity_id', 'id', 'languages'));
	}

	public function delete($id = null, $entity = null, $parent_entityid = null, $document_type_id = null) {

		$this->loadModel('Document');

		$this->Document->id = $id;

		if (!$this->Document->exists()) {
			throw new NotFoundException(__('Invalid document'), 'flash/warning');
		}
		$query = $this->Document->updateAll(
			array('Document.deleted' => "'" . date('Y-m-d H:i:s') . "'"), array('Document.id' => $id)
		);
		if ($query == 1) {
			$this->Session->setFlash(__('Document deleted.'), 'flash/success');
			$this->redirect(array('action' => 'index', $parent_entityid, $document_type_id));
		} else {
			$this->Session->setFlash(__('Invalid deleted'), 'flash/error');
		}


		$this->set(compact('id', 'entity', 'parent_entityid'));
	}

	public function view($id = null, $parent_entityid = null, $entity = null) {

		$this->Document->id = $id;
		if (!$this->Document->exists()) {
			throw new NotFoundException(__('Invalid document'));
		}
		$this->set('document', $this->Document->read(null, $id));
		$this->set(compact('parent_entityid', 'entity'));
	}

	public function published($id = null, $document_type_id = null, $parent_entityid = null) {

		$this->Document->id = $id;
		if (!$this->Document->exists()) {
			throw new NotFoundException(__('Invalid Document'));
		}

		$this->loadModel('Document');

		$document = $this->Document->read(null, $id);
		if ($document['Document']['published'] == Configure::read('zero_datetime')) {
			$this->Document->updateAll(array('Document.published' => "'" . date('Y-m-d H:i:s') . "'"), array('Document.id' => $id));
		} else {
			$this->Document->updateAll(array('Document.published' => "'" . Configure::read('zero_datetime') . "'"), array('Document.id' => $id));
		}
		$document = $this->Document->read(null, $id);

		$this->loadModel('DocumentType');
		$documentType = $this->DocumentType->read(NULL, $document_type_id);

		$this->set(compact('document', 'documentType', 'document_type_id', 'parent_entityid'));
	}

	public function user_empty() {
		
	}

}
