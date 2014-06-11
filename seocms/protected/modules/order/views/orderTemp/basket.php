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
    <div class="basket-step-1">
        <table class="basket-detail">
            <?php foreach($models as $model):
                /**
                 * @var $model OrderTemp
                 */
                ?>
                <tr id="orderTemp<?=$model->id?>">
                    <td><?=CHtml::image($model->thumb_url, '')?></td>
                    <td class="img-count">
                        <form action="#" method="post">
                            <input type="text" class="img-count" data-id="<?=$model->id?>" data-url="<?=Yii::app()->createUrl("order/orderTemp/update", array("id"=>$model->id))?>" name="OrderTemp[img_count]" value="<?=$model->img_count?>"/>
<!--                            <input type="hidden" name="OrderTemp[id]"/>-->
                        </form>
                    </td>
                    <td>
                        <p class="single-img-price">
                        <span id="singleImgPrice<?=$model->id?>">
                            <?=$model->img_count * $config['price']?>
                        </span>
                            &nbsp;<?=$config['currency']?></p>
                    </td>
                    <td>
                        <?=CHtml::ajaxLink(CHtml::image('/img/delete-button.png'), Yii::app()->createUrl('order/orderTemp/delete'), array(
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
                            )
                        )?>
                    </td>
                </tr>
            <?php endforeach?>
        </table>
        <div class="overflow-hidden total-price-wrap">
            <p class="total-word"><?=Yii::t('frontend', 'Итого')?></p>
            <p class="total-price"><span id="totalPrice"><?=OrderTemp::CollectPrice($config['price'])?></span>&nbsp;<?=$config['currency']?></p>
        </div>
        <div class="overflow-hidden">
            <a class="back-button" href="javascript: history.back(); return false;"><?=Yii::t('frontend', 'Назад')?></a>
            <a class="continue-button"><?=Yii::t('frontend', 'Следующий шаг')?></a>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        $(document).on('change', '.img-count', function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            var url = $(this).data('url');
            var id = $(this).data('id');
            $.ajax({
                type: 'post',
                url: url,
                data: form.serialize(),
                success: function(response) {
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
        });
    });
</script>
