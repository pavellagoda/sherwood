<?php

/**
 * Admin_ObjectsController
 * 
 * @author pavel
 * @version 1
 */
class Admin_ObjectsController extends modules_admin_controllers_ControllerBase {

    public function init() {
        /* Initialize action controller here */
        parent::init();
    }

    public function indexAction() {
        $request = $this->getRequest();

        $page = (int) $request->getParam('page', 1);

        $objects = models_ObjectMapper::getAllPaginator($page);

        $this->view->objects = $objects;
    }

    public function editAction() {
        $request = $this->getRequest();

        $id = (int) $request->getParam('id', 0);
        $item = models_ObjectMapper::findById($id);
        $form = new modules_admin_forms_ObjectEditForm();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $item->title = $form->getValue('title');
                $item->short = $form->getValue('short');
                $item->full = $form->getValue('full');
                $item->tourLink = FW_Strings::titleToSeo($item->title);
                $item->isTour = $form->getValue('is_tour');
                $item->headDescription = $form->getValue('head_description');
                $item->headTitle = $form->getValue('head_title');
                $item->headMeta = $form->getValue('head_meta');
                models_ObjectMapper::update($item->id, $item->toArray(), models_ObjectMapper::$_dbTable);
                $this->_redirect($this->_helper->url('index'));
            }
        }
        $form->populate($item->toArray());
        $this->view->form = $form;
        $this->view->headScript()->appendFile('/js/tiny_mce/tiny_mce.js');
        $this->view->headScript()->appendFile('/js/texteditor.js');
    }
    public function createAction() {
        $request = $this->getRequest();
        $item = new models_Object();
        $form = new modules_admin_forms_ObjectEditForm();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $item->title = $form->getValue('title');
                $item->short = $form->getValue('short');
                $item->full = $form->getValue('full');
                $item->tourLink = FW_Strings::titleToSeo($item->title);
                $item->isTour = $form->getValue('is_tour');
                $item->headDescription = $form->getValue('head_description');
                $item->headTitle = $form->getValue('head_title');
                $item->headMeta = $form->getValue('head_meta');
                $id = models_ObjectMapper::save($item);
                $this->_redirect($this->_helper->url('index'));
            }
            $form->populate($request->getPost());
        }
        $this->view->form = $form;
        $this->view->headScript()->appendFile('/js/tiny_mce/tiny_mce.js');
        $this->view->headScript()->appendFile('/js/texteditor.js');
    }

    public function deleteAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();

        $idNews = (int) $request->getParam('id', 0);

        $newsItem = models_ObjectMapper::findById($idNews);

        if (null != $newsItem) {
            models_NewsMapper::deleteFromBase($idNews, models_ObjectMapper::$_dbTable);
        }

        $this->_redirect($this->_helper->url('index'));
    }

}

