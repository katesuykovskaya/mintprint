<?php
return CMap::mergeArray(
    (require dirname(dirname(__FILE__)).'/common/config/main.php'),
    array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Mint print',
    'theme'=>'mint-print',
    'sourceLanguage'=>'ru',
    'language'=>'ru',

	// autoloading model and component classes
	'import'=>array(
//		'application.models.*',
		'application.components.*',
        'application.extensions.EAjaxUpload.*',
        'ext.easyimage.EasyImage'
	),

	'modules'=>array(
        'attach',
        'social',
        'order',
        'users'
	),
//    'aliases' => array(
//        'xupload' => 'ext.xupload'
//    ),

	// application components
	'components'=>array(
        'easyImage' => array(
            'class' => 'application.extensions.easyimage.EasyImage',
        ),
        'user'=>array(
            'class'=>'CWebUser',
            // enable cookie-based authentication
//            'stateKeyPrefix'=>'common',
            'allowAutoLogin'=>true,
            'autoRenewCookie'=>true,
            'authTimeout'=>3600 * 24 * 7,
        ),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
            'class' => 'application.backend.components.UrlManager',
			'urlFormat'=>'path',
//            'urlSuffix'=>'.html',
            'showScriptName'=>false,
            'useStrictParsing'=>true,
            'matchValue'=>false,
			'rules'=>array(
                ''=>'site/home',
                '/news/<translit>'=>array('site/news', 'urlSuffix'=>'.html'),
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<page:[\w\d-]+>'=>'site/pages',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
                '<module>/<controller:\w+>/<action:\w+>/*'=>'<module>/<controller>/<action>',
			),
		),

	),
));