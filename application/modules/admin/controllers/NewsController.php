<?php

/**
 * Admin NewsController
 * 
 * @author pavel
 * @version 1
 */
class Admin_NewsController extends modules_admin_controllers_ControllerBase {

    public function init() {
        /* Initialize action controller here */
        parent::init();
    }

    public function indexAction() {
        $request = $this->getRequest();

        $page = (int) $request->getParam('page', 1);

        $category = (int) $request->getParam('category', 0);

        $news = models_NewsMapper::getAllPaginator($category, $page);

        $this->view->news = $news;
    }

    public function editAction() {
        $request = $this->getRequest();

        $idNews = (int) $request->getParam('id', 0);
        $newsItem = models_NewsMapper::findById($idNews);
        $form = new modules_admin_forms_NewsEditForm();

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $values = $form->getValues();
                foreach ($values as $key=>$value) {
                    $newsItem->$key = $value;
                }
                
                $newsItem->seoUrlRu = FW_Strings::titleToSeo($newsItem->title_ru);
                $newsItem->seoUrlEn = FW_Strings::titleToSeo($newsItem->title_en);
                $newsItem->seoUrlUa = FW_Strings::titleToSeo($newsItem->title_ua);
                
                models_NewsMapper::update($newsItem->id, $newsItem->toArray(), models_NewsMapper::$_dbTable);
                $this->_redirect($this->_helper->url('index'));
            }
        }
        $form->populate($newsItem->toArray());
        $this->view->form = $form;
        $this->view->headScript()->appendFile('/js/tiny_mce/tiny_mce.js');
        $this->view->headScript()->appendFile('/js/texteditor.js');

        $this->view->newsItem = $newsItem;
    }

    public function createAction() {
        $request = $this->getRequest();
        $newsItem = new models_News();
        $form = new modules_admin_forms_NewsEditForm();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $values = $form->getValues();
                foreach ($values as $key=>$value) {
                    $newsItem->$key = $value;
                }
                $newsItem->seoUrlRu = FW_Strings::titleToSeo($newsItem->title_ru);
                $newsItem->seoUrlEn = FW_Strings::titleToSeo($newsItem->title_en);
                $newsItem->seoUrlUa = FW_Strings::titleToSeo($newsItem->title_ua);
                
                $idNews = models_NewsMapper::save($newsItem);
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

