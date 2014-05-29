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