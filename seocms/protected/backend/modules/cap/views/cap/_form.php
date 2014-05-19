<?php
/* @var $this CapController */
/* @var $model Cap */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cap-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data'
    )
)); ?>

	<p class="note"><?=Yii::t('backend','Поля отмеченные <span class="required">*</span> обязательны.')?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'img'); ?>
        <?php
        $fileName = Yii::getPathOfAlias("webroot").'/uploads/Cap/'.$model->id.'/'.$model->img;
        if(!empty($model->img) && is_file($fileName)) {

            $tmb = Yii::app()->easyImage->thumbOf($fileName, array(
                "resize" => array("width"=>200,"master"=>EasyImage::RESIZE_WIDTH),
                "savePath"=>"/uploads/Cap/".$model->id."/",
                "quality" => 80,
            ));
            echo $form->hiddenField($model, 'img');
            echo CHtml::link($tmb, '/uploads/Cap/'.$model->id.'/'.$model->img, array('class'=>'full-cap'));
            echo '<br/>';
            echo CHtml::link(Yii::t('backend', 'Удалить').'<i class="icon-remove"></i>',
                Yii::app()->createUrl('backend/cap/cap/delImage', array('language'=>Yii::app()->language)),
                array(
                    'class'=>'del-image',
                    'data-id'=>$model->id
            ));
        } else
		    echo $form->fileField($model,'img'); ?>
		<?php echo $form->error($model,'img'); ?>
	</div>
    <hr/>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'show'); ?>
		<?php echo $form->checkBox($model,'show'); ?>
		<?php echo $form->error($model,'show'); ?>
	</div>
    <hr/>

    <div class="row-fluid">
        <?php echo $form->label($modelTranslate, 't_blockquote')?>
        <?php echo $form->textArea($modelTranslate, 't_blockquote', array('class'=>'span5', 'rows'=>4))?>
<!--        --><?php //echo CHtml::textField('CapTranslate['.Yii::app()->language.'][blockquote]', $modelTranslate->t_blockquote)?>
    </div>

    <div class="row-fluid">
        <?php echo $form->label($modelTranslate, 't_cite')?>
        <?php echo $form->textField($modelTranslate, 't_cite', array('class'=>'span5'))?>
    </div>

	<div class="buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('backend','Создать') : Yii::t('backend','Сохранить'),['class'=>'btn']); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script src="/js_plugins/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="/js_plugins/fancybox/jquery.fancybox-1.3.4.css"/>
<script>
    $(document).ready(function(){
        $(document).ready(function(){
            $('.full-cap').fancybox();
            $(document).on('click', '.del-image', function(e) {
                e.preventDefault();
                var _this = $(this);
                var id = _this.attr('data-id')
                $.ajax({
                    type: 'POST',
                    data: { id : id },
                    url:_this.attr('href'),
                    success: function(response){
                        $res = $.parseJSON(response);
                        if($res.success) {
                            location.reload();
                        }
                    }
                });
            })
        });
    });
</script>