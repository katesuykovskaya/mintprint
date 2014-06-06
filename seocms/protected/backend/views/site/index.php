<?php
/**
 * @var $this SiteController
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/seocms/protected/backend/vendors/autoload.php';
?>

<h4 class="page-header"><em><?=Yii::t('backend','Панель администрирования проекта')?></em></h4>

<?php
    $this->widget('application.backend.modules.attach.widgets.TmpSizeWidget',array(
        /*size in Mb*/
        'maxSize'=>1024,
        'path'=>Yii::getPathOfAlias('webroot').'/uploads/tmp/',
        'clearAction'=> Yii::app()->urlManager->createUrl('/backend/attach/default/clearTmp'),
        'title'=>'Временная папка изображений: ',
    ));

    $this->widget('application.backend.modules.gallery.widgets.GalleryTmpSizeWidget',array(
        /*size in Mb*/
        'maxSize'=>1024,
        'path'=>Yii::getPathOfAlias('webroot').'/galleries/tmp/',
        'clearAction'=> Yii::app()->urlManager->createUrl('/backend/gallery/gallery/clearTmp'),
        'title'=>'Временная папка галереи: ',
    ));

use Guzzle\Http\Client;
use Guzzle\Http\StaticClient;
use Guzzle\Http\EntityBodyInterface;
use Guzzle\Plugin\Oauth\OauthPlugin as Auth;

// Create a client to work with the Twitter API
$client = new Client('https://api.twitter.com/{version}', array(
    'version' => '1.1'
));

// Sign all requests with the OauthPlugin
$client->addSubscriber(new Auth(array(
    'consumer_key'  => 'gHS0HH3gECwQjQ7u5lgwA',
    'consumer_secret' => 'II1jHeps4EcSbq4msrPsRTfzRME9Hw0U6IMlxhyDM',
    'token'       => '306783637-NBWHseGXjdvu3D7HhOFs6CaxjpqUL4PdXvJztX2h',
    'token_secret'  => 'muBns8c2vPUHsC4h4KEJxVk5NbU9caHPFudipztKk'
)));

$myTweets = $client->get('statuses/user_timeline.json')->send()->getBody();
//echo $myTweets;

$tweets = CJSON::decode($myTweets);
?>
<div class="span4 pull-right">
<?php foreach($tweets as $key=>$tweet): ?>
    <div class="span3">
        <form>
            <fieldset>
                <legend></legend>
                <label><?=Yii::app()->dateFormatter->format('dd MMMM H:mm:ss',$tweet['created_at'])?></label>
                <span class="help-block"><?=explode('http',$tweet['text'])[0]?></span>
            </fieldset>
        </form>
    </div>
<?php endforeach?>
</div>

<?php
//$socialArray = require_once(Yii::getPathOfAlias('application.backend.modules.social.config').'/config.php');
//////////////////// vkontakte ///////////

//if (isset($_GET['auth']) && $_GET['auth'] === 'vk') {
//    $vk = new Guzzle\Http\StaticClient();

//    try {
//        $test = $vk->post($socialArray['vk']['tokenUrl']);
//        $test->addPostFields($socialArray['vk']['token']);
//        $test = $vk::get($socialArray['vk']['tokenUrl'] . '?' . urldecode(http_build_query($socialArray['vk']['token'])));
//        $vkToken = $test->send()->json();
//        $vkToken = $_GET['token'];
//        $vkToken = $test->json();
//        echo 'access token: '.$vkToken['access_token'];

//        try {
//            $photoParams = [
//                'count'=>100
//            ];
//            $apiUrl = 'https://api.vk.com/method/';
//            $req = $vk::get($apiUrl.'photos.getUserPhotos?'.urldecode(http_build_query($photoParams)).'&access_token='.$vkToken);
//            $photos = $req->json()['response'];
//            $len = count($photos);
//            for($i=1; $i < $len; $i++) {
//                    echo CHtml::image($photos[$i]['src_big'],$photos[$i]['text']);
//            }
//        } catch(Exception $e) {
//            echo $e->getMessage();
//        }
//
//    } catch(Exception $e) {
//        echo $e->getMessage();
//    }
//}
//
///////////////// vkontakte end /////////////////
//
//
/////////////////// instagram ////////////
//
//if(isset($_GET['auth']) && $_GET['auth'] === 'instagram') {
//    $instaMediaUrl = 'https://api.instagram.com/v1/users/self/feed';
//    $insta = new Guzzle\Http\Client();
//
//    try {
//        $request = $insta->post($socialArray['instagram']['tokenUrl']);
//        $request->addPostFields($socialArray['instagram']['token']);
//        $instaToken = $request->send()->json();
//        $token = $instaToken['access_token'];
//        echo 'token is: '.$token;
//
//        try {
//            $requestM = $insta->get($instaMediaUrl.'?access_token='.$token);
//            $instaMedia = $requestM->send()->json();
//            if(!empty($instaMedia)) {
//                foreach($instaMedia['data'] as $key=>$image) {
//                    if(!empty($image['images'])) {
//                        echo CHtml::image($image['images']['thumbnail']['url'],$image['caption']['text']);
//                    }
//                }
//            }
//        } catch (Exception $e) {
//            echo $e->getMessage();
//        }
//    } catch(Exception $e) {
//        echo $e->getMessage();
//    }
//}
//////// end of instagram //////////////


////////////// facebook ////////////////
//
//if (isset($_GET['auth']) && $_GET['auth'] === 'fb') {
//    $fb = new Guzzle\Http\StaticClient();
//
//    try {
//        $test = $fb::get($socialArray['fb']['tokenUrl'] . '?' . urldecode(http_build_query($socialArray['fb']['token'])));
//        $fbToken = $test->getBody(true); // as string
//        $arr1 = [];
//        parse_str($fbToken,$arr1);
//        echo 'access token: '.$arr1['access_token'];
//
//        try {
//            $apiUrl = 'https://graph.facebook.com/me/photos/uploaded';
//            $req = $fb::get($apiUrl.'?&access_token='.$arr1['access_token']);
//
//            $photos = $req->json();
//
//            foreach($photos['data'] as $key=>$photo) {
//                echo CHtml::image($photo['source']);
//            }
//        } catch(Exception $e) {
//            echo $e->getMessage();
//        }
//    } catch(Exception $e) {
//        echo $e->getMessage();
//    }
//}
//
///////////// end of facebook ////////////////
//
//
///////////// google + ///////////////////////
//
//if (isset($_GET['auth']) && $_GET['auth'] === 'google') {
//    $google = new Guzzle\Http\Client();
//
//    try {
//        $request = $google->post($socialArray['google']['tokenUrl']);
//        $request->addPostFields($socialArray['google']['token']);
//        $googleToken = $request->send()->json();
//        $token = $googleToken['access_token'];
//
//        try {
//            $google2 = new Guzzle\Http\StaticClient();
//            $apiUrl = 'https://www.googleapis.com/oauth2/v3/userinfo';
//            $req = $google2::get($apiUrl.'?'.urldecode(http_build_query($socialArray['google']['token'])).'&access_token='.$token);
//
//            $data = $req->json();
//            echo CVarDumper::dump($data,5,true);
//        } catch(Exception $e) {
//            echo $e->getMessage();
//        }
//
//    } catch(Exception $e) {
//        echo $e->getMessage();
//    }
//}
//
/////////////end of google + /////////////////
//Yii::app()->session->clear();

/*$this->widget('backend.modules.social.widgets.SocialAuthWidget',[
    'providers'=>['vk','fb','instagram','google'],
    'socialArray'=>$socialArray,
    'scenario'=>'photos'
]);
*/
echo CHtml::link('CLEAR', '/backend/social/default/clearSession');
//http://oauth.vk.com/authorize?client_id=4321188&amp;response_type=code&amp;scope=photos&amp;redirect_uri=http://photo-service.home/backend/social/default/auth/authprovider/vk?scenario=photos&amp;v=5.16
//http://oauth.vk.com/authorize?client_id=4321188&amp;response_type=code&amp;scope=photos&amp;redirect_uri=http://photo-service.home/backend/social/default/auth/authprovider/vk&amp;v=5.16&amp;scenario=photos
