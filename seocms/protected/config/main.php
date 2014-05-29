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
	),

	'modules'=>array(
        'attach',
        'social',
	),

	// application components
	'components'=>array(
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
            'class' => 'application.backend.components.UrlManager',
			'urlFormat'=>'path',
//            'urlSuffix'=>'.html',
            'showScriptName'=>false,
            'useStrictParsing'=>true,
            'matchValue'=>false,
			'rules'=>array(
                ''=>['site/index','urlSuffix'=>''],
                'video'=>['site/video', 'urlSuffix'=>'.html'],
                '<language:[a-zA-Z]{2}>/video'=>['site/video', 'urlSuffix'=>'.html'],
                'video.html/page/<page:\d+>'=>['site/video'],
                '<language:[a-zA-Z]{2}>/video.html/page/<page:\d+>'=>['site/video'],
                '<language:[a-zA-Z]{2}>'=>['site/index', 'urlSuffix'=>''],
                'kontakty'=>['site/contacts', 'urlSuffix'=>'.html'],
                '<language:[a-zA-Z]{2}>/contacts'=>['site/contacts', 'urlSuffix'=>'.html'],
                'gallery'=>['site/gallery', 'urlSuffix'=>'.html'],
                '<language:[a-zA-Z]{2}>/gallery'=>['site/gallery', 'urlSuffix'=>'.html'],
                'main'=>['site/main','urlSuffix'=>'.html'],
                '<language:[a-zA-Z]{2}>/<action:main>'=>['site/main','urlSuffix'=>'.html'],
                '<language:[a-zA-Z]{2}>/news'=>['site/allNews', 'urlSuffix'=>'.html'],
                'news'=>['site/allNews','urlSuffix'=>'.html'],
                'news/*'=>'site/news/url/<alias>',
                '<language:[a-zA-Z]{2}>/news/*'=>'site/news/url/<alias>',
                'newspreview/*'=>'site/newsPreview/url/<alias>',
                '<language:[a-zA-Z]{2}>/newspreview/*'=>'site/newsPreview/url/<alias>',
                'teams/*'=>'site/teams/id/<alias>',
                '<language:[a-zA-Z]{2}>/teams/*'=>'site/teams/id/<alias>',
                '<page:[\w\d-]+>'=>['site/pages', 'urlSuffix'=>'.html'],
                '<language:[a-zA-Z]{2}>/<page:[\w\d-]+>'=>['site/pages', 'urlSuffix'=>'.html'],
//                '<language:[a-zA-Z]{2}>/<page:\w+>'=>'site/pages',
//                '<page:[\w\d-]+>'=>'site/pages',
                '<language:[a-zA-Z]{2}>/<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<language:[a-zA-Z]{2}>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<language:[a-zA-Z]{2}>/<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',
                '<language:[a-zA-Z]{2}>/<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
			),
		),

	),
));