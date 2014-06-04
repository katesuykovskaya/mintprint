<?php
/* @var $this OrderTempController */
/* @var $model OrderTemp */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'session_id'); ?>
		<?php echo $form->textField($model,'session_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'img_url'); ?>
		<?php echo $form->textField($model,'img_url',array('size'=>60,'maxlength'=>512)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'thumb_url'); ?>
		<?php echo $form->textField($model,'thumb_url',array('size'=>60,'maxlength'=>512)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'img_count'); ?>
		<?php echo $form->textField($model,'img_count'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'img_width'); ?>
		<?php echo $form->textField($model,'img_width'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'img_height'); ?>
		<?php echo $form->textField($model,'img_height'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'img_x'); ?>
		<?php echo $form->textField($model,'img_x'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'img_y'); ?>
		<?php echo $form->textField($model,'img_y'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->