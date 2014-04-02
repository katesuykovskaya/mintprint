<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 13.02.14
 * Time: 10:40
 */

class Document extends CFormModel
{
    public $file;

    public function rules()
    {
        return array(
            array('file', 'file', 'allowEmpty'=>true,'types'=>'doc, xls, xlsx, pdf, txt, djvu, rtf','maxSize'=>10240),
        );
    }
}