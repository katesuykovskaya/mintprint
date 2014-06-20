<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 26.03.14
 * Time: 23:28
 */

use Guzzle\Http\Client;
use Guzzle\Http\StaticClient;

class Vk {

    protected $token = false;
    protected $conf = null;


    public function __construct()
    {
        $this->conf = Yii::app()->getModule('social')->getConfig();
    }

    public function getToken()
    {
        $this->setToken();
        return $this->token;
    }

    public function setToken()
    {
        $vk = new Guzzle\Http\StaticClient();
        try {
            $test = $vk::get($this->conf['vk']['tokenUrl'] . '?' . urldecode(http_build_query($this->conf['vk']['token'])));
            $vkToken = $test->json();
            $token = isset($vkToken['access_token']) ? $vkToken['access_token'] : null;
            Yii::app()->session['vk_token'] = $token;
            $this->token = $token;
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }


    public function getAllPhotos($token)
    {
        $vk = new Guzzle\Http\StaticClient();

        try {
            $photoParams = [
                'count'=>100
            ];
            $apiUrl = 'https://api.vk.com/method/';
            $req = $vk::get($apiUrl.'photos.getAll?'.urldecode(http_build_query($photoParams)).'&access_token='.$token);
            $data = $req->json()['response'];
            return $data;
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getAlbums($token, array $params = array())
    {
        $vk = new Guzzle\Http\StaticClient();

        try {
            $photoParams = [
                'count'=>100,
                'need_covers'=>1
            ];
            $apiUrl = 'https://api.vk.com/method/';
            $req = $vk::get($apiUrl.'photos.getAlbums?'.urldecode(http_build_query(array_merge($photoParams, $params))).'&access_token='.$token);
            $response = $req->json();
            if(isset($response['error'])) {
                unset(Yii::app()->session['vk_token']);
                return null;
            }
            $data = $response['response'];
            $data[] = array(
                'aid'=>'wall',
                'title'=>'Фотографии со стены',
            );
            $data[] = array(
                'aid'=>'profile',
                'title'=>'Аватары',
            );
            $data[] = array(
                'aid'=>'saved',
                'title'=>'Сохраненные фотографии',
            );
            return $data;
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getPhotosFromAlbum($albumId, $token)
    {
        $vk = new Guzzle\Http\StaticClient();
        $count = $this->conf['vk']['albums']['page_size'];
        $rev = empty($_REQUEST['rev']) ? 0 : $_REQUEST['rev']; // sorting by date (1 - from old to new, 0 - from new to old)
        $offset = empty($_REQUEST['offset']) ? 0 : $_REQUEST['offset'];
//        $offset = empty($_REQUEST['page']) ? 0 : ($_REQUEST['page'] - 1) * $count;
        try {
            $photoParams = [
                'count'     => $count,
                'album_id'  => $albumId,
                'rev'       => $rev,
                'offset'    => $offset
            ];
            $apiUrl = 'https://api.vk.com/method/';
            $req = $vk::get($apiUrl.'photos.get?'.urldecode(http_build_query($photoParams)).'&access_token='.$token);
//            if(empty($req->json()['response'])) echo CVarDumper::dump($req->json(), 6, true);
            $data = $req->json()['response'];
//            echo CVarDumper::dump($data, 7, true);
//            die();
            return $data;
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
} 