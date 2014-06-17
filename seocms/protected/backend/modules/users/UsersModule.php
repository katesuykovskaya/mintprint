<?php

class UsersModule extends CWebModule
{
    public $urlRules = array(
//        '/users'=>'users/users/index',
//        '/adminka'=>'users/users/adminka',
//        '/<language:(\w){2}>/users'=>'users/users/index',
//        '/<language:(\w){2}>/login'=>'users/users/login',
//        'login'=>'users/users/login',
//        'logout'=>'users/users/logout',
//        '<language:(\w){2}>/adminka'=>'users/users/adminka',
    );


    public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

        //переопределяем языковые настройки для модуля
        Yii::app()->setComponents(
            array('messages' => array(
//                'class'=>'CPhpMessageSource',
                    'class'=>'CDbMessageSource',
//                'basePath'=>'protected/modules/'.$this->getName().'/messages',
                'forceTranslation'=>true,
            )));


		// import the module-level models and components
		$this->setImport(array(
//			'users.models.*',
//			'users.components.*',
//            'application.modules.backendmenu.models.*' // не есть правильно, не должно зависеть жестко от другого компонента
            'application.backend.modules.users.models.*'
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
}
