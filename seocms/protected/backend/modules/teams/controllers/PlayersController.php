<?php

class PlayersController extends Controller
{

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
    public $layout="//layouts/main";
    public $defaultAction = 'Admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
//			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
//            'rights'
            array('auth.filters.AuthFilter'),
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
//	public function accessRules()
//	{
//		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
//		);
//	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
//	public function actionView($id)
//	{
//		$this->render('view',array(
//			'model'=>$this->loadModel($id),
//		));
//	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Player;
        $translate = new PlayerTranslate;
        $cr = new CDbCriteria;
        $cr->select = 't.id';
        $modelTeam = Team::model()->findAll($cr);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
//        die(CVarDumper::dump($model, 3, true));
		if(isset($_POST['Player']))
		{
			$model->attributes=$_POST['Player'];
//            echo CVarDumper::dump($_POST, 3, true);
//            echo CVarDumper::dump($model->attributes, 3, true);
//            die();
			if($model->save()) {

                $modelTeamPlayer = new TeamPlayer;//$model->team_player;

                $modelTeamPlayer->team_id = $_POST['Player']['team_id'];//$model->attributes->team_id;
                $modelTeamPlayer->player_id = $model->id;
//                echo CVarDumper::dump($modelTeamPlayer, 3, true);
//                die();
                $modelTeamPlayer->save();
                $this->redirect(Yii::app()->urlManager->createUrl('/backend/teams/players/admin',array('language'=>Yii::app()->language)));
            }

		}

		$this->render('create',array(
			'model'=>$model,
            'translate'=>$translate,
            'modelTeam'=>$modelTeam
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        $translate = $model->translation;
//        $m = Player::model()->with('team_player')->findAll();

        $cr = new CDbCriteria;
        $cr->select = 't.id';
        $modelTeam = Team::model()->findAll($cr);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Player']))
		{
			$model->attributes=$_POST['Player'];
			if($model->save()) {
                $modelTeamPlayer = $model->team_player;
//                die(CVarDumper::dump($model, 4, true));
                if(!$modelTeamPlayer) $modelTeamPlayer = new TeamPlayer;
                $modelTeamPlayer->team_id = $_POST['Player']['team_id'];
                $modelTeamPlayer->player_id = $model->id;
                $modelTeamPlayer->save();
//                die(CVarDumper::dump($modelTeamPlayer, 3, true));
                $this->redirect($this->createUrl('teams/players/',array('language'=>Yii::app()->language)));
            }

		}

		$this->render('update',array(
			'model'=>$model,
            'modelTeam'=>$modelTeam,
            'translate'=>$translate
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
//	public function actionIndex()
//	{
//		$dataProvider=new CActiveDataProvider('Player');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Player('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Player']))
			$model->attributes=$_GET['Player'];

		$this->render('admin',array(
			'model'=>$model->with('teams'),
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Player the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Player::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function loadMultilangModel($id,$lang)
    {
        $model = Player::model()
            ->with(array(
                'translation'=>array(
                    'joinType'=>'LEFT JOIN',
                    'on'=>'translation.t_language=:lang',
                    'params'=>array(':lang'=>$lang),
                )))->findByAttributes(array('id'=>$id));
        return $model;
    }

	/**
	 * Performs the AJAX validation.
	 * @param Player $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='player-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function tabsArray($model,$param = true)
    {
        $tabsArray = array();
        foreach(Yii::app()->params['languages'] as $language)
        {
            if($param) {
                if(Yii::app()->language == $language['langcode']) {
                    $tabsArray[] = array(
                        'label'=>$language['lang'],
                        'content'=>
                        $this->getTabContent(
                            $model,
                            $language['langcode']
                        ),
                        'active'=>true
                    );
                } else {
                    $tabsArray[] = array(
                        'label'=>$language['lang'],
                        'content'=>
                        $this->getTabContent(
                            $model,
                            $language['langcode']
                        )
                    );
                }
            } else {
                if(Yii::app()->language == $language['langcode']) {
                    $tabsArray[] = array(
                        'label'=>$language['lang'],
                        'content'=>
                        $this->getTabContent(
                            $this->loadMultilangModel($model->id,$language['langcode']),
                            $language['langcode'],$param=false
                        ),
                        'active'=>true
                    );
                } else {
                    $tabsArray[] = array(
                        'label'=>$language['lang'],
                        'content'=>
                        $this->getTabContent(
                            $this->loadMultilangModel($model->id,$language['langcode']),
                            $language['langcode'],
                            $param=false)
                    );
                }
            }
        }
        return $tabsArray;
    }

    public function getTabContent($model,$lang,$param = true)
    {
//            $fieldsArray = Yii::app()->params['translateAttrs'];
//        CVarDumper::dump($model, 7, true);
        $fieldsArray = $model->translateAttributes;
//        CVarDumper::dump($model, 7, true);
        $content = '';
        if($param) {
            foreach($fieldsArray as $key=>$field) {
                $label = CHtml::activeLabel($model, $field['label']);
//                    if($field['fieldType']=='textArea')
//                        $textField = $this->tinyToTabs($model, $field['label'], $lang);
//                    else {
                $formField = 'active'.ucfirst($field['fieldType']);
                $textField = CHtml::$formField($model, $field['label'].'['.$lang.']',$field['htmlOptions']);
//                    }

                $content .= $label.$textField;
            }
        } else {
//            CVarDumper::dump($model->translation, 7, true);
//            foreach($model->translation as $k=>$v) {
//                echo $k.' - '.$v->t_fio.'<br>';
//            }
            foreach($fieldsArray as $key=>$field) {
                /* $model->translation can be NULL if the new project language was added and no
                 * page translation instance was created, it will be created after page save automatically,
                 * but not during adding new language support
                 * */
                if($model->translation === null)
                    $model->translation = new PlayerTranslate;
                $tmodel = $model->translation[$lang];
                $label = CHtml::activeLabel($tmodel, $field['label']);
                $formField = 'active'.ucfirst($field['fieldType']);
                $htmlOptions = $field['htmlOptions'];
                $htmlOptions['name'] = 'PlayerTranslate['.$field['label'].']['.$lang.']';
                $textField = CHtml::$formField($tmodel, $field['label'],$htmlOptions);
                $content .= $label.$textField;
            }
        }

        return $content;
    }
}
