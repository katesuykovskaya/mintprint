<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 12.06.14
 * Time: 11:36
 */
class CreateAccountForm extends CFormModel
{
    public $email;
    public $password;
    public $password2;
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('email, password, password2', 'required'),
            array('email', 'email'),
            array('password2','passwords'),
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
            'email'=>Yii::t('frontend', 'Электронная почта'),
            'password'=>Yii::t('frontend', 'Пароль'),
            'password2'=>Yii::t('frontend', 'Еще раз пароль'),
        );
    }

    public function passwords($attribute,$params)
    {
        if($this->password2!==$this->password)
            $this->addError('password','Пароли не совпадают!');
    }
}