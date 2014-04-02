<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 13.02.14
 * Time: 10:40
 */

class Video extends CFormModel
{
    public $file;

    public function rules()
    {
        return array(
            array('file', 'file', 'allowEmpty'=>true, 'types'=>'mpg, mpeg4, mp4, avi, flv','maxSize'=>10240),
        );
    }
}