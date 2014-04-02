<?php
/* @var $this PagesController */
/* @var $model StaticPages */

$this->breadcrumbs=array(
	'Static Pages'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List StaticPages', 'url'=>array('index')),
	array('label'=>'Create StaticPages', 'url'=>array('create')),
);
?>

<h1>Manage Static Pages</h1>

</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'static-pages-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'page_id',
		'translation.t_translit',
                array(
                    'name'=>'translation.t_title',
               //     'value'=>"$model->translation['t_title']",
                ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
