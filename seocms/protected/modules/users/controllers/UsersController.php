<?php

class UsersController extends Controller
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
        );
    }
    public function actionLogin()
    {
        if(empty(Yii::app()->session['from'])) {
            if(!empty($_SERVER['HTTP_REFERER']))
                Yii::app()->session['from'] = $_SERVER['HTTP_REFERER'];
            else
                Yii::app()->session['from'] = Yii::app()->createUrl('site/index');
        }
        Yii::import('application.backend.vendors.bCrypt');
        $this->layout='//layouts/no-bg';
        $model=new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
                $this->redirect(Yii::app()->session['from']);
        }

        // display the login form
        $this->render('login',array('model'=>$model));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        if(empty(Yii::app()->session['from'])) {
            if(!empty($_SERVER['HTTP_REFERER']))
                Yii::app()->session['from'] = $_SERVER['HTTP_REFERER'];
            else
                Yii::app()->session['from'] = Yii::app()->createUrl('site/index');
        }
        $this->redirect(Yii::app()->session['from']);
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new Users();
        $model->scenario = 'insert';

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

//        if(isset($_POST['Users']))
//        {
            $model->attributes=$_POST['CreateAccountForm'];
            $model->
            $model->role = 'Guest';
            $obj = new bCrypt();
            $model->token = $obj->hash(time());
//            echo CVarDumper::dump($model, $depth=10, $highlight=true);
//            echo 'user role = '.$_POST['userRole'];
            if($model->save()){
                /* продумать механизм удаления юзеров и тасков к ним */
                Rights::assign($model->role,$model->user_id);
                $event = new CEvent($this,array('model'=>$model));
                $notifier = new Notifier();
                $model->onCreate = array($notifier, 'newUser');
                $model->onCreate($event);
                $this->redirect($this->createUrl('users/users/admin'));
            }

//        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

//    public function actionConfirm()
//    {
//        $model=new ConfirmForm;
//
//        // if it is ajax validation request
//        if(isset($_POST['ajax']) && $_POST['ajax']==='confirm-form')
//        {
//            echo CActiveForm::validate($model);
//            Yii::app()->end();
//        }
//
//        // collect user input data
//        if(isset($_POST['ConfirmForm']))
//        {
//            $obj = new bCrypt();
//            $model->attributes=$_POST['ConfirmForm'];
//            // validate user input and redirect to the previous page if valid
//            if($model->validate())
//            {
//                $user = Users::model()->findByPk((int)$_POST['ConfirmForm']['userid']);
//                $user->pass = $obj->hash($model->password);
//                $user->active = 1;
//                $user->token = null;
//                if($user->save(false))
//                    $this->redirect($this->createUrl('backend/users/users/login'));
//                else
//                    die('error111');
//            }
//        }
//        // display the login form
//
//        if(isset($_GET['token']))
//        {
//            $data = Users::model()->findByAttributes(array('token'=>$_GET['token']));
//            if(count($data)!=1 && $data->token != null)
//                throw new CHttpException('404','Запись уже активирована или не существует, обратитесь к администратору.');
//            else
//                $this->render('confirm',array('model'=>$model,'data'=>$data));
//        } else {
//            $this->render('confirm',array('model'=>$model));
//        }
//    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
//    public function actionUpdate($id)
//    {
//        $model=$this->loadModel($id);
//
//        // Uncomment the following line if AJAX validation is needed
//        // $this->performAjaxValidation($model);
//
//        if(isset($_POST['Users']))
//        {
//            $model->attributes=$_POST['Users'];
//            $model->role = $_POST['userRole'];
//            $items = AuthAssignment::model()->findByAttributes(array('userid'=>$model->user_id));
//            if($items!=null)
//            {
//                AuthAssignment::model()->deleteAll('userid=:userid',array(':userid'=>$model->user_id));
//            }
//            Rights::assign($model->role,$model->user_id);
//            if($model->save())
//                $this->redirect($this->createUrl('users/users/admin'));
//        }
//
//        $this->render('update',array(
//            'model'=>$model,
//        ));
//    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=Users::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

//    public function actionRenewPassword()
//    {
//        $id = Yii::app()->request->getParam('user',null);
//        if($id){
//            $model = Users::model()->findByPk($id);
//            $model->active = 0;
//            $obj = new bCrypt();
//            $model->token = $obj->hash(time());
//            $model->save(false);
//            $event = new CEvent($this,array('model'=>$model));
//            $notifier = new Notifier();
//            $model->onRenewPassword = array($notifier, 'newUserPassword');
//            $model->onRenewPassword($event);
//            echo '<div class="alert alert-success span3">';
//            echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
//            echo 'На email пользователя '.$model->email.' было выслано сообщение с ссылкой для восстановления пароля.<br />';
//            echo '</div>';
//        } else
//        {
//            echo '<div class="alert alert-error span3">';
//            echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
//            echo 'ERROR!<br />';
//            echo '</div>';
//        }
//    }
}
