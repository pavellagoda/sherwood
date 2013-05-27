<?php

/**
 * NewsController
 *
 * @author pavel
 * @version 1
 */
class BackformController extends modules_default_controllers_ControllerBase {

    public $ajaxable = array(
        'refresh-captcha' => array('json'),
    );
    
    protected $slider_partial = 'photo-slider.phtml';
    protected $photoidenter = 'objects';

    public function init() {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            parent::init();
        }
        $this->_helper->AjaxContext()->initContext('json');
    }

    public function indexAction() {

        $form = new modules_default_forms_CommentForm();

        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
            $lang = new Zend_Session_Namespace('language');
            $this->view->lang = $lang->language;
        }

        $showSuccessMessage = false;
        $parent_id = 0;

        if ($request->isPost()) {
            if ($form->isValid($request->getParams())) {
                $model = new models_Comment();
                $model->parent_id = $request->getParam('parent_id');
                $model->name = $request->getParam('name');
                $model->email = $request->getParam('email');
                $model->message = $request->getParam('text');
                $model->moderated = 0;
                $model->created_ts = time();
                models_CommentMapper::save($model);
                $showSuccessMessage = true;
                if($model->parent_id > 0) {
                    $parent_id = 1;
                }
            } else {
                $form->populate($request->getParams());
            }
        }
        
        
        $this->view->comments = FW_CommentsComparator::getCommentsRecursive();
        $this->view->parent_id = $parent_id;
        $this->view->showSuccessMessage = $showSuccessMessage;

        $this->view->headScript()->appendFile('/js/backform.js?rand=' . rand(1, 100000));

        $this->view->form = $form;
    }

    public function refreshCaptchaAction() {
        $form = new modules_default_forms_CommentForm();
        $this->view->captcha = $form->captcha->getCaptcha()->generate();
    }

}

