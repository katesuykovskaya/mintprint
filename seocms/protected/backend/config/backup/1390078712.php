<?php
Yii::setPathOfAlias('backend', dirname(dirname(__FILE__)));
return CMap::mergeArray(
    (require  dirname(dirname(dirname(__FILE__))).'/common/config/main.php'),
    array(
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
        'backend.vendors.*',
        'application.extensions.yii-mail.YiiMailMessage',
        'ext.easyimage.EasyImage',
),
'aliases'=>array(
    //If you manually installed it
    'xupload' => 'application.backend.extensions.xupload',
),
'modules'=>require(dirname(__FILE__) . '/modules.php'),
'preload'=>array(
     'log',
     'bootstrap',
),
        /*ошибка после переноса Rights в common */
//'onBeginRequest'=>array(
//    'ModuleUrlManager','collectRules'
//),
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
	'urlManager'=>array(
    'class' => 'application.backend.components.UrlManager',
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'caseSensitive'=>true,
            'useStrictParsing'=>true,
            'matchValue'=>false,
            'rules'=>array(

                /*gii*/

                'backend/gii'=>'gii/default/index',

                /*end of gii*/

                /*test for organising breadcrumbs*/

         '<language:[a-zA-Z]{2}>/backend'=>'site/index',
                'backend'=>'site/index',
                'backend/restore'=>'siteconfig/default/restore',
                '<language:[a-zA-Z]{2}>/backend/login'=>'users/users/login',
                'backend/login'=>'users/users/login',
                '<language:[a-zA-Z]{2}>/backend/logout'=>'users/users/logout',
                'backend/logout'=>'users/users/logout',
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
//	'db'=>array(
//            'connectionString' => 'mysql:host=localhost;dbname=sc-olympiec',
//            'emulatePrepare' => true,
//            'username' => 'sc-olympiec',
//            'password' => 'sc-olympiec',
//            'charset' => 'utf8',
//            'tablePrefix'=>'', // needs to be set up for multilingual behavior, or we'll get an error which is in code of ext (usin table prefixes)
//            'enableParamLogging'=>true,
//            'enableProfiling'=>true,
//        ),
//	'errorHandler'=>array(
//     'errorAction'=>'site/error',
//),
	'mail'=>require(dirname(__FILE__) . '/mail.php'),
	'messages'=>array(
    'class'=>'CDbMessageSource',
    'forceTranslation'=>true,
),
),
));