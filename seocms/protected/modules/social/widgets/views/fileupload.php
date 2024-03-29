<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 30.05.14
 * Time: 15:38
 */
$this->widget('ext.EAjaxUpload.EAjaxUpload',
    array(
        'id'=>'uploadFile',
        'config'=>array(
            'action'=>Yii::app()->createUrl('site/upload'),
            'allowedExtensions'=>array("jpg","jpeg","gif","png"),//array("jpg","jpeg","gif","exe","mov" and etc...
            'sizeLimit' => 100 * 9216 * 1024 + 1,
            'minSizeLimit' => 1*1024,
            'auto'=>true,
            'multiple' => true,
            'onComplete'=>"js:function(id, fileName, responseJSON)
            {
                ajaxLoadPhoto(responseJSON.originalPath, responseJSON.iconPath, responseJSON.id, responseJSON.sum);
            }",
            'messages'=>array(
                'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                'emptyError'=>"{file} is empty, please select files again without it.",
                'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
            ),
            'showMessage'=>"js:function(message){ alert(message); }"
        )

    ));
?>