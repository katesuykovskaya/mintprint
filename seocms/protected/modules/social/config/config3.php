<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 03.06.14
 * Time: 16:51
 */
$code = (isset($_GET['code'])) ? $_GET['code'] : null;
$scenario = (isset($_GET['scenario'])) ? $_GET['scenario'] : null;

return [
    'scenario'=>[
        'auth'=>['socialAuth'],
        'login'=>['socialAuth','socialRegister'],
        'photos'=>['socialAuth','socialRegister','getPhotos'],
    ],
    'vk'=>[
        'authUrl'=>'http://oauth.vk.com/authorize',
        'auth'=>[
            'client_id' => '4382088',
            'response_type'=>'code',
            'scope'=>'photos',
            'redirect_uri' => 'http://mint-print.seotm.biz/social/default/auth?authprovider=vk',
            'v'=>'5.16'

        ],
        'tokenUrl'=>'https://oauth.vk.com/access_token',
        'token'=>[
            // http://mint-print.seotm.biz
            'client_id'=>'4382088',
            'client_secret' => 'BijBNOVApjLsGb83KlAq',
            'response_type'=>'code',
            'scope'=>'photos',
            'redirect_uri' => 'http://mint-print.seotm.biz/social/default/auth?authprovider=vk',
            'code'=>$code,
        ],
        'albums'=>array(
            'title'         => 'title',
            'thumb_src'     => 'thumb_src',
            'album_id'      => 'aid',
            'album_ids'     => 'album_ids',
            'album_size'    => 'size',
            'page_size'     => 20
        )
    ],
    'instagram'=>[
        'authUrl'=>'https://api.instagram.com/oauth/authorize/',
        'auth'=>[
            //photo-service.home
//            'client_id' => 'c3a5d2a20bd7484e8260dfdc9fc295b4',
            // mint-print.seotm.biz
            'client_id'=>'ae8b424720a64f278e31849ebcdac957',
            'response_type'=>'code',
            'redirect_uri' => 'http://mint-print.seotm.biz/social/default/auth?authprovider=instagram',

        ],
        'tokenUrl'=>'https://api.instagram.com/oauth/access_token',
        'token'=>[
            'client_id' => 'ae8b424720a64f278e31849ebcdac957',
            'client_secret'=>'dcb38e4984404cbc94b0aaaab6bd01c2',
            'grant_type'=> 'authorization_code',
            'redirect_uri' => 'http://mint-print.seotm.biz/social/default/auth?authprovider=instagram',
            'code'=>$code,
        ],
    ],
    'fb'=>[
        'authUrl'=>'https://www.facebook.com/dialog/oauth',
        'auth'=>[
            'client_id' => '1490682084479558',
            'client_secret' => '26b103623cec4483b764061706fe4758',
//            'client_id' => '769552843084826',
//            'client_secret'=>'457272200ac7b556e97820808861fb93',
//            'scope' => 'user_photos',
            'redirect_uri' => 'http://photo-service.home/social/default/auth?authprovider=fb'

        ],
        'tokenUrl'=>'https://graph.facebook.com/oauth/access_token',
        'token'=>[
            //kate
            'client_id' => '1490682084479558',
            'client_secret'=>'26b103623cec4483b764061706fe4758',
            //alexandr
//            'client_id' => '769552843084826',
//            'client_secret'=>'457272200ac7b556e97820808861fb93',
            'redirect_uri' => 'http://photo-service.home/social/default/auth?authprovider=fb',
            'code'=>$code,
        ],
        'albums'=>array(
            'title'         => 'name',
            'thumb_src'     => 'thumb_src',
            'album_id'      => 'id',
            'album_ids'     =>'id',
            'album_size'    =>'count',
            'page_size'     => 20
        )
    ],
    'google'=>[
        'authUrl'=>'https://accounts.google.com/o/oauth2/auth',
        'auth'=>[
            'redirect_uri'  => 'http://127.0.1.31/backend/social/default/auth/authprovider/google',
            'response_type' => 'code',
            'client_id'     => '540679363717-n6p49rjuihmj63ijs3298u5273phdqn5.apps.googleusercontent.com',
            'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
        ],
        'tokenUrl'=>'https://accounts.google.com/o/oauth2/token',
        'token'=>[
            'client_id' => '540679363717-n6p49rjuihmj63ijs3298u5273phdqn5.apps.googleusercontent.com',
            'client_secret'=>'SWOulmiZJND26OeljFICRPHy',
            'grant_type'=> 'authorization_code',
            'redirect_uri' => 'http://127.0.1.31/backend/social/default/auth/authprovider/google',
            'code'=>$code,
        ]
    ],
];