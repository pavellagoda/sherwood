<?php

class Zend_View_Helper_UrlMaker {

    public static function urlMaker($url) {
        $current_language = new Zend_Session_Namespace('language');
        if($current_language->language == 'ru') {
            return $url;
        } else {
            return '/'.$current_language->language.$url;
        }
    }
}