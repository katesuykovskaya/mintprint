<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 12.06.14
 * Time: 12:28
 */
?>
<h2><?=Yii::t('frontend', 'создать новый профиль')?></h2>
<?php
$form=$this->beginWidget('CActiveForm', array(
    'id'=>'create-profile-form',
    'action'=>Yii::app()->createUrl('users/users/createAccount'),
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>
<?php echo $form->errorSummary($createAccountModel); ?>

<div>
    <?php echo $form->labelEx($createAccountModel,'email'); ?>
    <?php echo $form->textField($createAccountModel,'email', array(
        'placeholder'=>'почта@mail.ru'
    )); ?>
</div>

<div>
    <?php echo $form->labelEx($createAccountModel,'password'); ?>
    <?php echo $form->passwordField($createAccountModel,'password', array(
        'placeholder'=>'******'
    )); ?>
</div>

<div>
    <?php echo $form->labelEx($createAccountModel,'password2'); ?>
    <?php echo $form->passwordField($createAccountModel,'password2', array(
        'placeholder'=>'******'
    )); ?>
</div>

<div class="buttons">
    <?php echo CHtml::submitButton('Продолжить', array('class'=>'back-button')); ?>
</div>

<?php $this->endWidget(); ?>