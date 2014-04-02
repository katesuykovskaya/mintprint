<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 13.02.14
 * Time: 10:40
 */

class Audio extends CFormModel
{
    public $file;

    public function rules()
    {
        return array(
            array('file', 'file', 'allowEmpty'=>true,'types'=>'mp3, wav','maxSize'=>10240),
        );
    }
}