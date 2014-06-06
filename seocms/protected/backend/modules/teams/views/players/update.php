<?php
/* @var $this PlayersController */
/* @var $model Player */
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Управление игроками'),$this->createUrl('/backend/teams/players/admin',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Обновление данных ').$model->translation[Yii::app()->language]->t_fio?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend','Обновление данных ').$model->translation[Yii::app()->language]->t_fio?></h3>

<?php echo $this->renderPartial('_formUpdate', array('model'=>$model, 'modelTeam'=>$modelTeam, 'translate'=>$translate)); ?>