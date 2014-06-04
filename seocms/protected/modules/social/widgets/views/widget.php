<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 29.05.14
 * Time: 17:56
 * @var $this SocialPhotoWidget
 */
?>
<div class="social-widget" id="socialWidget">
    <ul class="tabs-head">
        <li><a class="ins" href="#tabs-1"><span>инстаграм</span></a></li>
        <li><a class="fb" href="#tabs-2"><span>фейсбук</span></a></li>
        <li><a class="vk" href="#tabs-3"><span>вконтакте</span></a></li>
        <li><a class="upload" href="#tabs-4"><span>загрузить</span></a></li>
    </ul>
    <?php foreach($this->socials as $key=>$val):
        if($val == 'upload'):
            ob_start();
            $this->render('fileupload');
            $upload = ob_get_contents();
            ob_end_clean();?>
            <div class="tab" id="tabs-<?=($key+1)?>">
                <?=$upload?>
            </div>
        <?php else:
        if(empty(Yii::app()->session[$val.'_token'])) :
            $socialArray = $this->config;
            $socialArray[$val]['auth']['redirect_uri'] .= '&scenario=auth';
            $url = $socialArray[$val]['authUrl'] . '?' . urldecode(http_build_query($socialArray[$val]['auth']));?>
            <div class="tab <?=$val?>-tab" id="tabs-<?=($key+1)?>">
                <div class="stripe"></div>
                <div class="enter">
                    <h3>войдите в сеть.</h3>
                    <p>жмите на кнопку</p>
                    <?=CHtml::link(Yii::t('frontend', 'enter '.$val), $url, array('class'=>'login-social'))?>
                </div>
            </div>
        <?php else :?>
            <div class="tab <?=$val?>-tab" id="tabs-<?=($key+1)?>">
                <div class="my-viewport">
                    <div class="stripe"></div>
                    <div class="viewport">
                        <?php $this->getAlbum($val);?>
                    </div>
                </div>
            </div>
        <?php endif;
    endif;
    endforeach?>
</div>
<script>
    $(document).ready(function(){
        $('#socialWidget').tabs();
        var tabs = $('.tab');
        for(var i = 0; i < tabs.length; i++) {
//            tabs.eq(i).tinyscrollbar();
        }
    });
</script>
