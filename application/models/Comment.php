<?php

/**
 * Class representing Comment model
 * @author pavel
 *
 */

class models_Comment {
	
	public $id;
	public $parent_id;
	public $name;
	public $email;
	public $message;
	public $moderated;
	public $created_ts;
	
	public function toArray()
	{
		return array(
			'id'			=> $this->id,
			'parent_id'		=> $this->parent_id,
			'name'			=> $this->name,
			'email'			=> $this->email,
			'message'		=> $this->message,
			'moderated'		=> $this->moderated,
			'created_ts'		=> $this->created_ts,
		);
	}
	
}