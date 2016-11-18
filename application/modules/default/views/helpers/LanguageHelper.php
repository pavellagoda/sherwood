<?php

class Zend_View_Helper_LanguageHelper {

    public static function languageHelper($lang) {
        $current_language = new Zend_Session_Namespace('language');
        if($current_language->language == $lang) {
            return 'javascript:void(0)';
        }
        
        if($current_language->language == 'ru') {
            return '/'.$lang.$_SERVER['REQUEST_URI'];
        } else {
            $url_parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
            unset($url_parts[0]);
            if($lang == 'ru') {
                return '/'.implode('/', $url_parts);
            } else {
                return '/'.$lang.'/'.implode('/', $url_parts);
            }
        }
    }
}