<?php
/* @var $this CapController */
/* @var $model Cap */

$this->breadcrumbs=array(
	'Caps'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Cap', 'url'=>array('index')),
	array('label'=>'Create Cap', 'url'=>array('create')),
	array('label'=>'Update Cap', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Cap', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Cap', 'url'=>array('admin')),
);
?>

<h1>View Cap #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'img',
		'show',
	),
)); ?>
