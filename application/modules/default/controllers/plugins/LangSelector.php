<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LangSelector
 *
 * @author Pasha
 */
class modules_default_controllers_plugins_LangSelector extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $lang = new Zend_Session_Namespace('language');

        if (!isset($lang->language))
            $lang->language = 'ru';
        
        $translate = new Zend_Translate('array', APPLICATION_PATH . '/languages');
        $translate->addTranslation(
                array(
                    'content' => APPLICATION_PATH . '/languages/front_en.php',
                    'locale' => 'en'
                )
        );
        $translate->addTranslation(
                array(
                    'content' => APPLICATION_PATH . '/languages/front_ua.php',
                    'locale' => 'ua'
                )
        );
        $translate->addTranslation(
                array(
                    'content' => APPLICATION_PATH . '/languages/front_ru.php',
                    'locale' => 'ru'
                )
        );
        $translate->setLocale($lang->language);
        Zend_Registry::set('Zend_Translate', $translate);
        Zend_Validate_Abstract::setDefaultTranslator($translate);
        Zend_Form::setDefaultTranslator($translate);
    }

}

