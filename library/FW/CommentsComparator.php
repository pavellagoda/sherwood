<?php

/**
 * @author pavel
 */

class FW_CommentsComparator {
    
    public static function getCommentsRecursive($page = 1) {
        $result = array();
        $responces = models_CommentMapper::getAllByParentIdPaginator(0, $page);
        foreach ($responces as $responce) {
            $tmp = array();
            $tmp['responce'] = $responce;
            $tmp['comments'] = self::getComments($responce['id']);
            $result[] = $tmp;
        }
        
        echo '<pre>';
        print_r($result); die;
        
        return $result;
    }
    
    private static function getComments($id, $result = array()) {
        $childs = models_CommentMapper::getAllByParentId($id);
        foreach ($childs as $id => $child) {
            $result[$id]['model'] = models_CommentMapper::findById($child->id)->toArray();
            $result[$id]['childs'] = array();
            $result[$id]['childs'] = self::getComments($child->id, $result[$id]['childs']);
        }
        
        return $result;
    }
}
