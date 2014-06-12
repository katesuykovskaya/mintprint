<?php
/* @var $this PagesController */
/* @var $model StaticPages */
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Динамические страницы'),$this->createUrl('/backend/pages/pages/grid',array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Обновление страницы ').'"'.$model->translation[Yii::app()->language]->t_title.'"'?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend','Обновление страницы ').'"'.$model->translation[Yii::app()->language]->t_title.'"'?></h3>

<?php echo $this->renderPartial('_formUpdate', array('model'=>$model)); ?>