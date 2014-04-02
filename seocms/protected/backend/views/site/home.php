<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>



<h1>HOME</h1>

<h4>current controller = <?=CVarDumper::dump(Yii::app()->getController(),5,true);?></h4>

<ul>
    <li>current file (__FILE__): <code><?php echo __FILE__; ?></code></li>
    <li>conroller path = <?=Yii::app()->controllerPath;?></li>
    <li>view path = <?=Yii::app()->viewPath;?></li>
    <li>base path = <?=Yii::app()->basePath;?></li>
    <li>backend alias path = <?=Yii::getPathOfAlias('backend');?></li>
</ul>


