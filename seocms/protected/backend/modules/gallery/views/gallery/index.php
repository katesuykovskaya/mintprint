<?php
/* @var $this GalleryController */
/* @var $dataProvider CActiveDataProvider */
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Управление галереями')?></li>
    </ul>
</div>

<h3><?=Yii::t('backend','Управление галереями')?></h3>

<?=CHtml::link(Yii::t('backend','Создать галерею'),$this->createUrl('backend/gallery/gallery/gallerycreate',['language'=>Yii::app()->language]),['class'=>'btn'])?>


<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
<script>
    $(document).on("click","#delete",function(e){
        e.preventDefault();
        if(confirm($(this).data("prompt"))){
            $.ajax({
                type:"POST",
                url:"/backend/gallery/gallery/removeNode",
                data:{
                    id:$(this).data("id"),
                    role:"category"
                },
                success:function(){
                    window.location.reload();
                }
            });
        }
    });
</script>