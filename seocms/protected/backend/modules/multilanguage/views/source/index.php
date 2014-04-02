<?php
/* @var $this SourceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Source Messages',
);

$this->menu=array(
	array('label'=>'Create SourceMessage', 'url'=>array('create')),
	array('label'=>'Manage SourceMessage', 'url'=>array('admin')),
);
?>

<h1>Source Messages</h1>

<?php echo CHtml::link(Yii::t('main','Добавить запись'),Yii::app()->urlManager->createUrl('multilanguage/source/create',array('language'=>Yii::app()->language)),array('class'=>'btn'));?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
