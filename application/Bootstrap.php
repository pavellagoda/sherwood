<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initDoctype() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }

    protected function _initFrontController() {
        $front = Zend_Controller_Front::getInstance();

        $front->setControllerDirectory(
                array(
                    'default' => APPLICATION_PATH .
                    '/modules/default/controllers',
                    'admin' => APPLICATION_PATH .
                    '/modules/admin/controllers',
                    'project' => APPLICATION_PATH .
                    '/modules/project/controllers'
                )
        );

        $front->addModuleDirectory(APPLICATION_PATH . '/modules');

        $front->setDefaultModule('default');

        $router = $front->getRouter();
        $this->bootstrap('autoload');
        $this->bootstrap('db');
        $names = models_StaticpageMapper::getPages();
        $resultNamesArray = array();
        foreach ($names as $name)
        {
            $resultNamesArray[] = $name->name;
        }
        $nameString = implode('|', $resultNamesArray);
        
        $router->addRoute('staticpages',
                        new Zend_Controller_Router_Route_Regex(
                                        '('.$nameString.')$',
                                        array(
                                                        'controller' => 'staticpages',
                                                        'action' => 'index'
                                        ),
                                        array(
                                                        1 => 'page',
                                        )
                        )
        );
        $router->addRoute('language',
                        new Zend_Controller_Router_Route_Regex(
                                        'language/(ru|en|ua)$',
                                        array(
                                                        'controller' => 'language',
                                                        'action' => 'index'
                                        ),
                                        array(
                                                        1 => 'lang',
                                        )
                        )
        );
        return $front;
    }

    protected function _initAutoload() {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->setFallbackAutoloader(true);
        return $autoloader;
    }

    protected function _initConfig() {
        $oConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini');
        $oRegistry = Zend_Registry::getInstance();
        $oRegistry->set('config', $oConfig);
    }

    protected function _initTranslation() {
        $translate = new Zend_Translate('array', APPLICATION_PATH . '/languages');
        Zend_Registry::set('Zend_Translate', $translate);
        Zend_Validate_Abstract::setDefaultTranslator($translate);
        Zend_Form::setDefaultTranslator($translate);
    }

    protected function _initSession() {
        $oRegistry = Zend_Registry::getInstance();
        $oConfig = $oRegistry->get('config')->session;
        Zend_Session::setOptions($oConfig->toArray());
        $oRegistry->set('Zend_Session_Namespace', new Zend_Session_Namespace());
    }

    protected function _initLayout() {
        Zend_Layout::startMvc();
    }

}

