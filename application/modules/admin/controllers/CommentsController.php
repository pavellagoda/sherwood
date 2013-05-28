<?php

/**
 * Admin CommentsController
 * 
 * @author pavel
 * @version 1
 */
class Admin_CommentsController extends modules_admin_controllers_ControllerBase
{

    public function init()
    {
        /* Initialize action controller here */
        parent::init();
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        $this->view->comments = models_CommentMapper::getAllByParentIdPaginator(0, $request->getParam('page',1), 10, false);
    }
    public function deleteAction()
    {
        $request = $this->getRequest();
        $id = $request->getParam('id');
        if($id) {
            models_CommentMapper::delete($id);
            $this->_redirect($this->_helper->url('index'));
        }
    }
    
    public function moderateAction() {
        $request = $this->getRequest();
        if($request->isPost()) {
            $comment_id = $request->getParam('comment_id');
            $moderate = $request->getParam('moderate_val');
            if($comment_id) {
                models_CommentMapper::update($comment_id, array('moderated' => $moderate));
            }
        }
        die;
    }

}

