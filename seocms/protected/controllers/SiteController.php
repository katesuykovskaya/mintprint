<?php

class SiteController extends Controller
{
    public $layout = '//layouts/main';
    public $conf;
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */

    public function beforeAction($action) {
        if(parent::beforeAction($action)) {
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerCoreScript('jquery.ui');
            $this->conf = require Yii::getPathOfAlias('application.modules.order.config.config').'.php';
            return true;
        }
        return false;
    }

	public function actionIndex() {
        Yii::app()->clientScript->registerScriptFile('/js/socialLogout.js');
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

    public function actionLogout()
    {
        if(isset($_GET['provider']))
        {
            $provider = $_GET['provider'];
            if(isset(Yii::app()->session[$provider.'_token']))
            {
                Yii::app()->session[$provider.'_old_token'] = Yii::app()->session[$provider.'_token'];
                Yii::app()->session[$provider.'_token'] = null;
                die(json_encode(array("response"=>true)));
            }
            die(json_encode(array("response"=>false)));
        }
        die(json_encode(array("response"=>false)));
    }

    public function actionHome() {
        $this->layout = '//layouts/home';


        if(!empty($_POST))
        {
            $signature = 'tWOkSixhuvwFo4A4FCx8iOvZemvqYLQASD6OJnAu';
            if(isset($_POST['signature']))
                $insig = $_POST['signature'];
            else
                $insig = null;//'Or+eoT3wbcIuUZ30VsYO76YaTo8=';

            if(isset($_POST['operation_xml']))
                $resp = base64_decode($_POST['operation_xml']);
            else
                $resp = null;

            $gensig = base64_encode(sha1($signature . $resp . $signature, 1));

            if ($insig == $gensig)
            {
                $amount = $this->parseTag($resp, 'amount');
                $status = $this->parseTag($resp, 'status');
                $description = $this->parseTag($resp, 'description');
                //Почемуто слетает кодировка в ответе поэтому нужно сделать такую конвертацию чтобы получить на выходе UTF-8
                $description = @iconv('utf-8','ISO-8859-1',$description);
                $transaction_id = $this->parseTag($resp, 'transaction_id');
                $pay_way = $this->parseTag($resp, 'pay_way');


                $msgLiqPay =  '<span id="message" class="success">

                    <b>' . $description . '<br />' .
                    '<b>'.$this->multi['STATUS'].':</b> ' .$status . '<br />'.
                    '<b>Id транзакции:</b> ' . $transaction_id . '<br />'.
                    '<b>Сума:</b> ' . $amount.'<br>

                </span>';
                $idorder = explode('№', $description);

                Yii::import('application.modules.order.models.OrderHead');

                $model = OrderHead::model()->findByPk($idorder[1]);
                $model->status = 'ready';
                $model->save();

            }
        }

        if(empty($msgLiqPay))
            $msgLiqPay = null;

        $this->render('home', array('msgLiqPay' => $msgLiqPay));
    }

    public function parseTag($rs, $tag)
    {
        $rs = str_replace("\n", "", str_replace("\r", "", $rs));
        $tags = '<' . $tag . '>';
        $tage = '</' . $tag;
        $start = strpos($rs, $tags) + strlen($tags);
        $end = strpos($rs, $tage);
        return substr($rs, $start, ($end - $start));
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
        echo $return;// it's array
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
        else {
            $this->render('error', array('message'=>'Такой страницы нету', 'code'=>'404'));
        }
	}

    public function actionAllNews()
    {
        Yii::import('application.backend.modules.news.models.*');
        Yii::import('application.backend.modules.attach.models.*');
        Yii::import('application.backend.components.ZHtml');
        $this->layout = '//layouts/page';
        $criteria = new CDbCriteria();
        $criteria->together = true;
        $criteria->with = array(
            'translation'=>array(
                'condition'=>'t_status = 1 AND t_createdate < NOW() AND t_duedate > NOW() AND t_language=:language',
                'params'=>[':language'=>Yii::app()->language],
            ),
        );
        $criteria->order = 'translation.t_createdate DESC';
        $count=News::model()->count($criteria);

        $pages=new CPagination($count);
        $pages->pageSize=7;
        $pages->applyLimit($criteria);

        $models = News::model()->findAll($criteria);

        $sql = "select `t1`.`entity_id`,
            (select `path` from `Attachments` `t2`
                where `t2`.`attachment_id`=`t1`.`attachment_id`
                order by position ASC
                limit 1) as `img`
            from `Attachments` `t1`
             where `attachment_entity` = \"News\"
            group by t1.entity_id";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $images = array();
        foreach($rows as $val)
            $images[$val['entity_id']] = $val['img'];

        $config = require Yii::getPathOfAlias('application.modules.order.config.config').'.php';

        $this->render('newsAll',[
            'news'=>$models,
            'conf'=>$config,
            'images'=>$images,
            'pager'=>$pages]);
    }

    public function actionNews($translit)
    {
        Yii::import('application.backend.modules.news.models.*');
        $this->layout = '//layouts/page';
        $model = Yii::app()->db->createCommand()
            ->select()
            ->from('News')
            ->join('NewsTranslate','News.id=t_id')
            ->where('NewsTranslate.t_url=:url AND NewsTranslate.t_status = 1',[':url'=>$translit])
            ->queryRow();
        if(!$model)
            throw new CHttpException(404, "Такой новости нет.");
        $sql = "select `path` from `Attachments` where `attachment_entity` = 'News' and `hidden` = 0 and `entity_id` = ".$model['t_id']." order by `position`";
        $attaches = Yii::app()->db->createCommand($sql)->queryAll();

        $this->render('news',['model'=>$model, 'attaches'=>$attaches]);
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
        $model = StaticPages::model()->with(array(
                'translation'=>array(
                    'joinType'=>'INNER JOIN',
//                    'conditition'=>'translation.t_translit="'.$pageUrl.'"',
                    'on'=>'translation.t_lang="'.Yii::app()->language.'" AND translation.t_translit=:translit',
                    'params'=>array(':translit'=>$pageUrl)
                )
            )
        )->find();
        if(empty($model)) {
            throw new CHttpException(404, 'Нет такой страницы');
        }
        $conf = require(Yii::getPathOfAlias('application.modules.order.config.config').'.php');
        $this->render('pages', array(
            'model'=>$model->translation[Yii::app()->language],
            'conf'=>$conf
        ));
    }
}