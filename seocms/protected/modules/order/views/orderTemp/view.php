<?php
/* @var $this OrderTempController */
/* @var $model OrderTemp */

$this->breadcrumbs=array(
	'Order Temps'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OrderTemp', 'url'=>array('index')),
	array('label'=>'Create OrderTemp', 'url'=>array('create')),
	array('label'=>'Update OrderTemp', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrderTemp', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrderTemp', 'url'=>array('admin')),
);
?>

<h1>View OrderTemp #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'session_id',
		'user_id',
		'img_url',
		'thumb_url',
		'img_count',
		'img_width',
		'img_height',
		'img_x',
		'img_y',
	),
)); ?>
