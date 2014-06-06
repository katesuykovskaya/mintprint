<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Manage Users')?></li>
    </ul>
</div>

<h3 class="page-header"><?php echo Yii::t('backend','Manage Users');?></h3>

<div id='message'>

</div>

<?php echo CHtml::link(Yii::t('backend','Create user'),$this->createUrl('/backend/users/users/create',array('language'=>Yii::app()->language)),array('class'=>'btn btn-info'));?>

<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'type'=>'striped bordered',
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
            array(
                'header'=>Yii::t('backend','id'),
                'name'=>'user_id',
            ),
            array(
                'header'=>Yii::t('backend','Логин'),
                'name'=>'login',
            ),
            array(
                'header'=>Yii::t('backend','Почтовый адрес'),
                'name'=>'email',
            ),
            array(
                'header'=>Yii::t('backend','Дата регистрации'),
                'name'=>'reg_date',
            ),

            array(
                'header'=>Yii::t('backend','Дата последнего посещения'),
                'name'=>'last_login',
                'value'=>'$data->last_login',
            ),

            array(
                'header'=>Yii::t('backend','Статус'),
                'name'=>'status',
                'type'=>'raw',
                'value'=>function($data){ return $data->online ? '<span class="label label-success">'.Yii::t('backend','Онлайн').'</span>' : '<span class="label label-important">'.Yii::t('backend','Оффлайн').'</span>';},
            ),

            array(
                'header'=>Yii::t('backend','Дата последней активности'),
                'name'=>'last_action_time',
            ),
            array(
                'header'=>Yii::t('backend','Кол-во входов'),
                'name'=>'login_numbs',
            ),
            array(
                'header'=>Yii::t('backend','Роль'),
                'type'=>'raw',
                'value'=> '$data->getRole($data->user_id)',
            ),
            array(
                'name'=>'active',
                'class'=>'bootstrap.widgets.TbToggleColumn',
                'toggleAction'=>'users/users/deactivate',
                'uncheckedButtonLabel'=>'Активировать пользователя',
                'checkedButtonLabel'=>'Деактивировать пользователя',
                'checkedIcon'=>'icon-ok',
                'uncheckedIcon'=>'icon-remove',
            ),
            array(
                'name'=>'user_id',
                'header'=>"REпароль",
                'type'=>'raw',
                'value'=>'CHtml::link("<i class=icon-refresh></i>",Yii::app()->urlManager->createUrl("/backend/users/users/renewpassword",array("user"=>$data->user_id,"language"=>Yii::app()->language)),array(
                        "ajax"=>array(
                        "type"=>"post",
                        "url"=>Yii::app()->urlManager->createUrl("/backend/users/users/renewpassword",array("user"=>$data->user_id,"language"=>Yii::app()->language)),
                        "update"=>"#message",
                    )))',
            ),
		array(
            'header'=>Yii::t('backend','Операции'),
			'class'=>'CButtonColumn',
            'headerHtmlOptions'=>array('style'=>'width: 7%; text-align:center;'),
            'template'=>'{update}{delete}{view}',
            'updateButtonUrl'=>'Yii::app()->urlManager->createUrl("users/users/update",array("id"=>$data->user_id,"language"=>Yii::app()->language))',
            'viewButtonUrl'=>'Yii::app()->urlManager->createUrl("users/users/view",array("id"=>$data->user_id,"language"=>Yii::app()->language))',
            'deleteButtonUrl'=>'"delete/id/".$data->user_id',
            'buttons'=>array(
                'delete'=>array(
                    ),
                ),
		    ),
	),
));
