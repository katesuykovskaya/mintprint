<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 29.10.13
 * Time: 11:37
 */

class FileUploadWidget extends CWidget{

    private $_assetsUrl;
    public $moduleAlias = 'application.backend.modules.gallery.assets';
    public $entity;
    public $entity_id;
    public $versions;
    public $tempUrl;
    public $uploadUrl;
    public $webTmp;
    public $webUrl;
    public $filePath;
    public $filesToken;
    public $id = 'fileupload';
    public $gallery = false;
    public $scriptUrl;

    public function init()
    {
        $filesArray = array(
            'files'=>array(
                'entity'=>$this->entity,
                'entity_id'=> $this->entity_id,
                'versions'=>$this->versions,
                'tempUrl'=>$this->tempUrl,
                'uploadUrl'=>$this->uploadUrl,
                'webTmp'=>$this->webTmp,
                'webUrl'=>$this->webUrl,
                'filePath'=>$this->filePath,
                'id'=>$this->id,
                'token'=>$this->filesToken,
                'scriptUrl'=>$this->scriptUrl,
            )
        );

        if($this->gallery === false || !isset(Yii::app()->session['files']))
            Yii::app()->session['files'] = $filesArray;
        else {
            $sessionArray = Yii::app()->session['files'];
            $sessionArray['files']['galleries'][] = $this->gallery;
            Yii::app()->session['files'] = $sessionArray;
        }

        $this->getAssetsUrl();
        $this->registerFiles();
    }

    public function getAssetsUrl()
    {
        if ($this->_assetsUrl === null)
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias($this->moduleAlias) );
        return $this->_assetsUrl;
    }

    public function run()
    {
        $this->render('fileUpload',[
            'id'=>$this->id,
            'entity'=>$this->entity,
            'entity_id'=> $this->entity_id,
            'versions'=>$this->versions,
            'tempUrl'=>$this->tempUrl,
            'uploadUrl'=>$this->uploadUrl,
            'webTmp'=>$this->webTmp,
            'webUrl'=>$this->webUrl,
            'filePath'=>$this->filePath,
            'token'=>$this->filesToken,
            'scriptUrl'=>$this->scriptUrl,
        ]);
    }

    private function registerFiles()
    {
        $clientScript = Yii::app()->clientScript;

        $clientScript->registerCssFile($this->assetsUrl.'/css/blueimp-gallery.min.css');
        $clientScript->registerCssFile($this->assetsUrl.'/css/jquery.fileupload.css');
        $clientScript->registerCssFile($this->assetsUrl.'/css/jquery.fileupload-ui.css');

        $clientScript->registerCoreScript('jquery');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/vendor/jquery.ui.widget.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/tmpl.min.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/load-image.min.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/canvas-to-blob.min.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/bootstrap.min.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/jquery.blueimp-gallery.min.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/jquery.iframe-transport.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/jquery.fileupload.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/jquery.fileupload-process.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/jquery.fileupload-image.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/jquery.fileupload-audio.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/jquery.fileupload-video.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/jquery.fileupload-validate.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/jquery.fileupload-ui.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/main.js');
        $clientScript->registerScriptFile($this->assetsUrl.'/js/cors/jquery.xdr-transport.js');
    }
} 