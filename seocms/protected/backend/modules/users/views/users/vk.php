<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */


$client_id = '3485057'; // ID приложения

$client_secret = 'ldFMthERrnHUe9MXIMFT'; // Защищённый ключ

$redirect_uri = 'http://test.home/users/users/vklogin'; // Адрес сайта

$url = 'http://oauth.vk.com/authorize';



$params = array(
    'client_id'     => $client_id,
    'redirect_uri'  => $redirect_uri,
    'response_type' => 'code'
);

echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через ВКонтакте</a></p>';

if (isset($_GET['code'])) {
    $result = false;
    $params = array(
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $_GET['code'],
        'redirect_uri' => $redirect_uri,
    );
 
    $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
 
    if (isset($token['access_token'])) {
        $params = array(
            'uids'         => $token['user_id'],
            'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big,photo_rec',
            'access_token' => $token['access_token']
        );
 
        $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
        if (isset($userInfo['response'][0]['uid'])) {
            $userInfo = $userInfo['response'][0];
            $result = true;
        }
        
        echo CVarDumper::dump($userInfo,$depth=3,$highlight=true); echo '<br />';
    }
 
    if ($result) {
        echo "Социальный ID пользователя: " . $userInfo['uid'] . '<br />';
        echo "Имя пользователя: " . $userInfo['first_name'] . '<br />';
        echo "Email пользователя: " . $userInfo['last_name'] . '<br />';
        echo "Ссылка на профиль пользователя: " . $userInfo['screen_name'] . '<br />';
        echo "Пол пользователя: " . $userInfo['sex'] . '<br />';
        echo "День Рождения: " . $userInfo['bdate'] . '<br />';
        echo '<img src="' . $userInfo['photo_big'] . '" />'; echo "<br />";
//        echo 'hash: '.$userInfo['hash'].'<br />';
        echo '<img src="' . $userInfo['photo_rec'] . '" />'; echo "<br />";
    }
}



