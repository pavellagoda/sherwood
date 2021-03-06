<?php

/**
 * News data mapper class
 * @author pavel
 *
 */
class models_NewsMapper extends models_MapperBase {

    public static $_dbTable = 'models_DbTable_News';

    /**
     * Init object from db row
     * @param Zend_Db_Table_Row $row
     */
    protected static function _initItem($row) {
        if (null == $row) {
            return null;
        }

        $item = new models_News();

        if (isset($row->id))
            $item->id = $row->id;
        if (isset($row->title_ru))
            $item->title_ru = $row->title_ru;
        if (isset($row->title_en))
            $item->title_en = $row->title_en;
        if (isset($row->title_ua))
            $item->title_ua = $row->title_ua;
        if (isset($row->short_ru))
            $item->short_ru = $row->short_ru;
        if (isset($row->short_ua))
            $item->short_ua = $row->short_ua;
        if (isset($row->short_en))
            $item->short_en = $row->short_en;
        if (isset($row->full_ru))
            $item->full_ru = $row->full_ru;
        if (isset($row->full_en))
            $item->full_en = $row->full_en;
        if (isset($row->full_ua))
            $item->full_ua = $row->full_ua;
        if (isset($row->created_ts))
            $item->createdTs = $row->created_ts;
        if (isset($row->views_count))
            $item->viewsCount = $row->views_count;
        if (isset($row->seo_url_ru))
            $item->seoUrlRu = $row->seo_url_ru;
        if (isset($row->seo_url_en))
            $item->seoUrlEn = $row->seo_url_en;
        if (isset($row->seo_url_ua))
            $item->seoUrlUa = $row->seo_url_ua;

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

    public static function findBySeo($seo) {
        $db = self::_getDbTable(self::$_dbTable);

        $select = $db->select();

        $select->where('seo_url_ru = ?', $seo);
        $select->orWhere('seo_url_en = ?', $seo);
        $select->orWhere('seo_url_ua = ?', $seo);

        $result = $db->fetchRow($select);

        return self::_initItem($result);
    }

    public static function findByCategory($idCategory, $count = 5) {
        $db = self::_getDbTable(self::$_dbTable);

        $select = $db->select();

        $select->where('news_category_id = ?', $idCategory);
        $select->limit($count);
        $select->order('created_ts DESC');

        $resultSet = $db->fetchAll($select);

        return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
    }

    /**
     * Find all news by associated tag id
     * @param int $idNewsCategory
     * @return models_NewsCategory
     */
    public static function findByTagId($idTag, $page = 1, $itemsPerPage = 5) {
        $db = self::_getDbTable(models_NewsTagsMapper::$_dbTable);

        $select = $db->select();
        $select->setIntegrityCheck(false);
        $select->from('news_tags', array());
        $select->joinLeft('news', 'news_tags.news_id = news.id', array('*'));
        $select->joinLeft('comment', 'comment.news_id = news.id', array('comments' => 'COUNT(comment.id)'));
        $select->where('news_tags.tag_id = ?', $idTag);

        $select->group('news.id');

        $select->order('news.id DESC');

        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
        $paginator->setItemCountPerPage($itemsPerPage)
                ->setCurrentPageNumber($page);

        return $paginator;
    }

    public static function getAll() {
        $db = self::_getDbTable(self::$_dbTable);

        $select = $db->select();

        $resultSet = $db->fetchAll($select);

        return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
    }

    public static function getLast($num) {
        $db = self::_getDbTable(self::$_dbTable);

        $select = $db->select('*');
        $select->order('news.created_ts DESC');
        $select->group('news.id');
        $select->limit($num);
        $resultSet = $db->fetchAll($select);

        return $resultSet;
    }

    public static function findByCategoryPage($idCategory, $page = 1, $itemsPerPage = 5, $newIds = null) {
        $db = self::_getDbTable(self::$_dbTable);

        $select = $db->select('*');
        $select->setIntegrityCheck(false);
        $select->joinLeft('comment', 'comment.news_id = news.id', array('comments' => 'COUNT(comment.id)'));
        $select->where('news_category_id = ?', $idCategory);
        $select->where('type != ?', 'statistic');
        if ($newIds != null)
            $select->where('news.id NOT IN(' . implode(', ', $newIds) . ')');

        $select->limit($itemsPerPage);
        $select->order('news.created_ts DESC');
        $select->order('news.id DESC');
        $select->group('news.id');
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
        $paginator->setItemCountPerPage($itemsPerPage)
                ->setCurrentPageNumber($page)
                ->setPageRange(4);


        return $paginator;

        //return self::_createArrayFromResultSet($resultSet, array(__CLASS__, '_initItem'));
    }

    public static function findOthersPage($idCategory, $page = 1, $itemsPerPage = 5, $newIds = null) {
        $db = self::_getDbTable(self::$_dbTable);

        $select = $db->select('*');
        $select->setIntegrityCheck(false);
        $select->joinLeft('comment', 'comment.news_id = news.id', array('comments' => 'COUNT(comment.id)'));
        $select->where('news_category_id != ?', $idCategory);
        $select->where('type != ?', 'statistic');
        $select->where('news.id NOT IN(' . implode(', ', $newIds) . ')');
        $select->limit($itemsPerPage);
        $select->order('news.created_ts DESC');
        $select->order('news.id DESC');
        $select->group('news.id');
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
        $paginator->setItemCountPerPage($itemsPerPage)
                ->setCurrentPageNumber($page)
                ->setPageRange(4);
        return $paginator;
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
     * Update News_Count column
     * @param int $idNews
     */
    public static function incrementViewsCount($idNews) {
        $db = self::_getDbTable(self::$_dbTable);

        $sql = 'UPDATE `news` SET views_count = views_count + 1 WHERE id = ' . (int) $idNews;

        return $db->getAdapter()->query($sql);
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
