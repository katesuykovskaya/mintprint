<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 23.04.14
 * Time: 16:35
 * @var $config array
 * @var $provider string
 */
$aConf = $config['albums'];
if($albums === null) {?>
    <div class="enter">
        <h3>войдите в сеть.</h3>
        <p>жмите на кнопку</p>
        <?php
        $config['auth']['redirect_uri'] .= '&scenario=auth';
        $url = $config['authUrl'] . '?' . urldecode(http_build_query($config['auth']));
        ?>
        <?=CHtml::link(Yii::t('frontend', 'enter '.$provider), $url, array('class'=>'login-social'))?>
    </div>
<?php }
else {
    echo CHtml::openTag('div', array('class'=>'logout-wrap'));
    echo CHtml::link('Выйти', Yii::app()->urlManager->createUrl('site/logout', array('provider'=>$provider)), array(
        'class'=>'logout',
        'data-logout-url'=>$config['logoutUrl']));
    echo CHtml::closeTag('div');
    foreach($albums as $key => $album) {
    echo CHtml::ajaxLink(
        CHtml::image('/img/folder.png', $album[$aConf['title']],
            array('class'=>'folder')).
        '<span class="loader loader'.$provider.'-'.$key.'"></span>'.
        CHtml::tag('p', array(), $album[$aConf['title']]),
        Yii::app()->createUrl($this->url, [
            'auth'=>$provider
        ]),
        array(
            'type'=>'get',
            'data'=>'js:{'.$aConf['album_id'].' : "'.$album[$aConf['album_id']].'"}',
            'beforeSend'=>'js:function(){$(".loader'.$provider.'-'.$key.'").css("display", "block")}',
            'complete'=>'js:function(){$(".loader'.$provider.'-'.$key.'").css("display", "none");$(".image-wrap").draggable({
        cursor: "move",
            scroll: false,
            helper: "clone",
            containment: ".content"});}',
            'update'=>'.'.$provider.'-tab .viewport',
        ),
        array(
            'id'=>$provider.'_'.$album[$aConf['album_id']],
            'class'=>'album-thumb',
            'data-url'=>Yii::app()->createUrl($this->url, [
                    'auth'=>$provider
                ]),
        )
    );
}}


?>
<div class="clearfix"></div>