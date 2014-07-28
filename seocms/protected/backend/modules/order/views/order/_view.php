<?php
/* @var $this OrderHeadController */
/* @var $data OrderHead */
?>
<li>
    <form method="post">
        <?=CHtml::hiddenField('date', $data->date)?>
        <?=CHtml::submitButton($data->date.' ('.$data->photoCount.' заказ(ов))', array('name'=>'download', 'class'=>'link'))?>
    </form>
</li>
