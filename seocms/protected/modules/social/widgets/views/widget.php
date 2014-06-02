<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 29.05.14
 * Time: 17:56
 * @var $this SocialPhotoWidget
 */
foreach($this->socials as $val) {
    if(empty(Yii::app()->session[$val.'_token'])) {
        $socialArray = $this->config;
        $socialArray[$val]['auth']['redirect_uri'] .= '?scenario=auth';
        $url = $socialArray[$val]['authUrl'] . '?' . urldecode(http_build_query($socialArray[$val]['auth']));
        echo CHtml::link($val, $url).'<br>';
    } else {
        $this->getAlbum($val);
    }
}