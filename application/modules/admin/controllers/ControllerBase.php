<?php

class modules_admin_controllers_ControllerBase extends controllers_ControllerBase
{

    /**
     * Set content layout (full, short)
     * @var string
     */
    protected $_bForLoggedAdminOnly = true;

    public function init()
    {
        parent::init();

        $oZendSession = Zend_Registry::getInstance()->get('Zend_Session_Namespace');

        if (!FW_Admin_Auth::isLogged() && $this->_bForLoggedAdminOnly) {
            $this->_redirect('/admin/login/');
        }

//		$this->view->headLink()->appendStylesheet('/css/common/reset.css');
//		$this->view->headLink()->appendStylesheet('/css/common/960.css');
//		$this->view->headLink()->appendStylesheet('/css/common/sexybuttons.css');

        $this->view->headLink()->appendStylesheet($this->view->baseUrl('/bootstrap/css/bootstrap.min.css'));
//        $this->view->headLink()->appendStylesheet('/bootstrap/css/bootstrap-responsive.min.css');
        $this->view->headLink()->appendStylesheet($this->view->baseUrl('/bootstrap/css/bootstrap-yii.css'));

        $this->view->headLink()->appendStylesheet('/css/admin/main.css?r=' . rand(1, 100000));
        $this->view->headLink()->appendStylesheet('/css/datapicker.css');

        $this->view->headScript()->appendFile('/js/global.js');
        $this->view->headScript()->appendFile('/js/lib/jquery-1.7.1.min.js');
        $this->view->headScript()->appendFile('/js/lib/ui/jquery-ui.js');
        $this->view->headScript()->appendFile($this->view->baseUrl('/bootstrap/js/bootstrap-dropdown.js'));

        $this->view->headScript()->appendFile('/js/lib/ui/jquery.datepicker.js');

        $this->view->loggedUser = FW_Admin_Auth::getLoggedAdminId();
        
        $this->view->headTitle()->setSeparator(' / ');

        $this->view->siteName = 'Sherwood and Ko';
    }

}

