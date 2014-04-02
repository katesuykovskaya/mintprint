<?php
/**
 * @var $this PagesController
 * @var $model StaticPages
 */
Yii::app()->clientScript->registerScriptFile('/js/lightbox.js');
Yii::app()->clientScript->registerCssFile('/css/lightbox.css');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile('/js/jquery.ui.i18n-ru.js');
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note"><?=Yii::t('backend','Поля отмеченные <span class="required">*</span> обязательны.')?></p>

	<?php echo $form->errorSummary($model);
        
    $this->widget('bootstrap.widgets.TbTabs', array(
        'type'=>'tabs', // 'tabs' or 'pills'
        'tabs'=>
            $this->tabsArray($model,$param = false),
    ));

    if(!empty($model->img)){
        $imageParams =   array(
            'resize' => array('width' => 100, 'master'=>EasyImage::RESIZE_WIDTH),
            'background' => '#ffffff',
            'savePath'=>'/uploads/News/'.$model->id.'/',
        );
        $imageName = '/uploads/News/'.$model->id.DIRECTORY_SEPARATOR.$model->img;

        echo '<a href="/uploads/News/'.$model->id.DIRECTORY_SEPARATOR.$model->img.'" data-lightbox="'.$model->img.'">
                            '.Yii::app()->easyImage->thumbOf($imageName,$imageParams).'</a>';

        echo '<span class="clearfix"></span>';
        echo CHtml::link(Yii::t('backend','Удалить').' <i class="icon-remove"></i>',
                        '#',array(
                        'id'=>'delImg','data-id'=>$model->id,
                        'data-url'=>$this->createUrl('backend/news/news/delImage',array('language'=>Yii::app()->language)),
                        'data-name'=>Yii::app()->easyImage->getHashedName($imageName,$imageParams,true)
            )
        );
    } else {
        echo CHtml::activeFileField($model,'img',array());
    }

?>
</div><!-- form -->
<hr />
<?php echo CHtml::submitButton(Yii::t('backend','Сохранить'),array('id'=>'submit','class'=>'btn')); ?>


<?php $this->endWidget(); ?>


<?php
//echo 't_imgmeta = '.$model->translation['ru']['t_imgmeta'].'<br />';
//$test = unserialize($model->translation['ru']['t_imgmeta']);
//echo '$test = '.CVarDumper::dump($test,5,true);
//echo CVarDumper::dump($model->translation['ru']->attributes,5,true);
?>

<?php
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
                name:"/uploads/News/"+$(this).data("id")+"/"+$(this).data("name")
            },
            success:function(response){
                var resp = JSON.parse(response);
                if (resp.success === true) location.reload();
            }
        });
    });

    $(document).ready(function(){
        $(".url").after("<a href='#'><i id='urlEdit' class='icon-edit icon-large'></i></a>");
    });

    $(document).on("click","#urlEdit",function(){
        $(".url").removeAttr("disabled");

    });

    $(document).on("click","#submit",function(){
        $(".url").removeAttr("disabled");
    });

    $(function() {
        $( ".date" ).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            defaultDate: $(this).val()
        });
    });



</script>