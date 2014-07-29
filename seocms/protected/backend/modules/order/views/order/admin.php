<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend', array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Администрирование заказов')?></li>
    </ul>
</div>

<h3 class="page-header"><?php echo Yii::t('backend','Администрирование заказов');?></h3>
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="alert alert-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'page-form',
    'enableAjaxValidation'=>true,
    'method'=>'get',
)); ?>
<h4>Поиск по дате</h4>
<div class="overflow-hidden">
    <div class="date-range-wrap left">
        <b>From :</b>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name'=>'from_date',
            'flat'=>true,
            'value'=>isset($_GET['from_date']) ? $_GET['from_date'] : time(),  // value comes from cookie after submittion
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
            'name'=>'to_date',
            'flat'=>true,
            'value'=>isset($_GET['to_date']) ? $_GET['to_date'] : strtotime('+1 month'),
            'options'=>array(
                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',

            ),
            'htmlOptions'=>array(
                'style'=>''
            ),
        ));?>
    </div>
    <div class="right">
        <?php
            $url = '/backend/order/order/export';
            $params = array();
            if(!empty($_GET['OrderHead']['status'])) $params['status'] = $_GET['OrderHead']['status'];
            if(isset($_GET['from_date'])) $params['from_date'] = $_GET['from_date'];
            if(isset($_GET['to_date'])) $params['to_date'] = $_GET['to_date'];
        ?>
        <a class="export-link" href="<?=Yii::app()->createUrl('/backend/order/order/export', $params)?>">Экспорт таблицы в формат Excel</a>
    </div>
</div>


<?php echo CHtml::submitButton('Поиск', array('class'=>'btn')); ?>
<hr/>
<?php $this->endWidget(); ?>
<div>
    <a class="select-all btn" href="#">Выбрать все</a>
    <?=CHtml::link('Сбросить фильтры', Yii::app()->createUrl('/backend/order/order/admin'), array('class'=>'btn reset-filters'))?>
</div>
<?php
 $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'order-head-grid',
     'type'=>'striped bordered',
     'enableSorting'=>false,
     'ajaxUpdate'=>false,
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'type'=>'raw',
            'value'=>'CHtml::checkBox("id[$data->id]", false, array("class"=>"change-status", "value"=>$data->id))',
        ),
		'id',
		'name',
		'email',
		'phone',
		'address',
		'city',
        'region',
        'photoCount'=>array(
          'value'=>'$data->count?$data->count:""',
          'name'=>'photoCount',
        ),
        'price' => array(
            'value'=>'$data->price." грн"',
            'name'  => 'photoCount',
            'header'=> CHtml::encode($model->getAttributeLabel('price')),
            'filter'=> CHtml::activeTextField($model, 'price'),
        ),
       'status' => array(
           'value'=>'Yii::t("backend",$data->status)',
           'name'=>'status',
           'filter'=>CHtml::activeDropDownList($model,'status', array('new'=>Yii::t("backend","new"),'ready'=>Yii::t("backend","ready"),'shipped'=>Yii::t("backend","shipped"),'delete'=>Yii::t("backend","delete")),array('prompt'=>Yii::t('backend','Выберите статус'))),
        ),
        'date',
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{delete}',
            'buttons' => array(
                'update' => array(
                    'url' => 'Yii::app()->createUrl("backend/order/order/update", array("id"=>$data->id))',
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("backend/order/order/delete", array("id"=>$data->id))',
                ),
            ),
		),
	),
));
?>
<h4>Изменить статус:</h4>
<form class="change-status-form" method="post">
    <?php echo ZHtml::enumDropDownList($model, 'status', array('name'=>'new_status'))?>
    <div><?=CHtml::submitButton('Сохранить', array('class'=>'btn btn-success', 'name'=>'change_status', 'id'=>'change_status'))?></div>
</form>

<script>
    $(document).ready(function(){
        $('.select-all').on('click', function(e){
            e.preventDefault();
            $('.change-status').prop('checked', true);
        });

        $('.change-status-form').submit(function(e){
            var ids = $('.change-status:checked');
            for(var i=0;i<ids.length; i++) {
                 $('<input type="hidden">').attr('name', ids.eq(i).attr('name')).val(ids.eq(i).val()).appendTo($(this));
            }
        });
    });
</script>
