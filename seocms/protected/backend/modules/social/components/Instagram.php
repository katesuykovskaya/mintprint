<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 27.03.14
 * Time: 8:45
 */

class Instagram {

    protected $token = null;

    public function __construct()
    {
        $conf = Yii::app()->getModule('social')->getConfig();
        $instagram = new Guzzle\Http\Client();
        try {
            $request = $instagram->post($conf['instagram']['tokenUrl']);
            $request->addPostFields($conf['instagram']['token']);
            $instaToken = $request->send()->json();
            $this->token = $instaToken['access_token'];
        } catch(Exception $e) {
            echo $e->getMessage();
        }

    }

    public function getToken()
    {
        return $this->token;
    }

} 