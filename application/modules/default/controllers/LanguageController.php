<?php

/**
 * IndexController
 *
 * @author pavel
 * @version 1
 */
class LanguageController extends modules_default_controllers_ControllerBase {

    public $ajaxable = array(
        'refresh-captcha' => array('json'),
    );

    public function init() {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            parent::init();
        }

        $this->_helper->AjaxContext()->initContext('json');
    }

    public function indexAction() {
        $request = $this->getRequest();
        $language = $request->getParam('lang');
        
        $allowed_languages = array('ru', 'en', 'ua');
        
        if(in_array($language, $allowed_languages)) {
            $lang = new Zend_Session_Namespace('language');
            $lang->language = $language;
        }
        return $this->_helper->redirector('index', 'index');
    }

}

