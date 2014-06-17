<?php
/* @var $this OrderHeadController */
/* @var $model OrderHead */
?>



    <div class="row">
        <ul class="breadcrumb span6">
            <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',array('language'=>Yii::app()->language)))?></li>
            <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Заказы'),$this->createUrl('/backend/order/orderHead/admin',array('language'=>Yii::app()->language)))?></li>
            <li><span class="divider">/</span><?=Yii::t('backend','Обновление заказа ').'"'.$model->name.'"'?></li>
        </ul>
    </div>

    <h3 class="page-header"><?=Yii::t('backend','Обновление заказа ').'"'.$model->name.'"'?></h3>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>