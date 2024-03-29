<?php
/* @var $this SliderController */
/* @var $model Slider */

$this->breadcrumbs=array(
    'Sliders'=>array('/backend/slider/slider/admin', 'language'=>Yii::app()->language),
	'Manage',
);
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend', array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Управление слайдером')?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend', 'Управление слайдером на главной')?></h3>
<?php $l = Yii::app()->language?>

<div class="span10 clearfix">
    <?php echo CHtml::link(Yii::t('backend','Создать слайд'),
        $this->createUrl('/backend/slider/slider/create',array('language'=>Yii::app()->language)),array('class'=>'btn btn-success','style'=>'margin-bottom:40px'))?>
</div>

<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'slider-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'type'=>'striped bordered',
    'htmlOptions'=>array('class'=>'span12 clearfix'),
    'sortableRows'=>true,
    'sortableAttribute' => 'id',
    'sortableAjaxSave' => true,
    'sortableAction' => 'backend/slider/slider/imageSortable',
    'afterSortableUpdate' => 'js:function(){return true;}',
	'columns'=>array(
		array(
            'name'=>'id',
            'filter'=>false,
            'sortable'=>false,
        ),
        array(
            'name'=>'img',
            'value'=>'$data->img ? ZHtml::thumbnail(Yii::getPathOfAlias("webroot")."/uploads/Slider/".$data->id."/".$data->img,
                array(
                    "resize" => array("width" => 300, "height"=>200, "master"=>EasyImage::RESIZE_AUTO),
                    "savePath"=>"/uploads/Slider/".$data->id."/",
                    "quality" => 80,
                )) : " "',
            'type'=>'html',
            'filter'=>false,
            'sortable'=>false,
            'htmlOptions'=>array('class'=>'span5 text-center')
        ),
		array(
            'name'=>'show',
            'type'=>'html',
            'value'=>'$data->show ? "<i>visible</i>" : "<i>No</i>"',
            'filter'=>false,
            'sortable'=>false,
            'htmlOptions'=>array('class'=>'span2')
//            'filter'=>CHtml::activeDropDownList($model, 'show', array('1'=>'Visiblwe', '0'=>'not vis'), array('prompt'=>'choose'))
        ),
        array(
            'name'=>'translation.t_desc',
            'value'=>'isset($data->translation[Yii::app()->language]) ? $data->translation[Yii::app()->language]->t_desc : ""',
            'htmlOptions'=>array(
                'class'=>'span6'
            )
        ),
        array(
            'name'=>'translation.t_href',
            'value'=>'isset($data->translation[Yii::app()->language]) ? $data->translation[Yii::app()->language]->t_href : ""',
            'htmlOptions'=>array(
                'class'=>'span4'
            )
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
            'header'=>Yii::t('backend', 'Действия'),
            'buttons'=>array(
                'update'=>array(
                    'url'=>'Yii::app()->controller->createUrl("/backend/slider/slider/update",array("id"=>$data->id, "language"=>Yii::app()->language))',
                ),
                'delete'=>array(
                    'url'=>'Yii::app()->controller->createUrl("/backend/slider/slider/delete",array("id"=>$data->id, "language"=>Yii::app()->language))',
                ),
            ),
		),
	),
));
//Yii::app()->clientScript->registerCoreScript('jquery.ui');
?>
