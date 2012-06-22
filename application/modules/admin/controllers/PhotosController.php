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
        $id = $request->getParam('id');
        
        $photo = models_PhotoMapper::findById($id);
        $photos_pages = models_PhotoPageMapper::findByPhotoId($id);
        $page_list = array();
        
        foreach($photos_pages as $item) {
            $page_list[] = $item->page;
        }
        
        $this->view->item = $photo;
        $this->view->page_list = $page_list;
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

