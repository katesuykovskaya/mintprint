<?php
/* @var $this OrderTempController */
/* @var $model OrderTemp */
Yii::app()->clientScript->registerScriptFile('/js_plugins/cropper/cropper.js');
Yii::app()->clientScript->registerCssFile('/js_plugins/cropper/cropper.css');
?>
<section class="content">
    <div class="edit-image">
        <?=CHtml::image($model->img_url, '', array(
            'class'=>'cropper'
        ))?>
    </div>
    <div class="row">
        <button class="print-button" id="saveAndCrop">Продолжить</button><span class="loader"></span>
    </div>
</section>


<script>
    $(document).ready(function(){
        $('.cropper').cropper({
            aspectRatio: 1,
            data: {
                x1: <?=$model->img_x?>,
                y1: <?=$model->img_y?>,
                width: <?=$model->img_width?>,
                height: <?=$model->img_height?>
            }
        });

        $(document).on('click', '#saveAndCrop', function(e){
            e.preventDefault();

            var data = $('.cropper').cropper("getData");
            var loader = $(this).next();
            loader.css('display', 'inline-block');

            var originalWidth = $('.cropper-container > img')[0].naturalWidth;

            $.ajax({
                url: '<?=Yii::app()->createUrl("order/orderTemp/update", array("id"=>$model->id))?>',
                type: 'post',
                data: {
                    'OrderTemp[img_width]': data.width,
                    'OrderTemp[img_height]': data.height,
                    'OrderTemp[img_x]': data.x1,
                    'OrderTemp[img_y]': data.y1,
                    'OrderTemp[original_width]': originalWidth
                },
                success: function(response) {
                    loader.css('display', 'none');
                    location.href= "<?=Yii::app()->urlManager->createUrl('site/index')?>";
                }
            });
        });
    });
</script>