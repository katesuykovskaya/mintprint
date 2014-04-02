<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 27.03.14
 * Time: 8:45
 */

class Vk {

    protected $token = null;

    public function __construct()
    {
        $conf = Yii::app()->getModule('social')->getConfig();
        $vk = new Guzzle\Http\StaticClient();
        try {
            $test = $vk::get($conf['vk']['tokenUrl'] . '?' . urldecode(http_build_query($conf['vk']['token'])));
            $vkToken = $test->json();
            $this->token = isset($vkToken['access_token']) ? $vkToken['access_token'] : null;
        } catch(Exception $e) {
            echo $e->getMessage();
        }

    }

    public function getToken()
    {
        return $this->token;
    }

} 