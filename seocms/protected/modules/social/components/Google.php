<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 27.03.14
 * Time: 8:45
 */

class Google {

    protected $token = false;
    protected $conf = null;


    public function __construct()
    {
        $this->conf = Yii::app()->getModule('social')->getConfig();
    }

    public function setToken()
    {
        $gplus = new Guzzle\Http\Client();
        try {
            $request = $gplus->post($this->conf['google']['tokenUrl']);
            $request->addPostFields($this->conf['google']['token']);
            $googleToken = $request->send()->json();
            $this->token = $googleToken['access_token'];
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }


    public function getToken()
    {
        $this->setToken();
        return $this->token;
    }

    public function getInfo($token)
    {
        $google = new Guzzle\Http\StaticClient();
        $apiUrl = 'https://www.googleapis.com/oauth2/v3/userinfo';
        try {
            $req = $google::get($apiUrl.'?'.urldecode(http_build_query($this->conf['google']['token'])).'&access_token='.$token);
            $data = $req->json();
            return $data;
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }



} 