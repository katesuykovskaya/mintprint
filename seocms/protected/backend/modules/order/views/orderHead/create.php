<?php
/* @var $this OrderHeadController */
/* @var $model OrderHead */

$this->breadcrumbs=array(
	'Order Heads'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OrderHead', 'url'=>array('index')),
	array('label'=>'Manage OrderHead', 'url'=>array('admin')),
);
?>

<h1>Create OrderHead</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>