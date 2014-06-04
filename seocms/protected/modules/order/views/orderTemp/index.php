<?php
/* @var $this OrderTempController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Order Temps',
);

$this->menu=array(
	array('label'=>'Create OrderTemp', 'url'=>array('create')),
	array('label'=>'Manage OrderTemp', 'url'=>array('admin')),
);
?>

<h1>Order Temps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
