<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>
<h1><?php echo $this->uniqueId . '/' . $this->action->id; ?></h1>



<div class="well span2">
    <h5 class="page-header"><?php echo Yii::t('backend','Menu\'s list');?></h5>
<?php
    echo CHtml::link('usermenu',$this->createUrl('menugen/default/usermenu',array('language'=>Yii::app()->language)),array('class'=>'btn'));
    echo '<hr />';
?>

<?php
    echo CHtml::link('mainmenu',$this->createUrl('menugen/default/mainmenu',array('language'=>Yii::app()->language)),array('class'=>'btn'));
    echo '<hr />';
?>


<?php
    echo CHtml::link('sidemenu',$this->createUrl('menugen/default/sidemenu',array('language'=>Yii::app()->language)),array('class'=>'btn'));
    echo '<hr />';
?>


<?php
    echo CHtml::link('footermenu',$this->createUrl('menugen/default/footermenu',array('language'=>Yii::app()->language)),array('class'=>'btn'));
    echo '<hr />';
?>
    </div>

