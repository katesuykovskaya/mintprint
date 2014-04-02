<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    
    public function authenticate()
    {
        $username=strtolower($this->username);
        $user=User::model()->find('LOWER(login)=?',array($username));
        
        if($user===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        
        else if(!bCrypt::verify($this->password, $user->pass)) 
            $this->errorCode=self::ERROR_PASSWORD_INVALID;

        else
        {

            $this->_id=$user->user_id;
            $auth = AuthAssignment::model()->findByAttributes(array('userid'=>$user->user_id));
            $this->setState('role',$auth->itemname);
            $this->setState('login',$user->login);
            $this->setState('lastLogin', date('Y-m-d H:i:s'));
            $this->errorCode=self::ERROR_NONE;
            ++$user->login_numbs;
            $user->last_login = date('Y-m-d H:i:s');
            $user->last_action_time = date('Y-m-d H:i:s');
            $user->save(false);
        }
        
        return !$this->errorCode;
    }
 
    public function getId()
    {
        return $this->_id;
    }
}