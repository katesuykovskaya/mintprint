<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lesha
 * Date: 13.08.13
 * Time: 17:10
 * To change this template use File | Settings | File Templates.
 */

class mailOrPhone extends CValidator
{

    /**
     * Validates a single attribute.
     * This method should be overridden by child classes.
     * @param CModel $object the data object being validated
     * @param string $attribute the name of the attribute to be validated.
     */
    protected function validateAttribute($object, $attribute)
    {

        $opposite = $attribute === 'sender_mail' ? 'phone' : 'sender_mail';
            if($object->{$attribute} === '' && $object->{$opposite} === ''){
            $value=$object->$attribute;
            if($value === '')
                $this->addError($object,$attribute,Yii::t('frontend',"Вы должны заполнить поле email или телефон!"));
        }
    }

    public function clientValidateAttribute($object,$attribute)
    {
        $opposite = $attribute === 'sender_mail' ? 'phone' : 'sender_mail';

        return "
            var opposite = document.getElementById('Feedback_".$opposite."');
            var elem = document.getElementById('Feedback_".$attribute."');
            if(elem.value ==='' && opposite.value ==='') {
                messages.push(".CJSON::encode(Yii::t('frontend','Вы должны заполнить поле email или телефон!')).");
            } else {
            var oppositeErr = document.getElementById('Feedback_".$opposite."_em_');
            var elemErr = document.getElementById('Feedback_".$attribute."_em_');
                $(oppositeErr).hide();
                $(opposite).parent('div').removeClass('error');
            }
            ";

    }
}