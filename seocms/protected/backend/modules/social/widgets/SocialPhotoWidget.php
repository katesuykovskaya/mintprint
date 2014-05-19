<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 23.04.14
 * Time: 16:26
 */

class SocialPhotoWidget extends CWidget {
    public $provider;
    public $url;
    public $config;

    public function init() {
        Yii::app()->clientScript->registerScriptFile('/js/vkAjax.js', CClientScript::POS_HEAD);
    }

    public function run() {
        $provider = $this->provider;
        $authClass = ucfirst($provider);
        $auth = new $authClass();
        $token = Yii::app()->session[$provider.'_token'];
//        echo $provider;
        $albums = $auth->getAlbums($token);

        $this->render('albums', array(
            'albums'=>$albums,
            'config'=>$this->config[$provider]
        ));
    }
} 