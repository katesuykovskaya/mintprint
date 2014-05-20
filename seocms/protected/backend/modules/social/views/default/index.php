<?php
/**
 * @var $this DefaultController
 * @var $model VK
 * @var $socials array
 */
foreach($socials as $val) {
    if(empty(Yii::app()->session[$val.'_token'])) {
        $socialArray = $this->module->config;
        $url = $socialArray[$val]['authUrl'] . '?' . urldecode(http_build_query($socialArray[$val]['auth'])).'&scenario=photos';
        echo CHtml::link($val, $url).'<br>';
    } else {
        $this->widget('application.backend.modules.social.widgets.SocialPhotoWidget', array(
            'provider'=>$val,
            'config'=>$this->module->config,
            'url'=>'/backend/social/default/photosFromAlbum'
        ));
    }
}