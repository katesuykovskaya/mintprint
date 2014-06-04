<?php
/* @var $this OrderTempController */
/* @var $model OrderTemp */

$this->breadcrumbs=array(
	'Order Temps'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OrderTemp', 'url'=>array('index')),
	array('label'=>'Manage OrderTemp', 'url'=>array('admin')),
);
?>

<h1>Create OrderTemp</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>