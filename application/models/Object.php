<?php

/**
 * Class representing Object model
 * @author pavel
 *
 */

class models_Object {
	
	public $id;
	public $title;
	public $short;
	public $full;
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
			'title'			=> $this->title,
			'short'			=> $this->short,
			'full'			=> $this->full,
			'tour_link'		=> $this->tourLink,
			'is_tour'		=> $this->isTour,
			'head_meta'		=> $this->headMeta,
			'head_description'	=> $this->headDescription,
			'head_title'		=> $this->headTitle,
			'order' 		=> $this->order,
		);
	}
	
}