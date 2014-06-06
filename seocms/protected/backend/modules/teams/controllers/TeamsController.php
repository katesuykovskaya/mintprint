<?php

class TeamsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';
    public $defaultAction = 'Admin';
    public $basePath;

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
//        return array();
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
		$model=new Team;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Team']))
		{
            $model->attributes=$_POST['Team'];
            $model->photo = CUploadedFile::getInstance($model,'photo');
            if($model->save()) {
                if($model->photo){
                    $imgDir = Yii::getPathOfAlias('webroot').'/uploads/'.get_class($model).DIRECTORY_SEPARATOR.$model->id.DIRECTORY_SEPARATOR;
                    if(is_dir($imgDir)){
                        $model->photo->saveAs($imgDir.$model->photo->name);
                    } else {
                        mkdir($imgDir, 0777, true);
                        $model->photo->saveAs($imgDir.$model->photo->name);
                    }
                }
                $this->redirect($this->createUrl('/backend/teams/teams/admin',array('language'=>Yii::app()->language)));
            }
		}

		$this->render('create',array(
			'model'=>$model,
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

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Team']))
		{
			$model->attributes=$_POST['Team'];
            $img = CUploadedFile::getInstance($model,'photo');
            if($img) {
                $model->photo = $img;
            }
			if($model->save()) {
                if($img){
                    $model->photo = $img;
                    $imgDir = Yii::getPathOfAlias('webroot').'/uploads/'.get_class($model).DIRECTORY_SEPARATOR.$model->id.DIRECTORY_SEPARATOR;
                    if(is_dir($imgDir)){
                        $model->photo->saveAs($imgDir.$model->photo->name);
                    } else {
                        mkdir($imgDir, 0777, true);
                        $model->photo->saveAs($imgDir.$model->photo->name);
                    }
                }
                $this->redirect($this->createUrl('/backend/teams/teams/admin',array('language'=>Yii::app()->language)));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
//        echo 'here';
//        die(CVarDumper::dump($_REQUEST, 3, true));
//        $this->loadModel($id)->team_player->delete();
//		if($this->beforeDelete())
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
//		$dataProvider=new CActiveDataProvider('Team');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Team('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Team']))
			$model->attributes=$_GET['Team'];
//        $dataProvider=new CActiveDataProvider('Player');
//        CVarDumper::dump($dataProvider, 5, true);
		$this->render('admin',array(
			'model'=>$model,
            'baseUrl'=>Yii::getPathOfAlias('webroot')
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Team the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Team::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Team $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='team-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionDelImage()
    {
        if(Yii::app()->request->isAjaxRequest){
            $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : null;
            $dir = Yii::getPathOfAlias('webroot').'/uploads/Team/'.$id.'/';
            if($id){
//                die($id);
                $sql = "update `Teams` set `photo`=NULL where `id`='".$id."'";
                $command = Yii::app()->db->createCommand($sql)->execute();
                if($command){
                    if(is_dir($dir)) {
                        @chmod($dir, 0777);
                        $res = $this->deleteDirectory($dir);
                        if(!$res) die(CJSON::encode(array('success'=>false, 'reason'=>'rmdir', 'dir'=>$dir, 'res1'=>$res1)));
                    } else {
                        die(CJSON::encode(array('success'=>'not a dir')));
                    }
                    echo CJSON::encode(array('success'=>true));
                } else {
                    echo CJSON::encode(array('success'=>false));
                }
            } else {
                echo CJSON::encode(array('success'=>false, 'reason'=>'no ID to remove'));
            }
        }
    }

    function actionRelational() {
        $id = Yii::app()->request->getParam('id') ? Yii::app()->request->getParam('id') : null;
//        $model = Team::model()->findByPk($id);
        $condition = 'translation.t_language="'.Yii::app()->language.'"';
        $model = Team::model()->with(array(
                'players'=>array(
                    'with'=>array(
                        'translation'=>array(
                            'condition'=>$condition
                        )
                    )
                )
            )
        )->findByPk($id);
        $dataProvider = new CArrayDataProvider('Players');
        if(isset($model->players)) {
            $dataProvider->setData($model->players);
            $this->renderPartial('_relational', array(
                'model'=>$model,
                'dataProvider'=>$dataProvider,
                'baseUrl'=>Yii::getPathOfAlias('webroot')
            ),false, true);
        } else {
            echo Yii::t('backend', 'Игроки отсутствуют');
        }
    }

    function deleteDirectory($dirname) {
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        if (!$dir_handle)
            return false;
        while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                    unlink($dirname."/".$file);
                else
                    $this->deleteDirectory($dirname.'/'.$file);
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }
}
