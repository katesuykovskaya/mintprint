<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 25.03.14
 * Time: 17:29
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
//            'client_id' => '3485057',
            'client_id' => '4321188',
            'response_type'=>'code',
            'scope'=>'photos',
            'redirect_uri' => 'http://photo-service.home/backend/social/default/auth/authprovider/vk',
            'v'=>'5.16'

        ],
        'tokenUrl'=>'https://oauth.vk.com/access_token',
        'token'=>[
//            'client_id' => '3485057',
//            'client_secret'=>'ldFMthERrnHUe9MXIMFT',
            'client_id' => '4321188',
            'client_secret' => '1se2sLZmk2IZoXibbPRr',
            'response_type'=>'code',
            'scope'=>'photos',
            'redirect_uri' => 'http://photo-service.home/backend/social/default/auth/authprovider/vk?scenario='.$scenario,
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
            'client_id' => 'c3a5d2a20bd7484e8260dfdc9fc295b4',
            'response_type'=>'code',
            'redirect_uri' => 'http://photo-service.home/backend/social/default/auth/authprovider/instagram',

        ],
        'tokenUrl'=>'https://api.instagram.com/oauth/access_token',
        'token'=>[
            'client_id' => 'c3a5d2a20bd7484e8260dfdc9fc295b4',
            'client_secret'=>'6c59c6ba085a48f18e795f6ab0b62045',
            'grant_type'=> 'authorization_code',
            'redirect_uri' => 'http://photo-service.home/backend/social/default/auth/authprovider/instagram?scenario='.$scenario,
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
            'redirect_uri' => 'http://photo-service.home/backend/social/default/auth/authprovider/fb'

        ],
        'tokenUrl'=>'https://graph.facebook.com/oauth/access_token',
        'token'=>[
            'client_id' => '1490682084479558',
            'client_secret'=>'26b103623cec4483b764061706fe4758',
//            'client_id' => '769552843084826',
//            'client_secret'=>'457272200ac7b556e97820808861fb93',
            'redirect_uri' => 'http://photo-service.home/backend/social/default/auth/authprovider/fb?scenario='.$scenario,
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