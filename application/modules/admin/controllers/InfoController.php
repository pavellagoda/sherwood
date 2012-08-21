<?php

/**
 * Info controller
 *
 * @author pavel
 *
 */
class Admin_InfoController extends modules_admin_controllers_ControllerBase
{

    public function indexAction()
    {
        $blocks = models_InfoBlockMapper::getAll(false);
        $this->view->blocks = $blocks;
    }

    public function addAction()
    {
        $form = new modules_admin_forms_InfoEditForm();
        $this->view->form = $form;
    }
    public function editAction()
    {
        $form = new modules_admin_forms_InfoEditForm();
        $this->view->form = $form;
    }

}