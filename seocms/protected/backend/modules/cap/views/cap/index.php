<?php
/* @var $this CapController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Caps',
);

$this->menu=array(
	array('label'=>'Create Cap', 'url'=>array('create')),
	array('label'=>'Manage Cap', 'url'=>array('admin')),
);
?>

<h1>Caps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
