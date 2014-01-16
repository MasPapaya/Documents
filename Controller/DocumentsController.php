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
		$this->loadModel('Documents.Document');
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index($document_type_id = null, $parent_entityid = null) {
		if (is_null($parent_entityid)) {
			if (!empty($this->authuser['id'])) {
				$parent_entityid = $this->authuser['id'];
			} else {
				throw new MethodNotAllowedException();
				return false;
			}
		} else {
			if (!is_numeric($parent_entityid)) {
				throw new MethodNotAllowedException();
				return false;
			}
		}
		$this->loadModel('DocumentType');
		$this->DocumentType->recursive = 0;
		$documentType = $this->DocumentType->read(NULL, $document_type_id);
		$this->set(compact('documentType'));
		if (!$documentType['DocumentType']['is_multiple']) {
			$this->Language->recursive = 0;
			$count_language = $this->Language->find('count');
			$conditions_settings = array(
				'conditions' => array(
					'Document.document_type_id' => $document_type_id,
					'Document.parent_entityid' => $parent_entityid,
					'Document.deleted' => Configure::read('zero_datetime'),
				));
			if ($documentType['DocumentType']['use_user_id']) {
				$conditions_settings['conditions']['Document.user_id'] = $parent_entityid;
			}

			$count_documents = $this->Document->find('count', $conditions_settings);
			if ($count_language == $count_documents) {
				$this->set('disable_button', true);
			}
		}

		$conditions = array(
			'Document.deleted' => Configure::read('zero_datetime'),
			'Document.document_type_id' => $document_type_id
		);

		$is_admin = false;
		switch ($this->authuser['Group']['name']) {
			case 'superadmin':
				$is_admin = true;
				break;
			case 'admin':
				$is_admin = true;
				break;

			default:
				$is_admin = false;
				break;
		}

		if (!$is_admin) {
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

		$this->Document->recursive = 2;
		$this->DocumentType->bindModel(array(
			'belongsTo' => array('Entity')
		));

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
			$conditions_language = array();
			if (!$documentType['DocumentType']['is_multiple']) {
				$conditions_list = array('Document.document_type_id' => $document_type_id, 'Document.parent_entityid' => $parent_entityid, 'Document.deleted ' => Configure::read('zero_datetime'));
				if ($documentType['DocumentType']['use_user_id']) {
					$conditions_list['Document.user_id'] = $this->authuser['id'];
				}
				$list_document = $this->Document->find('list', array(
					'fields' => array('Document.id', 'Document.language_id'),
					'group' => array('Document.language_id'),
					'conditions' => $conditions_list
					));



				foreach ($list_document as $document) {
					$conditions_language[] = 'Language.id != ' . $document;
				}
			}
			$languages = $this->Language->find('list', array(
				'conditions' => $conditions_language
				));
			if ($this->request->is('post') || $this->request->is('put')) {
				$is_save = true;
				$is_idUser = true;
				if (!empty($this->request->data['Document']['user_id']) && $this->authuser['Group']['name'] == 'superadmin' || $this->authuser['Group']['name'] == 'admin') {
					$this->loadModel('Accounts.User');
					$exist_user = $this->User->find('first', array(
						'conditions' => array(
							'deleted' => Configure::read('zero_datetime'),
							'banned ' => Configure::read('zero_datetime'),
							'activated !=' => Configure::read('zero_datetime'),
							'username' => $this->request->data['Document']['user_id']
						),
						'recursive' => 0
						));
					if (empty($exist_user)) {
						$this->Session->setFlash(__('User no exist'), 'flash/warning');
						$is_save = false;
					} else {
						$is_idUser = false;
						$this->request->data['Document']['user_id'] = $exist_user['User']['id'];
					}
				}

				if ($is_save) {
					if ($documentType['DocumentType']['use_user_id'] === TRUE) {
						if ($is_idUser) {
							$this->request->data['Document']['user_id'] = $this->authuser['id'];
						}
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
			}

			$this->set(compact('languages'));
		} else {
			throw new NotFoundException(__('DocumentType not defined'));
		}

		if ($this->authuser['Group']['name'] == 'superadmin' || $this->authuser['Group']['name'] == 'admin') {
			$users = true;
			$this->set(compact('users'));
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
//		if ($this->request->is('ajax')) {
		$this->loadModel('Accounts.User');
		$this->Document->id = $id;
		if (!$this->Document->exists()) {
			throw new NotFoundException(__('Invalid document'));
		}

		$document = $this->Document->read(null, $id);
		$user_id = $this->User->find('first', array(
			'fields' => array('User.id', 'username'),
			'recursive' => 0,
			'conditions' => array('User.deleted' => Configure::read('zero_datetime'),
				'User.activated !=' => Configure::read('zero_datetime'),
				'User.banned' => Configure::read('zero_datetime'),
				'User.id' => $document['Document']['user_id']
			)
			));
		if (!empty($user_id)) {
			$this->set('user_name', $user_id['User']['username']);
		}

		$is_noadmin = true;

		switch ($this->authuser['Group']['name']) {
			case 'superadmin':
			case 'admin':
				$is_noadmin = false;
				break;
			default:
				$is_noadmin = true;
				break;
		}

		if ($is_noadmin) {
			if ($document['DocumentType']['use_user_id'] === TRUE) {
				if ($document['Document']['user_id'] != $this->authuser['id']) {
					$this->Session->setFlash(__('Upss'), 'flash/success');
					//$this->redirect(array('plugin' => 'accounts', 'controller' => 'Users', 'action' => 'welcome', 'admin' => false), null, true);
					$this->set('error', 'intruder');
				}
			}
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			$is_save = true;

			if (!empty($this->request->data['Document']['user_id'])) {
				$this->loadModel('Accounts.User');

				$exist_user = $this->User->find('first', array(
					'conditions' => array(
						'deleted' => Configure::read('zero_datetime'),
						'banned ' => Configure::read('zero_datetime'),
						'activated !=' => Configure::read('zero_datetime'),
						'username' => $this->request->data['Document']['user_id']
					),
					'recursive' => 0
					));
				if (empty($exist_user)) {
					$this->Session->setFlash(__('User no exist'), 'flash/warning');
					$is_save = false;
				} else {
					$this->request->data['Document']['user_id'] = $exist_user['User']['id'];
				}
			}
			if ($is_save) {
				if ($this->Document->save($this->request->data)) {
					$this->Session->setFlash(__('The document has been saved'), 'flash/success');
					$this->redirect(array('action' => 'index', $document_type_id, $parent_entityid));
				} else {
					$this->Session->setFlash(__('The document could not be saved. Please, try again.'), 'flash/error');
				}
			}
		} else {
			$this->request->data = $document;
		}

		$languages = $this->Document->Language->find('list');

		if ($this->authuser['Group']['name'] == 'superadmin' || $this->authuser['Group']['name'] == 'admin') {
			$this->set('users', true);
		}

		$this->set(compact('document'));
		$this->set(compact('document_type_id', 'parent_entity_id', 'id', 'languages'));
//			$this->set(compact('documentTypes'));
//		} else {
//			throw new NotFoundException(__('Expected ajax request'));
//		}
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

	public function admin_search($document_type_id = NULL, $parent_entityid = 0) {
		$this->loadModel('DocumentType');
		$this->DocumentType->recursive = 0;
		$documentType = $this->DocumentType->read(NULL, $document_type_id);
		$this->set(compact('documentType'));
		$conditions = array();
		$this->Document->recursive = 2;
		$this->DocumentType->bindModel(array(
			'belongsTo' => array('Entity')
		));

		if (isset($this->request->data['Document']['search']) and $this->request->data['Document']['search'] != " ") {
			if (strlen($this->request->data['Document']['search']) > 2) {
				$this->Session->delete('conditions_search');
				$fields = trim($this->request->data['Document']['search'], " ");
				$search = explode(" ", $fields);
				for ($i = 0; $i < count($search); $i++) {
					if (strlen($search[$i]) > 2) {
						$conditions[] = "Document.title like '%" . $search[$i] . "%'";
					}
				}
				$results = $this->paginate('Document', array(
					'OR' => $conditions,
					));
				$this->Session->write('conditions_search', $conditions);
				if (count($results) == 0) {
					$this->Session->setFlash('No se encontraron Registros!.', 'flash/warning');
				}
				$this->set('documents', $results);
			} else {
				$this->Session->setFlash('No se encontraron Registros!.', 'flash/warning');
				$this->redirect(array('action' => 'index', $document_type_id, 0));
			}
		} else {
			$settings = array();
			if ($this->Session->check('conditions_search')) {
				if (!empty($this->request->params['named']['page'])) {
					$settings['page'] = $this->request->params['named']['page'];
				} else {
					$settings['page'] = 1;
				}
				$settings['conditions']['OR'] = $this->Session->read('conditions_search');
				$this->paginate = $settings;
				$this->set('documents', $this->paginate());
			} else {
				$this->Session->setFlash('No se encontraron Registros!.', 'flash/warning');
				$this->redirect(array('action' => 'index', $document_type_id, 0));
			}
		}
		$this->set(compact('document_type_id', 'parent_entityid'));
	}

	public function get_users($username = NULL) {
		$this->autoRender = false;
		$this->loadModel('Accounts.User');
		$all_users = $this->User->find('list', array(
			'fields' => array('User.username'),
			'recursive' => 0,
			'conditions' => array(
				'User.deleted' => Configure::read('zero_datetime'),
				'User.activated !=' => Configure::read('zero_datetime'),
				'User.banned' => Configure::read('zero_datetime'),
				'User.username LIKE' => '%' . $username . '%',
			)
			));
		$users_complet = array();
		foreach ($all_users as $all_user) {
			$users_complet[] = $all_user;
		}
		echo json_encode($users_complet);
	}

}

