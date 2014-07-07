<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 03.07.14
 * Time: 18:08
 */
$this->layout = '//layouts/no-bg';
?>
<div class="head-page">MINT PRINT</div>
<div class="wrapper-page">
    <div class="left-page">
        <div class="content-page">
            <div class="fake-news-head">
                <h1><?=Yii::t('frontend', 'Новости')?></h1>
                <p><?=Yii::t('frontend', 'Печать ваших замечательних фотографий')?></p>
            </div>
            <?php
            $l = Yii::app()->language;
            foreach($news as $item): ?>
                <div class="news-wrap">
                    <a href="<?=Yii::app()->createUrl('site/news', array('translit'=>$item->translation[$l]->t_url))?>">
                        <?php
                        $path = Yii::getPathOfAlias('webroot').'/uploads/News/'.$item->id.'/'.$images[$item->id];
                        $img = Yii::app()->easyImage->thumbOf($path, array(
                            'resize'=>array(
                                'width'=>135,
                                'height'=>90,
                                'master'=>EasyImage::RESIZE_WIDTH
                            ),
                            'savePath'=>'/uploads/News/'.$item->id.'/'
                        ));
                        ?>
                        <?=$img?>
                    </a>
                    <div class="news-body">
                        <time><?= Yii::app()->dateFormatter->format('dd.MM.yyyy', $item->translation[$l]->t_createdate)?></time>
                        <a href="<?=Yii::app()->createUrl('site/news', array('translit'=>$item->translation[$l]->t_url))?>">
                            <h2><?=$item->translation[$l]->t_title?></h2>
                        </a>
                        <div class="short"><?=$item->translation[$l]->t_shorttext?></div>
                        <a class="read-more" href="<?=Yii::app()->createUrl('site/news', array('translit'=>$item->translation[$l]->t_url))?>">ЧИТАТЬ ДАЛЕЕ</a>
                    </div>
                </div>
            <?php endforeach;
            $this->widget('CLinkPager', array(
            'pages' => $pager,
                'header'=>false,
                'cssFile'=>false,
                'htmlOptions'=>array('class'=>'news-pager'),
                'firstPageLabel'=>'',
                'lastPageLabel'=>'',
//                'nextPageLabel'=>'&#8594;',
//                'prevPageLabel'=>'&#8592;',
                'nextPageLabel'=>'',
                'prevPageLabel'=>'',
                'maxButtonCount'=>5,
            ))?>
        </div>
    </div>
    <div class="right-page">
        <div class="right-block-info">
            <div class="head-block-info">РЕШАЙТЕ СОХРАНИТЬ СВОИ ЛУЧШИЕ ВОСПОМИНАНИЯ</div>
            <div class="price-photo">Цена фотографии всего</div>
            <div id="priceWrap" class="relative">
                <span id="price"><?=$conf['price']?></span><sup><?=$conf['currency']?></sup>
            </div>
            <div class="desc-photo">А воспоминания - бесценны. жмите на кнопку и посмотрите, как моменты вашей жизненной истории смотрятся в полароидных рамочках</div>
            <a href="<?=Yii::app()->createUrl('site/index')?>" class="back-button margin-top-10">СМОТРЕТЬ МОИ ФОТО</a>
        </div>

    </div>
</div>