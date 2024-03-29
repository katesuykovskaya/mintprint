<?php

class OrderController extends Controller
{
    public function filters()
    {
        return array(
            'ajaxOnly + result', // we only allow deletion via POST request
        );
    }
    public function actionCreate() {
        $model = new OrderHead;
        $model->attributes = Yii::app()->session['OrderHead'];
        $model->price = OrderTemp::CollectPrice($this->module->config['price']);
        $model->date = date("Y-m-d");
        if(!empty(Yii::app()->session['certificate']))
            $model->status = 'certificate';
        if($model->save(false)) {
            $sql = "update Certificate set id_order = $model->id where code = '".Yii::app()->session['certificate']."'";
            Yii::app()->db->createCommand($sql)->execute();
            Yii::app()->session['id_order'] = $model->id;
            die(json_encode(array('res'=>true, 'id_order'=>$model->id)));
        }
    }

    public function actionSavePhoto() {
        $idOrder = Yii::app()->session['id_order'];
        Yii::import('application.backend.components.ZHtml');
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

            $path_parts = pathinfo($tempPath);

        $dateFolder = Yii::getPathOfAlias("webroot")."/uploads/Order/".date("d-m-Y")."/";
        if(!file_exists($dateFolder))
            mkdir($dateFolder, 0777, true);
        $orderFolder = $dateFolder.$idOrder."/";
        $position = OrderBody::model()->countByAttributes(array('id_order'=>$idOrder)) + 1;
        $fileName = $position.'-'.$image['img_count'].'.'.$path_parts['extension'];
        $file = $orderFolder.$fileName;
        if(!file_exists($orderFolder))
            mkdir($orderFolder, 0777);
            $crop = new EasyImage($tempPath);
            $crop->crop($image['img_width'], $image['img_height'], $image['img_x'], $image['img_y']);
            $crop->save($file, 80);

            if($image['type'] == 'social')
                unlink($tempPath);
        $this->CreatePolaroid($file, strtolower($path_parts['extension']));

        $model = new OrderBody;
        $model->count = $image['img_count'];

        $model->path = str_replace(Yii::getPathOfAlias('webroot'), "", $file);
        $model->id_order = $idOrder;
        $model->position = $position;
        $res = $model->save();
        if($res)
            $image->delete();
        die(json_encode(array('res'=>$res)));
    }

    protected function CreatePolaroid($path, $ext)
    {
        $imgHeight = getimagesize($path)[0];
        $resWidth = ($imgHeight / 3.5) * 4;
        $resHeight = ($resWidth / 9) * 11;
        $im = imagecreatetruecolor($resWidth, $resHeight);
        $white = imagecolorallocate($im, 255, 255, 255);
        imagefill($im, 0,0,$white);
        switch($ext)
        {
            case 'png':
                $im2 = imagecreatefrompng($path);
                break;
            case 'gif':
                $im2 = imagecreatefromgif($path);
            case 'bmp':
                $im2 = imagecreatefromwbmp($path);
            case 'jpg':case 'jpeg':
                $im2 = imagecreatefromjpeg($path);
                break;
            default:
                $im2 = imagecreatefromjpeg($path);
                break;
        }

        $offset = ($resWidth - $imgHeight) / 2;
        imagecopy($im, $im2, $offset, $offset, 0, 0, $imgHeight, $imgHeight);
//        header('Content-Type: image/jpeg');
        imagejpeg($im, $path);
        imagedestroy($im);
    }

    public function actionResult() {
        Yii::import('application.backend.components.ZHtml');
        $id = Yii::app()->session['id_order'];
//        unset(Yii::app()->session['id_order']);
        $tmpDir = Yii::getPathOfAlias('webroot').'/uploads/tmp/'.Yii::app()->session->sessionID.'/';
        if(file_exists($tmpDir))
            ZHtml::deleteDir($tmpDir);
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
            'amount'=>$model->price
        ));
    }

    protected function SendClientEmail(&$body, $email) {
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

    protected function SendAdminEmail(&$body, $id) {
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