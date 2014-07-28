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
        Yii::app()->clientScript->registerCssFile('/css/backend.css');
        $this->render('index');
    }

    /*
     * this action is exceptionally for SocialPhotosWidget
     */
    public function actionPhotosFromAlbum() {
        if(Yii::app()->request->isAjaxRequest) {
            $provider = $_REQUEST['auth'];
            $authClass = ucfirst($provider);
            $auth = new $authClass();
            $token = Yii::app()->session[$provider.'_token'];
            $data = $auth->getPhotosFromAlbum($_GET['aid'], $token);
            $album = $auth->getAlbums($token, array('album_ids' => $_GET['aid']))[0];
            $this->layout = false;
            $this->render('application.backend.modules.social.widgets.views.photos', array(
                'photos'=>$data,
                'album'=>$album
            ));
        }

    }
}