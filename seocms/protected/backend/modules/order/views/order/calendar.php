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
<form method="get" class="form">
    <?=ZHtml::enumDropDownList($model, 'status', array('prompt'=>'Все', 'name'=>'status', 'options'=>isset($_GET['status']) ? array($_GET['status']=>array('selected'=>true)) : array()))?>
    <div class="buttons"><?=CHtml::submitButton('Поиск', array('class'=>'btn'))?></div>
</form>
<hr/>
<h2>Статус: <?php echo !empty($_GET['status']) ? Yii::t('backend', $_GET['status']) : 'Все'?></h2>
<ul class="span6">
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
));
?>
</ul>