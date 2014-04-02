<?php
Yii::setPathOfAlias('backend', dirname(dirname(__FILE__)));
return array(
'name'=>'My Cool Project',
'sourceLanguage'=>'ru',
'language'=>'ru',
'theme'=>'unicorn',
'basePath'=>dirname(dirname(dirname(__FILE__))),
'controllerPath'=>dirname(dirname(__FILE__)).'/controllers',
'viewPath'=>dirname(dirname(__FILE__)).'/views',
'runtimePath'=>dirname(dirname(__FILE__)).'/runtime',
'import'=>array(
            'backend.models.*',
        'backend.components.*',
//        'application.models.*',
//        'application.components.*',
        'backend.vendors.*',
        'backend.modules.users.models.*',
        'backend.modules.rights.*',
        'backend.modules.rights.models.*',
//        'backend.modules.backendmenu.models.*',
//        'backend.modules.rights.components.*',
//            loading swift mailer extension yii-mail
        'application.extensions.yii-mail.YiiMailMessage',
),
'aliases'=>array(
    //If you used composer your path should be
    'xupload' => 'ext.vendor.asgaroth.xupload',
    //If you manually installed it
    'xupload' => 'ext.xupload',
),
'modules'=>require(dirname(__FILE__) . '/modules.php'),
'preload'=>array(
     'log',
     'bootstrap',
),
'onBeginRequest'=>array(
    'ModuleUrlManager','collectRules'
),
'params'=>array(
    'languages'=>require(dirname(__FILE__) . '/languages.php'),
    'defaultPageSize'=>25,
    'wysiwyg'=>'tinymce',
),

'components'=>array(
	'bootstrap'=>array(
    'class' => 'ext.bootstrap.components.Bootstrap',
    'responsiveCss' => true,
),
	'user'=>array(
  'class'=>'RWebUser', //used module Rights instead of basic class CWebUser
   // enable cookie-based authentication
  'allowAutoLogin'=>true,
  'autoRenewCookie'=>true,
  'authTimeout'=>7200,
),
	'authManager'=>array(
      'class'=>'RDbAuthManager', //used Rights's class instead of basic CDbAuthManager
      'defaultRoles'=>array('Guest'),
      'connectionID'=>'db',
),
	'urlManager'=>array(
    'class' => 'application.backend.components.UrlManager',
            'urlFormat'=>'path',
            'showScriptName'=>false,
//            'caseSensitive'=>false,
            'useStrictParsing'=>true,
            'matchValue'=>false,
            'rules'=>array(

                /*gii*/

                'backend/gii'=>'gii/default/index',

                /*end of gii*/

                /*test for organising breadcrumbs*/
//                '/backend/mainmenu-create'=>'menugen/sitemenu/mainmenu',

         '<language:[a-zA-Z]{2}>/backend'=>'site/index',
                'backend'=>'site/index',
                'backend/restore'=>'siteconfig/default/restore',
                '<language:[a-zA-Z]{2}>/backend/login'=>'users/users/login',
                'backend/login'=>'users/users/login',
                '<language:[a-zA-Z]{2}>/backend/logout'=>'users/users/logout',
                'backend/logout'=>'users/users/logout',
//				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
//				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<language:[a-zA-Z]{2}>/backend/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                'backend/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',

                /*rules for rights*/
                'backend/rights'=>'rights/assignment/view',
                '<language:[a-zA-Z]{2}>/backend/rights'=>'rights/assignment/view',
                'backend/rights/<controller:\w+>/<action:\w+>'=>'rights/<controller>/<action>',
                '<language:[a-zA-Z]{2}>/backend/rights/<controller:\w+>/<action:\w+>'=>'rights/<controller>/<action>',
                /*end of rights urls*/

                /*modules section*/
                '<language:[a-zA-Z]{2}>/backend/<module>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/view',
                'backend/<module>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/view',
                '<language:[a-zA-Z]{2}>/backend/<module>/<controller:\w+>/<action:\w+>/*'=>'<module>/<controller>/<action>',
                'backend/<module>/<controller:\w+>/<action:\w+>/*'=>'<module>/<controller>/<action>',
                '<language:[a-zA-Z]{2}>/backend/<module>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
                'backend/<module>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',


//                array('<module>/<controller>/<action>','pattern'=>'<language:[a-zA-Z]{2}>/backend/<module>/<controller:\w >/<action:\w >','matchValue'=>true,'parsingOnly'=>true),
//                array('<module>/<controller>/<action>','pattern'=>'backend/<module>/<controller:\w >/<action:\w >','matchValue'=>false),

            ),
),
	'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=seotm_cms',
            'emulatePrepare' => true,
            'username' => 'seotm_cms',
            'password' => '1q2w3e',
            'charset' => 'utf8',
            'tablePrefix'=>'', // needs to be set up for multilingual behavior, or we'll get an error which is in code of ext (usin table prefixes)
            'enableParamLogging'=>true,
            'enableProfiling'=>true,
        ),
	'errorHandler'=>array(
     'errorAction'=>'site/error',
),
	'session'=>array(
     'class' => 'system.web.CDbHttpSession',
     'connectionID'=>'db',
     'autoCreateSessionTable'=>false,
     'autoStart'=>true,
     'timeout'=>'1440',
),
	'mail'=>require(dirname(__FILE__) . '/mail.php'),
	'messages'=>array(
    'class'=>'CDbMessageSource',
    'forceTranslation'=>true,
),
),
);