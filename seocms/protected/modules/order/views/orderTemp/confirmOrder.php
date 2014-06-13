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
    </table>
</section>
