<?php

class SocialModule extends CWebModule
{
    private $config;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

//        $this->config = include(dirname(__FILE__).'/config/config3.php');
        //photo-service.home
        $this->config = include(dirname(__FILE__).'/config/config.php');

		// import the module-level models and components
		$this->setImport(array(
//			'social.models.*',
			'social.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

    public function getConfig()
    {
        return $this->config;
    }
}
