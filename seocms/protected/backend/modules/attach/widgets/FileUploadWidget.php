<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 29.10.13
 * Time: 11:37
 */

class FileUploadWidget extends CWidget{

    private $_assetsUrl;
    public $moduleAlias = 'application.backend.modules.attach.assets';
    public $entity;
    public $entity_id;
    public $versions;
    public $tempUrl;
    public $uploadUrl;
    public $webTmp;
    public $webUrl;
    public $filePath;
    public $filesToken;

    public function init()
    {
        $filesArray = array(
            'files'=>array(
                'entity'=>$this->entity,
                'entity_id'=> $this->entity_id,
//                'versions'=>array('small','thumbnail',''),
//                'tempUrl'=>Yii::getPathOfAlias('webroot').'/uploads/tmp/'.$this->filesToken.DIRECTORY_SEPARATOR,
//                'uploadUrl'=>Yii::getPathOfAlias('webroot').'/uploads/',
//                'webTmp'=>'/uploads/tmp/'.$this->filesToken.DIRECTORY_SEPARATOR,
//                'webUrl'=>'/uploads/',
//                'filePath'=>Yii::getPathOfAlias('webroot').'/uploads/'.$this->entity.DIRECTORY_SEPARATOR.$this->entity_id.DIRECTORY_SEPARATOR,
                'versions'=>$this->versions,
                'tempUrl'=>$this->tempUrl,
                'uploadUrl'=>$this->uploadUrl,
                'webTmp'=>$this->webTmp,
                'webUrl'=>$this->webUrl,
                'filePath'=>$this->filePath,
                'token'=>$this->filesToken,
            )
        );
        Yii::app()->session['files'] = $filesArray;
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
        $this->render('fileUpload');
    }

    private function registerFiles()
    {
        $clientScript = Yii::app()->clientScript;

//        $clientScript->registerCssFile($this->assetsUrl.'/css/bootstrap.min.css');
        /*adds 60px padding to top and thats all (useless file)*/
//        $clientScript->registerCssFile($this->assetsUrl.'/css/style.css');
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