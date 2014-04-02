<?php
$safe = array();
$required = array();
$validators = array();

foreach($model->validators as $validator)
{
    if($validator instanceof CRequiredValidator)
        $required = $validator->attributes;
    elseif($validator instanceof CSafeValidator)
        $safe = $validator->attributes;
}

$validators = array_merge($required,$safe);

$form = $this->beginWidget('CActiveForm', array(
    'id'=>'categorycreate-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
));
?>

<h6><?php echo Yii::t('backend','Поля с символом * - обязательны к заполнению!')?></h6><br />

<?php echo $form->errorSummary($model); ?>

<?php

    echo $form->hiddenField($model,'type',array('value'=>$model->type));

    echo $form->hiddenField($model,'link_type');


    echo $form->labelEx($model,'Родитель');
    echo CHtml::dropDownList('Sitemenu[parent]',isset($parent->id) ? $parent->id : '',$listData).'<br />';

    echo '<label>'.CHtml::label(Yii::t('backend','Отображать после'),'after').'</label>';
?>
<span id="after">
     <?php echo $this->getTreeDropDown(isset($parent->id) ? $parent->id : null,$model,$model->type);?>
</span>
<br />

    <?php echo CHtml::hiddenField('itemid',$model->id); ?>
<hr />

<?php
    $this->widget('bootstrap.widgets.TbTabs', array(
        'type'=>'tabs', // 'tabs' or 'pills'
        'tabs'=>$model->getTranslateData(Yii::app()->params['languages'],$model->translateAttributes,$validators,$model),
    ));

    echo CHtml::activeHiddenField($model,'scenario',array('value'=>$model->scenario));
    echo CHtml::hiddenField('itemid',$model->id);

    echo '<br />';
?>

<div id="messages" class="row-fluid">
</div>

<?php $this->widget('application.backend.extensions.widgets.SubmitButtons');

    $this->endWidget();
?>


<script>
    document.getElementById('Sitemenu_parent').onchange = function(){
        $.ajax({
            type:"POST",
            url: "<?=$this->createUrl('backend/menugen/sitemenu/dropdown',array('language'=>Yii::app()->language));?>",
            data:{
                parent:$('#Sitemenu_parent option:selected').val()
            },
            success: function(response){
                $('#after').html(response);
            }
        });
    }

    $(document).on("click","#save",function(e){
        var lang = "<?=Yii::app()->language?>";
        var text = $("#t_url_"+lang).val();
        if(text === ''){
            e.preventDefault();
            $("#messages").html("<div class='alert alert-error span3'>Error! You must fill in text!</div>");
            setTimeout(function(){
                $("#messages").html("");
            },3000);
        }
    });

    $(document).on("click","#confirm",function(e){
        var lang = "<?=Yii::app()->language?>";
        var text = $("#t_url_"+lang).val();
        if(text === ''){
            e.preventDefault();
            $("#messages").html("<div class='alert alert-error span3'>Error! You must fill in text!</div>");
            setTimeout(function(){
                $("#messages").html("");
            },3000);
        }
    });
</script>
