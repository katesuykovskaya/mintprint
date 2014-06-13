<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Меню сайта'),$this->createUrl('backend/menugen/sitemenu/index',array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=CHtml::link($parent->translation[Yii::app()->language]->t_text,$this->createUrl('backend/menugen/sitemenu/view',array('type'=>$model->type,'language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=$model->translation[Yii::app()->language]->t_text?></li>
    </ul>
</div>

<div class="span10">

      <?php
      echo CHtml::beginForm($this->createUrl('backend/menugen/sitemenu/updatemenu'),'post',array('id'=>'updateForm','name'=>'updateForm'));

      echo CHtml::label(Yii::t('backend','Тип'),Yii::t('backend','link_type'));
      echo CHtml::dropDownList('type_link',$model->link_type,ZHtml::enumItem($model,'link_type'));?>
    <hr />

    <div id="formContent">
    <?php
        $this->renderPartial('_form'.ucfirst($model->link_type),array(
            'model'=>$model,
            'listData'=>$listData,
            'parent'=>$parent,
        ),false,true);
    ?>
    </div>
    <?php echo CHtml::endForm();?>
</div>

<script>
    $(document).on('change','#type_link',function(){
            $.ajax({
                type:"POST",
                url:"<?=$this->createUrl('backend/menugen/sitemenu/changeType',array('language'=>Yii::app()->language));?>",
                data:{
                    link_type:this.value,
                    model_id:"<?=$model->id;?>"
                },
                success:function(response){
                    $('#formContent').html(response);
                    $('#Sitemenu_link_type').val($('#type_link').val());
                }
            })
        }
    );
</script>