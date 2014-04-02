<?php
/* @var $this NewsController */
/* @var $model News */
?>

<h3 class="page-header"><?php echo Yii::t('backend','Обновление новости: ').'<br />'.$model->translation[Yii::app()->language]['t_title']; ?></h3>

<?php echo $this->renderPartial('_formUpdate', array('model'=>$model)); ?>