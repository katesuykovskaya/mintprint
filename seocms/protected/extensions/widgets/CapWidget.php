<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kate
 * Date: 23.01.14
 * Time: 9:54
 * To change this template use File | Settings | File Templates.
 */
class CapWidget extends CWidget {
    public $model;
    public $mainUrl;
    public $switchlangParams = array('from'=>'url');

    public function init() {
        $client = Yii::app()->clientScript;
        $client->registerCssFile('/css/cap.css');
        $client->registerCssFile('/css/bootstrap-select.min.css');
        $client->registerCoreScript('jquery');
        $client->registerScriptFile('/js/vendor/jquery.carouFredSel-6.2.1-packed.js');
    }
    public function run() {
//        $url = Yii::app()->language == Yii::app()->sourceLanguage ? '/main.html' : '/'.Yii::app()->language.'/main.html';
        $this->render('capWidget', array('model'=>$this->model, 'url'=>$this->mainUrl));
    }
}