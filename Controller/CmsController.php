<?php

App::uses('AppController', 'Controller');

/**
 * Documents Controller
 *
 * @property Document $Document
 */
class CmsController extends DocumentsAppController {

//	var $components = array('Documents.LanguageDefault');

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

	public function admin_index() {
		$this->loadModel('Entity');
		$entity = $this->Entity->find('first', array('conditions' => array('Entity.alias' => 'cms')));

		$entity_id = 0;
		if (!empty($entity)) {
			$entity_id = $entity['Entity']['id'];
		}
		$this->paginate = array(
			'conditions' => array('DocumentType.entity_id' => $entity_id)
		);

		$this->DocumentType->recursive = 0;
		$documentTypes = $this->paginate('DocumentType', array('DocumentType.entity_id' => $entity_id));
		$this->set(compact('documentTypes'));
	}

}
