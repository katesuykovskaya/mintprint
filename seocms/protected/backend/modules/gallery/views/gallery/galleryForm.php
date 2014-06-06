<?php
/* @var $this GalleryController */
/* @var $model Gallery */
/* @var $translation GalleryTranslate */
/* @var $form CActiveForm */
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Управление галереями'),$this->createUrl('/backend/gallery/gallery/index',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Создание галереи')?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend','Создание галереи')?></h3>
<div>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'gallery-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?=Yii::t('backend','Поля отмеченные <span class="required">*</span> обязательны.')?></p>

	<?php echo $form->errorSummary($model); ?>

	<div>
		<?php echo $form->labelEx($model,Yii::t('backend','Тип')); ?>
        <?=ZHtml::enumDropDownList($model,'type',['class'=>'input-xxlarge','selected'=>'gallery','disabled'=>true])?>
        <?=CHtml::activeHiddenField($model,'type',['value'=>'gallery'])?>
		<?php echo $form->error($model,'type'); ?>
	</div>

    <?php foreach(Yii::app()->params['languages'] as $key=>$language) :?>
        <p><?=CHtml::label(Yii::t('backend','Название галереи ( '.$language['lang'].' )'),'GalleryTranslate_t_title_'.$key)?></p>
        <p><?=CHtml::textField('GalleryTranslate[t_title]['.$key.']','',['class'=>'input-xxlarge'])?></p>
        <?=CHtml::hiddenField('GalleryTranslate[t_fileType]['.$key.']','none')?>
    <?php endforeach ?>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('backend','Сохранить') : Yii::t('backend','Создать'),['class'=>'btn']); ?>
	</div>

<?php $this->endWidget();?>

</div><!-- form -->