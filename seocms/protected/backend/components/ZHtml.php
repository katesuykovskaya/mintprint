<?php
//
//  created for getting enum dropdownlist to use on creating & updating models

class ZHtml extends CHtml
{
    public static function enumDropDownList($model, $attribute, $htmlOptions=array())
    {
      return CHtml::activeDropDownList( $model, $attribute, self::enumItem($model,  $attribute), $htmlOptions);
    }
 
    public static function enumItem($model,$attribute) {
        $attr=$attribute;
        self::resolveName($model,$attr);
        preg_match('/\((.*)\)/',$model->tableSchema->columns[$attr]->dbType,$matches);
        foreach(explode(',', $matches[1]) as $value) {
                $value=str_replace("'",null,$value);
                $values[$value]=Yii::t('backend',$value);
        }
        return $values;
    }

    public static function thumbnail($file, $params = array(), $htmlOptions = array()) {
        try {
            if(empty($file)) throw new CException('empty');
            if(!is_file($file)) throw new CException('no file');
            $image = Yii::app()->easyImage->thumbOf($file, $params, $htmlOptions);
            return $image;
        }
        catch(CException $e) {
            $file = Yii::getPathOfAlias('webroot').'/img/no-image.gif';
            return Yii::app()->easyImage->thumbOf($file, array(
                "resize" => array("width"=>100,"master"=>EasyImage::RESIZE_WIDTH),
                "savePath"=>"/img/",
                "quality" => 80,
            ));
        }
    }

    public static function randomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public static function randomNumber($length = 8)
    {
        $characters = '0123456789';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

//    public static function deleteDir($dir) {
//        $files = glob($dir."/*");
//        $c = count($files);
//        if (count($files) > 0) {
//            foreach ($files as $file) {
//                if (file_exists($file)) {
//                    unlink($file);
//                }
//            }
//        }
//
//        rmdir($dir);
//    }

    static function deleteDir($dir) {
        if (!is_dir($dir) || is_link($dir)) return unlink($dir);
        foreach (scandir($dir) as $file) {
            if ($file == '.' || $file == '..') continue;
            if (!self::deleteDir($dir . DIRECTORY_SEPARATOR . $file)) {
                chmod($dir . DIRECTORY_SEPARATOR . $file, 0777);
                if (!self::deleteDir($dir . DIRECTORY_SEPARATOR . $file)) return false;
            };
        }
        return rmdir($dir);
    }
}


