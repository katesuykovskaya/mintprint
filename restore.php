<?php

$backup = dirname(__FILE__).'/seocms/protected/backend/config/backup/';
$dir = scandir($backup);
$new = dirname(__FILE__).'/seocms/protected/backend/config/main.php';
$max = 0;
foreach($dir as $k=>$v){
    $val = (int)$v;
    if($val === 0)
        unset($dir[$k]);
    $max = $val > $max ? $val : 0;
}
$oldConfig = file_get_contents($backup.$max.'.php');
if($newConfig = file_put_contents($new,$oldConfig,LOCK_EX)){
    header("location:http://".$_SERVER['SERVER_NAME'].'/backend');
}