<?php

/**
 * Admin_StaticpagesController
 * 
 * @author pavel
 * @version 1
 */
class Admin_PhotosController extends modules_admin_controllers_ControllerBase {

    private $pagelist = array(
        'contacts' => 'Контакты',
        'main' => 'Главная',
        'about' => 'О компании',
        'objects' => 'Заведения',
        'vacancies' => 'Вакансии',
        'programs' => 'Программы лояльности',
        'news' => 'Новости',
    );

    public function init() {
        /* Initialize action controller here */
        parent::init();
        
        $objects = models_ObjectMapper::getAll();
        foreach ($objects as $object) {
            $this->pagelist[$object->tourLink] = $object->title_ru;
        }
        $this->view->pagelist = $this->pagelist;
    }

    public function indexAction() {

        $page = $this->getRequest()->getParam('page', 1);
        $items = models_PhotoMapper::getAllPaginator($page, 14);
        $this->view->items = $items;
    }

    public function editAction() {
        $request = $this->getRequest();
        $id = $request->getParam('id');

        $photo = models_PhotoMapper::findById($id);
        
        if ($request->isPost()) {
            $post = $request->getPost();
            models_PhotoPageMapper::delete($id);
            $photo_id = $id;
            $this->createRecords($post, 0, $photo_id);
            $photo->title_ru = $post['title_ru'];
            $photo->title_en = $post['title_en'];
            $photo->title_ua = $post['title_ua'];
            if ($_FILES['photo']['size']) {
                $path = $_SERVER['DOCUMENT_ROOT'] . '/i/galleries/images/' . $photo_id . '.' . $photo->extention;
                $path_preview = $_SERVER['DOCUMENT_ROOT'] . '/i/galleries/previews/' . $photo_id . '.' . $photo->extention;
                if (is_file($path))
                    unlink($path);
                if (is_file($path_preview))
                    unlink($path_preview);
                $name_parts = explode('.', $_FILES['photo']['name']);
                $ext = $name_parts[count($name_parts) - 1];
                $photo->extention = $ext;
                move_uploaded_file($_FILES['photo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/i/galleries/images/' . $photo_id . '.' . $ext);
                move_uploaded_file($_FILES['preview']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/i/galleries/previews/' . $photo_id . '.' . $ext);
            }
            models_PhotoMapper::update($id, $photo->toArray());
        }
        
        $photos_pages = models_PhotoPageMapper::findByPhotoId($id);
        $page_list = array();
        foreach ($photos_pages as $item) {
            $page_list[] = $item->page;
        }

        $this->view->item = $photo;
        $this->view->page_list = $page_list;
    }

    public function addAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            foreach ($_FILES['photo']['size'] as $id => $size) {
                if ($size) {
                    $name_parts = explode('.', $_FILES['photo']['name'][$id]);
                    $ext = $name_parts[count($name_parts) - 1];
                    $model = new models_Photo();
                    $model->extention = $ext;
                    $model->title_ru = $post['title_ru'][$id];
                    $model->title_en = $post['title_en'][$id];
                    $model->title_ua = $post['title_ua'][$id];
                    $photo_id = models_PhotoMapper::save($model);
                    $this->createRecords($post, $id, $photo_id);
                    move_uploaded_file($_FILES['photo']['tmp_name'][$id], $_SERVER['DOCUMENT_ROOT'] . '/i/galleries/images/' . $photo_id . '.' . $ext);
                    move_uploaded_file($_FILES['preview']['tmp_name'][$id], $_SERVER['DOCUMENT_ROOT'] . '/i/galleries/previews/' . $photo_id . '.' . $ext);
                }
            }
        }
        $this->view->page_list = array();
    }

    private function createRecords($post, $id, $photo_id) {

        foreach ($this->pagelist as $key => $name) {
            if (isset($post[$key][$id])) {
                $model = new models_PhotoPage();
                $model->photo_id = $photo_id;
                $model->page = $key;
                models_PhotoPageMapper::save($model);
            }
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

