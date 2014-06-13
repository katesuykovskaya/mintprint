<?php

class SourceController extends RightsBaseController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
            'rights',
//			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
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
		$model=new SourceMessage;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SourceMessage']))
		{
			$model->attributes=$_POST['SourceMessage'];
			if($model->save()){
                Yii::app()->user->setFlash('success',Yii::t('backend','Запись успешно добавлена'));
                $this->redirect(array(Yii::app()->urlManager->createUrl('backend/multilanguage/source/admin',array('language'=>Yii::app()->language))));
            } else {
                Yii::app()->user->setFlash('error',Yii::t('backend','Ошибка! Обратитесь к администратору.'));
                $this->redirect(array(Yii::app()->urlManager->createUrl('backend/multilanguage/source/admin',array('language'=>Yii::app()->language))));
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
		// $this->performAjaxValidation($model);

		if(isset($_POST['SourceMessage']))
		{
			$model->attributes=$_POST['SourceMessage'];
			if($model->save()){
                Yii::app()->user->setFlash('success',Yii::t('backend','Успешно отредактировано'));
                $this->redirect($this->createUrl('backend/multilanguage/source/admin',array('language'=>Yii::app()->language)));
            } else {
                Yii::app()->user->setFlash('error',Yii::t('backend','Не удалось изменить! Обратитесь к администратору.'));
                $this->redirect($this->createUrl('backend/multilanguage/source/admin',array('language'=>Yii::app()->language)));
            }

		}

        $translation = array();
        foreach(Yii::app()->params['languages'] as $key=>$language){
            $translation[$key] = isset($model->messages[$key]->attributes) ? $model->messages[$key]->attributes : null;
        }

		$this->render('update',array(
			'model'=>$model,
            'translation'=>$translation,
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
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('SourceMessage');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{

		$model=new SourceMessage('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SourceMessage']))
			$model->attributes=$_GET['SourceMessage'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionManage()
    {
        if(Yii::app()->request->isAjaxRequest){
            $langArray = $_POST;
            $path = Yii::getPathOfAlias('application.common.config');
            $file = $path.'/languages.php';
            $content = "<?php\n return ";
            $content .= var_export($langArray,true);
            $content .=";";

            if(!file_put_contents($file, $content))
                echo CJSON::encode('error');
            else
                echo CJSON::encode('success');
        } else {
            $this->render('manage');
        }

    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SourceMessage the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SourceMessage::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function actionRelational()
    {
        $id = Yii::app()->request->getParam('id') ? Yii::app()->request->getParam('id') : null;

            $model = Message::model()->findAll('id='.(int)$id);
            $dataProvider = new CActiveDataProvider('Message',array(
                'criteria'=>array(
                    'condition'=>'id=:id',
                    'params'=>array(':id'=>$id),
                ),
            ));

        $r = Yii::app()->getRequest();
        // we can check whether is comming from a specific grid id too
        // avoided for the sake of the example
        if($r->getParam('editable'))
        {
            $id = (int)$r->getParam('translation_id') ? $r->getParam('translation_id') : false;
            $translation = $r->getParam('value') ? $r->getParam('value') : null;

            if($id) {
                $model = Message::model()->findByPk($id);
                $model->translation = $translation;
            }

            if($model->save(false))
                echo $r->getParam('value');
            else
                echo Yii::t('main','Ошибка сохранения в базу');
            Yii::app()->end();
        }

        $this->renderPartial('_relational', array(
            'model'=>$model,
            'dataProvider'=>$dataProvider,
        ),false, true);
    }

	/**
	 * Performs the AJAX validation.
	 * @param SourceMessage $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='source-message-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
