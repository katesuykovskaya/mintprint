<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ConfirmForm extends CFormModel
{
	public $username;
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
			array('username, password, password2', 'required'),
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
			'username'=>'Имя пользователя',
            'password'=>'Пароль',
            'password2'=>'Пароль еще раз',
		);
	}

    public function passwords($attribute,$params)
    {
        if($this->password2!==$this->password)
            $this->addError('password','Пароли не совпадают!');
    }
}

