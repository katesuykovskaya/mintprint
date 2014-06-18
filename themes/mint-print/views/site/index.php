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
            <div id="priceWrap" class="relative">
                <span id="price"><?=$sum?></span><sup>грн.</sup>
            </div>
            <a class="print-button" href="<?=Yii::app()->createUrl('order/orderTemp/basket')?>">печатать их</a>
        </div>
        <div class="left all-photos-thumbs">
            <?php
            Yii::import('application.modules.order.models.OrderTemp');
            $attr = array(
                'session_id'=>Yii::app()->session->sessionID,
            );
            if(!Yii::app()->user->isGuest)
                $attr['user_id'] = Yii::app()->user->id;
            $model = OrderTemp::model()->resent()->findAllByAttributes($attr);

            $countIconWithPhoto =  count($model);

            if($countIconWithPhoto >= 9){
                $emptyIcon = 3;
            }else{
                $emptyIcon = 12 - $countIconWithPhoto;
            }
//            CVarDumper::dump($model, 5,true);
//            $start = time(true);

            ?>
            <?php foreach($model as $photo):
                $info = $photo->cropStyle;
                ?>
                <div class="photo-wrap full">
                    <a href="#" class="remove" data-id="<?=$photo['id']?>"></a>
                    <a href="<?=Yii::app()->createUrl('order/orderTemp/update', array('id'=>$photo['id']))?>" class="photo">
                            <?=CHtml::image($info['src'], null, array('data-original'=>$photo['img_url'], 'data-thumb'=>$photo['thumb_url'],'data-type'=>$photo['type'], 'style'=>$info['style']))?>
                    </a>
                </div>
            <?php endforeach;

//            echo time(true) - $start;
            for ($i = 1; $i <= $emptyIcon; $i++) {
                if($i == 1){?>
                    <div class="photo-wrap">
                        <div class="photo">
                            <img class="no-image" src="/img/insert-image.jpg" alt=""/>
                        </div>
                    </div>
                <?php }else{ ?>
                    <div class="photo-wrap">
                        <div class="photo">
                            <img class="no-image" src="/img/no-image.jpg" alt=""/>
                        </div>
                    </div>
                <?php }
            }

            ?>

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
