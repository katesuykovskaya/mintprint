<?php

class OrderController extends Controller
{
    public function actionCreate() {
        $model = new OrderHead;
        $model->attributes = Yii::app()->session['OrderHead'];
        if($model->save(false))
            die(json_encode(array('id_order'=>$model->id)));
    }

    function save_image($inPath,$outPath)
    { //Download images from remote server
        $in=    fopen($inPath, "rb");
        $out=   fopen($outPath, "wb");
        while ($chunk = fread($in,8192))
        {
            fwrite($out, $chunk, 8192);
        }
        fclose($in);
        fclose($out);
    }

    public function actionSave() {
        Yii::import('application.backend.components.ZHtml');
        $img = 'http://scontent-b.cdninstagram.com/hphotos-xpf1/t51.2885-15/10358204_1487823968114526_412982456_n.jpg';
        $content = file_get_contents($img);
        $tempPath = Yii::getPathOfAlias('webroot')."/uploads/tmp/".ZHtml::randomString(32).".jpg";
        $fp = fopen($tempPath, "w");
        fwrite($fp, $content);
        fclose($fp);
        echo Yii::app()->easyImage->thumbOf($tempPath, array(
            "savePath"=>Yii::getPathOfAlias("webroot")."/uploads/",
            "save"=>ZHtml::randomString(32),
            "quality" => 80,
            'crop'=>array(
                'width'=>200,
                'height'=>200,
                'offset_x'=> 50,
                'offset_y'=>30
            ),
        ));
        unlink($tempPath);
//        $image = new EasyImage($img);
//        $image->resize(100, 100);
//        $image->save(Yii::getPathOfAlias("webroot").'/uploads/1.jpg');

    }
}