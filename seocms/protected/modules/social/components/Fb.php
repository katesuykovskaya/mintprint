<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 27.03.14
 * Time: 8:45
 */

class Fb {

    protected $token = false;
    protected $conf = null;


    public function __construct()
    {
        $this->conf = Yii::app()->getModule('social')->getConfig();
    }

    public function setToken()
    {
        $fb = new Guzzle\Http\StaticClient();
        try {
            $test = $fb::get($this->conf['fb']['tokenUrl'] . '?' . urldecode(http_build_query($this->conf['fb']['token'])));
            $fbToken = $test->getBody(true); // as string
            $arr1 = [];
            parse_str($fbToken,$arr1);
            $this->token = isset($arr1['access_token']) ? $arr1['access_token'] : null;
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }


    public function getToken()
    {
        $this->setToken();
        return $this->token;
    }

    public function getPhotos($token)
    {
        $fb = new Guzzle\Http\StaticClient();

        try {
            $apiUrl = 'https://graph.facebook.com/me/photos/uploaded';
            $req = $fb::get($apiUrl.'?&access_token='.$token);

            $data = $req->json();

        return $data;
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getAlbums($token, array $params = array()) {
        $fb = new Guzzle\Http\StaticClient();
        if(empty($params)) {
            $apiUrl = 'https://graph.facebook.com/me/albums';
            $req = $fb::get($apiUrl.'?&access_token='.$token);
            $data = $req->json();

            foreach($data['data'] as $key=>$val) {
//            echo $val['cover_photo'].'<br>';

                $url = 'https://graph.facebook.com/'.$val['id'].'/photos';
                $req = $fb::get($url.'?&access_token='.$token);
                $cover = array();
                $cover = $req->json();
                if(empty($cover['data'][0]['images']))
                    $cover['data'][0]['images'] = array();

                $data['data'][$key]['thumb_src'] = end($cover['data'][0]['images'])['source'];
            }

            return $data['data'];
        }
        else {
            $apiUrl = 'https://graph.facebook.com/'.$params['album_ids'];
            $req = $fb::get($apiUrl.'?&access_token='.$token);
            $data = $req->json();
            return array($data);
        }
    }

    public function getPhotosFromAlbum($id, $token) {
        $fb = new Guzzle\Http\StaticClient();
        $count = 20;
        $offset = empty($_REQUEST['offset']) ? 0 : $_REQUEST['offset'];
        $params = array(
            'offset'=> $offset,
            'limit'=>$count,
        );
        $url = 'https://graph.facebook.com/'.$id.'/photos';
        $req = $fb::get($url.'?'.urldecode(http_build_query($params)).'&access_token='.$token);
        $data = $req->json()['data'];
        $result = array();
        foreach($data as $val) {
            $result[] = array(
                'src'=>$val['picture'],
                'src_big'=>$val['source']
            );
        }
        return $result;
//        return $data;
    }
}
