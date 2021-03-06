<?php

/**
 * NewsController
 *
 * @author pavel
 * @version 1
 */
class ObjectsController extends modules_default_controllers_ControllerBase {

    public $ajaxable = array(
        'refresh-captcha' => array('json'),
    );

    public function init() {

        $this->slider_partial = 'photo-slider.phtml';
        $params = $this->getRequest()->getParams();
        if(isset($params['url']))
            $this->photoidenter = $params['url'];
        else 
            $this->photoidenter = 'objects';
        
        $this->jqueryFile = 'jquery-1.4.2.min.js';
        
        if (!$this->getRequest()->isXmlHttpRequest()) {
            parent::init();
        }

        $this->_helper->AjaxContext()->initContext('json');
    }

    public function indexAction() {
        $request = $this->getRequest();
        $this->view->objects = models_ObjectMapper::getAll();
    }

    public function viewAction() {
        $request = $this->getRequest();
        $id = $request->getParam('url', 0);
        if (0 === $id) {
            $this->_helper->redirector('index');
        }
        $item = models_ObjectMapper::findByUrl($id);
        if (null == $item) {
            $this->_helper->redirector('index');
        }
        $this->view->headTitle()->setDefaultAttachOrder('PREPEND');
        if ($item->headTitle)
            $this->view->headTitle()->append($item->headTitle);
        if ($item->headDescription)
            $this->view->headMeta()->appendName('description', $item->headDescription);
        if ($item->headMeta)
            $this->view->headMeta()->appendName('keywords', $item->headMeta);
        $this->view->item = $item->toArray();
    }

}

