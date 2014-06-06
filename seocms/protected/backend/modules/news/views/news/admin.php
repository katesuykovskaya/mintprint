<?php
/* @var $this NewsController */
/* @var $model News */
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Администрирование новостей')?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend','Администрирование новостей')?></h3>

<?=CHtml::link(Yii::t('backend','Написать новость'),$this->createUrl('/backend/news/news/create',['language'=>Yii::app()->language]),['class'=>'btn'])?>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id'=>'news-grid',
    'type'=>'striped bordered',
    'dataProvider'=>$model->search(),
    // -- аякс урл должен быть указан и указан правильно, чтобы после возврата пустого значения в поиске
    // -- не приходилось перезапускать грид обновлением страницы (возвращается undefined и грид вешается, при правильном аяксурл этого не происходит)
    'ajaxUrl'=>'admin',
    //--
    'fixedHeader' => true,
    'filter'=>$model,
    'enableHistory'=>true,
    'columns'=>array(
        array(
            'name'=>Yii::t('backend','Изображение'),
            'type'=>'html',
            'value'=>'!empty($data->img) ? Yii::app()->easyImage->thumbOf(Yii::getPathOfAlias("webroot")."/uploads/News/".$data->id."/".$data->img,
                array(
                    "resize" => array("width"=>100,"master"=>EasyImage::RESIZE_WIDTH),
                    "savePath"=>"/uploads/News/".$data->id."/",
                    "quality" => 80,
                )) : ""',
            'filter'=>''
        ),
        [
            'header'=>Yii::t('backend','Язык'),
            'name'=>'translation.t_language',
            'value'=>'Yii::t("backend",$data->translation[Yii::app()->language]["t_language"])',
        ],
        [
            'header'=>Yii::t('backend','Заголовок'),
            'name'=>'news.t_title',
            'value'=>'$data->translation[Yii::app()->language]["t_title"]'
        ],
        [
            'header'=>Yii::t('backend','Краткий текст'),
            'name'=>'news.t_shorttext',
            'value'=>'$data->translation[Yii::app()->language]["t_shorttext"]',
        ],
        [
            'header'=>Yii::t('backend','Категория'),
            'name'=>'category',
            'value'=>'Yii::t("backend",$data->category)',
            'filter'=>['allNews'=>'Новости футбола','clubNews'=>'Новости клуба'],
        ],
        [
            'header'=>Yii::t('backend','Статус'),
            'name'=>'t_status',
            'value'=>'Yii::t("backend",$data->translation[Yii::app()->language]["t_status"])',
            'filter'=>['published'=>'Публикация','draft'=>'Черновик','archive'=>'Архив'],
        ],
        [
            'class'=>'CButtonColumn',
            'template'=>'{view}{update}{delete}',
            'buttons'=>[
                'view'=>[
                    'url'=>'Yii::app()->request->hostInfo."/".Yii::app()->language."/newspreview/".$data->translation[Yii::app()->language]["t_url"].".html"',
                    'options'=>['target'=>'_blank']
                ],
            ],
            'updateButtonUrl'=>'Yii::app()->urlManager->createUrl("/backend/news/news/update",array("id"=>$data->id,"language"=>Yii::app()->language))',
            'deleteButtonUrl'=>'Yii::app()->urlManager->createUrl("/backend/news/news/delete",array("id"=>$data->id,"language"=>Yii::app()->language))',
        ],
    )));