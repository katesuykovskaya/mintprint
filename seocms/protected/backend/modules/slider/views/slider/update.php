<?php
/* @var $this SliderController */
/* @var $model Slider */
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Управление слайдером'),$this->createUrl('/backend/slider/slider/admin',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Редактирование данных')?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend','Редактирование данных')?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'modelTranslate'=>$modelTranslate)); ?>