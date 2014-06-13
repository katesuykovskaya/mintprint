<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 12.06.14
 * Time: 12:48
 * @var $orderFormModel OrderForm
 */
$form=$this->beginWidget('CActiveForm', array(
    'id'=>'order-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>
<?php echo $form->errorSummary($orderFormModel); ?>
<div class="overflow-hidden">
    <div class="left block-wrap">
        <?php echo $form->labelEx($orderFormModel,'name'); ?>
        <?php echo $form->textField($orderFormModel,'name', array(
            'class'=>'name'
        )); ?>
    </div>
    <div class="right block-wrap">
        <?php echo $form->labelEx($orderFormModel, 'phone'); ?>
        <?php echo $form->textField($orderFormModel, 'phone', array(
            'class'=>'phone'
        )); ?>
    </div>
</div>
<div>
    <?php echo $form->labelEx($orderFormModel, 'email'); ?>
    <?php echo $form->textField($orderFormModel, 'email'); ?>
</div>
<?php echo CHtml::label(CHtml::radioButton('OrderForm[delivery]', true, array(
    'value' => 'newPost',
    'id'=>'newPost',
    'uncheckValue'=>null
)).' Выбрать ближайшее отделение Новой Почты', null);?>
<div id="newPostData">
    <div>
        <?php echo $form->labelEx($orderFormModel, 'address'); ?>
        <?php echo $form->textField($orderFormModel, 'address'); ?>
    </div>
    <div class="overflow-hidden">
        <div class="left block-wrap">
            <?php echo $form->labelEx($orderFormModel, 'city'); ?>
            <?php echo $form->textField($orderFormModel, 'city'); ?>
        </div>
        <div class="right block-wrap">
            <?php echo $form->labelEx($orderFormModel, 'region'); ?>
            <?php echo $form->textField($orderFormModel, 'region'); ?>
        </div>
        <div>
            <?php echo $form->labelEx($orderFormModel, 'newPostAddress'); ?>
            <?php echo $form->textField($orderFormModel, 'newPostAddress'); ?>
        </div>
    </div>
</div>
<?php echo CHtml::label(CHtml::radioButton('OrderForm[delivery]', false, array(
    'value' => 'post',
    'id'=>'post',
    'uncheckValue'=>null
)).' Хочу получить на почтовое отделение', null);?>
<div id="postData">
    <div>
        <?php echo $form->labelEx($orderFormModel, 'address'); ?>
        <?php echo $form->textField($orderFormModel, 'address', array('disabled'=>true)); ?>
    </div>
    <div class="overflow-hidden">
        <div class="left block-wrap">
            <?php echo $form->labelEx($orderFormModel, 'city'); ?>
            <?php echo $form->textField($orderFormModel, 'city', array('disabled'=>true)); ?>
        </div>
        <div class="right block-wrap">
            <div class="overflow-hidden">
                <div class="left middle-block-wrap">
                    <?php echo $form->labelEx($orderFormModel, 'region'); ?>
                    <?php echo $form->textField($orderFormModel, 'region', array('disabled'=>true)); ?>
                </div>
                <div class="right small-block-wrap">
                    <?php echo $form->labelEx($orderFormModel, 'index'); ?>
                    <?php echo $form->textField($orderFormModel, 'index', array('disabled'=>true)); ?>
                </div>
            </div>
        </div>
    </div>
    <div>
        <?=CHtml::label($form->checkBox($orderFormModel, 'agree', array(
            'value'=>1,
            'uncheckValue'=>null
        )).'С правилами сервиса соглашаюсь'.'<span class="required">*</span>', null)?>
        <?=CHtml::label(CHtml::checkBox('OrderForm[sign]', true, array(
                'value'=>1,
                'uncheckValue'=>null
            )).'Присылайте мне акции то Mint Print на эл. почту', null)?>
    </div>
    <div class="buttons-block overflow-hidden">
        <a class="back-button left" href="javascript: history.back(); return false">назад</a>
        <?php echo CHtml::submitButton('Далее', array('class'=>'continue-button right')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>


<script>
    $(document).ready(function(){
        $('#newPost').change(function(){
            $('#newPostData input').prop('disabled', false);
            $('#postData input').prop('disabled', true);
        });
        $('#post').change(function(){
            $('#newPostData input').prop('disabled', true);
            $('#postData input').prop('disabled', false);
        });
    });
</script>