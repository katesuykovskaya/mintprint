<?php
/* @var $this NewsController */
/* @var $model News */
?>

<h3><?php echo $model->translation[Yii::app()->language]->t_title; ?></h3>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'img',
		'status',
	),
));
