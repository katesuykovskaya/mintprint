<?php
/* @var $this SourceController */
/* @var $model SourceMessage */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'source-message-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="note"><?=Yii::t('backend','Поля отмеченные <span class="required">*</span> обязательны для заполнения.')?></p>

	<?php echo $form->errorSummary($model); ?>

	<div id="category">
		<?php echo $form->labelEx($model,Yii::t('main','Категория')); ?>
        <?php echo $form->dropDownList($model,'category',ZHtml::enumItem(SourceMessage::model(),'category'),['class'=>'input-xxlarge']);?>
        <?php echo '<br />'; ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,Yii::t('main','Текст')); ?>
		<?php echo $form->textArea($model,'message',['class'=>'input-xxlarge','rows'=>6]); ?>
		<?php echo $form->error($model,'message'); ?>
	</div>

    <?php
        foreach(Yii::app()->params['languages'] as $language)
        {
            echo CHtml::label(Yii::t('language',$language['lang']),'SourceMessage_'.$language["langcode"]);
            echo CHtml::textField('SourceMessage['.$language["langcode"].']','',['class'=>'input-xxlarge']);
        }
    ?>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('main','Создать') : Yii::t('main','Сохранить'),['class'=>'btn']); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
    var message = $("#SourceMessage_message");
    message.change(function(){
        $("#SourceMessage_<?=Yii::app()->language;?>").val($(this).val());
    });
</script>
