<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kate
 * Date: 30.01.14
 * Time: 11:19
 * To change this template use File | Settings | File Templates.
 */

class MultilangUrl {
    private static $_modelTranslation;
    private static $_url;
    private static $_prefix;
    private static $_sufix;
    private static $_index_field_name;
    private static $_search_attr;
    public static $errorPage = 'site/error';

    public static function createFromModel($params) {
        self::$_url = $params['translit'];
        $urlName = $params['translit'];
        self::$_modelTranslation = $params['model'];
        self::$_index_field_name = $params['index'];
        self::$_prefix = $params['prefix'];
        self::$_sufix = $params['sufix'];
        self::$_search_attr = $params['search_attr'];

        $urls = array();
        $langs = Yii::app()->params['languages'];
        $model = self::loadModel(self::$_search_attr, self::$_modelTranslation, self::$_index_field_name);
//        echo CVarDumper::dump($model, 5, true);
        foreach($langs as $key => $lang) {
            if(isset($model[$key]) && !empty($model[$key]->$urlName)) {
                $translit = $model[$key]->$urlName;
                if($key != Yii::app()->sourceLanguage)
                    $url = $key;
                else
                    $url = '';
                if(!empty(self::$_prefix)) $url .= '/'.self::$_prefix;
                $url .= '/'.$translit;
                if(!empty(self::$_sufix)) $url .= self::$_sufix;
            } else
                $url = Yii::app()->createUrl(self::$errorPage, ['language'=>$key]);

            $urls[$key] = $url;
        }

        return $urls;
    }

//    public static function createFromUrl() {
//        $langs = Yii::app()->params['languages'];
//        $url = Yii::app()->request->url;
//        foreach($langs as $key => $lang) {
//            echo Yii::app()->createUrl($url, array('language'=>$key)).'<br>';
//        }
//    }

    public static function createFromPage($page) {
        $urls = array();
        $langs = Yii::app()->params['languages'];
        foreach($langs as $key => $lang) {
            $urls[$key] = '';
            if($key != Yii::app()->sourceLanguage)
                $urls[$key] .= '/'.$key;
            $urls[$key] .= '/'.$page;
        }
        return $urls;
    }

    public static function createFromUrl() {
        $urls = array();
        $currUrl = Yii::app()->request->url;
        $pattern = "/\/([a-z]{2})\/(.*)/";
        preg_match($pattern, $currUrl, $out);
        // language is set
        if(!empty($out)) {
            /* for current url "/en/main.html"
             * $out[1] - language - "en"
             * $out[2] - pure URL - "/main.html"
             */
            $pureUrl = $out[2];
        } else
            $pureUrl = $currUrl;
        if(strncmp($pureUrl, '/', 1)) {
            $pureUrl = '/'.$pureUrl;
        }

        foreach(Yii::app()->params['languages'] as $code=>$lang) {
            $urls[$lang['langcode']] = '';
            if($lang['langcode'] != Yii::app()->sourceLanguage)
                $urls[$lang['langcode']] .= '/'.$lang['langcode'];
            $urls[$lang['langcode']] .= $pureUrl;
        }
        return $urls;
    }

    public static function createFromPrevious() {
        $urls = [];
        foreach(Yii::app()->params['languages'] as $code=>$lang) {
            if($code == Yii::app()->language) {
                $urls[$code] = Yii::app()->request->url;
            } else {
                $urls[$code] = Yii::app()->request->urlReferrer;
            }
        }
        return $urls;
    }

    public static function loadModel($attributes, $modelName, $index = 't_lang'){
        $model = $modelName::model()->findAllByAttributes($attributes, array('index' => $index));
        return $model;
    }
}