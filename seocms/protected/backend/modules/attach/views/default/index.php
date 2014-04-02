<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);

$page = isset($_GET['page']) ? $_GET['page'] : '';
echo 'pagename = '.$page.'<hr />';

$this->widget('application.modules.attach.widgets.FileUploadWidget',array('model'=>$model));
