<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 27.03.14
 * Time: 8:45
 */

class Fb {

    protected $token = null;

    public function __construct()
    {
        $conf = Yii::app()->getModule('social')->getConfig();
        $fb = new Guzzle\Http\StaticClient();
        try {
            $test = $fb::get($conf['fb']['tokenUrl'] . '?' . urldecode(http_build_query($conf['fb']['token'])));
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
        return $this->token;
    }

} 