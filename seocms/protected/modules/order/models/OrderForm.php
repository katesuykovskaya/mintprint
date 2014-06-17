<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 12.06.14
 * Time: 12:32
 */
class OrderForm extends CFormModel {
    public $name;
    public $phone;
    public $address;
    public $city;
    public $region;
    public $index;
    public $newPostAddress;
    public $agree;
    public $email;
    public $sign;
    public $delivery;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('name, phone, address, city, region, email', 'required'),
            array('agree', 'required', 'message'=>'Вы должны сонласиться с правилами сервиса!'),
            array('email', 'email'),
            array('newPostAddress', 'length', 'max'=>255, 'allowEmpty'=>true),
            array('delivery', 'in', 'range'=>array('newPost', 'post')),
            array('name, city, region', 'match', 'pattern'=>'/^[a-zA-Z\s]+$/', 'message'=>'Только буквы!'),
            // rememberMe needs to be a boolean
            // password needs to be authenticated
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'email'     =>  Yii::t('frontend', 'Электронная почта'),
            'name'      =>  Yii::t('frontend', 'Имя и Фамилия'),
            'phone'     =>  Yii::t('frontend', 'Телефон'),
            'address'   =>  Yii::t('frontend', 'Адрес доставки'),
            'city'      =>  Yii::t('frontend', 'Город'),
            'region'    =>  Yii::t('frontend', 'Область'),
            'newPostAddress'=> Yii::t('frontend', 'Ближайшее отделение Новой Почты'),
            'index'     =>  Yii::t('frontend', 'Индекс'),
            'delivery'  =>  Yii::t('frontend', 'Доставка'),
        );
    }
}