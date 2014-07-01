<?php
/**
 * @var $this SiteController
 */
?>

<h4 class="page-header"><em><?=Yii::t('backend','Панель администрирования проекта')?></em></h4>

<?php
//    $this->widget('application.backend.modules.attach.widgets.TmpSizeWidget',array(
//        /*size in Mb*/
//        'maxSize'=>1024,
//        'path'=>Yii::getPathOfAlias('webroot').'/uploads/tmp/',
//        'clearAction'=> Yii::app()->urlManager->createUrl('backend/attach/default/clearTmp'),
//        'title'=>'Временная папка изображений: ',
//    ));
    $timeCriteria = 60 * 60 * 24 * 7;
    $this->widget('application.backend.modules.order.widgets.TmpOrderWidget',array(
        /*size in Mb*/
        'maxSize'=>1024,
        'path'=>Yii::getPathOfAlias('webroot').'/uploads/tmp/',
        'clearAction'=> Yii::app()->urlManager->createUrl('backend/order/order/clearTmp'),
        'title'=>'Временная папка изображений: ',
        'timeCriteria'=>$timeCriteria
    ));