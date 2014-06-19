<?php

class SiteController extends Controller
{
    public $layout = '//layouts/main';
    public $switchlangParams = array('from'=>'url');
    public $mainUrl;
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */

    public function beforeAction($action) {
        if(parent::beforeAction($action)) {
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerCoreScript('jquery.ui');
            return true;
        }
        return false;
    }

    public function init() {
        parent::init();
        $this->mainUrl = Yii::app()->createUrl('main.html', ['language'=>Yii::app()->language]);
    }

	public function actionIndex() {
        if(isset($_GET['token']) && isset($_GET['auth'])) {
            Yii::app()->session[$_GET['auth'].'_token'] = $_GET['token'];
        }
        Yii::import('application.modules.order.models.OrderTemp');
        $orderConf = require(Yii::getPathOfAlias('application.modules.order.config.config').'.php');
        $sum = OrderTemp::CollectPrice($orderConf['price']);
        $this->render('index', array(
            'sum'=>$sum
        ));
	}

    public function actionHome() {
        $this->layout = '//layouts/home';
        $this->render('home');
    }

    public function actionEdit() {
        $this->render('edit');
    }

    public function actionUpload()
    {
        Yii::import("ext.EAjaxUpload.qqFileUploader");
        $folder = Yii::getPathOfAlias('webroot').'/uploads/tmp/'.Yii::app()->session->sessionID.'/';
        if(!file_exists($folder))
            mkdir($folder, 0777);
        $allowedExtensions = array("jpg","jpeg","gif","png");
        $sizeLimit = 100 * 9216 * 1024 + 1;// maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);

        if(!empty($result['success'])){

            $crop = new EasyImage($result['uploadDirectory'] . $result['filename'] . '.' . $result['ext']);
            $sizeImg = $crop->resize(97, 97, $result['master']);
            $crop->save($result['uploadDirectory'] . $result['filename'] . 'Icon' . '.' . $result['ext']);

//            $sizeImg = getimagesize(Yii::app()->easyImage->thumbOf($result['uploadDirectory'] . $result['filename'] . '.' . $result['ext'], array(
//                "resize" => array("width"=>97, 'height' => 97, "master"=>$result['master']),
//                "savePath"=>$result['uploadDirectory'],
//                'save'=>$result['filename'] . 'Icon',
//                "quality" => 80,
//            )));

            Yii::import('application.modules.order.models.OrderTemp');

            $model = new OrderTemp;
            $path = 'http://' . $_SERVER['SERVER_NAME'] ."/uploads/tmp/" . Yii::app()->session->sessionID . "/";
            $model->attributes = array(
                'img_url'=> $path . $result['filename'] . '.' . $result['ext'],
                'thumb_url'=> $path . $result['filename'] . 'Icon' . '.' . $result['ext'],
                'thumb_width' => $sizeImg->width,
                'thumb_height' => $sizeImg->height,
                'type'=> 'upload'
            );

            if($model->save()) {
                $config = require(Yii::getPathOfAlias('application.modules.order.config.config').'.php');
                $result =  array(
                    'success'=>true,
                    'originalPath'=> $path . $result['filename'] . '.' . $result['ext'],
                    'iconPath' =>$path . $result['filename'] . 'Icon'. '.' . $result['ext'],
                    'id'=>$model->id,
                    'sum'=>OrderTemp::CollectPrice($config['price']));
            }
            else{
                $result = array('error'=> 'Could not save uploaded file.' .
                    'The upload was cancelled, or server error encountered');
            }



        }





        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

//        $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
//        $fileName=$result['filename'];//GETTING FILE NAME
        //$img = CUploadedFile::getInstance($model,'image');

        echo $return;// it's array
    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
        $this->switchlangParams = array(
            'from'=>'prev',
        );
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
        else {
            $this->render('error', array('message'=>'Такой страницы нету', 'code'=>'404'));
        }
	}

    public function actionAllNews()
    {
        Yii::import('application.backend.modules.news.models.*');

        $dataNews = new CActiveDataProvider('NewsTranslate',[
            'criteria'=>[
                'with'=> [
                    'news'=>[
                        'condition'=>'category = 1'
                    ]
                ],
                'condition'=>'t_status = 1 AND t_language=:language',
                'params'=>[':language'=>Yii::app()->language],
                'order'=>'t_createdate DESC',
            ],
            'pagination'=>[
                'pageVar'=>'all',
                'params'=>isset($_GET['url']) ? ['url'=>urlencode($_GET['url']),'language'=>Yii::app()->language] : ['language'=>Yii::app()->language],
                'pagesize'=>4,
            ],
        ]);

        $clubNews = new CActiveDataProvider('NewsTranslate',[
            'criteria'=>[
                'with'=> [
                    'news'=>[
                        'condition'=>'category = 2'
                    ]
                ],
                'condition'=>'t_status = 1 AND t_language=:language',
                'params'=>[':language'=>Yii::app()->language],
                'order'=>'t_createdate DESC',
            ],

            'pagination'=>[
                'pageVar'=>'club',
                'params'=>isset($_GET['url']) ? ['url'=>urlencode($_GET['url']),'language'=>Yii::app()->language] : ['language'=>Yii::app()->language],
                'pagesize'=>4,
            ],
        ]);

        $this->render('newsAll',['dataNews'=>$dataNews,'clubNews'=>$clubNews]);
    }

    public function actionNews()
    {
        Yii::import('application.backend.modules.news.models.*');

        $url = explode('.html',Yii::app()->request->url)[0];
        $exUrl = explode('/',$url);
        $dbUrl = $exUrl[sizeof($exUrl)-1];
        $model = Yii::app()->db->createCommand()
            ->select()
            ->from('News')
            ->join('NewsTranslate','News.id=t_id')
            ->where('NewsTranslate.t_url=:url AND NewsTranslate.t_status=1',[':url'=>$dbUrl])
            ->queryAll();

        $this->switchlangParams = array(
            'from'=>'model',
            'model' => 'NewsTranslate',
            'search_attr'=>array(
                't_id'=>$model[0]['t_id'],
                't_status'=>'published',
            ),
            'translit' => 't_url',
            'index' => 't_language',
            'sufix' => '.html',
            'prefix' => 'news'
        );

        $language = Yii::app()->language;
        $this->render('news',['model'=>$model,'language'=>$language]);
    }

    public function actionNewsPreview()
    {
        Yii::import('application.backend.modules.news.models.*');

        $url = explode('.html',Yii::app()->request->url)[0];
        $exUrl = explode('/',$url);
        $dbUrl = $exUrl[sizeof($exUrl)-1];
        $model = Yii::app()->db->createCommand()
            ->select()
            ->from('News')
            ->join('NewsTranslate','News.id=t_id')
            ->where('NewsTranslate.t_url=:url',[':url'=>$dbUrl])
            ->queryAll();

        $this->switchlangParams = array(
            'from'=>'model',
            'model' => 'NewsTranslate',
            'search_attr'=>array(
                't_id'=>$model[0]['t_id'],
                't_status'=>'published',
            ),
            'translit' => 't_url',
            'index' => 't_language',
            'sufix' => '.html',
            'prefix' => 'news'
        );

        $language = Yii::app()->language;

        $this->render('news',['model'=>$model,'language'=>$language]);
    }

    public function actionPages() {
        Yii::import('application.backend.modules.pages.models.*');
        $pageUrl = $_GET['page'];
        $models = StaticPages::model()->with(array(
                'translation'=>array(
                    'joinType'=>'INNER JOIN',
//                    'conditition'=>'translation.t_translit="'.$pageUrl.'"',
                    'on'=>'translation.t_lang="'.Yii::app()->language.'" AND translation.t_translit=:translit',
                    'params'=>array(':translit'=>$pageUrl)
                )
            )
        )->findAll();
        if(empty($models)) {
            throw new CHttpException(404, 'Нет такой страницы');
        }
        $model = $models[0];

        $this->switchlangParams = array(
            'from'=>'model',
            'model' => 'PagesTranslate',
            'search_attr'=>array(
                'page_id'=>$model['page_id'],
            ),
            'translit' => 't_translit',
            'index' => 't_lang',
            'sufix' => '.html',
        );

        $this->render('pages', array(
            'model'=>$model,
        ));
    }
}