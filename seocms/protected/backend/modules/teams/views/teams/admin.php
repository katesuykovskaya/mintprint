<?php
/* @var $this TeamsController */
/* @var $model Team */
?>
<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Администрирование команд')?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend', 'Администрирование команд')?></h3>
<div class="span10 clearfix">
    <?php echo CHtml::link(Yii::t('backend','Создать команду'),
    $this->createUrl('backend/teams/teams/create',['language'=>Yii::app()->language]),['class'=>'btn btn-success','style'=>'margin-bottom:40px;'])?>
</div>
<div>
<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
'id'=>'team-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'enableSorting' => false,
    'type'=>'striped bordered',
    'htmlOptions'=>['class'=>'span10 clearfix'],
	'columns'=>array(
        array(
            'name'=>'photo',
            'value'=>'$data->photo ? Yii::app()->easyImage->thumbOf(Yii::getPathOfAlias("webroot")."/uploads/Team/".$data->id."/".$data->photo,
                array(
                    "resize" => array("width" => 100,"master"=>EasyImage::RESIZE_WIDTH),
                    "savePath"=>"/uploads/Team/".$data->id."/",
                    "quality" => 80,
                )) : " "',
            'type'=>'html',
            'filter'=>false,
            'htmlOptions'=>array('class'=>'span2 text-center')
        ),
        array(
            'class'=>'bootstrap.widgets.TbRelationalColumn',
            'name' => 'id',//Yii::t("backend","Все игроки"),
            'url' => $this->createUrl('teams/teams/relational'),
//            'htmlOptions'=>array('class'=>'span4')
        ),
        array(
            'name'=>'season',
            'header'=>'Начало сезона'
//            'value'=>'$data->season." - ".($data->season+1)'
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
            'header'=>Yii::t('backend', 'Действия'),
            'buttons'=>array(
                'update'=>array(
                    'url'=>'Yii::app()->controller->createUrl("teams/teams/update",array("id"=>$data->id))',
                ),
                'delete'=>array(
                    'url'=>'Yii::app()->controller->createUrl("teams/teams/delete",array("id"=>$data->id))',
                ),
            ),
//            'htmlOptions'=>array('class'=>'span1')
		),
	),
));
    ?>
    </div>
<?php Yii::app()->clientScript->registerCssFile($baseUrl.'/css/backend.css', CClientScript::POS_HEAD);
?>
