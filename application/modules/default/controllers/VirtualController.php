<?php

/**
 * NewsController
 *
 * @author pavel
 * @version 1
 */
class VirtualController extends modules_default_controllers_ControllerBase {

    public $ajaxable = array(
        'refresh-captcha' => array('json'),
    );

    public function init() {
        $this->leftMenuPart = false;
        $this->showRightPart = false;
        if (!$this->getRequest()->isXmlHttpRequest()) {
            parent::init();
        }

        $this->_helper->AjaxContext()->initContext('json');
    }

    public function viewAction() {
        $request = $this->getRequest();
        $object = $request->getParam('object', 0);
        if (0 === $object) {
            $this->_helper->redirector('index', 'index');
        }
        $this->view->object = models_ObjectMapper::findByUrl($object);
    }

}

