<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 29.05.14
 * Time: 16:52
 */
Yii::app()->clientScript->registerScriptFile('/js_plugins/cropper/cropper.js');
Yii::app()->clientScript->registerCssFile('/js_plugins/cropper/cropper.css');
?>
<div class="edit-image">
    <img class="cropper" src="/uploads/StaticPages/7/341.jpg"/>
</div>

<script>
    $(document).ready(function(){
        $('.cropper').cropper({
            aspectRatio: 11 / 9
        });
        $(".cropper").cropper("setData", {width: 480, height: 270});
    });
</script>