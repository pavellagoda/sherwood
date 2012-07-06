<?php

/**
 * Object data mapper class
 * @author pavel
 *
 */

class models_ObjectMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_Objects';

	/**
	 * Init object from db row
	 * @param Zend_Db_Table_Row $row
	 */
	protected static function _initItem ($row)
	{
		if (null == $row)
		{
			return null;
		}

		$item = new models_Object();

		if (isset($row->id))
			$item->id				= $row->id;
		if (isset($row->title_ru))
			$item->title_ru				= $row->title_ru;
		if (isset($row->title_en))
			$item->title_en				= $row->title_en;
		if (isset($row->title_ua))
			$item->title_ua				= $row->title_ua;
		if (isset($row->short_ru))
			$item->short_ru				= $row->short_ru;
		if (isset($row->short_ua))
			$item->short_ua				= $row->short_ua;
		if (isset($row->short_en))
			$item->short_en				= $row->short_en;
		if (isset($row->full_ru))
			$item->full_ru				= $row->full_ru;
		if (isset($row->full_en))
			$item->full_en				= $row->full_en;
		if (isset($row->full_ua))
			$item->full_ua				= $row->full_ua;
		if (isset($row->tour_link))
			$item->tourLink				= $row->tour_link;
		if (isset($row->is_tour))
			$item->isTour				= $row->is_tour;
		if (isset($row->head_meta))
			$item->headMeta				= $row->head_meta;
		if (isset($row->head_description))
			$item->headDescription			= $row->head_description;
		if (isset($row->head_title))
			$item->headTitle			= $row->head_title;
		if (isset($row->order))
			$item->order            		= $row->order;

		return $item;
	}

	/**
	 * Find news by it's id
	 * @param int $idNews
	 * @return models_News
	 */

	public static function findById ($id)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('id = ?', $id);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}
        
        public static function findByUrl ($url)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->where('tour_link = ?', $url);

		$result = $db->fetchRow($select);

		return self::_initItem($result);
	}

	/**
	 * Find all news by associated tag id
	 * @param int $idNewsCategory
	 * @return models_NewsCategory
	 */


	public static function getAll ()
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();
                $select->order('order');
                $select->order('id DESC');

		$resultSet = $db->fetchAll($select);

		return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
	}
        

	public static function getAllPaginator ($page = 1, $count = 25)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$select = $db->select();

		$select->order('order');

		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
		$paginator->setItemCountPerPage($count);
		$paginator->setCurrentPageNumber($page);
		return $paginator;
	}


	/**
	 * Save object to database
	 * @param models_News $model
	 * @return int
	 */
	public static function save ($model)
	{
		return self::saveArray($model->toArray(), self::$_dbTable);
	}

}
