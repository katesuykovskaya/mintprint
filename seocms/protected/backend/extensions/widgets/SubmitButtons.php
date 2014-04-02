<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lesha
 * Date: 06.06.13
 * Time: 15:59
 * To change this template use File | Settings | File Templates.
 */

class SubmitButtons extends CWidget{

    public $buttons = array(
        'Save'=>array(
            'visible'=>true,
            'value'=>'Сохранить',
                'htmlOptions'=>array(
                    'class'=>'btn',
                    'name'=>'save',
                    'id'=>'save',
                )
        ),
        'Confirm'=>array(
            'visible'=>true,
            'value'=>'Confirm',
            'htmlOptions'=>array(
                'class'=>'btn',
                'name'=>'confirm',
                'id'=>'confirm',
            )
        ),
        'Cancel'=>array(
            'visible'=>true,
            'value'=>'Cancel',
            'htmlOptions'=>array(
                'class'=>'btn',
                'name'=>'cancel',
                'id'=>'cancel',
            )
        ),
        'Delete'=>array(
            'visible'=>true,
            'value'=>'Delete',
            'htmlOptions'=>array(
                'class'=>'btn',
                'name'=>'delete',
                'id'=>'delete',
            )
        ),
    );

    public function run()
    {
        $this->render('submitButtons',array(
            'buttons'=>$this->buttons,
        ));
    }
}