<?php
/* @var $this TeamsController */
/* @var $model Team */
/* @var $form CActiveForm */
?>
<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/backend.css', CClientScript::POS_HEAD);
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'team-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data'
    )
)); ?>

	<p class="note"><?=Yii::t('backend','Поля отмеченные <span class="required">*</span> обязательны.')?></p>

	<?php echo $form->errorSummary($model); ?>

	<div>
		<?php echo $form->labelEx($model,'id'); ?>
        <?php
        $htmlOptions = ['maxlength'=>20];
        if(!empty($model->id)) $htmlOptions['readonly'] = true;
        ?>
		<?php echo CHtml::textField('Team[id]', $model->id, $htmlOptions); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div>
        <?php
        $now = date('Y');
        $date = $now - 10;
        $i = $date;
        while($i <= $date + 20) {
            $data[$i] = $i;
            $i++;
        }
        ?>

		<?php echo $form->labelEx($model,'season'); ?>
        <?=CHtml::dropDownList('Team[season]', $model->season ? $model->season : $now, $data)?>
		<?php echo $form->error($model,'season'); ?>
    </div>

	<div>
        <?php echo $form->labelEx($model,'photo'); ?>
        <?php if(!$model->isNewRecord):?>
            <a class="team-photo" href="/uploads/Team/<?=$model->id?>/<?=$model->photo?>">
            <?php
                echo Yii::app()->easyImage->thumbOf(Yii::getPathOfAlias('webroot').'/uploads/Team/'.$model->id.'/'.$model->photo,
                    array(
                        'resize' => array('width' => 300,'master'=>EasyImage::RESIZE_WIDTH),
                        'savePath'=>'/uploads/Team/'.$model->id.'/',
                        'quality' => 80,
                    ));
            ?>
            </a>
            <span class="clearfix"></span>
            <?php echo CHtml::link(Yii::t('backend','Удалить').' <i class="icon-remove"></i>',
                        $this->createUrl(
                                    'backend/teams/teams/delImage',
                                    array('language'=>Yii::app()->language)
                                    ),
                                    array(
                                        'class'=>'del-image','data-id'=>$model->id,
                                    )
                        );
                echo $form->hiddenField($model, 'photo');
            ?>
        <?php endif?>

		<div><?php echo $form->fileField($model,'photo'); ?></div>
		<?php echo $form->error($model,'photo'); ?>
	</div>

	<div class="buttons input-xxlarge">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('backend','Создать') : Yii::t('backend','Сохранить'),array('class'=>'btn btn-default btn-lg btn-block')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
<script src="/js_plugins/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="/js_plugins/fancybox/jquery.fancybox-1.3.4.css"/>
<script>
    $(document).ready(function(){
        $('.team-photo').fancybox();
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
</script>