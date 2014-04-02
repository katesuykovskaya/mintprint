<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 06.02.14
 * Time: 16:26
 */

class VideoWidget extends CWidget {
    public $model;

    public function run() {
        $this->render('videoWidget', array(
            'model'=>$this->model
        ));
    }
} 