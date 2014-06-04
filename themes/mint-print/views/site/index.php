<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 28.05.14
 * Time: 15:00
 * @var $this SiteController
 */
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
            <?php
            Yii::import('application.modules.order.models.OrderTemp');
            $attr = array(
                'session_id'=>Yii::app()->session->sessionID,
            );
            if(!Yii::app()->user->isGuest)
                $attr['user_id'] = Yii::app()->user_id;
            $model = OrderTemp::model()->findAllByAttributes($attr);

            ?>
            <?php foreach($model as $photo):?>
                <div class="photo-wrap full">
                    <a href="#" class="remove"></a>
                    <div class="photo">
                        <?=CHtml::image($photo['thumb_url'])?>
                    </div>
                </div>
            <?php endforeach?>

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
        </div>
    </section>
<div style="background: white">
<!--    --><?//=CVarDumper::dump(Yii::app()->user->isGuest, 7, true)?>
</div>
<script>
    $(document).ready(function(){





        $(".my-viewport").on('click', '.image-wrap',  function(){

            var img = $(this).find('img').clone();
            SendAjax(img);
            var newImg = createPhoto(img);

            $('.all-photos-thumbs').prepend(newImg);

            if($(".all-photos-thumbs > div:not(div.full)").length > 3)
            {
                $(".all-photos-thumbs > .photo-wrap:last").remove();
            }
        });

        $(".all-photos-thumbs").on('click', 'a.remove',  function(){
            $(this).parent().remove();
        });

        function SendAjax(img) {
            $.ajax({
                url: '/order/orderTemp/create',
                type: 'post',
                data: {
                    'OrderTemp[img_url]': img.data('original'),
                    'OrderTemp[thumb_url]': img.attr('src')
                },
                success: function(response) {
                    try {
                        var result = $.parseJSON(response);
                        if(!result.res) {
                            if(typeof result.reason != 'undefined')
                                alert(result.reason);
                            else
                                alert('Не прошло сохранение');
                        }
                    } catch(e) {
                        alert('some error: watch site/index');
                    }
                }
            });
        }

        function createPhoto(img)
        {
            var size = JSON.parse(getImgSize(img[0].src));

            if(size.width == size.height)
            {
                var param = {'width': 97, 'height':97, 'handler': 'same'};
            }
            else if(size.width > size.height)
            {
                var marginLeft = Math.round((size.width - 97) / 2);
                var param = {'height': 97, 'marginLeft': marginLeft, 'handler': 'width'};
            }
            else if(size.width < size.height)
            {
                var marginTop = Math.round((size.height - 97) / 2);
                var param = {'width': 97, 'marginTop': marginTop, 'handler': 'height'};
            }
            var changeImg = img[0];
            switch (param.handler) {
                case 'same':
                    $(changeImg).attr({'width': '97', 'height': '97'});
                    break
                case 'width':
                    $(changeImg).attr({'height': '97'});
                    $(changeImg).css("margin-left","-"+param.marginLeft+"px");
                    break
                case 'height':
                    $(changeImg).attr({'width': '97'});
                    $(changeImg).css("margin-top","-"+param.marginTop+"px");
                    break
            }


            var newImg =  document.createElement('div');
            newImg.setAttribute('class', 'photo-wrap full');
            newImg.innerHTML = '<a href="#" class="remove"></a><div class="photo"></div>';
            $(newImg).find('.photo').append(changeImg);

            return newImg;
        }

        function getImgSize(imgSrc){
            var newImg = new Image();
            newImg.src = imgSrc;
            var height = newImg.height;
            var width = newImg.width;
            p = $(newImg).ready(function(){
                return {width: newImg.width, height: newImg.height};
            });

             return '{"width":'+p[0]['width']+',"height":'+p[0]['height']+'}';
        }


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