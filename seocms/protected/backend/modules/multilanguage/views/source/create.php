<?php
/* @var $this SourceController */
/* @var $model SourceMessage */
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Мультиязычность. Словарь.'),$this->createUrl('backend/multilanguage/source/admin',array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Новая Фраза')?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend','Новая Фраза')?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>