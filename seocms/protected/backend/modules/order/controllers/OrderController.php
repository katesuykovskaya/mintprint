<?php

class OrderController extends Controller
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
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
            'rights'
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */

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

    public function actionCalendar()
    {
        Yii::app()->clientScript->registerCssFile('/css/backend.css');
        if(isset($_POST['download'])) {
            Yii::import('application.backend.components.ZHtml');
            $date = $_POST['date'];
            $error = "";
            $condition = array('date'=>$date);
            if(isset($_GET['status']))
                $condition['status'] = $_GET['status'];
            $models = OrderHead::model()->with('body')->findAllByAttributes($condition);
            $zip = new ZipArchive();
            $zip_name = $date.".zip";
            if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
            {
                $error .= "* Sorry ZIP creation failed at this time";
            }
            $excelFiles = array();
            foreach($models as $key=>$model)
            {
                $excelFiles[$key] = ZHtml::randomString().'.csv';
                $excelFileHandler = fopen($excelFiles[$key], 'w');
                fwrite($excelFileHandler, b"\xEF\xBB\xBF" ) ; // to force utf-8 encoding
                fputcsv($excelFileHandler, array('Порядковый номер фото', 'Количество шт'), ';');
                foreach($model->body as $key1=>$item)
                {
                    fputcsv($excelFileHandler, array($item->position, $item->count), ';');
                    $zip->addFile(substr($item['path'], 1), str_replace('/uploads/Order/'.date('d-m-Y', strtotime($date)).'/', '', $item->path));
                }
                fclose($excelFileHandler);
                $zip->addFile($excelFiles[$key], $model->id.'/'.$model->id.'.csv');
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
                foreach($excelFiles as $val) // delete temporary csv files
                    unlink($val);
            }
            if($error)
                die($error);
            else
                die();
        }
        $criteria = new CDbCriteria(array(
            'select'=>'date, count(*) as photoCount',
            'group'=>'date'
        ));
        if(isset($_GET['status']))
            $criteria->compare('t.status', $_GET['status'], false);
        $dataProvider = new CActiveDataProvider('OrderHead', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'route'=>Yii::app()->createUrl('/backend/order/order/calendar', array('language'=>Yii::app()->language)),
                'pageSize'=>30,
                'pageVar'=>'page',
                'params'=> isset($_GET['page']) ? array('page'=>urlencode($_GET['page'])) : array()
            )
        ));

        $model = new OrderHead;
        $this->render('calendar', array(
            'dataProvider'=>$dataProvider,
            'model'=>$model,
        ));
    }

    protected function download($date) {
        $error = "";
        $models = OrderHead::model()->with('body')->findAllByAttributes(array('date'=>strtotime($date)));
        // проверяем выбранные файлы
        $zip = new ZipArchive();
        $zip_name = $date.".zip";
        if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
        {
            $error .= "* Sorry ZIP creation failed at this time";
        }
        foreach($models as $model)
        {
            foreach($model->body as $key=>$item)
            {
                $zip->addFile(substr($item['path'], 1)); // добавляем файлы в zip архив
            }
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
        if($error)
            die($error);
        else
            die();
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
                mkdir('uploads/Order/thumb/'.$id.'/');
                foreach($model->body as $key=>$item){

                    $path = str_replace('http://'.$_SERVER['SERVER_NAME'], "",$item['path']);
                    $path_parts = pathinfo($path);
                    $crop = new EasyImage($path);
                    $crop->resize(97, 97);
                    $crop->save('uploads/Order/thumb/'.$id.'/'.$item['id'].'.'.$path_parts['extension'], 80);
                }
        }

		if(isset($_POST['OrderHead']))
		{
            if($model->status != $_POST['OrderHead']['status'])
                $sendLetter = true;
            else
                $sendLetter = false;
			$model->attributes=$_POST['OrderHead'];
			if($model->save()) {
                if($sendLetter) {
                    $host = $_SERVER['HTTP_HOST'];
                    $body = "Уважаемый(я) ".$model->name.'<br>Статус вашего заказа на сайте <a href="http://'.$host.'">'.$host.'</a> изменился на - '.Yii::t('backend', $model->status);
                    $res = $this->SendClientEmail($body, $model->email);
                    if($res)
                        Yii::app()->user->setFlash('success', 'Статус успешно изменен');
                    else
                        Yii::app()->user->setFlash('error', 'Статус не изменен!');
                }
                $this->redirect($this->createUrl('/backend/order/order/admin',['language'=>Yii::app()->language]));
            }

		}

        $model->price = $model->price." грн";

        if(isset($_POST['download'])){
                $error = "";

                        if(count($model->body))
                        {
                // проверяем выбранные файлы
                            $zip = new ZipArchive(); // подгружаем библиотеку zip
                            $zip_name = $model->id.".zip"; // имя файла
                            if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
                            {
                                $error .= "* Sorry ZIP creation failed at this time";
                            }
                            $excelFile = ZHtml::randomString().'.csv';
                            $excelFileHandler = fopen($excelFile, 'w');
                            fwrite($excelFileHandler, b"\xEF\xBB\xBF" ) ; // to force utf-8 encoding
                            fputcsv($excelFileHandler, array('Порядковый номер фото', 'Количество шт'), ';');
                            foreach($model->body as $key=>$item)
                            {
                                $zip->addFile(substr($item['path'], 1), pathinfo($item['path'])['basename']); // добавляем файлы в zip архив
                                fputcsv($excelFileHandler, array($item->position, $item->count), ';');
                            }
                            fclose($excelFileHandler);
                            $zip->addFile($excelFile, $model->id.'.csv');
                            $zip->close();

                            if(file_exists($zip_name))
                            {
                // отдаём файл на скачивание
                                header('Content-type: application/zip');
                                header('Content-Disposition: attachment; filename="'.$zip_name.'"');
                                readfile($zip_name);
                // удаляем zip файл если он существует
                                unlink($zip_name);
                                unlink($excelFile);
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

    protected function SendClientEmail(&$body, $email) {
//        Yii::import('application.backend.modules.feedback.components.mailOrPhone');
//        Yii::import('application.extensions.yii-mail.YiiMailMessage');
//        Yii::import('application.backend.components.*');
        $message = new YiiMailMessage;
        $host = $_SERVER['HTTP_HOST'];
        $mailSettings = require(Yii::getPathOfAlias('webroot').'/seocms/protected/common/config/mail.php');
        $message->setCharset(Yii::app()->mail->charset);
        $message->setSubject('Заказ на '.$host);

        $message->setBody($body,'text/html');
        $message->setTo(array($email));
        $message->setFrom(array($mailSettings['adminEmail']=>'Администратор '.$host));
        $message->setReplyTo($mailSettings['adminEmail'], 'Администратор '.$host);

        return Yii::app()->mail->send($message);
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

    public function actionClearTmp()
    {
        if(Yii::app()->request->isAjaxRequest){
            $url = isset($_POST['tmp']) ? $_POST['tmp'] : null;
            $timeCriteria = isset($_POST['timeCriteria']) ? $_POST['timeCriteria'] : 60 * 60 * 24 * 7;
            if($url){
                $this->delete_files($url, $timeCriteria);
            }
        }
    }

    /**
     * php delete function that deals with directories recursively
     * @param $target - directory path to work with
     * @return bool
     */
    public function delete_files($target, $timeCriteria) {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
            foreach( $files as $file )
            {
                $this->delete_files( $file, $timeCriteria );
            }
            if(count(glob( $target . '*', GLOB_MARK )) === 0 && $target != Yii::getPathOfAlias('webroot').'/uploads/tmp/')
                rmdir( $target );
        } else {
            if(is_file($target) && filectime($target) + $timeCriteria < time()) {
                unlink( $target );
            }
        }
    }

    public function actionPrice(){
//        CVarDumper::dump($_REQUEST, 5, true);
//        die();
        $this->layout = '//layouts/main';
        $model = new ConfigForm();
        $file = Yii::getPathOfAlias('application.modules.order.config').'/config.php';
        $model->attributes = include $file;
        if(Yii::app()->request->isPostRequest){
            $model->attributes=$_POST['ConfigForm'];
            if($model->validate()){

                $content = "<?php\n return ";
                $content .= var_export($model->attributes,true);
                $content .=";";

                if(!file_put_contents($file, $content)) die ('<h1>error!</h1>');
            }

            }else{

                $priceArray = array();

            }


        $this->render('price',array(
            'file'=>$file,
            'model'=>$model
        ));

    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        Yii::app()->clientScript->registerCssFile('/css/backend.css');
        $this->layout = '//layouts/main';
		$model=new OrderHead('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrderHead']))
			$model->attributes=$_GET['OrderHead'];
        if(isset($_POST['change_status']) && !empty($_POST['id'])) {
            $status = $_POST['new_status'];
            $ids = implode(', ', array_keys($_POST['id']));
            $sql = "update OrderHead set status='$status' where id in ($ids)";
            echo Yii::app()->db->createCommand($sql)->execute();
            $model->status = null;
        }

//        $output = fopen('file.csv', 'w');
//        fputcsv($output, array('Column 1', 'Column 2', 'Column 3'), ';');
//        fputcsv($output, array('aaa', 'bbbb 2', 'cccc 3'), ';');
//        fclose($output);

        $this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionExport()
    {
        $criteria = new CDbCriteria();
        $sufix = array();
        if(isset($_GET['status'])) {
            $criteria->compare('t.status', $_GET['status'], false);
            $sufix[] = Yii::t('backend', $_GET['status']);
        }
        if(isset($_GET['from_date'])) {
            $criteria->addCondition('DATEDIFF(t.date, "'.$_GET['from_date'].'") >= 0' );
            $sufix[] = 'from_'.$_GET['from_date'];
        }
        if(isset($_GET['to_date'])) {
            $criteria->addCondition('DATEDIFF(t.date, "'.$_GET['to_date'].'") <= 0' );
            $sufix[] = 'to_'.$_GET['to_date'];
        }
        $fileName = 'orders_'.implode('_', $sufix).'.csv';
        $models = OrderHead::model()->with(array('count'))->findAll($criteria);
        header('Content-type: text/csv; charset=windows-1251');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        $output = fopen('php://output', 'w');
        fwrite($output,b"\xEF\xBB\xBF" ) ; // to force utf-8 encoding
        fputcsv($output, array('ID', 'Имя и Фамилия', 'E-mail', 'Телефон', 'Адрес', 'Город', 'Область', 'Кол-во фото', 'Сумма', 'Статус', 'Дата'), ';');
        foreach($models as $model)
            fputcsv($output, array($model->id, $model->name, $model->email, $model->phone, $model->address, $model->city, $model->region, $model->count, $model->price.' грн.', Yii::t('backend', $model->status), $model->date), ';');
        fclose($output);
        die();
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
