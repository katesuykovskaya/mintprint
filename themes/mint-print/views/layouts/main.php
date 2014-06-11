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
<body>
    <div class="header-and-content-wrap">
        <header>
            <div class="header-wrap">
                <menu>
                    <ul>
                        <li><a href="#">оплата и доставка</a></li>
                        <li><a href="#">новости</a></li>
                        <li><a href="#">главная</a></li>
                        <li><a href="#">о нас</a></li>
                    </ul>
                </menu>
                <div class="right-buttons">
                    <a id="profile" class="profile" href="#"></a>
                    <a id="basket" class="basket" href="<?=Yii::app()->createUrl('order/orderTemp/basket')?>"></a>
                </div>
            </div>
            <div class="header-bg"></div>
        </header>
        <?=$content?>
    </div>
    <footer>
        <div class="footer-text-wrap">
            <div class="footer-top-bg"></div>
            <div class="footer-text">
                <h2>печать всего за 1 гривну</h2>
                <div>
                    <p>а воспоминания - бесценны, сохраните их нстоящими.</p>
                    <p>бумажными фотографиями, которые можно дать в руки, подарить, и положить под подушку</p>
                </div>
            </div>

            <div class="footer-bottom-bg"></div>
        </div>
        <div class="footer-menu">
            <div class="footer-menu-wrap">
                <menu>
                    <ul>
                        <li><a href="#">вопросы</a></li>
                        <li><a href="#">оферта</a></li>
                        <li><a href="#">политика конфиденциальности</a></li>
                        <li><a href="#">блог</a></li>
                    </ul>
                </menu>
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