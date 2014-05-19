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

    public function init() {
        parent::init();
        $this->mainUrl = Yii::app()->createUrl('main.html', ['language'=>Yii::app()->language]);
    }

	public function actionIndex() {
        $this->layout = '//layouts/index';
        Yii::import('application.backend.modules.cap.models.*');
        $model = Cap::model()->with(array('translation'))->findAllByAttributes(array('show'=>true), array('order'=>'move'));
        $this->render('index', array('model'=>$model));
	}

    public function actionMain() {
        Yii::import('application.backend.modules.news.models.*');
        Yii::import('application.backend.modules.slider.models.*');
        Yii::import('application.backend.modules.gallery.models.*');
        $slider = Slider::model()->with('translation')->findAllByAttributes(array('show'=>true), array('order'=>'move'));

        $this->render('main', array(
            'news'=>News::model()->getNewsForMain(),
            'videos'=>Gallery::model()->GetVideosForMain(),
            'photos'=>Gallery::model()->GetPhotosForMain(),
            'slider'=>$slider
        ));

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

    public function actionVideo() {
        Yii::import('application.backend.modules.gallery.models.*');
        $gallery = new CActiveDataProvider('GalleryTranslate',[
            'criteria'=>[
                'with'=> [
                    'gallery'=>[
                        'condition'=>'root=28 AND level=2',
                    ]
                ],
                'condition'=>'t_language=:language',
                'params'=>[':language'=>Yii::app()->language],
                'order'=>'t_createdate DESC',
            ], 'pagination'=>array(
                'route'=>Yii::app()->urlManager->createUrl('video.html',array('language'=>Yii::app()->language)),
                'pageVar'=>'page',
                'params'=>isset($_GET['page']) ? array('page'=>urlencode($_GET['page'])) : array(),
                'pagesize'=>1,
            ),]);

//        $gallery1 = GalleryTranslate::model()->with(array(
//                'gallery'=>array(
//                    'condition'=>'root=28 AND level=2',
//                )
//            )
//        )->findAllByAttributes(array('t_language'=>Yii::app()->language),
//                array('index'=>'t_language'));
//        echo CVarDumper::dump($gallery1, 6, true);
        $this->render('video', array('gallery'=>$gallery));
    }

    public function actionGetEmbed() {
        Yii::import('application.backend.modules.gallery.models.*');
        echo $model = Gallery::model()->GetVideosOfEvent($_REQUEST['id']);

//        die(CVarDumper::dump($model, 8, true));
//        echo '<iframe width="640" height="360" src="//www.youtube.com/embed/f_9Tf279gEA?feature=player_detailpage" frameborder="0" allowfullscreen></iframe><iframe width="640" height="360" src="//www.youtube.com/embed/f_9Tf279gEA?feature=player_detailpage" frameborder="0" allowfullscreen></iframe>';
    }

    public function actionGallery()
    {
        Yii::import('application.backend.modules.gallery.models.GalleryTranslate');
        Yii::import('application.backend.modules.gallery.models.Gallery');
        $gallery = new CActiveDataProvider('GalleryTranslate',[
            'criteria'=>[
                'with'=> [
                    'gallery'=>[
                        'condition'=>'root=22 AND type=:type',
                        'params'=>[':type'=>2]
                    ]
                ],
                'condition'=>'t_language=:language',
                'params'=>[':language'=>Yii::app()->language],
                'order'=>'t_createdate DESC',
            ],           'pagination'=>[
                'pageVar'=>'page',
                'params'=>isset($_GET['url']) ? ['url'=>urlencode($_GET['url']),'language'=>Yii::app()->language] : ['language'=>Yii::app()->language],
                'pagesize'=>4,
            ],
        ]);

        $this->render('gallery',['gallery'=>$gallery]);
    }

    public function actionContacts() {
        Yii::import('application.backend.modules.pages.models.*');
        $model = StaticPages::model()->with(array(
                'translation'=>array(
                    'joinType'=>'INNER JOIN',
                    'on'=>'translation.t_lang="'.Yii::app()->language.'"'
                )
            )
        )->findByPk(5);

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

        Yii::app()->clientScript->registerCssFile('/css/contacts.css');
        $this->render('contacts', array(
            'model'=>$model
        ));
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

    public function actionTeams() {
        Yii::import('application.backend.modules.teams.models.*');
        $url = explode('.html',Yii::app()->request->url)[0];
        $temp = explode('/',$url);
        $teamId = end($temp);

        $model = Team::model()->with(array(
                'players'=>array(
                    'joinType'=>'LEFT JOIN',
                    'with'=>array(
                        'translation'=>array(
                            'joinType'=>'LEFT JOIN',
                        )
                    )
                )
            )
        )->findByPk($teamId);
        $players = $model->players;
        $arr = [];

        foreach($players as $k=>$player) {
            $arr[$player->player_role][] = $player;
        }

        $this->render('teams', array('model'=>$model, 'players'=>$arr));
    }
}