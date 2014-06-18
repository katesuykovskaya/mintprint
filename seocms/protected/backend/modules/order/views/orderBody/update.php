<?php
/* @var $this OrderBodyController */
/* @var $model OrderBody */

$this->breadcrumbs=array(
	'Order Bodies'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrderBody', 'url'=>array('index')),
	array('label'=>'Create OrderBody', 'url'=>array('create')),
	array('label'=>'View OrderBody', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrderBody', 'url'=>array('admin')),
);
?>

<h1>Update OrderBody <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>