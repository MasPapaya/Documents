<?php

App::uses('AppController', 'Controller');

class DocumentsAppController extends AppController {

	public $helpers = array(
		'Html',
		'Form',
		'Session',
		'Js' => array('Jquery'),
		'Documents.Ajs',
		'Paginator',
		'Text',
	);
	public $components = array(
		'Email',
		'Paginator',
		'RequestHandler',
		'Session',
//		'Auth',
//	  'Security',
//	  'Cookie',
	);

	public function beforeFilter() {
		parent::beforeFilter();
		if(Configure::read('debug') > 1) {
			$this->Auth->allow();
		}
		$this->language_multiple();
	}

	public function isAuthorized() {
		
	}

	public function language_multiple() {
		$this->loadModel('Language');
		$multiple = $this->Language->find('count', array(
			'recursive' => 0
		));

		if ($multiple > 1) {
			Configure::write('language_multiple', true);
		} else {
			Configure::write('language_multiple', false);
			$this->Language->unBindModel(array('hasMany' => array('Document')));
			$is_languages = $this->Language->find('first', array(
				'fields' => array('Language.name', 'Language.id'),
				'recursive' => -2
			));

			if (!empty($is_languages['Language']['id'])) {
				Configure::write('language_default', $is_languages['Language']['id']);
			} else {
				Configure::write('language_default', false);
			}
		}
	}

}