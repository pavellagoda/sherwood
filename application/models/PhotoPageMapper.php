<?php

/**
 * Object data mapper class
 * @author pavel
 *
 */

class models_PhotoPageMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_PhotosPages';

	/**
	 * Init object from db row
	 * @param Zend_Db_Table_Row $row
	 */
	protected static function _initItem ($row)
	{
            if (null == $row) {
                return null;
            }

            $item = new models_PhotoPage();

            if (isset($row->photo_id))
                $item->photo_id = $row->photo_id;
            if (isset($row->page))
                $item->page = $row->page;

            return $item;
	}

        
        public static function findByPage ($page)
	{
            $db = self::_getDbTable(self::$_dbTable);

            $select = $db->select();

            $select->where('page = ?', $page);

            $result = $db->fetchRow($select);

            return self::_initItem($result);
	}
        public static function findByPhotoId ($id)
	{
            $db = self::_getDbTable(self::$_dbTable);

            $select = $db->select();

            $select->where('photo_id = ?', $id);

            $resultSet = $db->fetchAll($select);

            return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
	}

	public static function getAll ()
	{
            $db = self::_getDbTable(self::$_dbTable);

            $select = $db->select();

            $resultSet = $db->fetchAll($select);

            return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
	}


	public static function getAllPaginator ($page = 1, $count = 25)
	{
            $db = self::_getDbTable(self::$_dbTable);

            $select = $db->select();

            $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
            $paginator->setItemCountPerPage($count);
            $paginator->setCurrentPageNumber($page);
            return $paginator;
	}
        
	public static function save ($model)
	{
            return self::saveArray($model->toArray(), self::$_dbTable);
	}

}
