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
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'pagecreate-form',
    'enableAjaxValidation'=>true,
//    'enableClientValidation'=>true,
));
?>

<h6>
    <?php echo Yii::t('backend','Поля с символом * - обязательны к заполнению!')?>
</h6><br />

<?php echo $form->errorSummary($model); ?>

<?php

    echo $form->hiddenField($model,'type',array('value'=>$model->type));

    echo $form->labelEx($model,Yii::t('backend','Страница'));

        /* if this is not new record - we need to set the model->t_text as dropdown's selected option */

        if($model->isNewRecord)
        {
            echo $form->dropDownList($model,'page',CHtml::listData(PagesTranslate::model()->findAllByAttributes(array('t_lang'=>Yii::app()->language)),'page_id','t_title')
                ,array(
                    'empty'=>Yii::t('backend','Выберите страницу'),
                )
            );
        } else {
            echo $form->dropDownList($model,'page',CHtml::listData(PagesTranslate::model()->findAllByAttributes(array('t_lang'=>Yii::app()->language)),'page_id','t_title')
                ,array(
                    'empty'=>null,
                    'options'=>array(PagesTranslate::getIdByUrl($model->translation[Yii::app()->language]->t_url)=>array('selected'=>'selected')),
                )
            );
        }
            echo $form->error($model,'page');

    if(!$model->isNewRecord)
        echo '<br />'.CHtml::link('<i class="icon-edit"></i>'.Yii::t('backend','Редактировать данные страницы'),
                $this->createUrl('/backend/pages/pages/update'
                    ,array('id'=>PagesTranslate::getIdByUrl($model->translation[Yii::app()->language]->t_url))
                ),array('id'=>'editlink')).'<br />';

    echo $form->hiddenField($model,'link_type',array('value'=>'page'));
    echo $form->error($model,'link_type');

    echo '<label>'.CHtml::label(Yii::t('backend','Родитель'),'parent').'</label>';
    echo CHtml::dropDownList('Sitemenu[parent]',isset($parent->id) ? $parent->id : '',$listData).'<br />';

    echo '<label>'.CHtml::label(Yii::t('backend','Отображать после'),'after').'</label>';
?>
<span id="after">
    <?php echo $this->getTreeDropDown(isset($parent->id) ? $parent->id : null,$model, $model->type);?>
</span>
<br />
    <?php echo CHtml::hiddenField('itemid',$model->id); ?>
<hr />

    <?php

    echo CHtml::link('<i class="icon-repeat"></i>'.Yii::t('backend','Обновить данные о странице'),'#',array('id'=>'updatelink','data-field'=>'t_text'));

    $this->widget('bootstrap.widgets.TbTabs', array(
        'type'=>'tabs', // 'tabs' or 'pills'
        'tabs'=>$model->getTranslateData(Yii::app()->params['languages'],$model->translateAttributes,$validators,$model),
    ));

    echo CHtml::hiddenField('scenario',$model->scenario);
    echo '<br />';

    ?>

<div id="messages" class="row-fluid">
<?php if(Yii::app()->user->hasFlash('error_message')) :?>

    <div class="alert alert-error span6">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><?php echo Yii::app()->user->getFlash('error_message');?></strong>
    </div>

    <?php endif;?>
</div>
<?php $this->widget('application.backend.extensions.widgets.submitButtons.SubmitButtons');

    /* end of form-widget*/
    $this->endWidget();

    ?>

<script type="text/javascript">
//    var $ = jQuery;
    var action = "<?=Yii::app()->controller->action->id;?>";
    var pageField = document.getElementById('Sitemenu_page');
    var editLink = document.getElementById('editlink');
    var updateLink = document.getElementById('updatelink');
    var parentField = document.getElementById('Sitemenu_parent');
    var languages = <?=CJSON::encode(array_keys(Yii::app()->params['languages']));?>;
    var attrs = <?=CJSON::encode(array_keys($model->translateAttributes));?>;
    var loaders = <?=CJSON::encode(array(
                                't_text',
                                't_hide'
                                ));?>

    $(document).ready(function(){
        setLoaders(loaders);
        setReadOnly();
    });

    function getTranslit(attrs,message,lang){
        $.ajax({
            type:"POST",
            url: "<?=$this->createUrl('backend/menugen/sitemenu/getTranslit',array('language'=>Yii::app()->language));?>",
            data:{
                pageid:pageField.value,
                lang:lang
            },
            success:function(response){
                var result = JSON.parse(response);

                if(result=='error') {
                    if(message != undefined){
                        $(updateLink).after("<span class='alert alert-error'>choose page first!</span>");
                        setTimeout(function(){
                            $('.alert-error').fadeOut();
                        },2000);
                    } else {
                        $.each(languages,function(key,v){
                            for(var i in attrs)
                            {
                                var value = attrs[i];
                                var elem = document.getElementById(value+"_"+v);
                                var val = '';
                                if(elem.type=='text') {
                                    $(elem).attr("value",val);
                                } else if (elem.type=='checkbox'){
                                    if(val=='0')
                                        $(elem).attr("checked","checked");
                                    else
                                        $(elem).removeAttr("checked");
                                }
                            }
                        });
                    }
                } else {
                    $.each(result,function(key,v){
                        for(var i in attrs)
                        {
                            var value = attrs[i];
                            var elem = document.getElementById(value+"_"+key);
                            var val = v[value] || '';
                            if(elem.type=='text') {
                                $(elem).attr("value",val);
                            } else if (elem.type=='checkbox'){
                                if(val=='0')
                                    $(elem).attr("checked","checked");
                            }
                        }
                        if(editLink != undefined){
                          $(editLink).attr("href","/backend/pages/pages/update/id/"+v.page_id);
                        }
                    });
                    if(message != undefined){
                        $(updateLink).after("<span class='alert alert-success'>updated successfully!</span>");
                        setTimeout(function(){
                            $('.alert-success').fadeOut();
                        },2000);
                    }
                }
            }
        });
    };

    function setReadOnly(){
        var count = languages.length;
            for(var i=0; i < count; i++)
            {
                document.getElementById('t_url_'+languages[i]).setAttribute('readonly','readonly');
            }
    }

    function setLoaders(loaders){
        var pageId = $('#Sitemenu_page option:selected').val();
        if(pageId != ''){

            $.each(languages,function(key,value){

                for(var i in attrs)
                {
                    var element = document.getElementById(loaders[i]+"_"+value);
                    if($(element).next("i").get(0) == undefined){
                        $(element).after(
                            '<i class="icon-repeat" data-element="'+loaders[i]+'" data-language="'+value+'" data-id="'+$('#Sitemenu_page option:selected').val()+'"></i>'
                        );
                    } else {
                        var repeatElem = $(element).next("i").get(0);
                        $(repeatElem).attr("data-element",loaders[i]);
                        $(repeatElem).attr("data-language",value);
                        $(repeatElem).attr("data-id",$('#Sitemenu_page option:selected').val());
                    }
                }
            });
        }
    }


    pageField.onchange = function(){
        getTranslit(attrs);
        setLoaders(loaders);
    };

    updateLink.onclick = function(e){
        e.preventDefault();
        getTranslit(attrs,message=true);
    };

    parentField.onchange = function(){
        $.ajax({
            type:"POST",
            url: "<?=$this->createUrl('backend/menugen/sitemenu/dropdown',array('language'=>Yii::app()->language));?>",
            data:{
                parent:$('#Sitemenu_parent option:selected').val()
            },
            success: function(response){
                $('#after').html(response);
            }
        });}


    $(document).on("click",".icon-repeat",function(){
            $.ajax({
                type:"POST",
                url:"<?= $this->createUrl('backend/menugen/sitemenu/loadData');?>",
                data:{
                    element:$(this).attr('data-element'),
                    language:$(this).attr('data-language'),
                    id:$(this).attr('data-id')
                },
                success:function(response){
                    var result = JSON.parse(response);
                    var elem = document.getElementById(result.attrbt+"_"+result.lang);
                    if(elem.type=='text') {
                        $(elem).attr("value",result.dat);
                    } else if (elem.type=='checkbox'){
                        if(result.dat=='0')
                            $(elem).attr("checked","checked");
                    }
                    $(elem).next().after("<span class='alert alert-success'>updated successfully!</span>");

                    setTimeout(function(){
                        $('.alert-success').fadeOut();
                    },2000);
                }
            });
        }
    );

    $(document).on("click","#save",function(e){
        var page = $("#Sitemenu_page").val();
        if(page === ''){
            e.preventDefault();
            $("#messages").html("<div class='alert alert-error span3'>Error! Choose page first!</div>");
            setTimeout(function(){
                $("#messages").html("");
            },3000);
        }
    });

    $(document).on("click","#confirm",function(e){
        var page = $("#Sitemenu_page").val();
        if(page === ''){
            e.preventDefault();
            $("#messages").html("<div class='alert alert-error span3'>Error! Choose page first!</div>");
            setTimeout(function(){
                $("#messages").html("");
            },3000);
        }
    });

</script>

