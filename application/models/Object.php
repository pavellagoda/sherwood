<?php

/**
 * Class representing Object model
 * @author pavel
 *
 */

class models_Object {
	
	public $id;
	public $title_ru;
	public $title_en;
	public $title_ua;
	public $short_ru;
	public $short_en;
	public $short_ua;
	public $full_ru;
	public $full_en;
	public $full_ua;
	public $tourLink;
	public $isTour;
	public $headMeta;
	public $headDescription;
	public $headTitle;
        public $order;
	
	public function toArray()
	{
		return array(
			'id'			=> $this->id,
			'title_ru'		=> $this->title_ru,
			'title_en'		=> $this->title_en,
			'title_ua'		=> $this->title_ua,
			'short_ru'		=> $this->short_ru,
			'short_en'		=> $this->short_en,
			'short_ua'		=> $this->short_ua,
			'full_ru'		=> $this->full_ru,
			'full_en'		=> $this->full_en,
			'full_ua'		=> $this->full_ua,
			'tour_link'		=> $this->tourLink,
			'is_tour'		=> $this->isTour,
			'head_meta'		=> $this->headMeta,
			'head_description'	=> $this->headDescription,
			'head_title'		=> $this->headTitle,
			'order' 		=> $this->order,
		);
	}
	
}