<?php
/**
 * @var $this PagesController
 * @var $translate PagesTranslate
 */
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'static-pages-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model);

        
  echo CHtml::label('Parent', 'parent');
       
            
            echo '<select name="parent" id="parent">';
                if($count){
                    echo '<option value="empty">'.Yii::t('backend','Choose root').'</option>';
                } else {
                    echo '<option>'.Yii::t('backend','Create root').'</option>';
                }
                 foreach (StaticPages::model()->selectArray() as $option)
                    echo $option;
            echo '</select>';
            
$this->widget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs', // 'tabs' or 'pills'
	'tabs'=>
            $this->tabsArray($translate),
));
        echo '<hr />';
        ?>

        <?php echo CHtml::activeFileField($translate,'img',array())?>

		<?php echo CHtml::submitButton('Создать',array('class'=>'btn')); ?>


<?php $this->endWidget(); ?>

</div><!-- form -->

<?php
$filesToken = sha1(uniqid(mt_rand(),true));
$entity = 'StaticPages';
$this->widget('application.backend.modules.attach.widgets.FileUploadWidget',array(
    'entity'=>$entity,
    'entity_id'=> !$translate->isNewRecord ? $translate->page_id : null,
    'versions'=>array('small','thumbnail',''),
    'tempUrl'=>'/var/www/seotm_cms/uploads/tmp/'.$filesToken.DIRECTORY_SEPARATOR,
    'uploadUrl'=>'/var/www/seotm_cms/uploads/',
    'webUrl'=>'/uploads/tmp/'.$filesToken.DIRECTORY_SEPARATOR,
    'filePath'=>'/var/www/seotm_cms/uploads/'.$entity.DIRECTORY_SEPARATOR.$translate->page_id.DIRECTORY_SEPARATOR,
));
?>

<?php
$this->widget('application.backend.extensions.tinymce.TinyMceWidget',array(
    'language'=>Yii::app()->language,
    'attribute'=>'tinyEditor'
));
?>