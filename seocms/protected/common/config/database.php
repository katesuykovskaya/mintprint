<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 20.05.14
 * Time: 17:28
 */
return array(
    'connectionString' => 'mysql:host=localhost;dbname=photo_service',
    'emulatePrepare' => true,
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
//            'tablePrefix'=>'', // nekjkjkeds to be set up for multilingual behavior, or we'll get an error which is in code of ext (usin table prefixes)
    'enableParamLogging'=>true,
    'enableProfiling'=>true,
);