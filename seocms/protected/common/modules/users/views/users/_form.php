<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div>
		<?php echo $form->labelEx($model,Yii::t('backend','login')); ?>
		<?php echo $form->textField($model,'login',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'login'); ?>
	</div>

<!--	<div class="row">-->
		<?php //echo $form->labelEx($model,'pass'); ?>
		<?php //echo $form->passwordField($model,'pass',array('size'=>60,'maxlength'=>255)); ?>
		<?php //echo $form->error($model,'pass'); ?>
<!--	</div>-->

	<div>
		<?php echo $form->labelEx($model,Yii::t('backend','email')); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

    <div>
		<?php echo CHtml::label(Yii::t('backend','userRole'),'userRole'); ?>
		<?php echo CHtml::dropDownList(Yii::t('backend','userRole'),'userRole',$model->roles); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('backend','Create') : Yii::t('backend','Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
