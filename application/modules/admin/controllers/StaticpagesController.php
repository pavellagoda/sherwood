<?php

/**
 * Admin_StaticpagesController
 * 
 * @author pavel
 * @version 1
 */
class Admin_StaticpagesController extends modules_admin_controllers_ControllerBase {

    public function init() {
        /* Initialize action controller here */
        parent::init();
    }

    public function indexAction() {
        $request = $this->getRequest();

        $page = (int) $request->getParam('page', 1);

        $items = models_StaticpageMapper::getAllPaginator($page);

        $this->view->items = $items;
    }

    public function editAction() {
        $request = $this->getRequest();

        $id = (int) $request->getParam('id', 0);
        $item = models_StaticpageMapper::findById($id);
        $form = new modules_admin_forms_StaticpageEditForm();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $item->title_ru = $form->getValue('title_ru');
                $item->title_en = $form->getValue('title_en');
                $item->title_ua = $form->getValue('title_ua');
                $item->content_ru = $form->getValue('content_ru');
                $item->content_ua = $form->getValue('content_ua');
                $item->content_en = $form->getValue('content_en');
                $item->headDescription = $form->getValue('head_description');
                $item->headTitle = $form->getValue('head_title');
                $item->headMeta = $form->getValue('head_meta');
                
                models_StaticpageMapper::update($item->id, $item->toArray(), models_StaticpageMapper::$_dbTable);
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
        $item = new models_Staticpage();
        $form = new modules_admin_forms_StaticpageEditForm();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $item->title = $form->getValue('title');
                $item->tourLink = trim($form->getValue('content'));
                $item->headDescription = $form->getValue('head_description');
                $item->headTitle = $form->getValue('head_title');
                $item->headMeta = $form->getValue('head_meta');
                $id = models_StaticpageMapper::save($item);
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

        $newsItem = models_NewsMapper::findById($idNews);

        if (null != $newsItem) {
            models_NewsMapper::deleteFromBase($idNews, models_NewsMapper::$_dbTable);
        }

        $this->_redirect($this->_helper->url('index'));
    }

}

