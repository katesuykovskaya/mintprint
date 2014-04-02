<?php

class UrlManager extends CUrlManager
{
    
    public function createUrl($route,$params=array(),$ampersand='&')
    {
        if(!isset($params['language'])){
            $route = '/'.$route;
            unset($params['language']);
            return parent::createUrl($route, $params, $ampersand);
        }

        if((isset($params['language']) && $params['language'] == Yii::app()->sourceLanguage)){
            $route = '/'.$route;
            unset($params['language']);
        return parent::createUrl($route, $params, $ampersand);
        }

        if(isset($params['language']) && $params['language'] != Yii::app()->sourceLanguage){
            $route = '/'.$params['language'].'/'.$route;
            unset($params['language']);
        return parent::createUrl($route, $params, $ampersand);
        }
   }

    static function collectRules()
    {
        if(!empty(Yii::app()->modules))
        {
        $cache = Yii::app()->getCache();
            foreach(Yii::app()->modules as $moduleName => $config)
            {
            $urlRules = false;
            if($cache)
                $urlRules = $cache->get('module.urls.'.$moduleName);
            if($urlRules===false){
                $urlRules = array();
                $module = Yii::app()->getModule($moduleName);
            if(isset($module->urlRules))
                $urlRules = $module->urlRules;
            if($cache)
                $cache->set('module.urls.'.$moduleName, $urlRules,300);
                }
            if(!empty($urlRules))
            Yii::app()->getUrlManager()->addRules($urlRules);
            }
        }
        return true;
    }
}