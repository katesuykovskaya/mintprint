<?php

class OrderHeadController extends Controller
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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new OrderHead;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrderHead']))
		{
			$model->attributes=$_POST['OrderHead'];
			if($model->save())
                $this->redirect($this->createUrl('/backend/order/orderHead/admin',['language'=>Yii::app()->language]));
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
        Yii::app()->clientScript->registerCssFile('/css/backend.css');

		$model=$this->loadModel($id);

        if(!file_exists('uploads/Order/thumb/'.$id)){
                foreach($model->body as $key=>$item){
                    $path = str_replace('http://'.$_SERVER['SERVER_NAME'], "",$item['path']);
                    getimagesize(Yii::app()->easyImage->thumbOf($path, array(
                        "resize" => array("width"=>97, 'height' => 97),
                        "savePath"=>'uploads/Order/thumb/'.$id.'/',
                        'save'=>$item['id'],
                        "quality" => 80,
                    )));

                }
        }

		if(isset($_POST['OrderHead']))
		{
			$model->attributes=$_POST['OrderHead'];
			if($model->save())
                $this->redirect($this->createUrl('/backend/order/orderHead/admin',['language'=>Yii::app()->language]));
		}

        $model->price = $model->price." грн";

        if(isset($_POST['download'])){

            $error = "";

                    if(count($model->body))
                    {
            // проверяем выбранные файлы
                        $zip = new ZipArchive(); // подгружаем библиотеку zip
                        $zip_name = time().".zip"; // имя файла
                        if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
                        {
                            $error .= "* Sorry ZIP creation failed at this time";
                        }
                        foreach($model->body as $key=>$item)
                        {
//                            $path = str_replace('http://'.$_SERVER['SERVER_NAME'].'/', "",$item['path']);
                            $zip->addFile(substr($item['path'], 1)); // добавляем файлы в zip архив
                        }
                        $zip->close();

                        if(file_exists($zip_name))
                        {
            // отдаём файл на скачивание
                            header('Content-type: application/zip');
                            header('Content-Disposition: attachment; filename="'.$zip_name.'"');
                            readfile($zip_name);
            // удаляем zip файл если он существует
                            unlink($zip_name);
                        }

                    }
                    else
                        $error .= "folder empty";

            if($error)
                die($error);
            else
                die();

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
		$model = $this->loadModel($id);

        if($model->status != "delete"){
            $model->status = 'delete';
            $model->save();
        }else{
            $model->delete();
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
		$dataProvider=new CActiveDataProvider('OrderHead');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OrderHead('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrderHead']))
			$model->attributes=$_GET['OrderHead'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OrderHead the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OrderHead::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OrderHead $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-head-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
