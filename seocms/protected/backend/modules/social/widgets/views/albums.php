<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 23.04.14
 * Time: 16:35
 */
foreach($albums as $album) {
    echo CHtml::ajaxLink(
        CHtml::image($album['thumb_src'], $album['title']).'<span class="loader"></span>',
        Yii::app()->createUrl($this->url,  [
            'auth'=>$_GET['auth']
        ]),
        array(
            'type'=>'get',
            'data'=>'js:{aid : '.$album['aid'].'}',
            'beforeSend'=>'js:function(){$(".loader").css("display", "block")}',
            'update'=>'#photos',
        ),array(
            'class'=>'album-thumb'
        )
    );
}
//echo CVarDumper::dump($this, 5, true);
?>
<div id="photos"></div>