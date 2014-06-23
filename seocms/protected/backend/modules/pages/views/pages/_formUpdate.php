<?php
/**
 * @var $this PagesController
 * @var $model StaticPages
 */
Yii::app()->clientScript->registerScriptFile('/js/lightbox.js');
Yii::app()->clientScript->registerCssFile('/css/lightbox.css');
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'static-pages-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<?php
    echo CHtml::label(Yii::t('backend','Родитель'), 'parent');
    $listdata = CHtml::listData(
                StaticPages::model()->with(array('translation',array(
                    'joinType'=>'LEFT JOIN',
                    'on'=>'translation.t_lang=:lang',
                    'params'=>array(':lang'=>Yii::app()->language),
                )))->findAll(),'translation.page_id','translation.t_title');
//echo CVarDumper::dump($listdata, 7, true);
    echo CHtml::dropDownList('parent', 'parent', $listdata,array('selected'=>$model->parent()->find(),'class'=>'input-xxlarge'));
        
    $this->widget('bootstrap.widgets.TbTabs', array(
        'type'=>'tabs', // 'tabs' or 'pills'
        'tabs'=>
            $this->tabsArray($model,$param = false),
    ));

    if(!empty($model->img)){
        $imageParams =   array(
            'resize' => array('width' => 100, 'height' => 100,'master'=>EasyImage::RESIZE_NONE),
            'background' => '#ffffff',
            'savePath'=>'/uploads/StaticPages/'.$model->page_id.'/',
        );
        $imageName = Yii::getPathOfAlias('webroot').'/uploads/StaticPages/'.$model->page_id.DIRECTORY_SEPARATOR.$model->img;
        echo '<a href="/uploads/StaticPages/'.$model->page_id.DIRECTORY_SEPARATOR.$model->img.'" data-lightbox="'.$model->img.'">
                            '.ZHtml::thumbnail($imageName,$imageParams).'</a>';

        echo '<span class="clearfix"></span>';
        echo CHtml::link(Yii::t('backend','Удалить').' <i class="icon-remove"></i>',
                        '#',array(
                        'id'=>'delImg','data-id'=>$model->page_id,
                        'data-url'=>$this->createUrl('backend/pages/pages/delImage',array('language'=>Yii::app()->language)),
                        'data-name'=>Yii::app()->easyImage->getHashedName($imageName,$imageParams,true)
            )
        );
    } else {
        echo CHtml::activeFileField($model,'img',array());
    }

?>
</div><!-- form -->
<hr />
<?php echo CHtml::submitButton(Yii::t('backend','Сохранить'),array('class'=>'btn')); ?>


<?php $this->endWidget(); ?>


<?php if(!$model->isNewRecord):?>
<div class="well">
    <h4 class="page-header"><?=Yii::t('backend','Загруженные файлы:')?></h4>
<?php
    $this->widget('application.backend.modules.attach.widgets.FileWidget');
?>
</div>
<?php endif?>

<?php
$filesToken = sha1(uniqid(mt_rand(),true));
$entity = get_class($model);
$this->widget('application.backend.modules.attach.widgets.FileUploadWidget',array(
        'entity'=>$entity,
        'entity_id'=> !$model->isNewRecord ? $model->page_id : null,
        'versions'=>array('small','thumbnail',''),
        'tempUrl'=>Yii::getPathOfAlias('webroot').'/uploads/tmp/'.$filesToken.DIRECTORY_SEPARATOR,
        'uploadUrl'=>Yii::getPathOfAlias('webroot').'/uploads/',
        'webUrl'=>'/uploads/tmp/'.$filesToken.DIRECTORY_SEPARATOR,
        'webTmp'=>'/uploads/tmp/'.$filesToken.DIRECTORY_SEPARATOR,
        'filePath'=>Yii::getPathOfAlias('webroot').'/uploads/'.$entity.DIRECTORY_SEPARATOR.$model->page_id.DIRECTORY_SEPARATOR,
        'filesToken'=>$filesToken,
));

$this->widget('application.backend.extensions.tinymce.TinyMceWidget',array(
    'language'=>Yii::app()->language,
    'attribute'=>'tinyEditor'
));
?>

<script>
    $(document).on("click","#delImg",function(e){
        e.preventDefault(e);
        $.ajax({
            type:"POST",
            url:$(this).data("url"),
            data:{
                id:$(this).data("id"),
                name:"/uploads/StaticPages/"+$(this).data("id")+"/"+$(this).data("name")
            },
            success:function(response){
                var resp = JSON.parse(response);
                if (resp.success === true) location.reload();
            }
        });
    });
</script>