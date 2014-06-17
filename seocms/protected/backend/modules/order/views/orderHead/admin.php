<?php
/* @var $this OrderHeadController */
/* @var $model OrderHead */


 $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'order-head-grid',
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
        ),
       'status' => array(
           'value'=>'Yii::t("backend",$data->status)',
           'name'=>'status',
           'filter'=>CHtml::activeDropDownList($model,'status', array('new'=>Yii::t("backend","new"),'ready'=>Yii::t("backend","ready"),'shipped'=>Yii::t("backend","shipped"),'delete'=>Yii::t("backend","delete")),array('prompt'=>Yii::t('backend','Выберите статус'))),
        ),
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
                    'url' => 'Yii::app()->createUrl("backend/order/orderHead/update", array("id"=>$data->id))',
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("backend/order/orderHead/delete", array("id"=>$data->id))',
                ),
            ),
		),
	),
)); ?>
