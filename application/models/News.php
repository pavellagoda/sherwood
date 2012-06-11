<?php

/**
 * Class representing News model
 * @author pavel
 *
 */

class models_News {
	
	public $id;
	public $title;
	public $short;
	public $full;
	public $createdTs;
	public $viewsCount;
	public $seoUrl;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'title'					=> $this->title,
			'short'					=> $this->short,
			'full'					=> $this->full,
			'created_ts'                            => $this->createdTs,
			'views_count'                           => $this->viewsCount,
			'seo_url'                               => $this->seoUrl,
		);
	}
	
}