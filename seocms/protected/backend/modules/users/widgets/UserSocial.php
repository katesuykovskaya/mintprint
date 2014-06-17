<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chosen1
 * Date: 18.10.13
 * Time: 17:53
 * To change this template use File | Settings | File Templates.
 */

class UserSocial extends CWidget{

    public $config = array(

        'twitter'=>array(
            'consumer_key'=>'gHS0HH3gECwQjQ7u5lgwA',
            'consumer_secret'=>'II1jHeps4EcSbq4msrPsRTfzRME9Hw0U6IMlxhyDM',
            'token'=>null,
            'secret'=>null,
            'bearer'=>null,
            'callback'=>'http://twoends.home/backend/social/twitterauth',
        ),

        'vk'=>array(
            'client_id'     => '3485057',
            'client_secret' => 'ldFMthERrnHUe9MXIMFT',
            'callback' => '',
        ),
    );

    public function init()
    {
        Yii::import('backend.vendors.tmhoauth.vendor.themattharris.tmhoauth.tmhOAuth');

        $oauth = new tmhOAuth($this->config['twitter']);

        $oauth->apponly_request(array(
            'without_bearer' => true,
            'method' => 'POST',
            'url' => $oauth->url('oauth/request_token', ''),
            'params' => array(
                'oauth_callback' =>$this->config['twitter']['callback'],
            ),
        ));

        $resp = array();
        if(parse_str($oauth->response['response'],$resp)){
            Yii::app()->session['oauth'] = $oauth->extract_params($oauth->response['response']);
        };

    }

    public function run()
    {
        $oauthToken = isset($_SESSION['oauth']['oauth_token']) ? $_SESSION['oauth']['oauth_token'] : null;
        $this->render('usersocial',array(
            'oauthToken'=>$oauthToken,
        ));
    }

}