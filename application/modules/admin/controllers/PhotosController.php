<?php

/**
 * Admin_StaticpagesController
 * 
 * @author pavel
 * @version 1
 */
class Admin_PhotosController extends modules_admin_controllers_ControllerBase {

    public function init() {
        /* Initialize action controller here */
        parent::init();
    }

    public function indexAction() {

        $items = models_PhotoMapper::getAll();
        $this->view->items = $items;
    }

    public function editAction() {
        $request = $this->getRequest();

        $id = (int) $request->getParam('id', 0);
        $item = models_StaticpageMapper::findById($id);
        $form = new modules_admin_forms_StaticpageEditForm();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $item->title = $form->getValue('title');
                $item->content = $form->getValue('content');
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
    public function addAction() {
        $request = $this->getRequest();
        $item = new models_Staticpage();
        if ($request->isPost()) {
            
            print_r($_FILES); die;
            
            $item->title = $form->getValue('title');
            $item->tourLink = trim($form->getValue('content'));
            $item->headDescription = $form->getValue('head_description');
            $item->headTitle = $form->getValue('head_title');
            $item->headMeta = $form->getValue('head_meta');
            $id = models_StaticpageMapper::save($item);
            $this->_redirect($this->_helper->url('index'));
        }
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

