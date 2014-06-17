<?php
/* @var $this CapController */
/* @var $model Cap */

$this->breadcrumbs=array(
    'Caps'=>array('backend/cap/cap/admin', 'language'=>Yii::app()->language),
	'Manage',
);
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Управление заглушкой')?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend', 'Управление заглушкой')?></h3>

<div class="span10 clearfix">
    <?php echo CHtml::link(Yii::t('backend','Создать слайд'),
        $this->createUrl('/backend/cap/cap/create',['language'=>Yii::app()->language]),['class'=>'btn btn-success','style'=>'margin-bottom:40px'])?>
</div>

<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'cap-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'type'=>'striped bordered',
    'htmlOptions'=>['class'=>'span12 clearfix'],
    'sortableRows'=>true,
    'sortableAttribute' => 'id',
    'sortableAjaxSave' => true,
    'sortableAction' => 'backend/cap/cap/imageSortable',
    'afterSortableUpdate' => '',
	'columns'=>array(
		array(
            'name'=>'id',
            'filter'=>false,
        ),
        array(
            'name'=>'img',
            'value'=>'$data->img ? Yii::app()->easyImage->thumbOf(Yii::getPathOfAlias("webroot")."/uploads/Cap/".$data->id."/".$data->img,
                array(
                    "resize" => array("width" => 300, "height"=>200, "master"=>EasyImage::RESIZE_AUTO),
                    "savePath"=>"/uploads/Cap/".$data->id."/",
                    "quality" => 80,
                )) : " "',
            'type'=>'html',
            'filter'=>false,
            'htmlOptions'=>array('class'=>'span5 text-center')
        ),
		array(
            'name'=>'show',
            'type'=>'html',
            'value'=>'$data->show ? "<i>visible</i>" : "<i>No</i>"',
            'filter'=>false,
            'htmlOptions'=>array('class'=>'span2')
//            'filter'=>CHtml::activeDropDownList($model, 'show', array('1'=>'Visiblwe', '0'=>'not vis'), array('prompt'=>'choose'))
        ),
        array(
            'name'=>'translation.t_blockquote',
            'value'=>'isset($data->translation[Yii::app()->language]) ? $data->translation[Yii::app()->language]->t_blockquote : ""',
            'htmlOptions'=>array(
                'class'=>'span6'
            )
        ),
        array(
            'name'=>'translation.t_cite',
            'value'=>'isset($data->translation[Yii::app()->language]) ? $data->translation[Yii::app()->language]->t_cite : ""',
            'htmlOptions'=>array(
                'class'=>'span2'
            )
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
            'header'=>Yii::t('backend', 'Действия'),
            'buttons'=>array(
                'update'=>array(
                    'url'=>'Yii::app()->controller->createUrl("cap/cap/update",array("id"=>$data->id))',
                ),
                'delete'=>array(
                    'url'=>'Yii::app()->controller->createUrl("cap/cap/delete",array("id"=>$data->id))',
                ),
            ),
		),
	),
));
//Yii::app()->clientScript->registerCoreScript('jquery.ui');
?>
<script>
    function myfunc() {
        alert('1234567');
    }
</script>
