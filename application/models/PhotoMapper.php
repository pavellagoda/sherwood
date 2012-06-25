<?php

/**
 * Object data mapper class
 * @author pavel
 *
 */

class models_PhotoMapper extends models_MapperBase
{

	public static $_dbTable = 'models_DbTable_Photos';

	/**
	 * Init object from db row
	 * @param Zend_Db_Table_Row $row
	 */
	protected static function _initItem ($row)
	{
            if (null == $row) {
                return null;
            }

            $item = new models_Photo();

            if (isset($row->id))
                $item->id = $row->id;
            if (isset($row->extention))
                $item->extention = $row->extention;

            return $item;
	}

        
        public static function findById ($id)
	{
            $db = self::_getDbTable(self::$_dbTable);

            $select = $db->select();

            $select->where('id = ?', $id);

            $result = $db->fetchRow($select);

            return self::_initItem($result);
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
        
	/**
	 * Save object to database
	 * @param models_News $model
	 * @return int
	 */
	public static function save ($model)
	{
            return self::saveArray($model->toArray(), self::$_dbTable);
	}
        public static function update($id, $data)
	{
		$db = self::_getDbTable(self::$_dbTable);

		$where['id = ?'] =  (int) $id;
		$update = $db->update($data, $where);
						
		return $update;
	}
        

}
