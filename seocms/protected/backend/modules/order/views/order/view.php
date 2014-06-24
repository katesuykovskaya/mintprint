<?php
/* @var $this OrderHeadController */
/* @var $model OrderHead */

$this->breadcrumbs=array(
	'Order Heads'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List OrderHead', 'url'=>array('index')),
	array('label'=>'Create OrderHead', 'url'=>array('create')),
	array('label'=>'Update OrderHead', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrderHead', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrderHead', 'url'=>array('admin')),
);
?>

<h1>View OrderHead #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'email',
		'phone',
		'address',
		'city',
		'region',
		'delivery',
		'newPostAddress',
		'sign',
		'price',
	),
)); ?>
