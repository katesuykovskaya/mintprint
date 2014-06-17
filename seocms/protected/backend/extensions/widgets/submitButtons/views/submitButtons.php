<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lesha
 * Date: 06.06.13
 * Time: 16:03
 * To change this template use File | Settings | File Templates.
 */
?>

    <div class="btn-group">
<?php
    foreach($buttons as $button=>$values)
        if(isset($values['visible']) ? $values['visible'] : false)
            echo CHtml::submitButton($values['value'],$values['htmlOptions']);
?>
        </div>