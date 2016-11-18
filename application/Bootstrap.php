<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }

    protected function _initFrontController()
    {
        $front = Zend_Controller_Front::getInstance();

        $this->bootstrap('autoload');

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

        $router->removeDefaultRoutes();

        $router->addRoute('default', new FW_MultilingualModule(
                        array(
                            'lang' => 'ru',
                            'module' => 'default',
                            'controller' => 'index',
                            'action' => 'index',
                        )
                )
        );
        
        $this->bootstrap('db');
        $names = models_StaticpageMapper::getPages();
        $resultNamesArray = array();
        foreach ($names as $name) {
            $resultNamesArray[] = $name->name;
        }
        $nameString = implode('|', $resultNamesArray);
//        var_dump($nameString); die;
        $router->addRoute('staticpages', new Zend_Controller_Router_Route_Regex(
                        '((?:ru|en|ua)/)?(' . $nameString . ')$',
                        array(
                            'controller' => 'staticpages',
                            'action' => 'index',
                            'lang' => 'ru'
                        ),
                        array(
                            1 => 'lang',
                            2 => 'page',
                        )
                )
        );


//        $router->addRoute('language', new Zend_Controller_Router_Route_Regex(
//                        'language/(ru|en|ua)$',
//                        array(
//                            'controller' => 'language',
//                            'action' => 'index'
//                        ),
//                        array(
//                            1 => 'lang',
//                        )
//                )
//        );

        $front->registerPlugin(new modules_default_controllers_plugins_LangSelector());

        return $front;
    }

    protected function _initAutoload()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->setFallbackAutoloader(true);
        return $autoloader;
    }

    protected function _initConfig()
    {
        $oConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini');
        $oRegistry = Zend_Registry::getInstance();
        $oRegistry->set('config', $oConfig);
    }

    protected function _initTranslation()
    {

//        $translate = new Zend_Translate('array', APPLICATION_PATH . '/languages');
//        $translate->addTranslation(
//                array(
//                    'content' => APPLICATION_PATH . '/languages/front_en.php',
//                    'locale' => 'en'
//                )
//        );
//        $translate->setLocale('ru_RU');
//        Zend_Registry::set('Zend_Translate', $translate);
//        Zend_Validate_Abstract::setDefaultTranslator($translate);
//        Zend_Form::setDefaultTranslator($translate);
    }

    protected function _initSession()
    {
        $oRegistry = Zend_Registry::getInstance();
        $oConfig = $oRegistry->get('config')->session;
        Zend_Session::setOptions($oConfig->toArray());
        $oRegistry->set('Zend_Session_Namespace', new Zend_Session_Namespace());
    }

    protected function _initLayout()
    {
        Zend_Layout::startMvc();
    }

}

