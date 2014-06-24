<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 29.05.14
 * Time: 14:15
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="/css/main.css"/>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
</head>
<body style="background: #382b22 url('/img/bg-main-page.jpg') top center;font-family: PoiretOne;text-transform: uppercase;background-repeat: no-repeat;background-position-y: 18px;">

    <?=$content?>

<footer>
    <div class="footer-text-wrap">
        <div class="footer-top-bg"></div>
        <div class="footer-text">
            <h2><?=Yii::t('frontend','печать всего за 1 гривну')?></h2>
            <div>
                <p>а воспоминания - бесценны, сохраните их нстоящими.</p>
                <p>бумажными фотографиями, которые можно дать в руки, подарить, и положить под подушку</p>
            </div>
        </div>

        <div class="footer-bottom-bg"></div>
    </div>
    <div class="img-main-page"></div>
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