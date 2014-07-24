<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 03.07.14
 * Time: 18:08
 */
$this->pageTitle = 'Новости';
//$cs = Yii::app()->clientScript;
//$cs->registerMetaTag($model['t_mdescription'], 'description');
//$cs->registerMetaTag($model['t_mkeywords'], 'keywords');
?>
<div class="fake-news-head">
    <h1><?=Yii::t('frontend', 'Новости')?></h1>
    <p><?=Yii::t('frontend', 'Печать ваших замечательних фотографий')?></p>
</div>
<?php
$l = Yii::app()->language;
foreach($news as $item): ?>
    <div class="news-wrap">
        <a href="<?=Yii::app()->createUrl('site/news', array('translit'=>$item->translation[$l]->t_url))?>">
            <?php if(isset($images[$item->id])):
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
        <?php endif; ?>
        </a>
        <div class="news-body">
            <time><?= Yii::app()->dateFormatter->format('dd.MM.yyyy', $item->translation[$l]->t_createdate)?></time>
            <h2>
                <a href="<?=Yii::app()->createUrl('site/news', array('translit'=>$item->translation[$l]->t_url))?>">
                    <?=$item->translation[$l]->t_title?>
                </a>
            </h2>
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