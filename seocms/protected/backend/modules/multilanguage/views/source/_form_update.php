<?php
/* @var $this SourceController */
/* @var $model SourceMessage */
/* @var $form CActiveForm */
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Мультиязычность. Словарь.'),$this->createUrl('backend/multilanguage/source/admin',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Обновление фразы')?></li>
    </ul>
</div>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'source-message-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?=Yii::t('backend','Поля отмеченные <span class="required">*</span> обязательны.')?></p>

	<?php echo $form->errorSummary($model); ?>

	<div id="category">
		<?php echo $form->labelEx($model,Yii::t('main','Категория')); ?>
        <?php echo ZHtml::enumDropDownList($model,'category',['class'=>'input-xxlarge']);?>
        <br />
	</div>

	<div>
		<?php echo $form->labelEx($model,Yii::t('main','Фраза')); ?>
		<?php echo $form->textArea($model,'message',['class'=>'input-xxlarge','rows'=>6]); ?>
	</div>

    <?php
        foreach(Yii::app()->params['languages'] as $key=>$language){
            echo CHtml::label(Yii::t('language',$language['lang']),'SourceMessage['.$key.']');
            echo CHtml::textField('SourceMessage['.$key.']',$translation[$key]['translation'],['class'=>'input-xxlarge']);
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
