<?php

/**
 * Class representing Staticpage model
 * @author pavel
 *
 */

class models_Staticpage {
	
	public $id;
	public $title_ru;
	public $title_en;
	public $title_ua;
	public $content_ru;
	public $content_en;
	public $content_ua;
        public $name;
        public $headMeta;
	public $headDescription;
	public $headTitle;
	
	public function toArray()
	{
		return array(
			'id'				=> $this->id,
			'title_ru'			=> $this->title_ru,
			'title_en'			=> $this->title_en,
			'title_ua'			=> $this->title_ua,
			'content_ru'			=> $this->content_ru,
			'content_en'			=> $this->content_en,
			'content_ua'			=> $this->content_ua,
                        'name'                          => $this->name,
                        'head_meta'                     => $this->headMeta,
			'head_description'              => $this->headDescription,
			'head_title'                    => $this->headTitle,
		);
	}
	
}