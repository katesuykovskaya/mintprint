<?php
/* @var $this PagesController */
/* @var $model StaticPages */

$this->breadcrumbs=array(
	'Static Pages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StaticPages', 'url'=>array('index')),
	array('label'=>'Manage StaticPages', 'url'=>array('admin')),
);
?>

<h1>Создание новой страницы</h1>



<?php echo $this->renderPartial('_form', array('translate'=>$translate,'count'=>$count)); ?>

<?php
//    echo CVarDumper::dump($translate->translateAttributes,10,true);
?>