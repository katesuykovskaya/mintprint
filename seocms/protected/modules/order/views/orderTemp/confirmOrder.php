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
    <h1>Подтвердите заказ</h1>
    <table class="confirm-table">
        <tr>
            <td><?=CHtml::activeLabel($orderForm, 'name')?></td>
            <td><?=$order['name']?></td>
        </tr>
        <tr>
            <td><?=CHtml::activeLabel($orderForm, 'phone')?></td>
            <td><?=$order['phone']?></td>
        </tr>
        <tr>
            <td><?=CHtml::activeLabel($orderForm, 'email')?></td>
            <td><?=$order['email']?></td>
        </tr>
        <tr>
            <td><?=CHtml::activeLabel($orderForm, 'delivery')?></td>
            <td><?=Yii::t('frontend', $order['delivery'])?></td>
        </tr>
        <tr>
            <td><?=CHtml::activeLabel($orderForm, 'address')?></td>
            <td><?=$order['address']?></td>
        </tr>
        <tr>
            <td><?=CHtml::activeLabel($orderForm, 'city')?></td>
            <td><?=$order['city']?></td>
        </tr>
        <tr>
            <td><?=CHtml::activeLabel($orderForm, 'region')?></td>
            <td><?=$order['region']?></td>
        </tr>
        <tr>
            <td><?=CHtml::activeLabel($orderForm, $order['delivery'] == 'newPost' ? 'newPostAddress' : 'index')?></td>
            <td><?=$order['delivery'] == 'newPost' ? $order['newPostAddress'] : $order['index']?></td>
        </tr>
    </table>

    <h2>Ваши фотографии</h2>
    <div class="confirm-all-photos">
        <?php foreach($photos as $model):
            $info = $model->cropStyle;
            ?>
            <div id="photos" class="confirm-photo-wrap">
                <div class="photo"><?=CHtml::image($info['src'], null, array(
                        'style' => $info['style'],
                        'data-id' => $model->id
                    ))?></div>
                <div class="result" id="res-<?=$model->id?>"></div>
                <p class="capitalize">Фото №<?=++$counter?></p>
            </div>
        <?php endforeach?>
    </div>
    <div class="buttons">
        <?=CHtml::link("Подтвердить", '#', array(
            'id' => 'confirm',
            'class' => 'continue-button',
        ))?>
        <span id="message"></span>
    </div>
</section>
<script>
    $(document).ready(function(){
        $('#confirm').on('click', function(e){
            $('#message').text("Идет сохренение вашего заказа....");
            e.preventDefault();
            var photos = $('#photos img');
            var counter = 0;
            $.ajax({
                type: 'post',
                url: '/order/order/create',
                success: function(response) {
                    try {
                        var resp = $.parseJSON(response);
                        var idOrder = resp.id;
                        SavePhoto(photos.eq(counter));

                    } catch(e) {
                        $('#message').text("Произошла ошибка");
                    }
                }
            });

            function SavePhoto(img) {
                $.ajax({

                });
            }
        });
    });


</script>
