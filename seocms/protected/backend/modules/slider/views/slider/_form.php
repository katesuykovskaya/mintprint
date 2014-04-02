<?php
/* @var $this SliderController */
/* @var $model Slider */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'slider-form',
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
        $fileName = Yii::getPathOfAlias("webroot").'/uploads/Slider/'.$model->id.'/'.$model->img;
        if(!empty($model->img) && is_file($fileName)) {

            $tmb = Yii::app()->easyImage->thumbOf($fileName, array(
                "resize" => array("width"=>200,"master"=>EasyImage::RESIZE_WIDTH),
                "savePath"=>"/uploads/Slider/".$model->id."/",
                "quality" => 80,
            ));
            echo $form->hiddenField($model, 'img');
            echo CHtml::link($tmb, '/uploads/Slider/'.$model->id.'/'.$model->img, array('class'=>'full-slider'));
            echo '<br/>';
            echo CHtml::link(Yii::t('backend', 'Удалить').'<i class="icon-remove"></i>',
                Yii::app()->createUrl('backend/slider/slider/delImage', array('language'=>Yii::app()->language)),
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
        <?php echo $form->label($modelTranslate, 't_desc')?>
        <?php echo $form->textArea($modelTranslate, 't_desc', array('class'=>'span5', 'rows'=>4))?>
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
            $('.full-slider').fancybox();
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