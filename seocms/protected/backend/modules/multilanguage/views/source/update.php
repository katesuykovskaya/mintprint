<h3 class="page-header"><?php echo Yii::t('backend','Редактирование').' '; echo $model->message; ?></h3>

<?php echo $this->renderPartial('_form_update', array(
    'model'=>$model,
    'translation'=>$translation,
)); ?>