<?php
class modules_default_controllers_ControllerBase extends controllers_ControllerBase
{

	/**
	 * Set content layout (full, short)
	 * @var string
	 */
	public $_contentLayout = 'full';
	protected $_bForLoggedUsersOnly = false;


	public function init()
	{
		parent::init();
		
		if (! FW_User::isLogged() && $this->_bForLoggedUsersOnly)
		{
			$this->_redirect('/login/');
		}
		

		$oZendSession = Zend_Registry::getInstance()->get('Zend_Session_Namespace');

		$this->view->headLink()->appendStylesheet('/css/common/reset.css');
		$this->view->headLink()->appendStylesheet('/css/common/960.css');
		$this->view->headLink()->appendStylesheet('/css/front/style.css');
		$this->view->headLink()->appendStylesheet('/css/front/menu.css');
		$this->view->headLink()->appendStylesheet('/css/common/sexybuttons.css');

		$this->view->headScript()->appendFile('/js/global.js');
		$this->view->headScript()->appendFile('/js/menu.js');
		$this->view->headTitle()->setSeparator(' / ');
                
                $this->view->objects = models_ObjectMapper::getAll();
                
		$frontController 			= Zend_Controller_Front::getInstance();
		$this->view->controllerName             = $frontController->getRequest()->getControllerName();
		$this->view->actionName                 = $frontController->getRequest()->getActionName();

		$this->view->headTitle()->setDefaultAttachOrder('PREPEND');
		$this->view->headTitle()->append('Аллея Гранд');

		$this->view->loggedUser = FW_User::getLoggedUser(); 
	}

}

