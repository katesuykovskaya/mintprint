<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 27.03.14
 * Time: 8:45
 */

class Instagram {

    protected $token = false;
    protected $conf = null;


    public function __construct()
    {
        $this->conf = Yii::app()->getModule('social')->getConfig();
    }

    public function setToken()
    {
        $instagram = new Guzzle\Http\Client();
        try {
            $request = $instagram->post($this->conf['instagram']['tokenUrl']);
            $request->addPostFields($this->conf['instagram']['token']);
            $instaToken = $request->send()->json();
            $this->token = $instaToken['access_token'];
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }


    public function getToken()
    {
        $this->setToken();
        return $this->token;
    }

    public function getPhotos($token)
    {
        $insta = new Guzzle\Http\Client();
//        $instaMediaUrl = 'https://api.instagram.com/v1/users/self/feed';
        $instaMediaUrl = 'https://api.instagram.com/v1/users/self/media/recent/';
        try {
//            echo $instaMediaUrl.'?access_token='.$token;
            $requestM = $insta->get($instaMediaUrl.'?access_token='.$token);
//            die(CVarDumper::dump($requestM->send(), 8, true));
            $data = $requestM->send()->json();
//            die(CVarDumper::dump($data, 5, true));
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
//            die();
        }
    }

}