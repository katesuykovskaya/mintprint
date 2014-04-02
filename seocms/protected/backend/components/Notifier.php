<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lesha
 * Date: 17.03.13
 * Time: 23:30
 * To change this template use File | Settings | File Templates.
 */

// Класс-оповещатель
// Рассылает почту при различных событиях
class Notifier {

    function newUser($event)
    {
        Yii::import('backend.modules.feedback.models.Feedback');
        $mailSettings = require(dirname(__FILE__).'/../config/mail.php');
        $model = new Feedback();
        $data = $event->params['model'];
        $host = $_SERVER['HTTP_HOST'];

        $message = new YiiMailMessage;
        $message->setCharset(Yii::app()->mail->charset);
        $message->setSubject('Регистрация на '.$host);

        $body = 'Здравствуйте, '.$data->login.'!<br />'.
        'Вы были зарегистрированы на сайте '.$host.' под логином: '.$data->login.'.<br />'.
        'для завершения регистрации, необходимо перейти по ссылке '.
            '<a href="http://'.$_SERVER['HTTP_HOST'].':/backend/users/users/confirm?token='.$data->token.'">подтверждение регистрации</a>';

        $message->setBody($body,'text/html');
        $message->setTo(array($data->email));
        $message->setFrom(array($mailSettings['adminEmail']=>'site admin'));
        $message->setReplyTo($mailSettings['adminEmail'],'site admin');

        Yii::app()->mail->send($message);
    }

    function newUserPassword($event)
    {
        Yii::import('backend.modules.feedback.models.Feedback');
        $mailSettings = require(dirname(__FILE__).'/../config/mail.php');
        $data = $event->params['model'];
        $host = $_SERVER['HTTP_HOST'];

        $message = new YiiMailMessage;
        $message->setCharset(Yii::app()->mail->charset);
        $message->setSubject('Восстановление пароля на '.$host);

        $body = 'Здравствуйте, '.$data->login.'!<br />'.
            'Вы запросили изменение пароля на сайте '.$host.'<br />'.
            'для изменения пароля, необходимо перейти по ссылке '.
            '<a href="http://'.$_SERVER['HTTP_HOST'].':/backend/users/users/confirm?token='.$data->token.'">изменение пароля</a>';

        $message->setBody($body,'text/html');
        $message->setTo(array($data->email));

        $message->setFrom(array($mailSettings['adminEmail']=>'site admin'));
        $message->setReplyTo($mailSettings['adminEmail'],'site admin');

        Yii::app()->mail->send($message);
    }

    function newFeedback($event)
    {
        Yii::import('backend.modules.feedback.models.Feedback');
        $mailSettings = require(dirname(__FILE__).'/../config/mail.php');

        $data = $event->params['model'];
        $host = $_SERVER['HTTP_HOST'];

        $message = new YiiMailMessage;
        $message->setCharset(Yii::app()->mail->charset);
        $message->setSubject(Yii::t('backend','Обратная связь сайта '.$host.' :: '.$data->subject));

        $body = $data->body;

        $message->setBody($body,'text/html');
        if(empty($mailSettings['mailGroup']))
            $message->setTo($mailSettings['adminEmail']);
        else {
//            $arr = $mailSettings['mailGroup'];
            $arr = array();
            foreach($mailSettings['mailGroup'] as $key=>$email){
                if(strlen($email)!= 0){
                    $arr[] = $email;
                }
            }
            $arr[] = $mailSettings['adminEmail'];
//            $message->setTo($mailSettings['adminEmail']);
            $message->setTo($arr);
        }
        $message->setFrom($mailSettings['adminEmail']);
        if($data->sender_mail !== '')
            $message->setReplyTo($data->sender_mail,$data->sender_name);
        if(!empty($data->files)){
            $filesArr = unserialize($data->files);
            foreach($filesArr as $file){
                $message->attach(Swift_Attachment::fromPath(Yii::getPathOfAlias('webroot').'/uploads/feedback/'.$file['name']));
            }
        }

        Yii::app()->mail->send($message);
    }
}