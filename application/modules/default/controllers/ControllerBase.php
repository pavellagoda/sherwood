<?php
class modules_default_controllers_ControllerBase extends controllers_ControllerBase
{

	/**
	 * Set content layout (full, short)
	 * @var string
	 */
	public $_contentLayout = 'full';
	protected $_bForLoggedUsersOnly = false;
        protected $leftMenuPart = 'inner.phtml';
        protected $showLastMenuBlock = true;
        protected $showRightPart = true;
        protected $photoidenter = 'main';


	public function init()
	{
		parent::init();
		
		if (! FW_User::isLogged() && $this->_bForLoggedUsersOnly)
		{
			$this->_redirect('/login/');
		}
		

		$oZendSession = Zend_Registry::getInstance()->get('Zend_Session_Namespace');

                $this->view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=utf-8');
                
		$this->view->headLink()->appendStylesheet('/css/common/reset.css');
		$this->view->headLink()->appendStylesheet('/css/common/960.css');
		$this->view->headLink()->appendStylesheet('/css/front/style.css');
		$this->view->headLink()->appendStylesheet('/css/front/menu.css');
		$this->view->headLink()->appendStylesheet('/css/common/sexybuttons.css');
		$this->view->headLink()->appendStylesheet('/css/fancybox.css');
		$this->view->headLink()->appendStylesheet('/css/slider.css');

		$this->view->headScript()->appendFile('/js/global.js');
		$this->view->headScript()->appendFile('/js/menu.js');
		$this->view->headScript()->appendFile('/js/slider.js');
		$this->view->headScript()->appendFile('/js/lib/funcybox/jquery.fancybox-1.3.1.js');
		$this->view->headScript()->appendFile('/js/lib/funcybox/jquery.mousewheel-3.0.2.pack.js');
		$this->view->headTitle()->setSeparator(' / ');
                
                $this->view->objects = models_ObjectMapper::getAll();
                $this->view->photos = models_PhotoPageMapper::findAllByPage($this->photoidenter);
                $this->view->leftMenuPart = $this->leftMenuPart;
                
                $this->view->lastNews = models_NewsMapper::getLast(3);
                $this->view->showLastMenuBlock = $this->showLastMenuBlock;
                $this->view->showRightPart = $this->showRightPart;
                
		$frontController 			= Zend_Controller_Front::getInstance();
		$this->view->controllerName             = $frontController->getRequest()->getControllerName();
		$this->view->actionName                 = $frontController->getRequest()->getActionName();

		$this->view->headTitle()->setDefaultAttachOrder('PREPEND');
		$this->view->headTitle()->append('Аллея Гранд');

		$this->view->loggedUser = FW_User::getLoggedUser(); 
	}

}

