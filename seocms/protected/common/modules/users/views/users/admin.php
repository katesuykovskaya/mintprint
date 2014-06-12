<h3 class="page-header"><?php echo Yii::t('backend','Manage Users');?></h3>

<div id='message'>

</div>

<?php echo CHtml::link(Yii::t('backend','Create user'),$this->createUrl('backend/users/users/create',array('language'=>Yii::app()->language)),array('class'=>'btn btn-info'));?>

<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
        'type'=>'striped bordered',
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
//	'filter'=>$model,
	'columns'=>array(
		array(
            'name'=>'user_id',
            'type'=>'raw',
        ),
		'login',
                'email',/*comment must be saved*/
                
                array(
                    'name'=>'reg_date',
                ),

                array(
                    'name'=>'last_login',
                    'value'=>'$data->last_login',
                ),
            
                array(
                    'name'=>'status',
                    'value'=>'$data->online',
                ),

                array(
                    'name'=>'last_action_time',
                ),
                array(
                    'name'=>'login_numbs',
                ),
                array(
                    'header'=>'role',
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
                    'value'=>'CHtml::link("<i class=icon-refresh></i>",Yii::app()->urlManager->createUrl("backend/users/users/renewpassword",array("user"=>$data->user_id,"language"=>Yii::app()->language)),array(
                            "ajax"=>array(
                            "type"=>"post",
                            "url"=>Yii::app()->urlManager->createUrl("backend/users/users/renewpassword",array("user"=>$data->user_id,"language"=>Yii::app()->language)),
                            "update"=>"#message",
                        )))',
                ),
		array(
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
)); ?>
