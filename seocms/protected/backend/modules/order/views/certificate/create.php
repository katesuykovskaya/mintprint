<?php
/* @var $this CertificateController */
/* @var $model Certificate */
?>
    <div class="row">
        <ul class="breadcrumb span6">
            <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',array('language'=>Yii::app()->language)))?></li>
            <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Сертификаты'),$this->createUrl('/backend/order/certificate/admin',array('language'=>Yii::app()->language)))?></li>
            <li><span class="divider">/</span><?=Yii::t('backend','Создание сертификата ')?></li>
        </ul>
    </div>
<h1>Create Certificate</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>