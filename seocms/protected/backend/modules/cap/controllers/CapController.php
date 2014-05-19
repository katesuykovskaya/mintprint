<?php

class CapController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';
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
		$model = new Cap;
        $modelTranslate = new CapTranslate;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cap']))
		{
            $model->attributes=$_POST['Cap'];
            $lastModel = Cap::model()->findByAttributes(array(), array('order'=>'move DESC'));
            $model->move = $lastModel->move + 1;
            $model->img = CUploadedFile::getInstance($model,'img');
            if($model->save()) {
                if($model->img){
                    $imgDir = Yii::getPathOfAlias('webroot').'/uploads/'.get_class($model).DIRECTORY_SEPARATOR.$model->id.DIRECTORY_SEPARATOR;
                    if(is_dir($imgDir)){
                        $model->img->saveAs($imgDir.$model->img->name);
                    } else {
                        mkdir($imgDir, 0777, true);
                        $model->img->saveAs($imgDir.$model->img->name);
                    }
                }
                $this->redirect($this->createUrl('backend/cap/cap/update',array(
                    'language'=>Yii::app()->language,
                    'id'=>$model->id
                )));
            }
		}

		$this->render('create',array(
			'model'=>$model,
            'modelTranslate'=>$modelTranslate
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
        $modelTranslate = $model->translation[Yii::app()->language];
        if($modelTranslate === null) $modelTranslate = new CapTranslate;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cap']))
		{
            $model->attributes=$_POST['Cap'];
            $img = CUploadedFile::getInstance($model,'img');
            if($img) {
                $model->img = $img;
            }
            if($model->save()) {
                if($img){
                    $model->img = $img;
                    $imgDir = Yii::getPathOfAlias('webroot').'/uploads/'.get_class($model).DIRECTORY_SEPARATOR.$model->id.DIRECTORY_SEPARATOR;
                    if(is_dir($imgDir)){
                        $model->img->saveAs($imgDir.$model->img->name);
                    } else {
                        mkdir($imgDir, 0777, true);
                        $model->img->saveAs($imgDir.$model->img->name);
                    }
                }
                $this->redirect($this->createUrl('backend/cap/cap/update',array(
                    'language'=>Yii::app()->language,
                    'id'=>$model->id
                )));
            }
		}

		$this->render('update',array(
			'model'=>$model,
            'modelTranslate'=>$modelTranslate
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
        $dir = Yii::getPathOfAlias('webroot').'/uploads/Cap/'.$id.'/';
        $this->deleteDirectory($dir);

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
//	public function actionIndex()
//	{
//		$dataProvider=new CActiveDataProvider('Cap');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Cap('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cap']))
			$model->attributes=$_GET['Cap'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cap the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cap::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cap $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cap-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionDelImage()
    {
        if(Yii::app()->request->isAjaxRequest){
            $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : null;
            $dir = Yii::getPathOfAlias('webroot').'/uploads/Cap/'.$id.'/';
            if($id){
//                die($id);
                $sql = "update `Cap` set `img`= '' where `id`='".$id."'";
                $command = Yii::app()->db->createCommand($sql)->execute();
                if($command){
                    if(is_dir($dir)) {
                        @chmod($dir, 0777);
                        $res = $this->deleteDirectory($dir);
                        if(!$res) die(CJSON::encode(array('success'=>false, 'reason'=>'rmdir', 'dir'=>$dir)));
                    } else {
                        die(CJSON::encode(array('success'=>'not a dir')));
                    }
                    echo CJSON::encode(array('success'=>true));
                } else {
                    echo CJSON::encode(array('success'=>false, 'reason'=>'query false'));
                }
            } else {
                echo CJSON::encode(array('success'=>false, 'reason'=>'no ID to remove'));
            }
        }

    }

    public function actionImageSortable() {
        $order = $_POST['newOrder'];
        $res = true;
        foreach($order as $pos=>$id) {
            $q = "UPDATE `Cap` SET `move` = '$pos' WHERE `id` = '$id'";
            $command = Yii::app()->db->createCommand($q)->execute();
            if(!$command) { $res = false; die(json_encode(array('res'=>false))); }
        }
        if($res) die(json_encode(array('res'=>true)));
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
