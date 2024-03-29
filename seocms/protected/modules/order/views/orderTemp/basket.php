<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 10.06.14
 * Time: 18:14
 * @var $models array
 * @var $config array
 */
?>
<section class="content">
    <?php if(empty($models)):?>
        <p>Корзина пуста</p>
        <a href="javascript: history.back();">Назад</a>
    <?php else:?>
    <div class="basket-step-1">
            <?php
            $counter = 0;
            foreach($models as $model):
                /**
                 * @var $model OrderTemp
                 */
                $info = $model->cropStyle;
                ?>
                    <div class="basket-single-form" id="orderTemp<?=$model->id?>">
                        <div class="photo-wrap">
                            <?=CHtml::ajaxLink('', Yii::app()->createUrl('order/orderTemp/delete'), array(
                                    'type' => 'post',
                                    'data'=>array(
                                        'OrderTemp[id]'=>$model->id
                                    ),
                                    'success'=>'js: function(data, status){
                                    try {
                                    var result = $.parseJSON(data);
                                    if(result.res) {
                                        $("#orderTemp'.$model->id.'").remove();
                                        $("#totalPrice").text(result.sum);
                                    }
                                    else
                                        alert("Произошла ошибка при удалении");
                                    } catch(e) {}
                                }'
                                ),
                                array(
                                    'live'=>false,
                                    'confirm'=>'Удалить',
                                    'class'=>'remove'
                                )
                            )?>
                            <div class="photo"><?=CHtml::image($info['src'], null, array('style'=>$info['style']))?></div>
                            <p class="capitalize">Фото №<?=++$counter?></p>
                        </div>
                        <form class="img-count-form" action="#" method="post">
                            <input type="text" class="img-count" data-id="<?=$model->id?>" data-url="<?=Yii::app()->createUrl("order/orderTemp/update", array("id"=>$model->id))?>" name="OrderTemp[img_count]" value="<?=$model->img_count?>"/>
                        </form>
                        <p class="single-img-price">
                        <span id="singleImgPrice<?=$model->id?>">
                            <?=$model->img_count * $config['price']?>
                        </span>
                            &nbsp;<?=$config['currency']?></p>
                </div>
            <?php endforeach?>
        <div class="overflow-hidden total-price-wrap">
            <p class="total-word"><?=Yii::t('frontend', 'Итого')?>:</p>
            <p class="total-price"><span id="totalPrice"><?=OrderTemp::CollectPrice($config['price'])?></span>&nbsp;<?=$config['currency']?></p>
        </div>
        <div>
            <a href="#" id="iUseCertificate">Я использую сертификат</a>
            <div class="show-cer-input">
                <p><?=CHtml::label('Введите код из сертификата', 'certificate')?></p>
                <?=CHtml::textField('certificate', '', array('id'=>'certificate'))?>
            </div>
        </div>
        <div class="overflow-hidden">
            <a class="back-button" href="javascript: window.history.go(-1);"><?=Yii::t('frontend', 'Назад')?></a>
            <a href="<?=Yii::app()->createUrl('order/orderTemp/buyerInfo')?>" class="continue-button"><?=Yii::t('frontend', 'Следующий шаг')?><a/>
        </div>
    </div>
    <?php endif; ?>
</section>
<link rel="stylesheet" href="/js/vendor/fancybox/jquery.fancybox-1.3.4.css"/>
<script type="text/javascript" src="/js/vendor/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script>
    $(document).ready(function(){
        $(document).on('click', '#iUseCertificate', function(e){
            e.preventDefault();
            $('.show-cer-input').show('slow');
        });
        $(document).on('click', '.continue-button:not(.disabled)', function(e){
//        $(document).on('submit', '#certificate-form', function(e){
            e.preventDefault();
            var _this = $(this);
            _this.addClass('disabled');
            if($('#certificate').val()) {
                $.ajax({
                    type: "post",
                    url: "/order/orderTemp/checkCertificate",
                    data: { code: $('#certificate').val() },
                    success: function(response) {
                        try {
                            var res = $.parseJSON(response);
                            if(res.res) {
                                var form = $('<form>')
                                    .css('display', 'none')
                                    .attr('method', 'post')
                                    .attr('action', _this.attr('href'))
                                    .append($('#certificate').clone());
                                $('body').append(form);
                                form.submit();
                            }
                            else
                                $.fancybox({
                                    content: '<p class="basket-warning">'+res.reason+'</p>',
                                    onClosed: fancyClose
                                });
                        }
                        catch(e) {

                        }
                    }
                });
            } else {
                $.ajax({
                    type: "post",
                    url: "/order/orderTemp/count",
                    success: function(response) {
                        _this.removeClass('disabled');
                        if(parseInt(response) == 1)
                            //location.href = _this.attr('href');
                            _this.trigger('click');
                        else {
                            $.fancybox({
                                content: '<p class="basket-warning">просьба пересмотреть Ваш заказ. Минимальный заказ 20 грн. Если Вы используете сертификат, укажите код из сертификата.</a></p>',
                                onClosed: fancyClose
                            });
                        }
                    }
                });
            }

        });
        $(document).on('change', '.img-count', function(e){
            e.preventDefault();
            $('.continue-button').addClass('disabled');
            changeCount($(this));
        });

        $(document).on('submit', '.img-count-form', function(e){
            e.preventDefault();
            $('.continue-button').addClass('disabled');
            changeCount($(this).find('.img-count').eq(0));
        });

        function fancyClose()
        {
            $('.continue-button').removeClass('disabled');
        }

        function changeCount(_this) {
            var form = _this.closest('form');
            var url = _this.data('url');
            var id = _this.data('id');
            $('#singleImgPrice'+id).html('<span class="price-loader"></span>');
            $('#totalPrice').html('<span class="price-loader"></span>');
            $.ajax({
                type: 'post',
                url: url,
                data: form.serialize(),
                success: function(response) {
                    $('.continue-button').removeClass('disabled');
                    try {
                        var result = $.parseJSON(response);
                        if(result.res) {
                            $('#singleImgPrice'+id).text(result.singleSum);
                            $('#totalPrice').text(result.total);
                        }
                    }
                    catch (e) {

                    }
                }
            });
        }
    });
</script>
