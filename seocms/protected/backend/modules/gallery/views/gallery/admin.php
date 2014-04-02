<?php
/* @var $this GalleryController */
/* @var $model Gallery */
?>

<h3><?=Yii::t('backend','Управление галереями')?></h3>

<?=CHtml::link(Yii::t('backend','Создать галерею'),$this->createUrl('backend/gallery/gallery/gallerycreate',['language'=>Yii::app()->language]),['class'=>'btn'])?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'gallery-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'lft',
		'rgt',
		'level',
		'type',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>