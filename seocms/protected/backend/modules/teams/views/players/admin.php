<?php
/* @var $this PlayersController */
/* @var $model Player */
Yii::app()->clientScript->registerCssFile('/css/backend.css');
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Управление Игроками')?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend', 'Управление Игроками')?></h3>

<div style="margin-bottom:40px;">
    <?php echo CHtml::link(Yii::t('backend','Создать игрока'),$this->createUrl('backend/teams/players/create',['language'=>Yii::app()->language]),['class'=>'btn btn-success'])?>
    <?php Yii::import('application.backend.modules.teams.models.*')?>
    <?php echo CHtml::link(Yii::t('backend', 'Сбросить фильтры'), Yii::app()->request->requestUri, ['class'=>'pull-right btn btn-primary'])?>
</div>
<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'player-grid',
    'type'=>'striped bordered',
	'dataProvider'=>$model->search(),
    'enableSorting' => false,
    'htmlOptions'=>[ 'class'=>'clearfix' ],
	'filter'=>$model,
	'columns'=>array(
		array(
            'name'=>'id',
            'filter'=>false
        ),
//		'fio',
        array(
            'name'=>'translation.t_fio',
            'value'=>'$data->translation[Yii::app()->language]->t_fio',
            'htmlOptions'=>array(
                'class'=>'span6'
            )
        ),
        array(
            'name'=>'translation.t_country',
            'value'=>'$data->translation[Yii::app()->language]->t_country',
            'htmlOptions'=>array(
                'class'=>'span2'
            )
//            'filer'=>
        ),
//        array(
//            'name'=>'translation.t_language',
//            'value'=>'$data->translation[Yii::app()->language]->t_language',
//            'filter'=>CHtml::dropDownList(
//                'Player[language_search]',
//                Yii::app()->language,
//                Player::getLangDropdown()
//            )
//        ),
//		'country',
		array(
            'name'=>'birth_date',
            'value'=>'Yii::app()->dateFormatter->format("dd-MM-yyyy","$data->birth_date")',
            'filter'=>false
        ),
		array(
            'name'=>'player_role',
            'filter'=>ZHtml::enumDropDownList($model,'player_role',array('class'=>'form-control input-sm lowercase', 'prompt'=>Yii::t('backend', 'Все'))),
            'htmlOptions'=>array(
                'class'=>'lowercase'
            )
        ),
        array(
            'name'=>'team_player.team_id',
            'value'=>'!empty($data->team_player) ? Chtml::link(
            $data->team_player->team_id,
                    Yii::app()->controller->createUrl("teams/teams/update", array(
                        "id"=>$data->team_player->team_id
                    )
                )
        ): " "',
            'filter'=>CHtml::dropDownList(
                'Player[team_search]', $model->team_search,
//                array(''=>'Все', 'u-18'=>'u-18', 'u-19'=>'u-19'),
                CHtml::listData(Team::model()->findAll(), 'id', 'id'),
                [
//                    'prompt'=>Yii::t('backend', 'Выберите команду'),
                    'empty'=>Yii::t('backend', 'Все'),
//                    )
                ]
            ),
            'type'=>'html',
//            'htmlOptions'=>array(
//                'width'=>'100px',
//            )
        ),
		array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
            'buttons'=>array(
                'update'=>array(
                    'url'=>'Yii::app()->controller->createUrl("backend/teams/players/update",array("id"=>$data->id, "language"=>Yii::app()->language))',
                ),
                'delete'=>array(
                    'url'=>'Yii::app()->controller->createUrl("backend/teams/players/delete",array("id"=>$data->id, "language"=>Yii::app()->language))',
                ),
            ),
		),
	),
)); ?>
<?php //echo CHtml::ajaxSubmitButton('Filter',array('menu/ajaxupdate'), array(),array("style"=>"display:none;")); ?>
