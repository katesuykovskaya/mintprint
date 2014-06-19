<?php

class OrderController extends Controller
{
    public function actionCreate() {
        $model = new OrderHead;
        $model->attributes = Yii::app()->session['OrderHead'];
        $model->price = OrderTemp::CollectPrice($this->module->config['price']);
        if($model->save(false)) {
            Yii::app()->session['id_order'] = $model->id;
            die(json_encode(array('res'=>true, 'id_order'=>$model->id)));
        }
    }

    public function actionSavePhoto() {
        $idOrder = Yii::app()->session['id_order'];
        Yii::import('application.backend.components.ZHtml');
//        try {
            $image = OrderTemp::model()->findByAttributes(array(
                'id'=>$_POST['id'],
                'session_id'=>Yii::app()->session->sessionID
            ));
            if($image['type'] == 'social') {
                $content = file_get_contents($image['img_url']);
                $tempPath = Yii::getPathOfAlias('webroot')."/uploads/tmp/".ZHtml::randomString(32).".jpg";
                $fp = fopen($tempPath, "w");
                fwrite($fp, $content);
                fclose($fp);
            } else
                $tempPath = str_replace("http://".$_SERVER['SERVER_NAME'], Yii::getPathOfAlias('webroot'), $image['img_url']);

//            $saved = Yii::app()->easyImage->thumbSrcOf($tempPath, array(
//                "savePath"=>Yii::getPathOfAlias("webroot")."/uploads/Order/".$idOrder."",
////                "save"=>ZHtml::randomString(32),
//                "quality" => 80,
//                'crop'=>array(
//                    'width'=>$image['img_width'],
//                    'height'=>$image['img_height'],
//                    'offset_x'=> $image['img_x'],
//                    'offset_y'=>$image['img_y']
//                ),
//            ));
            $path_parts = pathinfo($tempPath);

            if(!file_exists(Yii::getPathOfAlias("webroot")."/uploads/Order/".$idOrder."/"))
            {
                mkdir(Yii::getPathOfAlias("webroot")."/uploads/Order/".$idOrder."/");
            }


            $crop = new EasyImage($tempPath);
            $crop->crop($image['img_width'], $image['img_height'], $image['img_x'], $image['img_y']);
            $crop->save(Yii::getPathOfAlias("webroot")."/uploads/Order/".$idOrder."/".$path_parts['filename'].'.'.$path_parts['extension'], 80);
            $saved = Yii::getPathOfAlias("webroot")."/uploads/Order/".$idOrder."/".$path_parts['filename'].'.'.$path_parts['extension'];

            if($image['type'] == 'social')
                unlink($tempPath);
//        } catch(Exception $e) {
//            die(json_encode(array('res'=>false)));
//        }
        $model = new OrderBody;
        $model->path = str_replace(Yii::getPathOfAlias('webroot'), "", $saved);
        $model->count = $image['img_count'];
        $model->id_order = $idOrder;
        $res = $model->save();
        if($res)
            $image->delete();
        die(json_encode(array('res'=>$res)));
    }

    public function actionResult() {
        $id = Yii::app()->session['id_order'];
//        unset(Yii::app()->session['id_order']);
        $tmpDir = Yii::getPathOfAlias('webroot').'/uploads/tmp/'.Yii::app()->session->sessionID.'/';
        if(file_exists($tmpDir))
            rmdir($tmpDir);
        $model = OrderHead::model()->findByPk($id);
        $orderFormModel = new OrderForm;
        $config = $this->getModule()->config;
        ob_start();
        $this->renderPartial('_userEmail', array(
            'model'=>$model,
            'orderFormModel'=>$orderFormModel,
            'config'=>$config
        ));
        $body = ob_get_clean();
        $this->SendClientEmail($body, $model->email);
        $this->SendAdminEmail($body, $model->id);
        $this->renderPartial('result', array(
            'id'=>$id,
        ));
    }

    public function SendClientEmail(&$body, $email) {
        Yii::import('application.backend.modules.feedback.components.mailOrPhone');
        Yii::import('application.extensions.yii-mail.YiiMailMessage');
        Yii::import('application.backend.components.*');
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

    public function SendAdminEmail(&$body, $id) {
        Yii::import('application.backend.modules.feedback.components.mailOrPhone');
        Yii::import('application.extensions.yii-mail.YiiMailMessage');
        Yii::import('application.backend.components.*');
        $message = new YiiMailMessage;
        $host = $_SERVER['HTTP_HOST'];
        $mailSettings = require(Yii::getPathOfAlias('webroot').'/seocms/protected/common/config/mail.php');
        $body .= CHtml::link('Подробнее', Yii::app()->createAbsoluteUrl('/backend/order/orderHead/update', array('id'=>$id)));
        $message->setCharset(Yii::app()->mail->charset);
        $message->setSubject('Администрирование '.$host);
        $message->setBody($body,'text/html');
        $message->setTo($mailSettings['mailGroup']);
        $message->setFrom(array($mailSettings['adminEmail']=>'Администратор '.$host));
        $message->setReplyTo($mailSettings['adminEmail'], 'Администратор '.$host);

        return Yii::app()->mail->send($message);
    }
}