<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 07.07.14
 * Time: 18:02
 * @var $model array
 * @var $this SiteController
 */
$this->pageTitle = !empty($model['t_mtitle']) ? $model['t_mtitle'] : $model['t_title'];
$cs = Yii::app()->clientScript;
$cs->registerMetaTag($model['t_mdescription'], 'description');
$cs->registerMetaTag($model['t_mkeywords'], 'keywords');
$cs->registerScriptFile('/js_plugins/carouFredSel/jquery.carouFredSel-6.2.1-packed.js');
?>
<style>

</style>
<div class="fake-news-head">
    <a href="<?=Yii::app()->urlManager->createUrl('site/allNews')?>"><?=Yii::t('frontend', 'Новости')?></a>
    <p><?=Yii::t('frontend', 'Печать ваших замечательних фотографий')?></p>
</div>
<div class="single-news-wrap">
    <time><?=Yii::app()->dateFormatter->format('dd.MM // yyyy', $model['t_createdate'])?></time>
    <h1><?=$model['t_title']?></h1>
    <div class="single-news-content">
        <?=$model['t_fulltext']?>
    </div>
    <div id="carousel-wrapper">
        <div id="carousel">
            <?php foreach($attaches as $key=>$a):
                $path = Yii::getPathOfAlias('webroot').'/uploads/News/'.$model['t_id'].'/'.$a['path'];
                $img = Yii::app()->easyImage->thumbSrcOf($path, array(
                    'resize'=>array(
                        'width'=>550,
                        'height'=>415
                    ),
                    'savePath'=>'/uploads/News/'.$model['t_id'].'/thumbnail/'
                ))
                ?>
                <div class="slide">
                    <img id="photo<?=$key?>" src="<?=$img?>"/>
                </div>

            <?php endforeach?>
        </div>
    </div>
    <div id="thumbs-wrapper">
        <a class="pag" href="#" id="prev"><</a>
        <div class="thumbs">
            <div id="thumbs">
                <?php foreach($attaches as $key=>$a):
                    $imgPath = '/uploads/News/'.$model['t_id'].'/'.$a['path'];
                    $thumbPath = '/uploads/News/'.$model['t_id'].'/small/'.$a['path'];
                    if(!file_exists(Yii::getPathOfAlias('webroot').$thumbPath)) {
                        $thumb = new EasyImage($imgPath);
                        $thumb->resize(200, 150, EasyImage::RESIZE_AUTO);
                        $thumb->save(Yii::getPathOfAlias('webroot').$thumbPath);
                    }
                    ?>
                    <a href="photo<?=$key?>">
                        <img src="<?=$thumbPath?>"/>
                    </a>
                <?php endforeach?>
            </div>
        </div>

        <a class="pag" href="#" id="next">></a>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#carousel').carouFredSel({
            auto: false,
            items: {
                visible: 1,
            },
            scroll: {
                fx: 'crossfade'
            }
        });

        $('#thumbs').carouFredSel({
            infinite: true,
            responsive: true,
            circular: true,
            auto: false,
            prev: '#prev',
            next: '#next',
            items: {
                visible:4,
                width: 520,
                height: 120
            }
        });

        $('#thumbs a').click(function(e) {
            e.preventDefault();
            $('#carousel').trigger('slideTo', $('#' + $(this).attr('href')).parent() );
            $('#thumbs a').removeClass('selected');
            $(this).addClass('selected');
            return false;
        });
    });
</script>