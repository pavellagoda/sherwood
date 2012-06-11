<?php

/**
 * Class representing Staticpage model
 * @author pavel
 *
 */

class models_Staticpage {
	
	public $id;
	public $title;
	public $content;
        public $name;
        public $headMeta;
	public $headDescription;
	public $headTitle;
	
	public function toArray()
	{
		return array(
			'id'				=> $this->id,
			'title'				=> $this->title,
			'content'			=> $this->content,
                        'name'                          => $this->name,
                        'head_meta'                     => $this->headMeta,
			'head_description'              => $this->headDescription,
			'head_title'                    => $this->headTitle,
		);
	}
	
}