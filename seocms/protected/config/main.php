<?php
return CMap::mergeArray(
    (require dirname(dirname(__FILE__)).'/common/config/main.php'),
    array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'photo-servis',
    'theme'=>'photo-servis',
    'sourceLanguage'=>'ru',
    'language'=>'ru',

	// autoloading model and component classes
	'import'=>array(
//		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
        'attach',
	),

	// application components
	'components'=>array(
		// uncomment the following to enable URLs in path-format
        'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),

	),
));