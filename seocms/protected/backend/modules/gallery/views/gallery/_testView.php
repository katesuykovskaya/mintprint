<?php
/*FOR TEST ONLY*/
//Yii::import('application.backend/modules.pages.models.StaticPages');
//$model = StaticPages::model()->findByPk(2);
/*FOR TEST ONLY*/

/*
 * IMPORTANT: entity and its id (if !$model->isNewRecord) assigned to textarea in multilingual behavior
 * (via data-attributes during dynamic tabs generation)
 * */

$filesToken = sha1(uniqid(mt_rand(),true));
$entity = get_class($model);
//$entity = 'StaticPages';
//$entityId =  (int)Yii::app()->request->getParam('id');
$this->widget('application.backend.modules.gallery.widgets.FileUploadWidget',array(
    'entity'=>$entity,
    'id'=>$widgetId,
    'entity_id'=> !$model->isNewRecord ? $model->page_id : null,
//    'entity_id'=> $entityId,
    'versions'=>array(0=>'thumbnail',1=>''),
    'tempUrl'=>Yii::getPathOfAlias('webroot').'/uploads/tmp/'.$filesToken.DIRECTORY_SEPARATOR,
    'uploadUrl'=>Yii::getPathOfAlias('webroot').'/uploads/',
    'webUrl'=>'/uploads/tmp/'.$filesToken.DIRECTORY_SEPARATOR,
    'filePath'=>Yii::getPathOfAlias('webroot').'/uploads/'.$entity.DIRECTORY_SEPARATOR.$model->page_id.DIRECTORY_SEPARATOR,
    'filesToken'=>$filesToken,
//    'gallery'=>$widgetId,
    'scriptUrl'=>'/backend/gallery/gallery/init/',
));

//echo CVarDumper::dump($_SESSION,5,true);
