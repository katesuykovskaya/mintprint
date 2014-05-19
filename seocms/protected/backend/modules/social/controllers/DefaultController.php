<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionAuth($authprovider)
    {
        $scenario = Yii::app()->request->getParam('scenario');

        $authClass = ucfirst($authprovider);
        $auth = new $authClass();
        $token = $auth->getToken();

        $this->redirect($this->createUrl('/backend/social/default/photos?auth='.$authprovider.'&token='.$token.'&scenario='.$scenario));
    }

    public function actionAjaxAuth()
    {
        $provider = $_POST['provider'];
        $authClass = ucfirst($provider);
        $auth = new $authClass();
        $token = $auth->getToken();

        $this->redirect($this->createUrl('/backend?auth='.$provider.'&token='.$token));
    }
    public function actionPhotos()
    {
        //CAAVLxHgeUkYBAK2TZBk3jRKCUwVLyCAnYeNoAAbxZAqF1ZArBwQEWRmHfbrZCJAxMCcyUQPn1NnPR7fousgc6xGQb9QpjD0hZCL2nMrX5jFu2ptrZAe2nBm1a4Comv7PfZBQwGdDjuwvWGzs9pXlaELiyqg3GTjfyUKjEZCxCf2LuZAvaqUIkbxvm
        //Yii::app()->session['fb_token'] = 'CAAVLxHgeUkYBAK2TZBk3jRKCUwVLyCAnYeNoAAbxZAqF1ZArBwQEWRmHfbrZCJAxMCcyUQPn1NnPR7fousgc6xGQb9QpjD0hZCL2nMrX5jFu2ptrZAe2nBm1a4Comv7PfZBQwGdDjuwvWGzs9pXlaELiyqg3GTjfyUKjEZCxCf2LuZAvaqUIkbxvm';
        Yii::app()->clientScript->registerCssFile('/css/backend.css');
        $this->render('index');
    }

    /*
     * this action is exceptionally for SocialPhotosWidget
     */
    public function actionPhotosFromAlbum() {
        if(Yii::app()->request->isAjaxRequest) {
            $provider = $_REQUEST['auth'];
            $config = $this->module->config[$provider]['albums'];
            $authClass = ucfirst($provider);
            $auth = new $authClass();
            $token = Yii::app()->session[$provider.'_token'];
            $data = $auth->getPhotosFromAlbum($_GET[$config['album_id']], $token);
//            $album = $auth->getAlbums($token, array('album_ids' => $_GET['aid']))[0];
            $this->layout = false;
            $this->render('application.backend.modules.social.widgets.views.photos', array(
                'photos'=>$data,
//                'album'=>$album
            ));
        }

    }
}