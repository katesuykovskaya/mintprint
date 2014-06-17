<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 23.04.14
 * Time: 16:26
 */

class SocialPhotoWidget extends CWidget {
    public $socials;
    public $url;
    public $config;

    public function init() {
        Yii::app()->clientScript->registerScriptFile('/js/vkAjax.js', CClientScript::POS_HEAD);
    }

    public function run() {
        $this->render('widget');
//        $provider = $this->provider;
    }

    public function getAlbum($provider) {
        $authClass = ucfirst($provider);
        $auth = new $authClass();
        $token = Yii::app()->session[$provider.'_token'];
        if($provider == 'instagram') {
            $photos = $auth->getPhotos($token);
            $this->render('instagramPhotos', array(
                    'photos'=>$photos)
            );
        }
        else {
            $albums = $auth->getAlbums($token);
            $this->render('albums', array(
                'albums'=>$albums,
                'config'=>$this->config[$provider],
                'provider'=>$provider
            ));
        }
    }
} 