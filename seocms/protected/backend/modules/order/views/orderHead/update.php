<?php
/* @var $this OrderHeadController */
/* @var $model OrderHead */

$this->breadcrumbs=array(
	'Order Heads'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrderHead', 'url'=>array('index')),
	array('label'=>'Create OrderHead', 'url'=>array('create')),
	array('label'=>'View OrderHead', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrderHead', 'url'=>array('admin')),
);
?>

<h1>Update OrderHead <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>