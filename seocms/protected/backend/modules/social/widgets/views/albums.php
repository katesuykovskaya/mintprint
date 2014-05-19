<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 23.04.14
 * Time: 16:35
 * @var $config array
 */
//echo CVarDumper::dump($albums, 7, true);
$aConf = $config['albums'];
foreach($albums as $album) {
//    echo CVarDumper::dump($config, 6, true);
    echo CHtml::ajaxLink(
        CHtml::image($album[$aConf['thumb_src']], $album[$aConf['title']]).'<span class="loader"></span>',
        Yii::app()->createUrl($this->url,  [
            'auth'=>$_GET['auth']
        ]),
        array(
            'type'=>'get',
            'data'=>'js:{'.$aConf['album_id'].' : '.$album[$aConf['album_id']].'}',
            'beforeSend'=>'js:function(){$(".loader").css("display", "block")}',
            'update'=>'#photos',
        ),array(
            'class'=>'album-thumb'
        )
    );
}
?>
<div id="photos"></div>