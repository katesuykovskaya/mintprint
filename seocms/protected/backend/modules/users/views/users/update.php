<?php
/* @var $this UsersController */
/* @var $model Users */
?>
    <div class="row">
        <ul class="breadcrumb span6">
            <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',array('language'=>Yii::app()->language)))?></li>
            <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Управление пользователями'),$this->createUrl('backend/users/users/admin',array('language'=>Yii::app()->language)))?></li>
            <li><span class="divider">/</span><?=$model->login?></li>
        </ul>
    </div>

<h3 class="page-header"><?=Yii::t('backend','Изменение информации пользователя '.$model->login)?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>