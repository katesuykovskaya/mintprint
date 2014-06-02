<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 23.04.14
 * Time: 16:35
 * @var $config array
 * @var $provider string
 */
//if($provider == 'instagram')
//echo CVarDumper::dump($albums, 6, true);
?>
<!--<h2>--><?//=strtoupper($provider)?><!--</h2>-->
<?php $aConf = $config['albums'];
foreach($albums as $key => $album) {
//    echo CVarDumper::dump($config, 6, true);
    echo CHtml::ajaxLink(
        CHtml::image('/img/folder-jpg.jpg', $album[$aConf['title']],
            array('class'=>'folder')).
        '<span class="loader loader'.$provider.'-'.$key.'"></span>'.
        CHtml::tag('p', array(), $album[$aConf['title']]),
        Yii::app()->createUrl($this->url,  [
            'auth'=>$provider
        ]),
        array(
            'type'=>'get',
            'data'=>'js:{'.$aConf['album_id'].' : '.$album[$aConf['album_id']].'}',
            'beforeSend'=>'js:function(){$(".loader'.$provider.'-'.$key.'").css("display", "block")}',
            'complete'=>'js:function(){$(".loader'.$provider.'-'.$key.'").css("display", "none")}',
            'update'=>'.'.$provider.'-tab .viewport',
        ),array(
            'class'=>'album-thumb'
        )
    );
}
?>
<div class="clearfix"></div>
<!--<div id="photos--><?//=$provider?><!--"></div>-->