<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 23.04.14
 * Time: 16:38
 * @var $album array
 * @var $album_config array
 */
//echo CVarDumper::dump($album, 7, true);
$pageSize = $album_config['page_size'];
$url = '/social/default/photosFromAlbum';
$albumsUrl = '/social/default/albums';
$currentPage = (isset($_GET['offset']) && $_GET['offset'] != 0) ? ($_GET['offset'] / $pageSize) + 1 : 1;
$albumSize = $album[$album_config['album_size']];

//breadcrumbs
echo CHtml::openTag('div', array('id'=>$provider.'Breabcrumbs'));
echo CHtml::link('Альбомы', $albumsUrl,
    array(
        'class'=>'pager',
        'data-provider'=>$provider
    ));
echo '&nbsp;->';
echo $album[$album_config['title']];
echo CHtml::closeTag('div');

echo CHtml::link('Sort',  Yii::app()->createUrl($url, array(
    'auth'  => $_GET['auth'],
    $album_config['album_id']       => $_REQUEST[$album_config['album_id']],
    'rev'   => isset($_REQUEST['rev']) ? (int)(!$_REQUEST['rev']) : 1,
//    'page'  => isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1,
    'offset'    => ($currentPage - 1) * $album_config['page_size'],
    'limit'     => $album_config['page_size'],
    'provider'  => $provider,
)), array(
    'class'=>'pager',
    'data-provider'  => $provider,
));

//isset($_GET['page']) ? $_GET['page'] : 1;
echo CHtml::openTag('div', array(
    'id' => 'photoWidgetPager'
));
$pagersCount = ceil($albumSize / $pageSize);
/* previous page link */
if($currentPage != 1)
    echo CHtml::link('<-', Yii::app()->createUrl($url, array(
        'auth'      => $_GET['auth'],
        $album_config['album_id']       => $_REQUEST[$album_config['album_id']],
        'rev'       => isset($_REQUEST['rev']) ? (int)($_REQUEST['rev']) : 0,
        'page'      => $currentPage - 1,
        'offset'    => ($currentPage - 2) * $album_config['page_size'],
        'limit'     => $album_config['page_size'],
        'provider'  => $provider,
    )),array(
        'class'=> 'pager',
        'id'=>'pager'.($currentPage-1),
        'data-provider'  => $provider,
    ));
for($i = 1;$i <= $pagersCount; $i++) {
    echo CHtml::link($i, Yii::app()->createUrl($url, array(
        'auth'      => $_GET['auth'],
        $album_config['album_id']       => $_REQUEST[$album_config['album_id']],
        'rev'       => isset($_REQUEST['rev']) ? (int)($_REQUEST['rev']) : 0,
        'offset'    => ($i - 1) * $album_config['page_size'],
        'page'      => $i,
        'limit'     => $album_config['page_size'],
        'provider'  => $provider,
    )),array(
        'class'=>$currentPage == $i ? 'active' : 'pager',
        'id'=>'pager'.$i,
        'data-provider'  => $provider,
    ));
}
if($currentPage != $pagersCount)
    echo CHtml::link('->', Yii::app()->createUrl($url, array(
        'auth'      => $_GET['auth'],
        $album_config['album_id']       => $_REQUEST[$album_config['album_id']],
        'rev'       => isset($_REQUEST['rev']) ? (int)($_REQUEST['rev']) : 0,
        'page'      => $currentPage + 1,
        'offset'    => ($currentPage ) * $album_config['page_size'],
        'limit'     => $album_config['page_size'],
        'provider'  => $provider
    )),array(
        'class'=>'pager',
        'id'=>'pager'.($i+1),
        'data-provider'  => $provider,
    ));
echo '<span id="photoLoader"></span>';
echo CHtml::closeTag('div');
$len = count($photos);
for($i = 0; $i < $len; $i++) {
    echo CHtml::link(CHtml::image($photos[$i]['src'],$photos[$i]['text']).'<div class="add-photo">+<span>добавить</span></div>', '#', array(
        'class'=>'image-wrap'
    ));
}