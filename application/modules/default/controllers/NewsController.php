<?php

/**
 * NewsController
 *
 * @author pavel
 * @version 1
 */
class NewsController extends modules_default_controllers_ControllerBase {

    public $ajaxable = array(
        'refresh-captcha' => array('json'),
    );

    public function _init() {
        $this->photoidenter = 'news';
        if (!$this->getRequest()->isXmlHttpRequest()) {
            parent::init();
        }
        $this->_helper->AjaxContext()->initContext('json');
    }

    public function indexAction() {
        $this->showLastMenuBlock = false;
        $this->_init();
        $request = $this->getRequest();
        $this->view->news = models_NewsMapper::getAllPaginator(0, $request->getParam('page', 1), 25);
    }

    public function viewAction() {
        $this->_init();
        $request = $this->getRequest();
        $url = $request->getParam('url', '');
        if (0 === $url) {
            $this->_helper->redirector('index');
        }
        $item = models_NewsMapper::findBySeo($url);
        if (null == $item) {
            $this->_helper->redirector('index');
        }

        $this->view->item = $item;
    }

}

