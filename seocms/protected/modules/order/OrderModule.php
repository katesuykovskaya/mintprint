<?php

class OrderModule extends CWebModule
{
    public $config;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
        $this->config = include(dirname(__FILE__).'/config/config.php');
		// import the module-level models and components
		$this->setImport(array(
			'order.models.*',
			'order.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerCoreScript('jquery.ui');
			return true;
		}
		else
			return false;
	}
}
