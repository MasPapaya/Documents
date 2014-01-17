<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP LanguageDefaultComponent
 * @author developer02
 */
class MainComponent extends Component {

	public $components = array();
	private $Controller;

	public function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection, $settings);
		$this->Controller = $collection->getController();
		if (CakePlugin::loaded('Seo')) {
			$collection->load('Seo.SeoIn', array(
				'alias' => 'document',
				), 'Seo.SeoOut');
		}
	}

}
