<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chosen1
 * Date: 01.10.13
 * Time: 11:43
 * To change this template use File | Settings | File Templates.
 */
//Yii::setPathOfAlias('backend', dirname(dirname(__FILE__)));
// получаем список директорий в protected/modules
$dirs = scandir(dirname(__FILE__).'/../modules');
// строим массив
$modules = array();
foreach ($dirs as $name){
    if ($name[0] != '.')
        $modules[$name] = array('class'=>'common.modules.' . $name . '.' . ucfirst($name) . 'Module');
}

//return $modules;
return array_replace(
        $modules, array(
            // uncomment the following to enable the Gii tool
            /*кодогенератор, убить для продакшена*/
//            'gii'=>array(
//                'class'=>'system.gii.GiiModule',
//                'password'=>'1q2w3e',
//                // If removed, Gii defaults to localhost only. Edit carefully to taste.
//                'ipFilters'=>array('127.0.0.1','::1'),
//            ),
        )
    );
