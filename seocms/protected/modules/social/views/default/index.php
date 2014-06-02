<?php
/**
 * @var $this DefaultController
 * @var $model VK
 * @var $socials array
 */
foreach($socials as $val) {
    if(empty(Yii::app()->session[$val.'_token'])) {
        $socialArray = $this->module->config;
        $socialArray[$val]['auth']['redirect_uri'] .= '?scenario=auth';
        $url = $socialArray[$val]['authUrl'] . '?' . urldecode(http_build_query($socialArray[$val]['auth']));
        echo CHtml::link($val, $url).'<br>';
    } else {
        $this->widget('application.backend.modules.social.widgets.SocialPhotoWidget', array(
            'provider'=>$val,
            'config'=>$this->module->config,
            'url'=>'/backend/social/default/photosFromAlbum'
        ));
    }
}
//http://oauth.vk.com/authorize?client_id=4321188&response_type=code&scope=photos&redirect_uri=http://photo-service.home/backend/social/default/auth/authprovider/vk?v=5.16
// TRUE
//http://oauth.vk.com/authorize?client_id=4321188&response_type=code&scope=photos&redirect_uri=http://photo-service.home/backend/social/default/auth/authprovider/vk?scenario=photos&v=5.16