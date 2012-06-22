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
        if ($request->isPost()) {
            $post = $request->getPost();
            foreach ($_FILES['photo']['size'] as $id=>$size ) {
                if($size) {
                    $name_parts = explode('.',$_FILES['photo']['name'][$id]);
                    $ext = $name_parts[count($name_parts)-1];
                    $model = new models_Photo();
                    $model->extention = $ext;
                    $photo_id = models_PhotoMapper::save($model);
                    if(isset($post['contacts'][$id])) {
                        $model = new models_PhotoPage();
                        $model->photo_id = $photo_id;
                        $model->page = 'contacts';
                        models_PhotoPageMapper::save($model);
                    }
                    if(isset($post['main'][$id])) {
                        $model = new models_PhotoPage();
                        $model->photo_id = $photo_id;
                        $model->page = 'main';
                        models_PhotoPageMapper::save($model);
                    }
                    if(isset($post['objects'][$id])) {
                        $model = new models_PhotoPage();
                        $model->photo_id = $photo_id;
                        $model->page = 'objects';
                        models_PhotoPageMapper::save($model);
                    }
                    if(isset($post['about'][$id])) {
                        $model = new models_PhotoPage();
                        $model->photo_id = $photo_id;
                        $model->page = 'about';
                        models_PhotoPageMapper::save($model);
                    }
                    move_uploaded_file($_FILES['photo']['tmp_name'][$id], $_SERVER['DOCUMENT_ROOT'].'/i/galleries/'.$photo_id.'.'.$ext);
                }
            }
            
//            $this->_redirect($this->_helper->url('index'));
        }
    }

    public function deleteAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();

        $idNews = (int) $request->getParam('id', 0);

        $newsItem = models_PhotoMapper::findById($idNews);

        if (null != $newsItem) {
            models_PhotoMapper::deleteFromBase($idNews, models_PhotoMapper::$_dbTable);
        }

        $this->_redirect($this->_helper->url('index'));
    }

}

