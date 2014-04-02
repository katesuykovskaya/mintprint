<?php
/* @var $this FeedbackController */
/* @var $model Feedback */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'feedback-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

		<?php echo $form->labelEx($model,'from'); ?>
		<?php echo $form->textField($model,'from',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'from'); ?>
        
		<?php echo $form->labelEx($model,'sender_name'); ?>
		<?php echo $form->textField($model,'sender_name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'sender_name'); ?>

		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'subject'); ?>
    
            <?php echo $form->labelEx($model,'body'); ?>
            <?php //echo $form->textArea($model,'body'); ?>
        
        <?php

        
        $this->widget('ext.tinymce.TinyMce', array(
            'model' => $model,
            'attribute' => 'body',
            //                'language'=>$lang,
            // Optional config
            'compressorRoute' => 'tinyMce/compressor',
            //'spellcheckerUrl' => array('tinyMce/spellchecker'),
            // or use yandex spell: http://api.yandex.ru/speller/doc/dg/tasks/how-to-spellcheck-tinymce.xml
            //          'spellcheckerUrl' => 'http://speller.yandex.net/services/tinyspell',
            'fileManager' => array(
                'class' => 'ext.elFinder.TinyMceElFinder',
                //route to class with action connector (class or controller)
                'connectorRoute' => 'elfinder/connector',
            ),
            'htmlOptions' => array(
//                'name' => 'body',
//                            'rows' => 6,
//                            'cols' => 60,
                'width' => 'auto',
            ),
        ));
        ?> 
        <?php echo $form->error($model,'body'); ?>


        <?php echo $form->labelEx($model,'phone'); ?>
        <?php echo $form->textField($model,'phone'); ?>
        <?php echo $form->error($model,'phone'); ?>

        <?php echo $form->labelEx($model,'files'); ?>
        <?php echo $form->textField($model,'files'); ?>
        <?php echo $form->error($model,'files'); ?>

        <?php echo $form->labelEx($model,'ip'); ?>
        <?php echo $form->textField($model,'ip',array('value'=>long2ip($model->ip))); ?>
        <?php echo $form->error($model,'ip'); ?>
<br />
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>

<?php $this->endWidget(); ?>
