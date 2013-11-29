<?php

App::uses('AppController', 'Controller');

class UsersDocumentsController extends DocumentsAppController {

	public $uses = 'DocumentType';
	public $paginate = array(
		'DocumentType' => array(
			'limit' => 10,
		)
	);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

	public function index() {

		$this->loadModel('DocumentType');
		$this->loadModel('Entity');
		$entity = $this->Entity->find('first', array('conditions' => array('Entity.alias' => 'userdocument')));

		$doc_user_id = $this->DocumentType->find('first', array('conditions' => array('DocumentType.use_user_id' => 'true')));

		$use_user_id = 1;

		if (!empty($use_user_id)) {
			$use_user_id = $doc_user_id['DocumentType']['use_user_id'];
		} else {
			
		}

		$this->paginate = array(
			'conditions' => array('DocumentType', array('DocumentType.use_user_id' => $doc_user_id)));

		$entity_id = 0;
		if (!empty($entity)) {
			$entity_id = $entity['Entity']['id'];
		}
		$this->paginate = array(
			'conditions' => array('DocumentType.entity_id' => $entity_id)
		);

		$this->DocumentType->recursive = 0;
		$documentTypes = $this->paginate('DocumentType', array('DocumentType.entity_id' => $entity_id, 'DocumentType.use_user_id' => $use_user_id));
		$this->set(compact('documentTypes'));
	}

}

?>
