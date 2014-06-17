<h3 class="page-header"> Confirmation </h3>

<?php
$form=$this->beginWidget('CActiveForm', array(
    'id'=>'confirm-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php echo $form->errorSummary($model); ?>

    <div>
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username',array('value'=>$data->login)); ?>
    </div>

    <div>
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password'); ?>
    </div>

    <div>
        <?php echo $form->labelEx($model,'password2'); ?>
        <?php echo $form->passwordField($model,'password2'); ?>
    </div>

        <?php echo CHtml::hiddenField('ConfirmForm[userid]',$data->user_id);?>

    <div class="buttons">
        <?php echo CHtml::submitButton('Применить'); ?>
    </div>

<?php $this->endWidget(); ?>


