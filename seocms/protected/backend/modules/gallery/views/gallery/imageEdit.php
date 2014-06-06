<?php
/* @var $this GalleryController */
/* @var $model Gallery */
$metadata =  unserialize($model->translation[Yii::app()->language]->t_meta);
if(!is_array($metadata)){
    foreach($model->translateAttributes['t_meta']['value'] as $k=>$v){
        $metadata[$v] = '';
    }
}
?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'image-form',
    'enableAjaxValidation'=>false,
)); ?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Все галереи'),$this->createUrl('/backend/gallery/gallery/index',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('frontend','Фотогалерея'),$this->createUrl('/backend/gallery/gallery/view',['id'=>22,'language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=CHtml::link($parent->translation[Yii::app()->language]->t_title,$this->createUrl('/backend/gallery/gallery/view',['id'=>$parent->id,'language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=$model->translation[Yii::app()->language]->t_title;?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend','Обновление метаданных')?></h3>
<div class="row">
    <div id="message" class="span5 offset1">
        <?php if(Yii::app()->user->hasFlash('meta-success')) : ?>

            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo Yii::app()->user->getFlash('meta-success');?>
            </div>

        <?php elseif(Yii::app()->user->hasFlash('meta-error')) : ?>

            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo Yii::app()->user->getFlash('meta-error');?>
            </div>

        <?php endif?>
    </div>
</div>
<div>

    <div class="row">
        <div class="span4">
            <?php
            $image = is_file(Yii::getPathOfAlias("webroot").$model->translation[Yii::app()->language]->t_file) ? Yii::app()->easyImage->thumbOf(Yii::getPathOfAlias("webroot").$model->translation[Yii::app()->language]->t_file,
                [
                    "resize" => array("width"=>176,"height"=>150, "master"=>EasyImage::RESIZE_PRECISE),
                    "savePath"=>"/galleries/".$parent->id."/",
                    "quality" => 80,
                ]) : '';

            $this->widget(
                'bootstrap.widgets.TbBox',
                [
                    'title' => Yii::t('backend','Параметры:'),
                    'headerIcon' => 'icon-file',
                    'content' =>
                        $image.'<hr />'.
                        Yii::t('backend','Событие').': '.$parent->translation[Yii::app()->language]->t_title.'<br />'.
                        $model->getAttributeLabel(Yii::t('backend','Тип')).': '.$model->type.'<br />'.
                        $model->getAttributeLabel(Yii::t('backend','translation.t_title')).': '.$model->translation[Yii::app()->language]->t_title.'<br />'
                ]
            );
            ?>
        </div>
    </div

    <?php
        foreach($model->translateAttributes['t_meta']['value'] as $key=>$attribute){
            echo CHtml::label(Yii::t('backend',$key),'GalleryTranslate_'.$attribute.'_'.Yii::app()->language).'<br />'.
            CHtml::textField('GalleryTranslate['.$attribute.']['.Yii::app()->language.']',$metadata[$attribute]).'<br />';
        }
    ?>
    <div class="buttons">
        <?php echo CHtml::submitButton(Yii::t('backend','Сохранить'),['class'=>'btn']); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<script>
    $(function() {
        if($("#message") != undefined){
            $("#message").fadeOut(4000);
        }
    });
</script>