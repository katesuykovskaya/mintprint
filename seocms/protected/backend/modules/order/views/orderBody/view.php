<?php
/* @var $this OrderBodyController */
/* @var $model OrderBody */

$this->breadcrumbs=array(
	'Order Bodies'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OrderBody', 'url'=>array('index')),
	array('label'=>'Create OrderBody', 'url'=>array('create')),
	array('label'=>'Update OrderBody', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrderBody', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrderBody', 'url'=>array('admin')),
);
?>

<h1>View OrderBody #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_order',
		'path',
		'count',
	),
)); ?>
