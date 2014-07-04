<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 29.10.13
 * Time: 11:37
 */

class TmpOrderWidget extends CWidget
{

    private $_assetsUrl;
    public $moduleAlias = 'application.backend.modules.attach.assets';
    public $maxSize = null;
    public $path;
    public $clearAction;
    public $title = null;
    public $timeCriteria = 604800;

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
        $this->render('tmpOrderWidget',array(
            'maxSize'=>$this->maxSize,
            'size'=>$loaded,
            'clearAction'=>$this->clearAction,
            'tmp'=>$this->path,
            'title'=>$this->title,
            'timeCriteria'=>$this->timeCriteria
        ));
    }

    private function getTempLoad($path)
    {
        return round($this->foldersize($path)/(1024*1024));
    }

    protected function foldersize($path) {
        $total_size = 0;
        $files = scandir($path);
        $cleanPath = rtrim($path, '/'). '/';

        foreach($files as $t) {
            if ($t<>"." && $t<>"..") {
                $currentFile = $cleanPath . $t;
                if (is_dir($currentFile)) {
                    $size = $this->foldersize($currentFile);
                    $total_size += $size;
                }
                else {
                    $size = filesize($currentFile);
                    if(filectime($currentFile) + $this->timeCriteria < time())
                        $total_size += $size;
                }
            }
        }

        return $total_size;
    }

    private function registerFiles()
    {
        $clientScript = Yii::app()->clientScript;

        $clientScript->registerScriptFile($this->assetsUrl.'/js/google_jsapi.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/google_chart.js');
    }
} 