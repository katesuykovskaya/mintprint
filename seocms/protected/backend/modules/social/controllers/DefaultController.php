<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionAuth($authprovider)
    {
        echo CVarDumper::dump($_GET,5,true); die();

        $authClass = ucfirst($authprovider);
        $auth = new $authClass();
        $token = $auth->getToken();

        $this->redirect($this->createUrl('/backend?auth='.$authprovider.'&token='.$token));
    }

    public function actionAjaxAuth()
    {
        $provider = $_POST['provider'];
        $authClass = ucfirst($provider);
        $auth = new $authClass();
        $token = $auth->getToken();

        $this->redirect($this->createUrl('/backend?auth='.$provider.'&token='.$token));
    }

    public function actionTest()
    {
        $provider = $_POST['provider'];
        $providerUrl = $_POST['providerUrl'];

        $conf = Yii::app()->getModule('social')->getConfig();
        $vk = new Guzzle\Http\StaticClient();
        $client = new Guzzle\Http\Client();
//

        $req = $client->get($conf['vk']['authUrl'] . '?' . urldecode(http_build_query($conf['vk']['auth'])));
        echo CVarDumper::dump($req->send()->getBody(),5,true);
//        try {
//            $client->get($conf['vk']['authUrl'] . '?' . urldecode(http_build_query($conf['vk']['auth'])));
//            echo CVarDumper::dump($client,5,true);
//        } catch (RequestException $e) {
//            echo $e->getRequest() . "\n";
//            if ($e->hasResponse()) {
//                echo $e->getResponse() . "\n";
//            }
//        }


//        try {
//            $test = $vk::post($conf['vk']['authUrl'] . '?' . urldecode(http_build_query($conf['vk']['auth'])));
////            $vkToken = $test->json();
////            $token = isset($vkToken['access_token']) ? $vkToken['access_token'] : null;
//            echo CVarDumper::dump($test->json(),5,true);
//        } catch(Exception $e) {
//            echo $e->getMessage();
////            $token =  null;
//        }


    }


}