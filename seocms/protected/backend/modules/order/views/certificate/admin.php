<?php
/* @var $this CertificateController */
/* @var $model Certificate */
/* @var $generate GenerateForm */
Yii::app()->clientScript->registerCssFile('/css/backend.css');
?>

<h1>Управление сертификатами</h1>
<?php if(Yii::app()->user->hasFlash('success')): ?>
    <div class="row">
        <div class="alert alert-success span3 offset2">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    </div>
<?php endif;?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div class="row">
        <div class="alert alert-error span3 offset2">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    </div>
<?php endif;?>
<hr/>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'certificate-generate-form',
    'enableAjaxValidation'=>false,
    'action'=>Yii::app()->createUrl('backend/order/certificate/generate', array('language'=>Yii::app()->language)),
)); ?>
<h2>Генерация сертификатов</h2>
<div>
    <?php
    echo $form->labelEx($generate, 'count');
    echo $form->textField($generate, 'count');
    echo $form->error($generate, 'count');
    ?>
</div>
<div>
    <?php
    echo $form->labelEx($generate, 'due_date');
    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
        'model'=>$generate,
        'attribute'=>'due_date',
        'flat'=>true,//remove to hide the datepicker,
        'options'=>array(
            'showAnim'=>'slide',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
            'dateFormat'=>'yy-mm-dd',
        ),
        'htmlOptions'=>array(
            'style'=>''
        ),
    ));
    ?>
</div>
<div>
    <?php echo CHtml::submitButton('Генерировать', array('class'=>'btn btn-success', 'name'=>'generate'))?>
<!--    --><?php //echo CHtml::submitButton('Генерировать и экспортировать в Excel', array('class'=>'btn btn-success', 'name'=>'generate-n-export'))?>
</div>
<?php $this->endWidget()?>
<hr/>
<div>
    <?php echo CHtml::link('Создать сертификат', Yii::app()->createUrl('backend/order/certificate/create', array('language'=>Yii::app()->language)), array('class'=>'btn btn-primary'))?>
</div>
<?php echo CHtml::link('Експорт выбраных сертификатов в формат Excel', Yii::app()->createUrl('backend/order/certificate/export', !empty($_GET['Certificate']) ? array_filter($_GET['Certificate'], function($val){return !empty($val);}) : array()), array('class'=>'export-cer'))?>
<div class="text-right">
    <a class="btn" href="/backend/order/certificate/admin">Сбросить фильтры</a>
</div>
<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'certificate-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'ajaxUpdate'=>false,
    'enableSorting'=>false,
	'columns'=>array(
		'code',
		array(
            'name'=>'id_order',
            'value'=>'$data->id_order ? CHtml::link($data->id_order, Yii::app()->createUrl("backend/order/order/update", array("id"=>$data->id_order))) : "-"',
            'type'=>'html',
        ),
		'create_date',
		'due_date',
        array(
            'header'=>'Статус',
            'value'=>'$data->getStatus($data)',
            'filter'=>CHtml::activeDropDownList($model, 'status', array(
                    'new'=>'Новый',
                    'used'=>'Использован',
                    'overdue'=>'Прострочен',
                ), array('prompt'=>'Все')),
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{delete}',
            'buttons'=>array(
                'update'=>array(
                    'url'=>'Yii::app()->createUrl("backend/order/certificate/update", array("id"=>$data->id))',
                ),
                'delete'=>array(
                    'url'=>'Yii::app()->createUrl("backend/order/certificate/delete", array("id"=>$data->id))'
                ),
            ),
		),
	),
));
?>
