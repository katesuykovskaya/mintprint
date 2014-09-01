<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 03.07.14
 * Time: 14:26
 */
$sql = "select min(date) as min, max(date) as max from OrderHead";
$row = Yii::app()->db->createCommand($sql)->queryRow();
?>
<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Заказы'),$this->createUrl('/backend/order/order/admin',array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Календарь заказов')?></li>
    </ul>
</div>
<form method="get" class="form">
    <h3>Поиск</h3>
    <label>Статус</label>
    <?=CHtml::dropDownList('Search[status]', 0, ZHtml::enumItem($model, 'status'), array('prompt'=>'All', 'options'=> !empty($_GET['Search']['status']) ? array($_GET['Search']['status']=>array('selected'=>true)) : array()))?>
    <label>Дата</label>
    <div class="overflow-hidden">
        <div class="date-range-wrap left">
            <b>From :</b>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name'=>'Search[from_date]',
                'flat'=>true,
                'value'=>isset($_GET['Search']['from_date']) ? $_GET['Search']['from_date'] : $row['min'],  // value comes from cookie after submittion
                'options'=>array(
                    'showAnim'=>'slide',
                    'dateFormat'=>'yy-mm-dd',
                ),
                'htmlOptions'=>array(
                    'style'=>''
                ),
            ));
            ?>
        </div>
        <div class="date-range-wrap left">
            <b>To :</b>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name'=>'Search[to_date]',
                'flat'=>true,
                'value'=>isset($_GET['Search']['to_date']) ? $_GET['Search']['to_date'] : $row['max'],
                'options'=>array(
                    'showAnim'=>'fold',
                    'dateFormat'=>'yy-mm-dd',

                ),
                'htmlOptions'=>array(
                    'style'=>''
                ),
            ));?>
        </div>
    </div>
    <div class="buttons"><?=CHtml::submitButton('Искать', array('class'=>'btn'))?></div>
</form>
<hr/>
<h2>Статус: <?php echo !empty($_GET['Search']['status']) ? Yii::t('backend', $_GET['Search']['status']) : 'Все'?></h2>
<ul class="span6">
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
));
?>
</ul>