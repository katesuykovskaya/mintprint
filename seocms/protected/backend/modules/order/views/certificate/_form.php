<?php
/* @var $this CertificateController */
/* @var $model Certificate */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'certificate-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <?php if(!$model->getIsNewRecord()):?>
        <div class="">
            <?php echo $form->labelEx($model,'code'); ?>
            <?php echo $form->textField($model,'code'); ?>
            <?php echo $form->error($model,'code'); ?>
        </div>

        <div class="">
            <?php echo $form->labelEx($model,'id_order'); ?>
            <?php echo CHtml::link($model->id_order, Yii::app()->createUrl('backend/order/order/update', array('id'=>$model->id_order))) ?>
            <?php echo $form->error($model,'id_order'); ?>
        </div>
    <?php endif;?>
	<div class="">
		<?php echo $form->labelEx($model,'create_date'); ?>
		<?php
        $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'attribute'=>'create_date',
            'flat'=>true,//remove to hide the datepicker,
            'options'=>array(
                'showAnim'=>'slide',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                'dateFormat'=>'yy-mm-dd',
            ),
            'htmlOptions'=>array(
                'style'=>''
            ),
        ));
        ?>
		<?php echo $form->error($model,'create_date'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'due_date'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'attribute'=>'due_date',
            'flat'=>true,//remove to hide the datepicker,
            'options'=>array(
                'showAnim'=>'slide',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                'dateFormat'=>'yy-mm-dd',
            ),
            'htmlOptions'=>array(
                'style'=>''
            ),
        ));
        ?>
		<?php echo $form->error($model,'due_date'); ?>
	</div>

	<div class=" buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->