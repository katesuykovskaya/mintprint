<?php
/* @var $this NewsController */
/* @var $model News */
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Все новости'),$this->createUrl('/backend/news/news/admin',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Создание новости')?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend','Создание новости')?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model,'newsTranslate'=>$newsTranslate)); ?>