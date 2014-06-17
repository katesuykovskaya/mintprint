<?php
/* @var $this CapController */
/* @var $model Cap */
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Управление заглушкой'),$this->createUrl('/backend/cap/cap/admin',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Обновление заглушки')?></li>
    </ul>
</div>

<h3><?=Yii::t('backend','Обновление заглушки')?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'modelTranslate'=>$modelTranslate)); ?>