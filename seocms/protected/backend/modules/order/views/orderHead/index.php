<?php
/* @var $this OrderHeadController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Order Heads',
);

$this->menu=array(
	array('label'=>'Create OrderHead', 'url'=>array('create')),
	array('label'=>'Manage OrderHead', 'url'=>array('admin')),
);
?>

<h1>Order Heads</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
