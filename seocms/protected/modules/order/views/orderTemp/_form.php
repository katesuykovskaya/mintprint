<?php
/* @var $this OrderTempController */
/* @var $model OrderTemp */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-temp-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'session_id'); ?>
		<?php echo $form->textField($model,'session_id'); ?>
		<?php echo $form->error($model,'session_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'img_url'); ?>
		<?php echo $form->textField($model,'img_url',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($model,'img_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'thumb_url'); ?>
		<?php echo $form->textField($model,'thumb_url',array('size'=>60,'maxlength'=>512)); ?>
		<?php echo $form->error($model,'thumb_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'img_count'); ?>
		<?php echo $form->textField($model,'img_count'); ?>
		<?php echo $form->error($model,'img_count'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'img_width'); ?>
		<?php echo $form->textField($model,'img_width'); ?>
		<?php echo $form->error($model,'img_width'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'img_height'); ?>
		<?php echo $form->textField($model,'img_height'); ?>
		<?php echo $form->error($model,'img_height'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'img_x'); ?>
		<?php echo $form->textField($model,'img_x'); ?>
		<?php echo $form->error($model,'img_x'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'img_y'); ?>
		<?php echo $form->textField($model,'img_y'); ?>
		<?php echo $form->error($model,'img_y'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->