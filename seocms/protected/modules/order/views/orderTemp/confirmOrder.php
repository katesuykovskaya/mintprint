<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 13.06.14
 * Time: 15:36
 * @var $orderForm OrderForm
 * @var $order array
 */
?>
<section class="content">
    <div class="overflow-hidden">
        <div class="right margin-right-70">
            <h1>MINT PRINT</h1>
            <p class="white-text">ПЕЧАТЬ ФОТОГРАФИИ ИЗ СОЦСЕТЕЙ</p>
        </div>
    </div>
    <div class="blue-stripe"></div>
    <div class="confirm-order relative">
        <h2>Подтверждение заказа</h2>
        <p class="green-open-sans-text">Выбранные фото:</p>
        <div class="overflow-hidden">
            <div id="photos" class="left selected-photos">
                <?php
                $counter = 0;
                $photoCount = 0;
                foreach($photos as $model):
                    $info = $model->cropStyle;
                    $photoCount += $model->img_count;
                    if($counter % 2 == 0):?>
                        <div class="chess-stripe <?=$counter % 4 == 0 ? 'dark' : 'light'?>"></div>
                    <?php endif;?>
                    <div class="confirm-photo-wrap">
                        <div class="photo-wrap">
                            <div class="photo"><?=CHtml::image($info['src'], null, array(
                                    'style' => $info['style'],
                                    'data-id' => $model->id
                                ))?></div>
                            <div class="result" id="res-<?=$model->id?>"></div>
                        </div>
                        <div class="count"><?=$model->img_count?>&nbsp;шт.</div>

                    </div>
                <?php
                if($counter % 2 == 1):?>
                    <div class="clear-float"></div>
                <?php endif;
                $counter++;
                endforeach?>
            </div>
            <div class="right confirm-info">
                <table class="confirm-table">
                    <tr>
                        <td>
                            <?=CHtml::activeLabel($orderForm, 'name')?>
                            <?=CHtml::textField('', $order['name'], array('disabled'=>true))?>
                        </td>
                        <td>
                            <?=CHtml::activeLabel($orderForm, 'email')?>
                            <?=CHtml::textField('', $order['email'], array('disabled'=>true))?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::activeLabel($orderForm, 'phone')?>
                            <?=CHtml::textField('', $order['phone'], array('disabled'=>true))?>
                        </td>
                        <td>
                            <?=CHtml::activeLabel($orderForm, 'delivery')?>
                            <?=CHtml::textField('', Yii::t('frontend', $order['delivery']), array('disabled'=>true))?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::activeLabel($orderForm, 'address')?>
                            <?=CHtml::textField('', $order['address'], array('disabled'=>true))?>
                        </td>
                        <td>
                            <?=CHtml::activeLabel($orderForm, 'city')?>
                            <?=CHtml::textField('', $order['city'], array('disabled'=>true))?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=CHtml::activeLabel($orderForm, 'region')?>
                            <?=CHtml::textField('', $order['region'], array('disabled'=>true))?>
                        </td>
                        <td>
                            <?=CHtml::activeLabel($orderForm, $order['delivery'] == 'newPost' ? 'newPostAddress' : 'index')?>
                            <?=CHtml::textField('', $order['delivery'] == 'newPost' ? $order['newPostAddress'] : $order['index'], array('disabled'=>true))?>
                        </td>
                    </tr>
                </table>
                <p class="green-open-sans-text">Общее колличество: <span class="photo-count"><?=$photoCount.' шт'?></span></p>

            </div>
            <div class="basket-cost final">
                <p class="green-text">Распечатать ваши замечательные фотографии</p>
                <p class="grey-text">будут стоить - </p>
                <div id="priceWrap" class="relative">
                    <span><?=OrderTemp::CollectPrice($config['price'])?></span>
                    <sup><?=$config['currency']?></sup>
                </div>
            </div>
            <?=CHtml::link("Печатать их", '#', array(
                'id' => 'confirm',
                'class' => 'print-button final',
            ))?>
            <span id="message"></span>
        </div>
    </div>
    <div class="clear-float"></div>
</section>
<script type="text/javascript" src="/js_plugins/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="/js_plugins/fancybox/jquery.fancybox-1.3.4.css" />
<script>
    $(document).ready(function(){
        $('#confirm').on('click', function(e){
            e.preventDefault();
            if($(this).hasClass('disabled')) {
                return;
            }
            $(this).addClass('disabled');
            $('#message').text("Идет сохренение вашего заказа....");
            var photos = $('#photos img');
            var counter = 0;
            $.ajax({
                type: 'post',
                url: '/order/order/create',
                success: function(response) {
                    try {
                        var resp = $.parseJSON(response);
                        if(resp.res)
                            SavePhoto(photos.eq(counter));
                    } catch(e) {
                        $('#message').text("Произошла ошибка");
                    }
                }
            });

            function SavePhoto(img) {
//                console.log(img);
                var loader = img.closest('.confirm-photo-wrap').find('.result');
                loader.addClass('result-loading');
                $('#message').text("Идет сохранение фото №"+counter.toString());
                $.ajax({
                    type: 'post',
                    url:"/order/order/savePhoto",
                    data: { id: img.data('id') },
                    success: function(response) {
                        try {
                            var resp = $.parseJSON(response);
                            if(resp.res) {
                                loader.removeClass('result-loading');
                                loader.addClass('result-success');
                                counter++;
                                if(typeof photos[counter] != 'undefined')
                                    SavePhoto(photos.eq(counter));
                                else {
                                    $.fancybox.showActivity();
                                    $.ajax({
                                        url: '/order/order/result/',
                                        success: function(response){
                                            $.fancybox({
                                                content: response,
                                                onClosed: function(){
                                                    location.href="/";
                                                }
                                            });
                                        }
                                    });
                                    $('#message').addClass('success');
                                    $('#message').text('Ваш заказ сохранен');
                                }
                            }
                        } catch(e) {
                            alert('Error with saving single photo');
                        }
                    }
                });
            }
        });
    });


</script>
