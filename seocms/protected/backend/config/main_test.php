<?php
//$backend=dirname(dirname(__FILE__));
//$frontend=dirname($backend);
Yii::setPathOfAlias('backend', dirname(dirname(__FILE__)));



// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
//    'basePath'=>$frontend,
    'basePath'=>dirname(dirname(dirname(__FILE__))),
//    'controllerPath' => $backend.'/controllers',
    'controllerPath' => dirname(dirname(__FILE__)).'/controllers',
//    'viewPath' => $backend.'/views',
    'viewPath' => dirname(dirname(__FILE__)).'/views',
//    'runtimePath' => $backend.'/runtime',
    'runtimePath' => dirname(dirname(__FILE__)).'/runtime',
    'sourceLanguage'=>'ru',
    'language'=>'ru',
    'theme'=>'unicorn',

    'name'=>'My BACKEND Web Application',

    // preloading 'log' component
    'preload'=>array(
        'log',
        'bootstrap',
    ),

    // autoloading model and component classes
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


//    'modules'=>array_replace(
//        $modules, array(
//            // uncomment the following to enable the Gii tool
//            /*кодогенератор, убить для продакшена*/
////            'gii'=>array(
////                'class'=>'system.gii.GiiModule',
////                'password'=>'1q2w3e',
////                // If removed, Gii defaults to localhost only. Edit carefully to taste.
////                'ipFilters'=>array('127.0.0.1','::1'),
////            ),
//        )
//    ),

    'modules'=>require(dirname(__FILE__) . '/modules.php'),

    // application components
    'components'=>array(

//        'clientScript' => array(
//            'class' => 'ext.NLSClientScript',
//            //'excludePattern' => '/\.tpl/i', //js regexp, files with matching paths won't be filtered is set to other than 'null'
//            //'includePattern' => '/\.php/', //js regexp, only files with matching paths will be filtered if set to other than 'null'
//
//            'mergeJs' => true, //def:true
//            'compressMergedJs' => false, //def:false
//
//            'mergeCss' => true, //def:true
//            'compressMergedCss' => false, //def:false
//
//            'serverBaseUrl' => 'http://twoends.home', //can be optionally set here
//            'mergeAbove' => 7, //def:1, only "more than this value" files will be merged,
//            'curlTimeOut' => 5, //def:5, see curl_setopt() doc
//            'curlConnectionTimeOut' => 10, //def:10, see curl_setopt() doc
//
//            'appVersion'=>1.0 //if set, it will be appended to the urls of the merged scripts/css
//        ),

        'bootstrap' => array(
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
            //'class'=>'CDbAuthManager',
            'class'=>'RDbAuthManager', //used Rights's class instead of basic CDbAuthManager
            'defaultRoles'=>array('Guest'),
            'connectionID'=>'db',
        ),

        // uncomment the following to enable URLs in path-format

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


//                array('<module>/<controller>/<action>','pattern'=>'<language:[a-zA-Z]{2}>/backend/<module>/<controller:\w+>/<action:\w+>','matchValue'=>true,'parsingOnly'=>true),
//                array('<module>/<controller>/<action>','pattern'=>'backend/<module>/<controller:\w+>/<action:\w+>','matchValue'=>false),

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
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
//		'log'=>array(
//			'class'=>'CLogRouter',
//			'routes'=>array(
//				array(
//					'class'=>'CFileLogRoute',
//					'levels'=>'error, warning',
//				),
//				// uncomment the following to show log messages on web pages
//
//				array(
//					'class'=>'CWebLogRoute',
//				),
//
//			),
//		),

        'session'=>array(
            'class' => 'system.web.CDbHttpSession',
            'connectionID'=>'db',
            'autoCreateSessionTable'=>false,
            'autoStart'=>true,
            'timeout'=>'1440',
//                'sessionName'=>'SeoAdmin',
        ),

        'mail'=>
        require(dirname(__FILE__) . '/mail.php'),

        'messages' => array(
//                    // using static class method as event handler
//                    'onMissingTranslation' => array('MyEventHandler',
//                                    'handleMissingTranslation'),
            'class'=>'CDbMessageSource',
            'forceTranslation'=>true,
        ),


    ),

    'onBeginRequest'=>array('ModuleUrlManager','collectRules'),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
//        'adminEmail'=>'root@root.zt.ua',
        'languages'=>require(dirname(__FILE__) . '/languages.php'),
//        'translateAttrs' => array(
//                                't_title',
//                                't_desc',
//                                't_h1',
//                                't_content',
//                                't_mdesc',
//                                't_mtitle',
//                                't_mkeywords',
//                                't_translit',
//                            ),

        'defaultPageSize'=>25,
        'wysiwyg'=>'redactor',
    ),
);