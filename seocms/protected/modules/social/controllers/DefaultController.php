<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionAuth()
    {
        $authprovider = $_GET['authprovider'];
        require Yii::getPathOfAlias('webroot').'/seocms/protected/backend/vendors/autoload.php';
//        $scenario = Yii::app()->request->getParam('scenario');
        $authClass = ucfirst($authprovider);
        $auth = new $authClass();
        $token = $auth->getToken();

        $this->redirect($this->createUrl('/site/index', array('auth'=>$authprovider,'token'=>$token)));
//        $this->redirect($this->createUrl('/backend/social/default/photos?auth='.$authprovider.'&token='.$token.'&scenario='.$scenario));
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
        if(isset($_GET['token']) && isset($_GET['auth'])) {
            Yii::app()->session[$_GET['auth'].'_token'] = $_GET['token'];
        }
        Yii::app()->clientScript->registerCssFile('/css/backend.css');
        $socials = array(
            'vk',
            'fb',
            'instagram'
        );
        $this->render('index', array(
            'socials'=>$socials
        ));
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
            $album = $auth->getAlbums($token, array('album_ids' => $_GET[$config['album_id']]))[0];
//            $this->layout = false;
            $this->renderPartial('application.modules.social.widgets.views.photos', array(
                'photos'=>$data,
                'provider'=>$provider,
                'album'=>$album,
                'album_config'=>$config
            ));
        }
    }

    public function actionAlbums() {
        Yii::import('application.modules.social.widgets.SocialPhotoWidget');
        $widget = new SocialPhotoWidget;
        $widget->config = $this->module->config;
        $widget->getAlbum($_GET['provider']);
    }

    public function  actionInstagramViewMore() {
        $ins = new Guzzle\Http\StaticClient;
        $req = $ins::get($_POST['url']);
        $nextPhotos = $req->json();
        $this->renderPartial('application.modules.social.widgets.views._instagramPhotos', array(
            'photos'=>$nextPhotos
        ));
    }

    public function actionClearSession() {
        unset(Yii::app()->session['vk_token']);
        unset(Yii::app()->session['fb_token']);
        unset(Yii::app()->sessopn['instagram_token']);
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
}