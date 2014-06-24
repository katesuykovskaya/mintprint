<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Настройка цены за одну фотографию')?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend','Настройка цены за одну фотографию')?></h3>

<?php
$arr = include $file;

$form=$this->beginWidget('CActiveForm', array(
    'id'=>'priceForm',
    'enableAjaxValidation'=>false,
)); ?>

<div>
<?php echo $form->labelEx($model,Yii::t('backend','Цена')); ?>
<?php echo $form->textField($model,'price',['class'=>'input-xxlarge']); ?>
<?php echo $form->error($model,'price'); ?>
</div>

<div>
<?php echo $form->labelEx($model,Yii::t('backend','Валюта')); ?>
<?php echo $form->textField($model,'currency',['class'=>'input-xxlarge']); ?>
<?php echo $form->error($model,'currency'); ?>
</div>

<?php
echo CHtml::submitButton(Yii::t('backend','Изменить'), array('class'=>'btn'));

echo '<hr />';

$this->endWidget();
?>
