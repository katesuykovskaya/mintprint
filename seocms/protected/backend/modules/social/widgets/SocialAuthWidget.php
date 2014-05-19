<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.03.14
 * Time: 14:19
 */

class SocialAuthWidget extends CWidget {

    public $providers = [];
    public $socialArray = [];
    public $scenario = 'auth';
    public $redirect = null;

    public function run()
    {
        if(!empty($this->providers)) {
            if(empty($this->socialArray)) {
                $this->socialArray = require_once(Yii::getPathOfAlias('application.backend.modules.social.config').'/config.php');
            }
            foreach($this->providers as $key=>$provider) {
                if($provider !== 'google') {
                    $this->socialArray[$provider]['auth']['redirect_uri'] .= '?scenario='.$this->scenario;
                    $this->socialArray[$provider]['token']['redirect_uri'] .= '?scenario='.$this->scenario;
                } else {
                    $this->socialArray[$provider]['auth']['data'] = $this->scenario;
                    $this->socialArray[$provider]['token']['data'] = $this->scenario;
                }
            }
        }

        $this->render('socialauth',['socialArray'=>$this->socialArray]);
    }

}