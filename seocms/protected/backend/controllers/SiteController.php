<?php

//class SiteController extends RightsBaseController
class SiteController extends Controller
{

    public function filters()
	{
		return array(
//		    'rights',
            array('auth.filters.AuthFilter'),
        );
	}
	/**
	 * Declares class-based actions.
	 */
//	public function actions()
//	{
//		return array(
//			// captcha action renders the CAPTCHA image displayed on the contact page
//			'captcha'=>array(
//				'class'=>'CCaptchaAction',
//				'backColor'=>0xFFFFFF,
//			),
//			// page action renders "static" pages stored under 'protected/views/site/pages'
//			// They can be accessed via: index.php?r=site/page&view=FileName
//			'page'=>array(
//				'class'=>'CViewAction',
//			),
//		);
//	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
        $socialArray = Yii::app()->getModule('social')->getConfig();

        if(isset($_GET['auth'])) {
            $token = $_GET['token'];
            $authClass = ucfirst($_GET['auth']);
            Yii::import(Yii::getPathOfAlias('application.backend.modules.social.components.'.$authClass));
            $provider = new $authClass();
            if($authClass !== 'Google')
                $data = $provider->getPhotos($token);
            else
                $data = $provider->getInfo($token);

            $this->renderPartial('_photos',['data'=>$data]);
        }

        $this->render('index',['socialArray'=>$socialArray]);
	}


	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

}