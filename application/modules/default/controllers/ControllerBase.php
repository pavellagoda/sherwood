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
        protected $slider_partial = 'photo-imageflow.phtml';
        protected $language; 


	public function init()
	{
		parent::init();
                
                $lang = new Zend_Session_Namespace('language');
                
                if(!isset($lang->language))
                    $lang->language = 'ru';
		
                $this->language = $lang->language;
		if (! FW_User::isLogged() && $this->_bForLoggedUsersOnly)
		{
			$this->_redirect('/login/');
		}
		

		$oZendSession = Zend_Registry::getInstance()->get('Zend_Session_Namespace');

                $this->view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=utf-8');
                
		$this->view->headLink()->appendStylesheet('/css/front/style.css?rand='.rand(1,100000));
		$this->view->headLink()->appendStylesheet('/css/common/sexybuttons.css?rand='.rand(1,100000));
		$this->view->headLink()->appendStylesheet('/css/fancybox/fancybox.css?rand='.rand(1,100000));
		$this->view->headLink()->appendStylesheet('/css/slider/slider.css?rand='.rand(1,100000));
		$this->view->headLink()->appendStylesheet('/css/front/menu_static.css?rand='.rand(1,100000));
		$this->view->headLink()->appendStylesheet('/css/gallery/feature-carousel.css?rand='.rand(1,100000));
		
		$this->view->headScript()->appendFile('/js/global.js?rand='.rand(1,100000));
		$this->view->headScript()->appendFile('/js/menu.js?rand='.rand(1,100000));
		$this->view->headScript()->appendFile('/js/slider.js?rand='.rand(1,100000));
		$this->view->headScript()->appendFile('/js/lib/funcybox/jquery.fancybox-1.3.1.js?rand='.rand(1,100000));
		$this->view->headScript()->appendFile('/js/lib/funcybox/jquery.mousewheel-3.0.2.pack.js?rand='.rand(1,100000));
		$this->view->headScript()->appendFile('/js/feature-carousel/jquery.featureCarousel.js?rand='.rand(1,100000));
                $this->view->headScript()->appendFile('/js/imageflow-instance.js?rand='.rand(1,100000));
		$this->view->headTitle()->setSeparator(' / ');
                
                $this->view->objects = models_ObjectMapper::getAll();
                $this->view->photos = models_PhotoPageMapper::findAllByPage($this->photoidenter);
                $this->view->photoidenter = $this->photoidenter;
                $this->view->leftMenuPart = $this->leftMenuPart;
                
                $this->view->lastNews = models_NewsMapper::getLast(3);
                $this->view->showLastMenuBlock = $this->showLastMenuBlock;
                $this->view->showRightPart = $this->showRightPart;
                $this->view->slider_partial = $this->slider_partial;
                $this->view->info_blocks = models_InfoBlockMapper::getAll(true);
                
		$frontController 			= Zend_Controller_Front::getInstance();
		$this->view->controllerName             = $frontController->getRequest()->getControllerName();
		$this->view->actionName                 = $frontController->getRequest()->getActionName();

		$this->view->headTitle()->setDefaultAttachOrder('PREPEND');
		$this->view->headTitle()->append('Алея Смаку');
                
                $this->view->lang = $lang->language;
                
                $this->view->objects = models_ObjectMapper::getAll();
		$this->view->loggedUser = FW_User::getLoggedUser(); 
                $this->view->request = $this->getRequest()->getParams();
	}

}

