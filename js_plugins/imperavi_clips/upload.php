<?php

// files storage folder
$dir = '/images';

$_FILES['file']['type'] = strtolower($_FILES['file']['type']);

if ($_FILES['file']['type'] == 'image/png' 
|| $_FILES['file']['type'] == 'image/jpg' 
|| $_FILES['file']['type'] == 'image/gif' 
|| $_FILES['file']['type'] == 'image/jpeg'
|| $_FILES['file']['type'] == 'image/pjpeg')
{
    // setting file's mysterious name
    $file = $dir.md5(date('YmdHis')).'.jpg';
    // copying
    copy($_FILES['file']['tmp_name'], $file);
    // displaying file
    $array = array(
        'filelink' => '/images/'.$file
    );
    echo stripslashes(json_encode($array));
}
?>