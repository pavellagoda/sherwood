<?php

/**
 * Info controller
 *
 * @author pavel
 *
 */
class Admin_InfoController extends modules_admin_controllers_ControllerBase {

    public function indexAction() {
        $blocks = models_InfoBlockMapper::getAll(false);
        $this->view->blocks = $blocks;
    }

    public function addAction() {
        $form = new modules_admin_forms_InfoEditForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            if ($form->isValid($post)) {

                $name_parts = explode('.', $_FILES['bg']['name']);
                $ext = end($name_parts);

                $model = new models_InfoBlock();
                $model->text_ru = $post['text_ru'];
                $model->text_en = $post['text_en'];
                $model->text_ua = $post['text_ua'];
                $model->status = $post['status'];
                $model->background_extention = $ext;

                $id = models_InfoBlockMapper::save($model);

                move_uploaded_file($_FILES['bg']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/i/infoblocks/' . $id . '.' . $ext);

                $this->_helper->redirector('index');
            }
            $form->populate($post);
        }

        $this->view->form = $form;
        $this->view->headScript()->appendFile('/js/tiny_mce/tiny_mce.js');
        $this->view->headScript()->appendFile('/js/texteditor_small.js');
    }

    public function editAction() {
        $request = $this->getRequest();
        $id = $request->getParam('id');
        $form = new modules_admin_forms_InfoEditForm();
        $model = models_InfoBlockMapper::findById($id);

        if ($request->isPost()) {
            $post = $request->getPost();
            if ($form->isValid($post)) {

                $model->text_ru = $post['text_ru'];
                $model->text_en = $post['text_en'];
                $model->text_ua = $post['text_ua'];
                $model->status = $post['status'];

                if (!$_FILES['bg']['error']) {

                    @unlink($_SERVER['DOCUMENT_ROOT'] . '/i/infoblocks/' . $id . '.' . $model->background_extention);
                    
                    $name_parts = explode('.', $_FILES['bg']['name']);
                    $ext = end($name_parts);
                    $model->background_extention = $ext;
                    move_uploaded_file($_FILES['bg']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/i/infoblocks/' . $id . '.' . $ext);
                }
                models_InfoBlockMapper::update($id, $model->toArray());
            }
        }

        $form->populate($model->toArray());
        $this->view->form = $form;
        $this->view->headScript()->appendFile('/js/tiny_mce/tiny_mce.js');
        $this->view->headScript()->appendFile('/js/texteditor_small.js');
    }
    
    public function deleteAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();

        $id = (int) $request->getParam('id', 0);

        $item = models_InfoBlockMapper::findById($id);

        if (null != $item) {
            models_InfoBlockMapper::deleteFromBase($id, models_InfoBlockMapper::$_dbTable);
        }

        $this->_redirect($this->_helper->url('index'));
    }

}