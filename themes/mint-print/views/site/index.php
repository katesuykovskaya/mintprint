<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 28.05.14
 * Time: 15:00
 * @var $this SiteController
 */
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile('/js_plugins/tinyscrollbar.js');
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="/css/main.css"/>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <!--    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">-->
    <!--    <script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
    <!--    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>-->
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
                <a id="basket" class="basket" href="#"></a>
            </div>
        </div>
        <div class="header-bg"></div>
    </header>
    <section class="content inner-page overflow-hidden" id="content">
        <div class="left basket-cost">
            <p class="green-text">Распечатать ваши замечательные фотографии</p>
            <p class="white-text">будет стоить</p>
            <div id="price" class="relative">
                10<sup>грн.</sup>
            </div>
            <a class="print-button" href="#">печатать их</a>
        </div>
        <div class="left all-photos-thumbs">
            <div class="photo-wrap">
                <a href="#" class="remove"></a>
                <img src="/img/no-image.jpg" alt=""/>
            </div>
            <div class="photo-wrap"><img class="no-image" src="/img/insert-image.jpg" alt=""/></div>
            <div class="photo-wrap"><img class="no-image" src="/img/no-image.jpg" alt=""/></div>
            <div class="photo-wrap"><img class="no-image" src="/img/no-image.jpg" alt=""/></div>
            <div class="photo-wrap"><img class="no-image" src="/img/no-image.jpg" alt=""/></div>
            <div class="photo-wrap"><img class="no-image" src="/img/no-image.jpg" alt=""/></div>
            <div class="photo-wrap"><img class="no-image" src="/img/no-image.jpg" alt=""/></div>
            <div class="photo-wrap"><img class="no-image" src="/img/no-image.jpg" alt=""/></div>
            <div class="photo-wrap"><img class="no-image" src="/img/no-image.jpg" alt=""/></div>
            <div class="photo-wrap"><img class="no-image" src="/img/no-image.jpg" alt=""/></div>
            <div class="photo-wrap"><img class="no-image" src="/img/no-image.jpg" alt=""/></div>
            <div class="photo-wrap"><img class="no-image" src="/img/no-image.jpg" alt=""/></div>
        </div>
        <div class="left social-photo-widget">
            <h1>mint print</h1>
            <p class="white-text">печать фотографий из соцсетей</p>
            <div class="social-widget" id="socialWidget">
                <ul class="tabs-head">
                    <li><a class="ins" href="#tabs-1"><span>инстаграм</span></a></li>
                    <li><a class="fb" href="#tabs-2"><span>фейсбук</span></a></li>
                    <li><a class="vk" href="#tabs-3"><span>вконтакте</span></a></li>
                    <li><a class="upload" href="#tabs-4"><span>загрузить</span></a></li>
                </ul>
                <div class="tab" id="tabs-1">
                    <div class="scrollbar">
                        <div class="track">
                            <div class="thumb"></div>
                            <div class="end"></div>
                        </div>
                    </div>
                    <div class="viewport">
                        <div class="overview">
                            <a href="#"><img src="http://cs303601.vk.me/v303601610/44c7/_bhlOAKvc7g.jpg"></a>
                            <a href="#"><img src="http://cs416726.vk.me/v416726610/592/_U5Tnu5SsNA.jpg" alt=""/></a>
                            <a href="#"><img src="http://cs303601.vk.me/v303601610/44c7/_bhlOAKvc7g.jpg" alt=""/></a>
                            <a href="#"><img src="http://cs303601.vk.me/v303601610/44c7/_bhlOAKvc7g.jpg" alt=""/></a>
                            <a href="#"><img src="http://cs303601.vk.me/v303601610/44c7/_bhlOAKvc7g.jpg" alt=""/></a>
                            <a href="#"><img src="http://cs303601.vk.me/v303601610/44c7/_bhlOAKvc7g.jpg" alt=""/></a>
                            <a href="#"><img src="http://cs303601.vk.me/v303601610/44c7/_bhlOAKvc7g.jpg" alt=""/></a>
                            <a href="#"><img src="http://cs303601.vk.me/v303601610/44c7/_bhlOAKvc7g.jpg" alt=""/></a>
                            <a href="#"><img src="http://cs303601.vk.me/v303601610/44c7/_bhlOAKvc7g.jpg" alt=""/></a>
                            <a href="#"><img src="http://cs303601.vk.me/v303601610/44c7/_bhlOAKvc7g.jpg" alt=""/></a>
                            <a href="#"><img src="http://cs416726.vk.me/v416726610/592/_U5Tnu5SsNA.jpg" alt=""/></a>
                            <a href="#"><img src="http://cs416726.vk.me/v416726610/592/_U5Tnu5SsNA.jpg" alt=""/></a>
                            <a href="#"><img src="http://cs416726.vk.me/v416726610/592/_U5Tnu5SsNA.jpg" alt=""/></a>
                            <a href="#"><img src="http://cs416726.vk.me/v416726610/592/_U5Tnu5SsNA.jpg" alt=""/></a>
                        </div>
                    </div>
                </div>
                <div class="tab" id="tabs-2">dfsdfsf</div>
                <div class="tab" id="tabs-3">dfd5454353434sfsdf</div>
                <div class="tab" id="tabs-4">aaaaaaaaa</div>
            </div>
        </div>
    </section>
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
<script>
    $(document).ready(function(){
        var menu = $('header menu ul').eq(0);
        var index = Math.floor(menu.children().length / 2) - 1;
        var li = $('<li></li>', {'class': 'middle-leaf'}).insertAfter(menu.children('li').eq(index));
        $('<img>', {
            src: '/img/leaf.png'
        }).appendTo(li);

        $('#socialWidget').tabs();

        $('#tabs-1').tinyscrollbar();
    });
</script>
</body>
</html>