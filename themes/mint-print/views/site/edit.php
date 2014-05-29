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
<section class="content">
    <div class="edit-image">
        <img class="cropper" src="/uploads/StaticPages/7/341.jpg"/>
    </div>
    <div class="row">
        <button class="print-button" id="data">Продолжить</button>
    </div>
</section>


<script>
    $(document).ready(function(){
        $('.cropper').cropper({
            aspectRatio: 11 / 9
        });
        $('#data').click(function(e){
            console.log($('.cropper').cropper("getData"));
        });
    });
</script>