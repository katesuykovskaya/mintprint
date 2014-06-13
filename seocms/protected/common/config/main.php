<?php
Yii::setPathOfAlias('common', dirname(dirname(__FILE__)));
return array(
    'id'=>'seotm',
    'import'=>array(
        'common.models.*',
        'common.components.*',
        'common.vendors.*',
        'common.modules.users.models.*',
        'common.modules.rights.*',
        'common.modules.rights.models.*',
        'common.modules.rights.components.*',
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
        'db'=>require(dirname(__FILE__) . '/database.php'),
        'user'=>array(
            'class'=>'RWebUser', //used module Rights instead of basic class CWebUser
            // enable cookie-based authentication
//            'stateKeyPrefix'=>'common',
            'allowAutoLogin'=>true,
            'autoRenewCookie'=>true,
            'authTimeout'=>3600 * 24,
        ),
        'authManager'=>array(
            'class'=>'RDbAuthManager', //used Rights's class instead of basic CDbAuthManager
            'defaultRoles'=>array('Guest'),
            'connectionID'=>'db',
        ),
        'errorHandler'=>array(
            'errorAction'=>'site/error',
        ),
        'session'=>array(
            'class' => 'system.web.CDbHttpSession',
            'connectionID'=>'db',
            'autoCreateSessionTable'=>false,
            'autoStart'=>true,
            'timeout'=>3600 * 24 * 7,
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
        'mail'=>require(dirname(__FILE__) . '/mail.php'),
    ),
    'params'=>array('languages'=>require(dirname(__FILE__) . '/languages.php'),),
);