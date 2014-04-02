<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 07.02.14
 * Time: 14:19
 */
class PhotoWidget extends CWidget {
    public $model;
    public function init() {
        $this->render('photoWidget', array('model'=>$this->model));
    }
}