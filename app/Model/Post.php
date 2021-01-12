<?php
App::uses('Model', 'Model');

class Post extends AppModel
{
	public $validate = array(
		'title' => array(
			'rule' => 'notBlank'
		),
		'body' => array(
			'rule' => 'notBlank'
		)
	);
	public $belongsTo = array(
		'Author' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'counterCache' => true,
		)
	);

	public function isOwnedBy($post, $user)
	{
		return $this->field('id', array('id' => $post, 'user_id' => $user)) !== false;
	}


}

