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

	<p class="note"><?=Yii::t('backend','Поля отмеченные <span class="required">*</span> обязательны.')?></p>

	<?php echo $form->errorSummary($model); ?>

	<div>
		<?php echo $form->labelEx($model,Yii::t('backend','Логин')); ?>
		<?php echo $form->textField($model,'login',['class'=>'input-xxlarge']); ?>
		<?php echo $form->error($model,'login'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,Yii::t('backend','E-mail')); ?>
		<?php echo $form->textField($model,'email',['class'=>'input-xxlarge']); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

    <div>
		<?php echo CHtml::label(Yii::t('backend','Роль'),'userRole'); ?>
		<?php echo CHtml::dropDownList(Yii::t('backend','userRole'),'userRole',$model->roles,['class'=>'input-xxlarge']); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('backend','Создать') : Yii::t('backend','Сохранить'),['class'=>'btn']); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
