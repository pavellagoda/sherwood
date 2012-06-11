<?php

/**
 * IndexController
 *
 * @author pavel
 * @version 1
 */
class StaticpagesController extends modules_default_controllers_ControllerBase {

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
        $page = $request->getParam('page');
        $item = models_StaticpageMapper::findByPage($page);
        $this->view->headTitle()->setDefaultAttachOrder('PREPEND');
        if ($item->headTitle)
            $this->view->headTitle()->append($item->headTitle);
        else
            $this->view->headTitle($item->title);
        if ($item->headDescription)
            $this->view->headMeta()->appendName('description', $item->headDescription);
        if ($item->headMeta)
            $this->view->headMeta()->appendName('keywords', $item->headMeta);

        $this->view->item = $item;
    }

}

