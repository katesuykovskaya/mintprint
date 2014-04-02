<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database
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
        'commandMap'=> array(
            'migrate'=> array(
                'class'=>'system.cli.commands.MigrateCommand',
                'interactive'=> 0,
            ),
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);