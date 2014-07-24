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
    public $price;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('name, phone, address, city, region, email, index', 'required'),
            array('agree', 'required', 'message'=>'Вы должны согласиться с правилами сервиса!'),
            array('email', 'email'),
            array('index', 'numerical'),
            array('price', 'moreThen20'),
            array('newPostAddress', 'length', 'max'=>255, 'allowEmpty'=>true),
            array('delivery', 'in', 'range'=>array('newPost', 'post')),
            array('name, city, region', 'match', 'pattern'=>'/^[a-zA-Z\p{Cyrillic}\d\s\-\.]+$/u', 'message'=>'Только буквы, цифры и пробельные символы!'),
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

//    public function indexOnPost($attribute, $params) {
//        if($this->delivery == 'post' && empty($this->index)) $this->addError($attribute, $params['message']);
//        return true;
//    }

    public function moreThen20($attribute, $params) {
        $config = require Yii::getPathOfAlias('application.modules.order.config.config').'.php';
        $sum = OrderTemp::CollectPrice($config['price']);
        if($sum < 20)
            $this->addError('price', 'Минимальная сумма - 20 грн.');
    }
}