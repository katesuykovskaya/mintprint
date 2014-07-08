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
<?

 $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'order-head-grid',
     'type'=>'striped bordered',
     'enableSorting'=>false,
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'email',
		'phone',
		'address',
		'city',
        'photoCount'=>array(
          'value'=>'$data->count?$data->count:""',
          'name'=>'photoCount',
        ),
        'price' => array(
            'value'=>'$data->price." грн"',
            'name'  => 'photoCount',
            'header'=> CHtml::encode($model->getAttributeLabel('price')),
            'filter'=> CHtml::activeTextField($model, 'price'),
//            'sort'=>false
        ),
       'status' => array(
           'value'=>'Yii::t("backend",$data->status)',
           'name'=>'status',
           'filter'=>CHtml::activeDropDownList($model,'status', array('new'=>Yii::t("backend","new"),'ready'=>Yii::t("backend","ready"),'shipped'=>Yii::t("backend","shipped"),'delete'=>Yii::t("backend","delete")),array('prompt'=>Yii::t('backend','Выберите статус'))),
        ),
        'date',
		/*
		'region',
		'delivery',
		'newPostAddress',
		'sign',
		'price',
		*/
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
)); ?>
