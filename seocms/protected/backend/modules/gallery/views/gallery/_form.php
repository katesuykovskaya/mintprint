<?php
/* @var $this GalleryController */
/* @var $model Gallery */
/* @var $translation GalleryTranslate */
/* @var $form CActiveForm */
?>

<div>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'entity-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div>
		<?php echo $form->labelEx($model,'type'); ?>
<!--		--><?php //echo $form->textField($model,'type',array('size'=>8,'maxlength'=>8)); ?>
        <?=ZHtml::enumDropDownList($model,'type',['class'=>'input-xxlarge'])?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('backend','Сохранить') : Yii::t('backend','Создать'),['class'=>'btn']); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->