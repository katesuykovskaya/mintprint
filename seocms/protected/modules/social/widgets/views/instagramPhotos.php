<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 26.05.14
 * Time: 17:15
 * @var $photos array
 * @var $this SocialPhotoWidget
 */?>
<div class="logout-wrap">
    <?php /*echo CHtml::ajaxLink('Выйти', Yii::app()->createUrl('site/logout', array('provider'=>'instagram')), array(
        'success'=>'js:function(response){
            try {
                var res = $.parseJSON(response);
                if(res.response) {
                    // God forgive me for this!! - iframe in iframe
                    $(\'body\').append(\'<div id="inss" style="display:none"><iframe width="0" height="0"><iframe src="'.$config['logoutUrl'].'"></iframe></iframe></div>\');
                    location.href="/site/index";
                }
                else
                    alert("Возникла ошибка");
            }
             catch(e){
             console.log("ewewewe");
                location.href="http://'.$_SERVER['SERVER_NAME'].'/site/index";
            }
        }',
    ), array('class'=>'logout'));
 */
 echo CHtml::link('Выйти', Yii::app()->urlManager->createUrl('site/logout', array('provider'=>'instagram')), array(
        'class'=>'logout ins-logout',
        'data-logout-url'=>$config['logoutUrl']));
    ?>
</div>

   <?php $this->render('_instagramPhotos', array('photos'=>$photos,'config'=>$config))?>
