<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 07.08.14
 * Time: 12:10
 */ $code = (isset($_GET['code'])) ? $_GET['code'] : null;
$scenario = (isset($_GET['scenario'])) ? $_GET['scenario'] : null;
//$server = $_SERVER['']
return [
    'scenario'=>[
        'auth'=>['socialAuth'],
        'login'=>['socialAuth','socialRegister'],
        'photos'=>['socialAuth','socialRegister','getPhotos'],
    ],
    'vk'=>[
        'authUrl'=>'http://oauth.vk.com/authorize',
        'auth'=>[
            'client_id' => '4495283',
            'response_type'=>'code',
            'scope'=>'photos',
            'redirect_uri' => 'http://mintprint.com.ua/social/default/auth?authprovider=vk',
            'v'=>'5.16'

        ],
        'tokenUrl'=>'https://oauth.vk.com/access_token',
        'token'=>[
            'client_id' => '4495283',
            'client_secret' => 'esBtVNQZOnGJJF93eqKE',
            'response_type'=>'code',
            'scope'=>'photos',
            'redirect_uri' => 'http://mintprint.com.ua/social/default/auth?authprovider=vk',
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
        ,'photos'=>array(
            'original' => 'src_xxbig',
            'originalSecond' => 'src_big',
            'thumbnail' => 'src'
        )
    ],
    'instagram'=>[
        'authUrl'=>'https://api.instagram.com/oauth/authorize/',
        'auth'=>[
            //photo-service.home
            'client_id' => '9e0b0122226944678c2d77fe144b9dae',
            'response_type'=>'code',
            'redirect_uri' => 'http://mintprint.com.ua/social/default/auth?authprovider=instagram',

        ],
        'tokenUrl'=>'https://api.instagram.com/oauth/access_token',
        'token'=>[
            //photo-service.home
            'client_id' => '9e0b0122226944678c2d77fe144b9dae',
            'client_secret'=>'8b5681bab0fa4a339dd7fd1f7d472017',
            'grant_type'=> 'authorization_code',
            'redirect_uri' => 'http://mintprint.com.ua/social/default/auth?authprovider=instagram',
            'code'=>$code,
        ],
        'photos'=>array(
            'original' => 'standard_resolution',
            'originalSecond' => 'standard_resolution',
            'thumbnail' => 'thumbnail'
        )
    ],
    'fb'=>[
        'authUrl'=>'https://www.facebook.com/dialog/oauth',
        'auth'=>[
            'client_id' => '1490682084479558',
            'client_secret' => '26b103623cec4483b764061706fe4758',
            'scope' => 'user_photos',
            'redirect_uri' => 'http://mintprint.com.ua/social/default/auth?authprovider=fb'

        ],
        'tokenUrl'=>'https://graph.facebook.com/oauth/access_token',
        'token'=>[
            //kate
            'client_id' => '1490682084479558',
            'client_secret'=>'26b103623cec4483b764061706fe4758',
            'redirect_uri' => 'http://mintprint.com.ua/social/default/auth?authprovider=fb',
            'code'=>$code,
        ],
        'albums'=>array(
            'title'         => 'name',
            'thumb_src'     => 'thumb_src',
            'album_id'      => 'id',
            'album_ids'     =>'id',
            'album_size'    =>'count',
            'page_size'     => 20
        ),
        'photos'=>array(
            'original' => 'src_big',
            'originalSecond' => 'src_big',
            'thumbnail' => 'src'
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