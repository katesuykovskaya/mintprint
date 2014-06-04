<?php
/* @var $this OrderTempController */
/* @var $model OrderTemp */

$this->breadcrumbs=array(
	'Order Temps'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrderTemp', 'url'=>array('index')),
	array('label'=>'Create OrderTemp', 'url'=>array('create')),
	array('label'=>'View OrderTemp', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrderTemp', 'url'=>array('admin')),
);
?>

<h1>Update OrderTemp <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>