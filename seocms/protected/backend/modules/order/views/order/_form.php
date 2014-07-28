<?php
/* @var $this OrderHeadController */
/* @var $model OrderHead */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-head-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div>
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'region'); ?>
		<?php echo $form->textField($model,'region',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'region'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'delivery'); ?>
		<?php echo $form->textField($model,'delivery',array('size'=>7,'maxlength'=>7)); ?>
		<?php echo $form->error($model,'delivery'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'newPostAddress'); ?>
		<?php echo $form->textField($model,'newPostAddress',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'newPostAddress'); ?>
	</div>

    <div>
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status', array('new'=>Yii::t("backend","new"),'ready'=>Yii::t("backend","ready"),'shipped'=>Yii::t("backend","shipped"),'delete'=>Yii::t("backend","delete"))); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>

	<div >
		<?php echo $form->labelEx($model,'sign'); ?>
		<?php echo $form->checkBox($model,'sign'); ?>
		<?php echo $form->error($model,'sign'); ?>
	</div>

	<div >
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<div class="wrapper-photos">
    <?php
    foreach($model->body as $key=>$item):
        $path = "/uploads/Order/thumb/$model->id/$item->id.".substr(strrchr($item['path'], '.'), 1);
        ?>
        <div>
            <img src="<?=$path?>" title="<?=$path?>" />
            <div>
                <span>№<?=$item->position?></span>&nbsp;-&nbsp;
                <strong><?=$item->position?>&nbsp;шт</strong>
            </div>

        </div>

    <?php endforeach
    ?>
    <form method="post" >
        <input class="btn btn-primary" type="submit" name="download" value="Скачать архив">
    </form>
</div>

