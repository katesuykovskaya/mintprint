<?php

class CertificateController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';
    public $defaultAction = 'admin';
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
//			'rights', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Certificate;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Certificate']))
		{
			$model->attributes=$_POST['Certificate'];
            $model->code = ZHtml::randomNumber();
			if($model->save())
				$this->redirect(array('backend/order/certificate/admin'));
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

		if(isset($_POST['Certificate']))
		{
			$model->attributes=$_POST['Certificate'];
			if($model->save())
				$this->redirect('/backend/order/certificate/admin');
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Certificate('search');
        $generate = new GenerateForm;
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Certificate']))
			$model->attributes=$_GET['Certificate'];

		$this->render('admin',array(
			'model'=>$model,
            'generate'=>$generate,
		));
	}

    public function actionGenerate()
    {
        $model = new GenerateForm;
        $admin = new Certificate('search');
        $admin->unsetAttributes();
        if(isset($_GET['Certificate']))
            $admin->attributes=$_GET['Certificate'];

        if(isset($_POST['GenerateForm']))
        {
            $model->attributes = $_POST['GenerateForm'];
            $valid = $model->validate();
            $res = true;
            if($valid)
            {
//                for($i=0;$i<$model->count; $i++)
                $count = 0;
                $certificates = array();
                while(true)
                {
                    $cer = new Certificate;
                    $certificates[] = &$cer;
                    $cer->code = ZHtml::randomNumber();
                    $cer->due_date = $model->due_date;
                    $cer->create_date = date('Y-m-d');
                    $cer->limit = $model->limit;
                    $currentResult = $cer->save();
                    if($currentResult) $count++;
                    $res &= $currentResult;
                    if($count == $model->count) break;
                    if($count == '9999999') {
                        $res = false;
                        break;
                    }
                }
                if($res)
                {
                    Yii::app()->user->setFlash('success', 'Сертификаты успешно сгенерированы');
                }
                else
                    Yii::app()->user->setFlash('error', 'При генерации возникли ошибки');
//                if(isset($_POST['generate-n-export']))
//                {
//                    $this->download($certificates);
//                }
                $this->redirect('/backend/order/certificate/admin');
                $model->unsetAttributes();
            }
            else
            {
                $this->render('admin',array(
                    'model'=>$admin,
                    'generate'=>$model,
                ));
            }
        }
    }

    public function actionExport()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('code', $_GET['code'], true);
        $criteria->compare('id_order', $_GET['id_order']);
        $criteria->compare('create_date', $_GET['create_date']);
        $criteria->compare('due_date', $_GET['due_date']);
        if($_GET['status'])
        {
            switch($_GET['status'])
            {
                case 'used':
                    $criteria->addCondition('t.id_order IS NOT NULL');
                    break;
                case 'overdue':
                    $criteria->addCondition('t.id_order IS NULL');
                    $criteria->addCondition('DATEDIFF(NOW(), t.due_date) > 1');
                    break;
                case 'new':
                    $criteria->addCondition('t.id_order IS NULL');
                    $criteria->addCondition('DATEDIFF(NOW(), t.due_date) <= 1');
                    break;
            }
        }
        $model = Certificate::model()->findAll($criteria);
        $this->download($model);
    }

    protected function download(array $models)
    {
        $excelFile = 'certificates'.date('d-m-Y-H:i').'.csv';
        $excelFileHandler = fopen($excelFile, 'w');
        fwrite($excelFileHandler, b"\xEF\xBB\xBF" ) ; // to force utf-8 encoding
        fputcsv($excelFileHandler, array('Код', 'Дата истечения'), ';');
        foreach($models as $key=>$model)
        {
        fputcsv($excelFileHandler, array($model->code, $model->due_date), ';');
        }
        fclose($excelFileHandler);
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="'.$excelFile.'"');
        readfile($excelFile);
        unlink($excelFile);
        die();
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Certificate the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Certificate::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Certificate $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='certificate-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
