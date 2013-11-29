<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP LanguageDefaultComponent
 * @author developer02
 */
class LanguageDefaultComponent extends Component {

	public $components = array();
	private $controller;

	public function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection, $settings);

		$this->controller = $collection->getController();
	}

	public function initialize($controller) {
		
	}

	public function startup($controller) {
		
	}

	public function beforeRender($controller) {
		
	}

	public function shutDown($controller) {
		
	}

	public function beforeRedirect($controller, $url, $status = null, $exit = true) {
		
	}

	public function default_language($name) {

		$this->loadModel('Language');

		$this->Language->unBindModel(array('hasMany' => array('Document')));

		$is_languages = $this->Language->find('first', array(
			'fields' => array('Language.name', 'Language.id'),
			'conditions' => array('Language.code' => $name),
			'recursive' => -2
		));
		$id = $is_languages['Language']['id'];
		Configure::write('language_default', $is_languages['Language']['id']);
	}

}
