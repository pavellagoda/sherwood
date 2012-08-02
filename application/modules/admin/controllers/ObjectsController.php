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
        
        if($request->isPost()) {
            $post = $request->getPost(); 
            foreach($post['order'] as $id=>$order) {
                $model = models_ObjectMapper::findById($id);
                $model->order = $order;
                models_ObjectMapper::update($id, $model->toArray(), models_ObjectMapper::$_dbTable);
            }
        }

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
                $item->title_ru = $form->getValue('title_ru');
                $item->title_en = $form->getValue('title_en');
                $item->title_ua = $form->getValue('title_ua');
                $item->short_ru = $form->getValue('short_ru');
                $item->short_en = $form->getValue('short_en');
                $item->short_ua = $form->getValue('short_ua');
                $item->full_ru = $form->getValue('full_ru');
                $item->full_en = $form->getValue('full_en');
                $item->full_ua = $form->getValue('full_ua');
//                $item->tourLink = FW_Strings::titleToSeo($item->title);
                $item->isTour = $form->getValue('is_tour');
                $item->headDescription = $form->getValue('head_description');
                $item->headTitle = $form->getValue('head_title');
                $item->headMeta = $form->getValue('head_meta');
                models_ObjectMapper::update($item->id, $item->toArray(), models_ObjectMapper::$_dbTable);
                $this->_redirect($this->_helper->url('index'));
            }
            $form->populate($form->getValues());
        } else {
            $form->populate($item->toArray());
        }
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
                $item->title_ru = $form->getValue('title_ru');
                $item->title_en = $form->getValue('title_en');
                $item->title_ua = $form->getValue('title_ua');
                $item->short_ru = $form->getValue('short_ru');
                $item->short_en = $form->getValue('short_en');
                $item->short_ua = $form->getValue('short_ua');
                $item->full_ru = $form->getValue('full_ru');
                $item->full_en = $form->getValue('full_en');
                $item->full_ua = $form->getValue('full_ua');
                $item->tourLink = FW_Strings::titleToSeo($item->title);
                $item->isTour = $form->getValue('is_tour');
                $item->headDescription = $form->getValue('head_description');
                $item->headTitle = $form->getValue('head_title');
                $item->headMeta = $form->getValue('head_meta');
                $item->order = 1;
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

