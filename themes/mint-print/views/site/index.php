<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 28.05.14
 * Time: 15:00
 * @var $this SiteController
 */
Yii::app()->clientScript->registerScriptFile('/js_plugins/tinyscrollbar.js');
Yii::app()->clientScript->registerScriptFile('/js/draggablePhotos.js');
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
                <div class="photo">
                    <img class="no-image" src="/img/insert-image.jpg" alt=""/>
                </div>
            </div>
            <div class="photo-wrap">
                <div class="photo">
                <img class="no-image" src="/img/no-image.jpg" alt=""/>
                </div>
            </div>
            <div class="photo-wrap">
                <div class="photo">
                    <img class="no-image" src="/img/no-image.jpg" alt=""/>
                </div>
            </div>
            <div class="photo-wrap">
                <div class="photo">
                    <img class="no-image" src="/img/no-image.jpg" alt=""/>
                </div>
            </div>
            <div class="photo-wrap">
                <div class="photo">
                    <img class="no-image" src="/img/no-image.jpg" alt=""/>
                </div>
            </div>
            <div class="photo-wrap">
                <div class="photo">
                    <img class="no-image" src="/img/no-image.jpg" alt=""/>
                </div>
            </div>

            <div class="photo-wrap">
                <div class="photo">
                    <img class="no-image" src="/img/no-image.jpg" alt=""/>
                </div>
            </div>

            <div class="photo-wrap">
                <div class="photo">
                    <img class="no-image" src="/img/no-image.jpg" alt=""/>
                </div>
            </div>

            <div class="photo-wrap">
                <div class="photo">
                    <img class="no-image" src="/img/no-image.jpg" alt=""/>
                </div>
            </div>
            <div class="photo-wrap">
                <div class="photo">
                    <img class="no-image" src="/img/no-image.jpg" alt=""/>
                </div>
            </div>

        </div>
        <div class="left social-photo-widget">
            <h1>mint print</h1>
            <p class="white-text">печать фотографий из соцсетей</p>
            <?php
            $this->widget('application.modules.social.widgets.SocialPhotoWidget', array(
                'url'=>'/social/default/photosFromAlbum',
                'config'=>Yii::app()->getModule('social')->config,
                'socials'=>array(
                    'instagram',
                    'fb',
                    'vk',
                    'upload'
                )
            ))?>
            <div class="addAllPhoto" >
                ALL<span>добавить все</span>
            </div>
        </div>

    </section>
<script>

    $(document).ready(function(){
        //menu
        var menu = $('header menu ul').eq(0);
        var index = Math.floor(menu.children().length / 2) - 1;
        var li = $('<li></li>', {'class': 'middle-leaf'}).insertAfter(menu.children('li').eq(index));
        $('<img>', {
            src: '/img/leaf.png'
        }).appendTo(li);

//        $('#socialWidget').tabs();

//        $('#tabs-1').tinyscrollbar();
    });
</script>