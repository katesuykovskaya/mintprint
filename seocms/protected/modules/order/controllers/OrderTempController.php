<?php

class OrderTempController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new OrderTemp;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_POST['OrderTemp'])) {
                $model->attributes=$_POST['OrderTemp'];
                if($model->save()) {
                    die(json_encode(array('res'=>true, 'id'=>$model->id)));
                }
                die(json_encode(array('res'=>false, 'reason'=>'not valid (kate message)')));
            }
		}
        die(json_encode(array('res'=>false,'reason'=>'not ajax request')));
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
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrderTemp']))
		{
			$model->attributes=$_POST['OrderTemp'];
			if($model->save())
				die(json_encode(array('res'=>true)));
            else
                die(json_encode(array('res'=>false)));
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
	public function actionDelete()
	{
        if(Yii::app()->request->isAjaxRequest) {
            $this->loadModel($_POST['OrderTemp']['id'])->delete();
            if(!empty($_POST['OrderTemp']['type']) && $_POST['OrderTemp']['type'] == 'upload'){
                $img_url = str_replace('http://' . $_SERVER['SERVER_NAME'], Yii::getPathOfAlias('webroot'), $_POST['OrderTemp']['img_url']);
                $thumb_url = str_replace('http://' . $_SERVER['SERVER_NAME'], Yii::getPathOfAlias('webroot'), $_POST['OrderTemp']['thumb_url']);
                unlink($img_url);
                unlink($thumb_url);
            }
        }


		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('OrderTemp');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OrderTemp('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrderTemp']))
			$model->attributes=$_GET['OrderTemp'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OrderTemp the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OrderTemp::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OrderTemp $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-temp-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}