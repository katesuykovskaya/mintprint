<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 29.10.13
 * Time: 11:37
 */

class TmpSizeWidget extends CWidget
{

    private $_assetsUrl;
    public $moduleAlias = 'application.backend.modules.attach.assets';
    public $maxSize = null;
    public $path;
    public $clearAction;
    public $title = null;

    public function init()
    {
        $this->getAssetsUrl();
        $this->registerFiles();

    }

    public function getAssetsUrl()
    {
        if ($this->_assetsUrl === null)
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias($this->moduleAlias));
        return $this->_assetsUrl;
    }

    public function run()
    {
        $loaded = $this->getTempLoad($this->path);
        $this->render('tmpSizeWidget',array(
            'maxSize'=>$this->maxSize,
            'size'=>$loaded,
            'clearAction'=>$this->clearAction,
            'tmp'=>$this->path,
            'title'=>$this->title,
        ));
    }

    private function getTempLoad($path)
    {
        $io = popen('/usr/bin/du -sb '.$path, 'r');
        $size = intval(fgets($io,80));
        pclose($io);
        return round($size/(1024*1024));
    }

    private function registerFiles()
    {
        $clientScript = Yii::app()->clientScript;

        $clientScript->registerScriptFile($this->assetsUrl.'/js/google_jsapi.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/google_chart.js');
    }
} 