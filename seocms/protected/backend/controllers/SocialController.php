<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chosen1
 * Date: 21.10.13
 * Time: 12:19
 * To change this template use File | Settings | File Templates.
 */

class SocialController extends CController {

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
            'callback' => 'http://twoends.home:81/backend/social/vkauth'
        ),

        'fb'=>array(
            'client_id'     => '414721841962588',
            'client_secret' => 'e12ff693b0ad1823123ed0bf1078df4d',
            'callback' => 'http://twoends.home:81/backend/social/vkauth'
        ),

    );


    public function actionTwitterAuth()
    {
        if(isset($_GET['oauth_verifier'])){
            Yii::import('backend.vendors.tmhoauth.vendor.themattharris.tmhoauth.tmhOAuth');
            $oauth = new tmhOAuth($this->config['twitter']);
            $oauth->config['token'] = Yii::app()->session['oauth']['oauth_token'];
            $oauth->config['secret'] = Yii::app()->session['oauth']['oauth_token_secret'];

            $code = $oauth->user_request(array(
                'method' => 'POST',
                'url' => $oauth->url('oauth/access_token', ''),
                'params' => array(
                    'oauth_verifier' => $_GET['oauth_verifier'],
                )
            ));


            if ($code == 200) {
                $oauth_creds = $oauth->extract_params($oauth->response['response']);
                Yii::app()->session['screen_name'] = $oauth_creds['screen_name'];
                Yii::app()->session['user_id'] = $oauth_creds['user_id'];
                $oauth->config['token'] = $oauth_creds['oauth_token'];
                $oauth->config['secret'] = $oauth_creds['oauth_token_secret'];

                $userCode = $oauth->user_request(array(
                    'method' => 'GET',
                    'url'    => $oauth->url('1.1/users/show'),
                    'params' => array(
                        'user_id' => array(
                            $oauth_creds['user_id'],
                        ),
                        'screen_name' => array(
                            $oauth_creds['screen_name'],
                        ),
                    ),
                ));

                if ($userCode == 200) {
                    $data = json_decode($oauth->response['response']);
                    Yii::app()->session['img'] = $data->profile_image_url;
                    Yii::app()->session['name'] = $data->name;

                    $this->redirect($this->createUrl('/backend',array('language'=>Yii::app()->language)));
                }
            }
        }
    }

    public function actionVkAuth()
    {
        if(isset($_GET['code'])){

            $url = 'https://oauth.vk.com/access_token?client_id=3485057&client_secret=ldFMthERrnHUe9MXIMFT&code='.$_GET['code'].'&redirect_uri='.urlencode('http://twoends.home:81/backend/social/vkauth').'&response_type=code';

            $params = array(
                'client_id'     => $this->config['vk']['client_id'],
                'client_secret' => $this->config['vk']['client_secret'],
                'code'=> $_GET['code'],
                'redirect_uri'  => 'http://twoends.home/backend/social/vkauth',
            );

            if( $curl = curl_init() ) {
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                $out = json_decode(curl_exec($curl));
                echo CVarDumper::dump($out,5,true);
                curl_close($curl);
            }

            $userUrl = 'https://api.vk.com/method/users.get?user_id='.$out->user_id.'&v=5.2&access_token='.$out->access_token.'&fields=nickname,screen_name,sex,bdate,city,country,timezone,photo_50,photo_100,photo_200_orig,has_mobile,contacts,education,online,counters,relation,last_seen,status,universities,schools,verified';
            if( $curlUser = curl_init() ) {
                curl_setopt($curlUser, CURLOPT_URL, $userUrl);
                curl_setopt($curlUser, CURLOPT_RETURNTRANSFER,true);
                $userInfo = json_decode(curl_exec($curlUser));
                curl_close($curlUser);

                Yii::app()->session['img'] = $userInfo->response[0]->photo_50;
                Yii::app()->session['screen_name'] = $userInfo->response[0]->screen_name;
                Yii::app()->session['user_id'] = $userInfo->response[0]->id;
                Yii::app()->session['name'] = $userInfo->response[0]->first_name.' '.$userInfo->response[0]->last_name;

                $this->redirect($this->createUrl('/backend',array('language'=>Yii::app()->language)));
            }
        }
    }


    public function actionFbAuth()
    {
        if(isset($_GET['code'])){
            $url = 'https://graph.facebook.com/oauth/access_token?client_id=414721841962588&redirect_uri=http://twoends.home:81/backend/social/fbauth&client_secret=e12ff693b0ad1823123ed0bf1078df4d&code='.$_GET['code'];

            if( $curl = curl_init() ) {
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                $out = array();
                parse_str(curl_exec($curl),$out);
                curl_close($curl);
            }

                $userUrl = 'https://graph.facebook.com/me?access_token='.$out['access_token'];
            if( $curlUser = curl_init() ) {
                curl_setopt($curlUser, CURLOPT_URL, $userUrl);
                curl_setopt($curlUser, CURLOPT_RETURNTRANSFER,true);
                $userInfo = json_decode(curl_exec($curlUser));
                curl_close($curlUser);

//                Yii::app()->session['img'] = $userInfo->;
                Yii::app()->session['screen_name'] = $userInfo->username;
                Yii::app()->session['user_id'] = $userInfo->id;
                Yii::app()->session['name'] = $userInfo->first_name.' '.$userInfo->last_name;

                $this->redirect($this->createUrl('/backend',array('language'=>Yii::app()->language)));
            }
        }
    }
}