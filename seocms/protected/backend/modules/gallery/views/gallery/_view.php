<?php
/* @var $this GalleryController */
/* @var $data Gallery */
$model = Gallery::model()->findByPk($data->id);
?>
<div class="well span3">
    <a href="<?=$this->createUrl('backend/gallery/gallery/view',['id'=>$data->id,'language'=>Yii::app()->language])?>">
        <h4 class="page-header"><?=CHtml::encode($data->translation[Yii::app()->language]->t_title);?></h4>

        <br />
        <?php
            $count = count($model->children()->findAll());
            echo ($count == 0) ? Yii::t('backend','Галерея пуста') : Yii::t('backend','количество элементов: ').$count;
        ?>
        <br />
    </a>
    <a href="#" id="delete" data-prompt="<?=Yii::t('backend','Удалить категорию со всеми файлами в ней ?')?>" data-id="<?=$data->id?>"><i class="icon-remove icon-2x"></i></a>
</div>