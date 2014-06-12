<?php

class FeedbackController extends RightsBaseController
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
            'rights'
        );
	}

//	/**
//	 * Displays a particular model.
//	 * @param integer $id the ID of the model to be displayed
//	 */
	public function actionView($id)
	{
        $model = $this->loadModel($id);
        $files = unserialize($model->files);
		$this->render('view',array(
			'model'=>$model,
            'files'=>$files,
		));
	}

    public function actionFeedback()
    {
        if(isset($_POST['Feedback'])){
            $model = new Feedback;
            $model->attributes = $_POST['Feedback'];
            $model->ip = ip2long(Yii::app()->request->userHostAddress);
            if(!empty($_POST['Feedback']['files'])){

                $filesArr = array();
                foreach($_POST['Feedback']['files'] as $file){
                    $file = CJSON::decode($file);
                    $filesArr[] = array(
                        'name'=>$file['name'],
                        'type'=>$file['type'],
                        'url'=>'/uploads/'.$file['name'],
                    );
                }
                $filesArr = serialize($filesArr);
                $model->files = $filesArr;
            }

            if($model->validate()){
                if($model->save()){
                    $event = new CEvent($this,array('model'=>$model));
                    $notifier = new Notifier();
                    $model->onFeedback = array($notifier, 'newFeedback');
                    $model->onFeedback($event);

                    echo CJSON::encode('success');
                }
            }
            else {
                echo CJSON::encode($model->errors);
            }

        }
    }

    /**
     * "public" method to accept user's feedback from main page
     * "public" means that it's allowed to guest users
     */
    public function actionUserFeedback()
    {
        $model = new Feedback;
        $model->attributes = $_POST;
        $model->subject = isset($_POST['subject']) ? implode(',' , $_POST['subject']) : '';
        $model->ip = ip2long(Yii::app()->request->userHostAddress);
        $user=Yii::app()->user;

        if(!empty($_FILES)){
            $filesArr = array();
            foreach($_FILES as $file){
                $filesArr[] = array(
                    'name'=>$file['name'],
                    'type'=>$file['type'],
                    'url'=>'/uploads/feedback/'.$file['name'],
                );
            }
            $model->files = serialize($filesArr);
        }

        if($model->validate()){

            if($model->save()){
                    $webroot = Yii::getPathOfAlias('webroot');
                if(!empty($_FILES)){
                    foreach($_FILES as $file){
                        move_uploaded_file($file['tmp_name'], $webroot.'/uploads/feedback/'.$file['name']);
                    }
                }
                $event = new CEvent($this,array('model'=>$model));
                $notifier = new Notifier();
                $model->onFeedback = array($notifier, 'newFeedback');
                $model->onFeedback($event);

                $user->setFlash('feedback-success',Yii::t('frontend','Ваше сообщение отправлено.'));
                $this->redirect('/#contacts');
            }
        } else {
            $user->setFlash('feedback-error',Yii::t('frontend','Сообщение не отправлено. Попробуйте еще раз или свяжитесь по телефону.'));
            $this->redirect($this->createUrl('/',array('#'=>'contacts')));
        }
    }

    public function actionDeleteFile()
    {
        $fileName = isset($_POST['file']) ? $_POST['file'] : null;
        if($fileName){
            $file = file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$fileName) ? Yii::getPathOfAlias('webroot').'/uploads/'.$fileName : null;
            $thumb = file_exists(Yii::getPathOfAlias('webroot').'/uploads/thumbnail/'.$fileName) ? Yii::getPathOfAlias('webroot').'/uploads/thumbnail/'.$fileName : null;
            $file = unlink($file);
            $thumb = unlink($thumb);
        }
        echo CJSON::encode(array(
            'file'=>$file,
            'thumb'=>$thumb,
            'divName'=>$fileName,
        ));
    }

    public function actionGetFiles()
    {
        if(isset($_POST['files'])){
            $files = unserialize($_POST['files']);
            $id = (int)$_POST['id'];
            echo CJSON::encode(array('files'=>$files,'id'=>$id));
        } else {
            echo CJSON::encode('error');
        }
    }

//    public function actionContact()
//	{
//        $model = new Feedback;
//        $this->performAjaxValidation($model);
//
//        if(isset($_POST['Feedback']))
//        {
//            $model->attributes = $_POST['Feedback'];
//            $model->save();
//            if($model->save())
//                $this->redirect(Yii::app()->request->requestUri);
//        }
//		$this->render('contact',array(
//            'model'=>$model,
//        ));
//	}

	/**
	 * Creates a new feedback config!.
	 */
	public function actionCreate()
	{
            $this->layout = '//layouts/main';
            $model=new Feedback;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Feedback']))
		{
                    $lang = isset($_POST['language']) ? $_POST['language'] : Yii::app()->language;
			        $model->attributes=$_POST['Feedback'];
                        $model->mailheader = Yii::app()->mail->mailheader[$lang];
                        $model->mailfooter = Yii::app()->mail->mailfooter[$lang];
                        $model->charset = Yii::app()->mail->charset;
                        $model->adminEmail = Yii::app()->mail->adminEmail;
                        $model->mailGroup = !empty(Yii::app()->mail->mailGroup) ? Yii::app()->mail->mailGroup : false;
                        
			if($model->save())
                        {
                            $message = new YiiMailMessage;
                            $message->setCharset($model->charset);
                            $message->setSubject($model->subject);
                            $message->setBody($model->mailheader."\n".  $this->imgSrc($model->body)."\n".$model->mailfooter,'text/html');
                            $message->setTo(array($model->adminEmail));
                            if($model->mailGroup){
                                foreach ($model->mailGroup as $key => $recepient)
                                {
                                    if($recepient != '')
                                    {
                                       $message->addTo($recepient, $recepient);
                                    }
                                }
                            }
                            $message->setFrom(array('blog@root.zt.ua'=>$model->sender_name));
                            $message->setReplyTo($model->sender_mail,$model->sender_name);
                

                            if(Yii::app()->mail->send($message)){
                                Yii::app()->user->setFlash('success', "Сообщение отправлено");
                            };
                            
				$this->redirect(array('view','id'=>$model->id));
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
//	public function actionUpdate($id)
//	{
//		$model=$this->loadModel($id);
//
//		// Uncomment the following line if AJAX validation is needed
//		// $this->performAjaxValidation($model);
//
//		if(isset($_POST['Feedback']))
//		{
//			$model->attributes=$_POST['Feedback'];
//			if($model->save())
//				$this->redirect(array('view','id'=>$model->id));
//		}
//
//		$this->render('update',array(
//			'model'=>$model,
//		));
//	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        if($this->loadModel($id)->delete()){
            Yii::app()->user->setFlash('success',Yii::t("backend","Запись успешно удалена!"));
        } else {
            Yii::app()->user->setFlash('error',Yii::t("backend","Запись не была удалена!"));
        }

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])){
            $this->redirect($this->createUrl('backend/feedback/feedback/maillist'),array('language'=>Yii::app()->language));
        }
	}
//
//	/**
//	 * Lists all models.
//	 */
//	public function actionIndex()
//	{
//		$dataProvider=new CActiveDataProvider('Feedback');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                $this->layout = '//layouts/main';
                $path = Yii::getPathOfAlias('application.common.config');
                $file = $path.'/mail.php';
                
                 if(Yii::app()->request->isPostRequest){
                    $postArray = array(
                        'host'=>$_POST['host'],
                        'port'=>$_POST['port'],
                        'username'=>$_POST['username'],
                        'password'=>$_POST['password'],
                        'encryption'=>$_POST['encryption'],
                    );
                    
                    if(isset($_POST['useMail']) != 1)
                                {
                    $mailArray = array(
                        'class' => 'ext.yii-mail.YiiMail',
                                      'transportType' => 'smtp',
                                      'transportOptions' => $postArray,
                                      'charset'=>$_POST['charset'],
                                      'adminEmail'=>$_POST['adminEmail'],
                                      'mailGroup' =>explode(';',$_POST['mailGroup']),
                                      'mailheader'=>$this->imgSrc($_POST['Feedback']['mailheader']),
                                      'mailfooter'=>$this->imgSrc($_POST['Feedback']['mailfooter']),
                           );
                                } else {
                                $mailArray = array(
                                    'class' => 'ext.yii-mail.YiiMail',
                                      'transportType' => 'php',
                                      'transportOptions' => '',
                                      'charset'=>$_POST['charset'],
                                      'adminEmail'=>$_POST['adminEmail'],
                                      'mailGroup' =>explode(';',$_POST['mailGroup']),
                                      'mailheader'=>$this->imgSrc($_POST['Feedback']['mailheader']),
                                      'mailfooter'=>$this->imgSrc($_POST['Feedback']['mailfooter']),
                                    );
                                }
                $content = "<?php\n return ";
                $content .= var_export($mailArray,true);
                $content .=";";
                if(!file_put_contents($file, $content)) die ('<h1>error!</h1>');
                    } else {
                        $postArray = array();
                    }

                $model=new Feedback('search');
		        $model->unsetAttributes();  // clear any default values
		if(isset($_GET['Feedback']))
			$model->attributes=$_GET['Feedback'];

		$this->render('admin',array(
			'model'=>$model,
                        'postArray'=>$postArray,
                        'path'=>$path,
                        'file'=>$file,
		));
	}
        
    public function actionMailList()
    {
           $model=new Feedback('search');
           $model->unsetAttributes();  // clear any default values

    if (isset($_GET['pageSize'])) {
        Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
        unset($_GET['pageSize']);  // сбросим, чтобы не пересекалось с настройками пейджера
    }

    if(isset($_GET['Feedback']))

        $model->attributes=$_GET['Feedback'];
        $this->render('maillist',array(
        'model'=>$model)
                );
    }

    protected function imgSrc($input)
    {
            $pattern = '^src="^';
            $host = $_SERVER['HTTP_HOST'];
            $replacement = 'src="http://'.$host;

            if(is_array($input))
            {
                foreach ($input as $key=>$val)
                {
                    $input[$key] = preg_replace($pattern, $replacement, $val);
                }
            } else {
                $input = preg_replace($pattern, $replacement, $input);
            }
            return $input;
    }


    public function tabsArray($model)
    {
        $tabsArray = array();
        foreach(Yii::app()->params['languages'] as $language)
        {
            if(Yii::app()->sourceLanguage == $language['langcode'])
                $tabsArray[] = array('label'=>$language['lang'],'content'=>$this->getTabContent($model,$language['langcode']),'active'=>true);
            else
                $tabsArray[] = array('label'=>$language['lang'],'content'=>$this->getTabContent($model,$language['langcode']));
        }
        return $tabsArray;
    }
        
    public function getTabContent($model,$lang)
    {
        $fieldsArray = array('mailheader','mailfooter');
        $content = '';
            foreach($fieldsArray as $field)
            {
                $label = CHtml::activeLabel($model, $field);

                    $textField = $this->tinyToTabs($model, $field, $lang);

                $content .= $label.$textField;
            }

        return $content;
    }
        
        
    public function tinyToTabs($model,$field,$lang)
    {
             $name = 'Feedback['.$field.']['.$lang.']';

             $model->{$field} = isset(Yii::app()->mail->{$field}[$lang]) ? Yii::app()->mail->{$field}[$lang] : '';
             $editor = $this->widget('ext.tinymce.TinyMce', array(
                    'model' => $model,
                    'attribute' => $field,
                    'language'=>$lang,
                    // Optional config
                    'compressorRoute' => 'tinyMce/compressor',
                    //'spellcheckerUrl' => array('tinyMce/spellchecker'),
                    // or use yandex spell: http://api.yandex.ru/speller/doc/dg/tasks/how-to-spellcheck-tinymce.xml
                    'fileManager' => array(
                        'class' => 'ext.elFinder.TinyMceElFinder',
                        //route to class with action connector (class or controller)
                        'connectorRoute'=>'elfinder/connector',
                    ),
                    'htmlOptions' => array(
                       'name'=>$name,
                       // 'rows' => 6,
                       // 'cols' => 60,
                        'width'=>'auto',
                    ),
                ),true);

        return $editor;
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Feedback the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Feedback::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Feedback $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='feedback-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
