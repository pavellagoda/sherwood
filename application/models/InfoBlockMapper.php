<?php

/**
 * InfoBlock data mapper class
 * @author pavel
 *
 */
class models_InfoBlockMapper extends models_MapperBase {

    public static $_dbTable = 'models_DbTable_InfoBlockMapper';

    /**
     * Init object from db row
     * @param Zend_Db_Table_Row $row
     */
    protected static function _initItem($row) {
        if (null == $row) {
            return null;
        }

        $item = new models_InfoBlock();

        if (isset($row->id))
            $item->id = $row->id;
        if (isset($row->text_ru))
            $item->text_ru = $row->text_ru;
        if (isset($row->text_en))
            $item->text_en = $row->text_en;
        if (isset($row->text_ua))
            $item->text_ua = $row->text_ua;
        if (isset($row->background_extention))
            $item->background_extention = $row->background_extention;
        if (isset($row->status))
            $item->status = $row->status;

        return $item;
    }

    /**
     * Find news by it's id
     * @param int $idNews
     * @return models_News
     */
    public static function findById($idNews) {
        $db = self::_getDbTable(self::$_dbTable);

        $select = $db->select();

        $select->where('id = ?', $idNews);

        $result = $db->fetchRow($select);

        return self::_initItem($result);
    }


    public static function getAll($onlyActive = true) {
        $db = self::_getDbTable(self::$_dbTable);

        $select = $db->select();
        
        if($onlyActive)
            $select->where('status = ?', 'active');
        
        $resultSet = $db->fetchAll($select);

        return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
    }

    /**
     * Get all news in paginator instance
     * @param int $idNewsCategory
     * @param int $page
     * @param int $count
     * @return Zend_Paginator
     */
    public static function getAllPaginator($idNewsCategory = 0, $page = 1, $count = 25) {
        $db = self::_getDbTable(self::$_dbTable);

        $select = $db->select();

        if (0 != $idNewsCategory) {
            $select->where('news_category_id = ?', $idNewsCategory);
        }

        $select->order('created_ts DESC');

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
    public static function save($model) {
        return self::saveArray($model->toArray(), self::$_dbTable);
    }

}
