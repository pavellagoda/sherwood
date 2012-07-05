<?php

/**
 * Class representing News model
 * @author pavel
 *
 */

class models_News {
	
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
	public $createdTs;
	public $viewsCount;
	public $seoUrlRu;
	public $seoUrlEn;
	public $seoUrlUa;
	
	public function toArray()
	{
		return array(
			'id'					=> $this->id,
			'title_ru'				=> $this->title_ru,
			'title_en'				=> $this->title_en,
			'title_ua'				=> $this->title_ua,
			'short_ru'				=> $this->short_ru,
			'short_en'				=> $this->short_en,
			'short_ua'				=> $this->short_ua,
			'full_ru'				=> $this->full_ru,
			'full_en'				=> $this->full_en,
			'full_ua'				=> $this->full_ua,
			'created_ts'                            => $this->createdTs,
			'views_count'                           => $this->viewsCount,
			'seo_url_ru'                            => $this->seoUrlRu,
			'seo_url_en'                            => $this->seoUrlEn,
			'seo_url_ua'                            => $this->seoUrlUa,
		);
	}
	
}