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
            <?php
            Yii::import('application.modules.order.models.OrderTemp');
            $attr = array(
                'session_id'=>Yii::app()->session->sessionID,
            );
            if(!Yii::app()->user->isGuest)
                $attr['user_id'] = Yii::app()->user_id;
            $model = OrderTemp::model()->findAllByAttributes($attr);
//            CVarDumper::dump($model, 5,true);
//            $start = time(true);
            ?>
            <?php foreach($model as $photo):
                if($photo['original_width']){
                    $width = 97 / $photo['img_width'] * 100;
                    $width = $photo['original_width'] * $width / 100;

                    $marginTop = $photo['img_y'] / $photo['original_width'] * 100;
                    $marginTop = $width * $marginTop / 100;

                    $marginLeft = $photo['img_x'] / $photo['original_width'] * 100;
                    $marginLeft = $width * $marginLeft / 100;

                    $style = 'width:'.$width.'px;margin-top: -'.$marginTop.'px;margin-left:-'.$marginLeft.'px;';
                    $src = $photo['img_url'];
                }
                else{
                    if($photo['thumb_width'] == $photo['thumb_height'])
                    {
                        $style = 'width: 97px;height: 97px;';
                    }
                    else if($photo['thumb_width'] > $photo['thumb_height'])
                    {
                        $marginLeft = round(($photo['thumb_width'] - 97) / 2);
                        $style = 'height: 97px;margin-left: -'.$marginLeft.'px;';
                    }
                    else if($photo['thumb_width'] < $photo['thumb_height'])
                    {
                        $marginTop = round(($photo['thumb_height'] - 97) / 2);
                        $style = 'width: 97px;margin-top: -'.$marginTop.'px;';
                    }
                    $src = $photo['thumb_url'];
                }

                ?>
                <div class="photo-wrap full">
                    <a href="#" class="remove" data-id="<?=$photo['id']?>"></a>
                    <a href="<?=Yii::app()->createUrl('order/orderTemp/update', array('id'=>$photo['id']))?>" class="photo")">
                            <?=CHtml::image($src, null, array('data-original'=>$photo['img_url'], 'data-thumb'=>$photo['thumb_url'],'data-type'=>$photo['type'], 'style'=>$style))?>
                    </a>
                </div>
            <?php endforeach;
//            echo time(true) - $start;
            ?>

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
