<?php

class SliderController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
            'rights'
//            array('auth.filters.AuthFilter'),
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
		$model = new Slider;
        $modelTranslate = new SliderTranslate;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        if(isset($_POST['save'])) $task = 'save';
        elseif(isset($_POST['confirm'])) $task = 'confirm';
        elseif(isset($_POST['cancel'])) $task = 'cancel';


		if(isset($_POST['Slider']))
		{
            if(isset($_POST['save'])) $task = 'save';
            elseif(isset($_POST['confirm'])) $task = 'confirm';
            elseif(isset($_POST['cancel'])) $task = 'cancel';
            elseif(isset($_POST['delete'])) $task = 'delete';
            switch($task) {
                case 'save':
                    if($this->saveSlide($model)) {
                        $this->redirect($this->createUrl($_POST['save_url'],array(
                            'language'=>Yii::app()->language,
                        )));
                    }
                    break;
                case 'confirm':
                    if($this->saveSlide($model)) {
                        $this->redirect($this->createUrl($_POST['confirm_url'],array(
                            'language'=>Yii::app()->language,
                            'id'=>$model->id
                        )));
                    }
                    break;
                default:
                    $this->redirect($this->createUrl('/backend/slider/slider/admin',array(
                        'language'=>Yii::app()->language,
                    )));
                    break;
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
        $modelTranslate = isset($model->translation[Yii::app()->language]) ? $model->translation[Yii::app()->language] : new SliderTranslate;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Slider']))
		{
            if(isset($_POST['save'])) $task = 'save';
            elseif(isset($_POST['confirm'])) $task = 'confirm';
            elseif(isset($_POST['cancel'])) $task = 'cancel';
            elseif(isset($_POST['delete'])) $task = 'delete';
                switch($task) {
                    case 'save':
                        if($this->saveSlide($model)) {
                            $this->redirect($this->createUrl($_POST['save_url'],array(
                                'language'=>Yii::app()->language,
                            )));
                        }
                        break;
                    case 'confirm':
                        if($this->saveSlide($model)) {
                            $this->redirect($this->createUrl($_POST['confirm_url'],array(
                                'language'=>Yii::app()->language,
                                'id'=>$model->id
                            )));
                        }
                        break;
                    case 'delete':
                        $this->actionDelete((int)$id);
                        break;
                    default:
                        $this->redirect($this->createUrl('/backend/slider/slider/admin',array(
                            'language'=>Yii::app()->language,
                        )));
                        break;
                }
		}

		$this->render('update',array(
			'model'=>$model,
            'modelTranslate'=>$modelTranslate
		));
	}

    public function saveSlide($model) {
        $model->attributes = $_POST['Slider'];
        if($model->isNewRecord) {
            $lastModel = Slider::model()->findByAttributes(array(), array('order'=>'move DESC'));
            $model->move = $lastModel->move + 1;
        }
        $img = CUploadedFile::getInstance($model,'img');
        if($img) {
            $model->img = $img;
        }
        if($model->save()) {
            if($img){
                $imgDir = Yii::getPathOfAlias('webroot').'/uploads/'.get_class($model).DIRECTORY_SEPARATOR.$model->id.DIRECTORY_SEPARATOR;
                if(is_dir($imgDir)){
                    $img->saveAs($imgDir.$model->img->name);
                } else {
                    mkdir($imgDir, 0777, true);
                    $img->saveAs($imgDir.$model->img->name);
                }
            }
            return true;
        }
        return false;
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
        $dir = Yii::getPathOfAlias('webroot').'/uploads/Slider/'.$id.'/';
        $this->deleteDirectory($dir);

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/backend/slider/slider/admin', 'language'=>Yii::app()->language));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Slider('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Slider']))
			$model->attributes=$_GET['Slider'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Slider the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Slider::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Slider $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='slider-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionDelImage()
    {
        if(Yii::app()->request->isAjaxRequest){
            $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : null;
            $dir = Yii::getPathOfAlias('webroot').'/uploads/Slider/'.$id.'/';
            if($id){
//                die($id);
                $sql = "update `Slider` set `img`= '' where `id`='".$id."'";
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
            $index = $pos + 1;
            $command = Yii::app()->db->createCommand();
            if($command->update(
                'Slider', array(
                    'move'=>$index,
                ),'id=:id', array(':id'=>$id)
            )){};
//            $command->execute();
//            if(!$res) { die(json_encode(array('res'=>false))); }
        }
        if($res) die(json_encode(array('res'=>true)));
    }

    function deleteDirectory($dirname) {
        if (is_dir($dirname)) {
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
}
