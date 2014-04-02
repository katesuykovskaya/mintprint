<?php
/* @var $this PlayersController */
/* @var $model Player */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'player-form',
        'enableAjaxValidation'=>false,
    )); ?>

    <p class="note"><?=Yii::t('backend','Поля отмеченные <span class="required">*</span> обязательны.')?></p>

    <?php echo $form->errorSummary($model); ?>

    <?php $this->widget('bootstrap.widgets.TbTabs', array(
        'type'=>'tabs', // 'tabs' or 'pills'
        'tabs'=>
        $this->tabsArray($model,$param = false),
    ));
    echo '<hr />';
    ?>

    <div >
        <?php echo $form->labelEx($model,'birth_date'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'value'=>$model->birth_date,
            'name'=>'Player[birth_date]',
            'language'=>Yii::app()->language,
            'htmlOptions'=>array(
            ),
            'options' =>array(
                'dateFormat'=>'yy-mm-dd',
                'changeYear'=>true,
                'showAnim'=>'slide',
            )
        ));

        ?>
        <?php echo $form->error($model,'birth_date'); ?>
    </div>

    <div >
        <?php echo $form->labelEx($model,'player_role'); ?>
        <?php echo ZHtml::enumDropDownList($model,'player_role',array('class'=>'form-control input-sm'))?>
        <?php echo $form->error($model,'player_role'); ?>
    </div>
    <div>
        <?php echo CHtml::label(Yii::t('backend', 'Команда'), 'teamId')?>
        <?php
        isset($model->team_player) ? $team = $model->team_player : $team = "";
        echo CHtml::dropDownList('Player[team_id]', $team,  CHtml::listData($modelTeam, 'id', 'id'), array('id'=>'teamId', 'prompt'=>Yii::t('backend', 'Выберите команду')))
        ?>
    </div>

    <div class="buttons span4">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('backend','Создать') : Yii::t('backend','Сохранить'),array('class'=>'btn btn-default btn-lg btn-block')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->