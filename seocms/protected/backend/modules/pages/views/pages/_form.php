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

	<?php
            echo CHtml::label(Yii::t('backend','Родитель'), 'parent');

            echo '<select name="parent" id="parent" class="input-xxlarge">';
                if($count){
                    echo '<option value="empty">'.Yii::t('backend','Выберите родителя').'</option>';
                } else {
                    echo '<option>'.Yii::t('backend','Создайте родительский раздел').'</option>';
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

        <?php echo CHtml::activeFileField($translate,'img',array()).'<hr />'?>

		<?php echo CHtml::submitButton('Создать',array('class'=>'btn')).'<hr />'; ?>


<?php $this->endWidget(); ?>

</div><!-- form -->

<?php
$filesToken = sha1(uniqid(mt_rand(),true));
$entity = 'StaticPages';
$webroot = Yii::getPathOfAlias('webroot');
$this->widget('application.backend.modules.attach.widgets.FileUploadWidget',array(
    'entity'=>$entity,
    'entity_id'=> !$translate->isNewRecord ? $translate->page_id : null,
    'versions'=>array('small','thumbnail',''),
    'tempUrl'=>$webroot.'/uploads/tmp/'.$filesToken.DIRECTORY_SEPARATOR,
    'uploadUrl'=>$webroot.'/uploads/',
    'webUrl'=>'/uploads/tmp/'.$filesToken.DIRECTORY_SEPARATOR,
    'webTmp'=>'/uploads/tmp/'.$filesToken.DIRECTORY_SEPARATOR,
    'filePath'=>'/uploads/'.$entity.DIRECTORY_SEPARATOR.$translate->page_id.DIRECTORY_SEPARATOR,
));

$this->widget('application.backend.extensions.tinymce.TinyMceWidget',array(
    'language'=>Yii::app()->language,
    'attribute'=>'tinyEditor'
));
?>