<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 17.06.14
 * Time: 15:03
 * @var $this OrderController
 * @var $model OrderHead
 */
?>
<p>Ваш заказ - №<?=$model->id?>:</p>
<table border="1">
    <tr>
        <td><?=CHtml::activeLabel($orderFormModel, 'name')?></td>
        <td><?=$model['name']?></td>
    </tr>
    <tr>
        <td><?=CHtml::activeLabel($orderFormModel, 'email')?></td>
        <td><?=$model['email']?></td>
    </tr>
    <tr>
        <td><?=CHtml::activeLabel($orderFormModel, 'phone')?></td>
        <td><?=$model['phone']?></td>
    </tr>
    <tr>
        <td><?=CHtml::activeLabel($orderFormModel, 'delivery')?></td>
        <td><?=Yii::t('frontend', $model['delivery'])?></td>
    </tr>
    <tr>
        <td><?=CHtml::activeLabel($orderFormModel, 'address')?></td>
        <td><?=$model['address']?></td>
    </tr>
    <tr>
        <td><?=CHtml::activeLabel($orderFormModel, 'city')?></td>
        <td><?=$model['city']?></td>
    </tr>
    <tr>
        <td><?=CHtml::activeLabel($orderFormModel, 'region')?></td>
        <td><?=$model['region']?></td>
    </tr>
<!--    <tr>-->
<!--        <td>--><?//=CHtml::activeLabel($orderFormModel, $model['delivery'] == 'newPost' ? 'newPostAddress' : 'index')?><!--</td>-->
<!--        <td>--><?//=$model['delivery'] == 'newPost' ? $model['newPostAddress'] : $model['index']?><!--</td>-->
<!--    </tr>-->
    <tr>
        <td><?=CHtml::activeLabel($model, 'photoCount')?></td>
        <td><?=$model->count?></td>
    </tr>
</table>
<p>Сумма: <strong><?=$model->price?>&nbsp;<?=$config['currency']?></strong></p>