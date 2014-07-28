<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 23.04.14
 * Time: 16:38
 */
echo CHtml::link('Sort',  Yii::app()->createUrl('/backend/social/default/photosFromAlbum', array(
    'auth'  => $_GET['auth'],
    'aid'   => $_REQUEST['aid'],
    'rev'   => isset($_REQUEST['rev']) ? (int)(!$_REQUEST['rev']) : 1,
    'page'  => isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1,
)), array(
    'class'=>'pager'
));

$albumSize = $album['size'];
$pageSize = 20;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
echo CHtml::openTag('div', array(
    'id' => 'photoWidgetPager'
));
$pagersCount = ceil($albumSize / $pageSize);
/* previous page link */
if($currentPage != 1)
    echo CHtml::link('<-', Yii::app()->createUrl('/backend/social/default/photosFromAlbum', array(
        'auth'  => $_GET['auth'],
        'aid'   => $_REQUEST['aid'],
        'rev'   => isset($_REQUEST['rev']) ? (int)($_REQUEST['rev']) : 0,
        'page'  => $currentPage-1
    )),array(
        'class'=> 'pager',
        'id'=>'pager'.($currentPage-1)
    ));
for($i = 1;$i <= $pagersCount; $i++) {
    echo CHtml::link($i, Yii::app()->createUrl('/backend/social/default/photosFromAlbum', array(
        'auth'  => $_GET['auth'],
        'aid'   => $_REQUEST['aid'],
        'rev'   => isset($_REQUEST['rev']) ? (int)($_REQUEST['rev']) : 0,
        'page'  => $i
    )),array(
        'class'=>$currentPage == $i ? 'active' : 'pager',
        'id'=>'pager'.$i
    ));
}
if($currentPage != $pagersCount)
    echo CHtml::link('->', Yii::app()->createUrl('/backend/social/default/photosFromAlbum', array(
        'auth'  => $_GET['auth'],
        'aid'   => $_REQUEST['aid'],
        'rev'   => isset($_REQUEST['rev']) ? (int)($_REQUEST['rev']) : 0,
        'page'  => $currentPage + 1
    )),array(
        'class'=>'pager',
        'id'=>'pager'.($i+1)
    ));
echo CHtml::closeTag('div');
$len = count($photos);
for($i = 0; $i < $len; $i++) {
    echo CHtml::image($photos[$i]['src'],$photos[$i]['text']);
}