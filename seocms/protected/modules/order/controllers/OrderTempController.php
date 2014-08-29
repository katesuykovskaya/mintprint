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
//			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

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
                    $singlePrice = $this->module->config['price'];
                    die(json_encode(array('res'=>true, 'id'=>$model->id, 'sum'=>OrderTemp::CollectPrice($singlePrice))));
                }
                die(json_encode(array('res'=>false, 'reason'=>'Возникла ошибка')));
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
        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_POST['OrderTemp']['img_count'])) {
                $model->attributes=$_POST['OrderTemp'];
                if($model->save(true, array('img_count'))) {
                    $config = $this->module->config;
                    die(json_encode(array(
                        'res' => true,
                        'total' => OrderTemp::CollectPrice($config['price']),
                        'singleSum' => $model->img_count * $config['price']
                    )));
                }
                else
                    die(json_encode(array('res'=>false, 'reason'=>'Fail save')));
            }
            elseif(isset($_POST['OrderTemp'])) {
                $model->attributes=$_POST['OrderTemp'];
                if($model->save())
                    die(json_encode(array('res'=>true)));
                else
                    die(json_encode(array('res'=>false)));
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
	public function actionDelete()
	{
        if(Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($_POST['OrderTemp']['id']);
            $model->delete();
            $singlePrice = $this->module->config['price'];
            die (json_encode(array('res'=>true, 'sum' => OrderTemp::CollectPrice($singlePrice))));
        }


		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Step 1.
	 */
	public function actionBasket()
	{
        $this->layout = '//layouts/no-bg';
        $attr = array(
            'session_id' => Yii::app()->session->sessionID,
        );
        if(!Yii::app()->user->isGuest)
            $attr['user_id'] = Yii::app()->user->id;
        $models = OrderTemp::model()->findAllByAttributes($attr);
        $config = $this->module->config;
        $this->render('basket', array(
            'models'=>$models,
            'config'=>$config
        ));
	}

    /**
     * Step 3
     */
    public function actionConfirm() {

        $photos = OrderTemp::model()->findAllByAttributes(array(
            'session_id'=>Yii::app()->session->sessionID
        ));

        $orderForm = new OrderForm;
        $order = Yii::app()->session['OrderHead'];
        $config = $this->module->config;

        $this->render('confirmOrder', array(
            'orderForm'=>$orderForm,
            'order'=>$order,
            'photos'=>$photos,
            'config'=>$config
        ));
    }

    /**
     * Step 2
     */
    public function actionBuyerInfo() {
        $this->layout = '//layouts/no-bg';
        Yii::import('application.modules.users.models.CreateAccountForm');
        $createAccountModel = new CreateAccountForm;
        $orderFormModel = new OrderForm;
        $orderFormModel->delivery = 'post';
        $config = $this->module->config;

        if(isset($_POST['OrderForm'])) {
            $orderFormModel->attributes = $_POST['OrderForm'];
            if($orderFormModel->validate()) {
                Yii::app()->session['OrderHead'] = $_POST['OrderForm'];
                $this->redirect(Yii::app()->createUrl('order/orderTemp/confirm'));
            }
        }

        $attr = array(
            'session_id' => Yii::app()->session->sessionID,
        );
        if(!Yii::app()->user->isGuest)
            $attr['user_id'] = Yii::app()->user->id;
        $count = OrderTemp::model()->countByAttributes($attr);

        $this->render('buyerInfo', array(
            'createAccountModel' => $createAccountModel,
            'orderFormModel' => $orderFormModel,
            'config' => $config,
            'count'=>$count
        ));
    }

    public function actionCount()
    {
        if(Yii::app()->request->isPostRequest)
        {
            $sum = OrderTemp::CollectPrice($this->module->config['price']);
            $sum >= 20 ? die("1") : die("0");
        }
        else
            throw new CHttpException(403,'The requested page does not exist.');
    }

    public function actionClear()
    {
        $sql = "delete from OrderTemp where session_id = '".Yii::app()->session->sessionID."'";
        Yii::app()->db->createCommand($sql)->execute();
        $this->redirect(Yii::app()->createUrl('site/index'));
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
