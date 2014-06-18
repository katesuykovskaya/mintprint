<?php
/* @var $this OrderBodyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Order Bodies',
);

$this->menu=array(
	array('label'=>'Create OrderBody', 'url'=>array('create')),
	array('label'=>'Manage OrderBody', 'url'=>array('admin')),
);
?>

<h1>Order Bodies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
