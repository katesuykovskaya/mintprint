<?php
/* @var $this OrderBodyController */
/* @var $model OrderBody */

$this->breadcrumbs=array(
	'Order Bodies'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OrderBody', 'url'=>array('index')),
	array('label'=>'Manage OrderBody', 'url'=>array('admin')),
);
?>

<h1>Create OrderBody</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>