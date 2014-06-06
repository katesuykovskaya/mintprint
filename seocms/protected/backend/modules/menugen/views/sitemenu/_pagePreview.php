<?php

    if(!empty($model)){

        echo CHtml::label('id','id');
        echo CHtml::textField('id',$model->page_id);echo '<br />';

        echo CHtml::label('t_title','t_title');
        echo CHtml::textField('t_title',$model->translation['t_title']);echo '<br />';

        echo CHtml::label('t_desc','t_desc');
        echo CHtml::textField('t_desc',$model->translation['t_desc']);echo '<br />';

        echo CHtml::link(Yii::t('backend','Edit'),
            $this->createUrl('/backend/pages/pages/update',
            array('id'=>$model->page_id,'language'=>Yii::app()->language)),
            array('class'=>'btn')
        );
    } else {
        echo 'no data received';
    }