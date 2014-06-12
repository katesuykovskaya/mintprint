<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 12.06.14
 * Time: 10:49
 */
?>
<section class="content buyer-info-form">
    <h1><?=Yii::t('frontend', 'Оплатите')?></h1>
    <p><?=Yii::t('frontend', 'Печать ваших замечательних фотографий')?></p>
    <div class="overflow-hidden forms-start">
        <div class="tree-forms left">
            <div class="overflow-hidden">
                <div class="left enter-wrap">
                    <h2><?=Yii::t('frontend', 'уже зарегистрированы?')?></h2>
                    <a href="#" class="continue-button"><?=Yii::t('frontend', 'Войти')?></a>
                </div>
                <div class="left create-profile-wrap">
                    <h2><?=Yii::t('frontend', 'создать новый профиль')?></h2>
<!--                    <label>--><?//=Yii::t('frontend', 'Электронная почта')?><!--</label>-->
<!--                    <label>--><?//=Yii::t('frontend', 'Пароль')?><!--</label>-->
<!--                    <label>--><?//=Yii::t('frontend', 'Еще раз пароль')?><!--</label>-->
                    <?php
                    $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'create-profile-form',
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
                        <?php echo CHtml::submitButton('Продолжить', array('class'=>'')); ?>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
            </div>

        </div>
        <div class="left total-basket-info">
            <h2><?=Yii::t('frontend', 'вы и ваш адрес')?></h2>
        </div>
    </div>

</section>