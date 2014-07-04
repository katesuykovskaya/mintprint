<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 03.07.14
 * Time: 14:26
 */
?>
<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Заказы'),$this->createUrl('/backend/order/order/admin',array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Календарь заказов')?></li>
    </ul>
</div>
<ul class="span6">
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
));
?>
</ul>