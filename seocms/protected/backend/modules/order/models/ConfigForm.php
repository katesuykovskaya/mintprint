<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ConfigForm extends CFormModel
{
    public $price;
    public $currency;


    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('price, currency', 'required'),
            array('price','numerical'),
        );
    }


    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'price'=>Yii::t('backend','Цена'),
            'currency'=>Yii::t('backend','Валюта')
        );
    }
}
