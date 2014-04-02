<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 04.02.14
 * Time: 16:23
 */
class SliderWidget extends CWidget {
    public $model;

    public function init() {
//        Yii::app()->clientScript->registerScriptFile('/js_plugins/carouFredSel/jquery.carouFredSel-6.2.1-packed.js');
//        Yii::import('application.backend.modules.slider.models.*');
    }

    public function run() {
        $this->render('sliderWidget', array('model'=>$this->model));
    }
}