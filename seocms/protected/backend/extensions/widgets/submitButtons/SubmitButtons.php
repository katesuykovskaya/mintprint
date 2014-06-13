<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lesha
 * Date: 06.06.13
 * Time: 15:59
 * To change this template use File | Settings | File Templates.
 */

class SubmitButtons extends CWidget{
    public $_assetsUrl;
    public $widgetAlias = 'application.backend.extensions.widgets.submitButtons.assets';
    public $buttons = array(
        'save'=>array(
            'visible'=>true,
            'value'=>'Сохранить',
                'htmlOptions'=>array(
                    'class'=>'btn',
                    'name'=>'save',
                    'id'=>'save',
                )
        ),
        'confirm'=>array(
            'visible'=>true,
            'value'=>'Confirm',
            'htmlOptions'=>array(
                'class'=>'btn',
                'name'=>'confirm',
                'id'=>'confirm',
            )
        ),
        'cancel'=>array(
            'visible'=>true,
            'value'=>'Cancel',
            'htmlOptions'=>array(
                'class'=>'btn',
                'name'=>'cancel',
                'id'=>'cancel',
            )
        ),
        'delete'=>array(
            'visible'=>true,
            'value'=>'Delete',
            'htmlOptions'=>array(
                'class'=>'btn',
                'name'=>'delete',
                'id'=>'delete',
            )
        ),
    );
    public $form;

    public function getAssetsUrl()
    {
        if ($this->_assetsUrl === null)
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias($this->widgetAlias) );
        return $this->_assetsUrl;
    }

    public function registerAssets() {
        Yii::app()->clientScript->registerScriptFile($this->assetsUrl.'/submitButtons.js');
    }

    public function run()
    {
        $this->registerAssets();
        $this->render('submitButtons',array(
            'buttons'=>$this->buttons,
//            'form'=>$this->form
        ));
    }
}