<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 08.07.14
 * Time: 9:40
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$this->pageTitle?></title>
    <link rel="stylesheet" href="/css/main.css"/>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
</head>
<style>
    body {
        background: #E6E7E8;
    }
</style>
<body>
<div class="header-and-content-wrap">
    <header>
        <div class="header-wrap">
            <?php $this->widget('application.backend.modules.menugen.widgets.FrontMenu',array('menuName'=>'меню в head'))?>
            <div class="right-buttons">
<!--                <a id="profile" class="profile" href="--><?//=!empty(Yii::app()->user->id) ? Yii::app()->createUrl('site/profile') : Yii::app()->createUrl('site/login')?><!--">--><?//=!empty(Yii::app()->user->id) ? Yii::app()->user->login : ''?><!--</a>-->
                <a id="basket" class="basket" href="<?=Yii::app()->createUrl('order/orderTemp/basket')?>"></a>
            </div>
        </div>
        <div class="header-bg"></div>
    </header>
    <div class="head-page">MINT PRINT</div>
    <div class="wrapper-page">
        <div class="left-page">
            <div class="content-page">
                <?=$content?>
            </div>
        </div>
        <div class="right-page">
            <div class="right-block-info">
                <div class="head-block-info">РЕШАЙТЕ СОХРАНИТЬ СВОИ ЛУЧШИЕ ВОСПОМИНАНИЯ</div>
                <div class="price-photo">Цена фотографии всего</div>
                <div id="priceWrap" class="relative">
                    <span id="price"><?=$this->conf['price']?></span><sup><?=$this->conf['currency']?></sup>
                </div>
                <div class="desc-photo">А воспоминания - бесценны. жмите на кнопку и посмотрите, как моменты вашей жизненной истории смотрятся в полароидных рамочках</div>
                <a href="<?=Yii::app()->createUrl('site/index')?>" class="back-button margin-top-10">СМОТРЕТЬ МОИ ФОТО</a>
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="footer-text-wrap">
        <div class="footer-top-bg"></div>
        <div class="footer-text">
            <h2><?=Yii::t('frontend','печать всего за 1 гривну')?></h2>
            <div>
                <p>а воспоминания - бесценны, сохраните их настоящими.</p>
                <p>бумажными фотографиями, которые можно дать в руки, подарить, и положить под подушку</p>
            </div>
        </div>

        <div class="footer-bottom-bg"></div>
    </div>
    <div class="footer-menu">
        <div class="footer-menu-wrap">
            <?php $this->widget('application.backend.modules.menugen.widgets.FrontMenu',array('menuName'=>'меню в footer'))?>
            <div class="socials-bottom">
                <a class="ins" href="#"></a>
                <a class="fb" href="#"></a>
                <a class="vk" href="#"></a>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
<script>
    $(document).ready(function(){
        //menu
        var menu = $('header menu ul').eq(0);
        var index = Math.floor(menu.children().length / 2) - 1;
        var li = $('<li></li>', {'class': 'middle-leaf'}).insertAfter(menu.children('li').eq(index));
        $('<img>', {
            src: '/img/leaf.png'
        }).appendTo(li);
    });
</script>