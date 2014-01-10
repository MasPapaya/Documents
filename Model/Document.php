<?php

App::uses('AppModel', 'Model');

/**
 * Document Model
 *
 * @property DocumentType $DocumentType
 * @property Entity $Entity
 * @property Fragment $Fragment
 */
class Document extends DocumentsAppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'document_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			//'message' => 'Debe seleccionar un campo',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'notempty',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'parent_entityid' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'excerpt' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'content' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'is_single' => array(
				'rule' => array('is_single'),
				'message' => 'Document exist',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'DocumentType' => array(
			'className' => 'DocumentType',
			'foreignKey' => 'document_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
//		'Fragment' => array(
//			'className' => 'Fragment',
//			'foreignKey' => 'document_id',
//			'dependent' => false,
//			'conditions' => '',
//			'fields' => '',
//			'order' => '',
//			'limit' => '',
//			'offset' => '',
//			'exclusive' => '',
//			'finderQuery' => '',
//			'counterQuery' => ''
//		)
	);

	public function is_single() {
		$is_multiple = $this->DocumentType->find('first', array(
			'conditions' => array('DocumentType.id' => $this->data['Document']['document_type_id']),
			));
		if ($is_multiple['DocumentType']['is_multiple'] == false) {			

			$conditions = array(
				'parent_entityid' => $this->data['Document']['parent_entityid'],
				'document_type_id' => $this->data['Document']['document_type_id'],
				'deleted' => Configure::read('zero_datetime'),
				'language_id' => $this->data['Document']['language_id'],
			);
			if ($is_multiple['DocumentType']['use_user_id']) {
				$conditions['Document.user_id'] = $this->data['Document']['parent_entityid'];
			}
			$exist_document = $this->find('count', array(
				'conditions' => $conditions
				));
			
			if ($exist_document > 0) {
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
		return false;
	}

}
