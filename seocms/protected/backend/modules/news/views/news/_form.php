<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerScriptFile('/js/lightbox.js');
Yii::app()->clientScript->registerCssFile('/css/lightbox.css');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile('/js/jquery.ui.i18n-ru.js');

if($model->isNewRecord){
    Yii::app()->clientScript->registerScript(
        'translit',
        '$(document).on("change",".translate",function(){
        var title = $(this).val();
        $.ajax({
            type:"POST",
            url:"/backend/news/news/urlGenerate",
            data:{
                title:title
            },
            success:function(response){
                $(".url").val(response);
            }
        });
    });'
    ,CClientScript::POS_END);
}
?>
<div style="width: 100%; overflow: hidden">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data'
    )
)); ?>

<?php
$this->widget('bootstrap.widgets.TbTabs', array(
    'type'=>'tabs', // 'tabs' or 'pills'
    'tabs'=>$this->tabsArray($newsTranslate),
));
?>

    <div class="span12">
<!--        --><?php //if($model->isNewRecord || empty($model->img)):?>
<!--            --><?php //echo $form->labelEx($model,Yii::t('backend','Основное изображение')); ?>
<!--            --><?php //echo CHtml::activeFileField($model,'img',['class'=>'form control input-sm'])?>
<!--            --><?php //echo $form->error($model,'img'); ?>
<!--        --><?php //else : ?>
<!--            --><?php
//            $imageParams = array(
//                'resize' => array('width' => 100, 'height' => 100,'master'=>EasyImage::RESIZE_NONE),
//                'savePath'=>'/uploads/News/'.$model->id.'/',
//                'quality' => 80,
//            );
//            $imageName = '/uploads/News/'.$model->id.DIRECTORY_SEPARATOR.$model->img;
//
//            echo '<a href="/uploads/News/'.$model->id.DIRECTORY_SEPARATOR.$model->img.'" data-lightbox="'.$model->img.'">
//                '.Yii::app()->easyImage->thumbOf($imageName,$imageParams).'</a>';
//
//                       echo '<span class="clearfix"></span>';
//                       echo CHtml::link(Yii::t('backend','Удалить').' <i class="icon-remove"></i>',
//            '#',array(
//            'id'=>'delImg','data-id'=>$model->id,
//            'data-url'=>$this->createUrl('/backend/news/news/delImage',array('language'=>Yii::app()->language)),
//            'data-name'=>Yii::app()->easyImage->getHashedName($imageName,$imageParams,true)
//            )
//            );
//            ?>
<!--        --><?php //endif;?>
    </div>


    <div class="buttons span12" style="margin: 30px 0 30px 30px;">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('backend','Создать') : Yii::t('backend','Сохранить'),['id'=>'submit','class'=>'btn btn-default btn-lg btn-block']); ?>
    </div>

    <?php $this->endWidget(); ?>
    </div>

<?php
$filesToken = sha1(uniqid(mt_rand(),true));
$entity = 'News';
$webroot = Yii::getPathOfAlias('webroot');
$this->widget('application.backend.modules.attach.widgets.FileUploadWidget',array(
    'entity'=>$entity,
    'entity_id'=> !$model->isNewRecord ? $model->id : null,
    'versions'=>array('small','thumbnail',''),
    'tempUrl'=>$webroot.'/uploads/tmp/'.$filesToken.DIRECTORY_SEPARATOR,
    'uploadUrl'=>$webroot.'/uploads/',
    'webUrl'=>'/uploads/',
    'webTmp'=>'/uploads/tmp/'.$filesToken.DIRECTORY_SEPARATOR,
    'filePath'=>'/uploads/'.$entity.DIRECTORY_SEPARATOR.$model->id.DIRECTORY_SEPARATOR,
));
$this->widget('application.backend.extensions.tinymce.TinyMceWidget',array(
    'language'=>Yii::app()->language,
    'attribute'=>'tinyEditor'
));
?>
<script>
    $(document).on("click","#urlgen",function(e){
        e.preventDefault();
        $.ajax({
            type:'POST',
            url:'/backend/news/news/urlGenerate',
            data:{
                title:$("#News_title").val()
            },
            success:function(response){
                $("#News_url").val(response);
            }
        });
    });

    $(document).on("click","#delImg",function(e){
        e.preventDefault(e);
        $.ajax({
            type:"POST",
            url:$(this).data("url"),
            data:{
                id:$(this).data("id"),
                name:"/uploads/News/"+$(this).data("id")+"/"+$(this).data("name")
            },
            success:function(response){
                var resp = JSON.parse(response);
                if (resp.success === true) location.reload();
            }
        });
    });
    $(function() {
        $(".url").removeAttr("disabled");
        $( ".date" ).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            defaultDate: $(this).val()
        });
    });
</script>