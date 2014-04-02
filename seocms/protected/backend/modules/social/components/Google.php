<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 27.03.14
 * Time: 8:45
 */

class Google {

    protected $token = null;

    public function __construct()
    {
        $conf = Yii::app()->getModule('social')->getConfig();
        $gplus = new Guzzle\Http\Client();
        try {
            $request = $gplus->post($conf['google']['tokenUrl']);
            $request->addPostFields($conf['google']['token']);
            $googleToken = $request->send()->json();
//            $token = $googleToken['access_token'];


//            $request = $gplus->post($conf['gplus']['tokenUrl']);
//            $request->addPostFields($conf['gplus']['token']);
//            $gplusToken = $request->send()->json();
            $this->token = $googleToken['access_token'];
        } catch(Exception $e) {
            echo $e->getMessage();
        }

    }

    public function getToken()
    {
        return $this->token;
    }

} 