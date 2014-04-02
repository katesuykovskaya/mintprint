<?php
/* @var $this UsersController */
/* @var $model User */
?>
<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Управление пользователями'),$this->createUrl('backend/users/users/admin',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Новый пользователь')?></li>
    </ul>
</div>

    <h3 class="page-header"><?=Yii::t('backend','Создание пользователя')?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>