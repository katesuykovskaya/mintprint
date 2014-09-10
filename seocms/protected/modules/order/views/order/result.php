<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 17.06.14
 * Time: 15:02
 * @var $this OrderController
 * @var $model OrderHead
 */
?>
    <p>Ваш заказ № <?=$id?> успешно оформлен.</p>
    <p> Вы получите письмо с номером заказа на  электронный адрес.</p>

<?php if(empty(Yii::app()->session['certificate'])):?>
    <form id="fomfLiqPay" method="POST" accept-charset="utf-8" action="https://www.liqpay.com/api/pay">
        <input type="hidden" name="public_key" value="i42177287461" />
        <input type="hidden" name="amount" value="<?=$amount?>" />
        <input type="hidden" name="currency" value="UAH" />
        <input type="hidden" name="description" value="Оплата за фотографии. Заказ №<?=$id?>" />
        <input type="hidden" name="type" value="buy" />
        <input type="hidden" name="server_url" value="http://mintprint.com.ua/order/orderTemp/confirm"/>
        <input type="hidden" name="result_url" value="http://mintprint.com.ua/?checkorder=<?=$id?>"/>
        <input type="hidden" name="pay_way" value="card" />
        <input type="hidden" name="language" value="ru" />
        <a id="confirm-liqpay" class="print-button" href="#">Оплатить с помощью LiqPay</a>
    </form>
<?php endif;?>