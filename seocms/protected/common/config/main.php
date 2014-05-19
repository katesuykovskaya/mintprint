<?php
Yii::setPathOfAlias('common', dirname(dirname(__FILE__)));
return array(
    'id'=>'seotm',
    'import'=>array(
        'common.models.*',
        'common.components.*',
        'common.vendors.*',
        'common.modules.users.models.*',
//        'common.modules.rights.*',
//        'common.modules.rights.models.*',
//        'common.modules.rights.components.*',
        'common.modules.auth.*',
        'common.modules.auth.models.*',
        'common.modules.auth.components.*',
        'common.modules.auth.filters.*',
        'common.modules.auth.controllers.*',
//            loading swift mailer extension yii-mail
        'application.extensions.yii-mail.YiiMailMessage',
        'ext.easyimage.EasyImage',
    ),
//    'preload'=>array('log'),
//    'modules'=>array(
//        'rights',
//        'multilanguage'
//    ),
    'modules'=>require(dirname(__FILE__) . '/modules.php'),
    'components'=>array(
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=photo_service',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
//            'tablePrefix'=>'', // needs to be set up for multilingual behavior, or we'll get an error which is in code of ext (usin table prefixes)
            'enableParamLogging'=>true,
            'enableProfiling'=>true,
        ),
//        'user'=>array(
//            'class'=>'RWebUser', //used module Rights instead of basic class CWebUser
//            // enable cookie-based authentication
////            'stateKeyPrefix'=>'common',
//            'allowAutoLogin'=>true,
//            'autoRenewCookie'=>true,
//            'authTimeout'=>7200,
//        ),
        'user'=>array(
            'class' => 'auth.components.AuthWebUser',
            'admins' => array('admin', 'foo', 'bar'), // users with full access
            'allowAutoLogin'=>true,
            'autoRenewCookie'=>true,
            'authTimeout'=>7200,
        ),
//        'authManager'=>array(
//            'class'=>'RDbAuthManager', //used Rights's class instead of basic CDbAuthManager
//            'defaultRoles'=>array('Guest'),
//            'connectionID'=>'db',
//        ),
        'authManager'=>array(
            'class'=>'auth.components.CachedDbAuthManager',
            'cachingDuration'=>3600,
//            'class'=>'RDbAuthManager', //used Rights's class instead of basic CDbAuthManager
//            'defaultRoles'=>array('Guest'),
//            'connectionID'=>'db',
            'behaviors' => array(
                'auth' => array(
                    'class' => 'auth.components.AuthBehavior',
                ),
            ),
        ),
        'errorHandler'=>array(
            'errorAction'=>'site/error',
        ),
        'session'=>array(
            'class' => 'system.web.CDbHttpSession',
            'connectionID'=>'db',
            'autoCreateSessionTable'=>false,
            'autoStart'=>true,
//            'timeout'=>'1440',
            'timeout'=>'7200',
        ),
        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),

        'messages'=>array(
            'class'=>'CDbMessageSource',
            'forceTranslation'=>true,
        ),

        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                array(
                    'class'=>'CWebLogRoute',
                ),
            ),
        ),
        'easyImage'=>array(
            'class' => 'application.extensions.easyimage.EasyImage',
            'driver' => 'GD',
            'quality' => 100,
            //'cachePath' => '/assets/easyimage/',
            //'cacheTime' => 2592000,
            //'retinaSupport' => false,
        ),
    ),
    'params'=>['languages'=>require(dirname(__FILE__) . '/languages.php'),],
);