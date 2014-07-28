<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 27.03.14
 * Time: 8:45
 */

class Fb {

    protected $token = false;
    protected $conf = null;


    public function __construct()
    {
        $this->conf = Yii::app()->getModule('social')->getConfig();
    }

    public function setToken()
    {
        $fb = new Guzzle\Http\StaticClient();
        try {
            $test = $fb::get($this->conf['fb']['tokenUrl'] . '?' . urldecode(http_build_query($this->conf['fb']['token'])));
            $fbToken = $test->getBody(true); // as string
            $arr1 = [];
            parse_str($fbToken,$arr1);
            $this->token = isset($arr1['access_token']) ? $arr1['access_token'] : null;
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
        $fb = new Guzzle\Http\StaticClient();

        try {
            $apiUrl = 'https://graph.facebook.com/me/photos/uploaded';
            $req = $fb::get($apiUrl.'?&access_token='.$token);

            $data = $req->json();

        return $data;
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

} 