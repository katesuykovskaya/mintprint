<?php
/* @var $this TeamsController */
/* @var $model Team */
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Управление командами'),$this->createUrl('backend/teams/teams/admin',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Редактирование Команды ').'"'.$model->id.'"'?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend','Редактирование Команды ').'"'.$model->id.'"'?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>