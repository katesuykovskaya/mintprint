<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Меню для сайта')?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend','Администрирование меню сайта')?></h3>
<div class="row-fluid">
    <div class="span3">
        <?php
        echo CHtml::link(Yii::t('backend','Создать меню'),
            $this->createUrl('backend/menugen/sitemenu/create',array('language'=>Yii::app()->language)),
            array('class'=>'btn btn-success','id'=>'createBtn')
        );?>
    </div>
    <div class="span3" id="messageBlock"></div>
</div>

<h5 class="page-header"><?php echo Yii::t('backend','Список меню: ');?></h5>
<div id="menuBlock">
    <table class="table table-striped table-bordered span4">
        <?php foreach($block as $key=>$row) : ?>

            <tr id="<?=$row['type']?>">
                <td><?php echo CHtml::link('<i class="icon-remove" data-toggle="tooltip" title='.Yii::t('backend','delete').'></i>',$this->createUrl('#'),array('id'=>'delLink','data-type'=>$row['type']))?></td>
                <td><?php echo CHtml::link($row['t_text'],$this->createUrl('backend/menugen/sitemenu/view',array('type'=>$row['type'],'language'=>Yii::app()->language)))?></td>
            </tr>

        <?php endforeach;?>
    </table>
</div>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><?php echo Yii::t('backend','Создание нового меню')?></h3>
        </div>

        <div class="modal-body">
            <p><label for="menuName"><?php echo Yii::t('backend','Название меню')?></label></p>
            <p><input type="text" name="menuName" class="input-large" id="menuName" placeholder="<?php echo Yii::t('backend','Введите название нового меню');?>"/></p>

            <?php foreach(Yii::app()->params['languages'] as $key=>$language) :?>
                <p><label for="t_text_<?=$key;?>"><?php echo Yii::t('backend',$language['lang'])?></label></p>
                <p><input type="text" name="t_text[<?=$key;?>]" class="input-large" id="t_text_<?=$key;?>" /></p>

            <?php endforeach;?>
        </div>

        <div class="modal-footer">
            <a href="#" class="btn" id="cancelBtn"><?php echo Yii::t('backend','Отмена');?></a>
            <a href="#" class="btn btn-primary" id="submitBtn"><?php echo Yii::t('backend','Создать');?></a>
        </div>
</div>

<script>

    var alertError = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Error occured!</div>';
    var alertSuccess = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Success!</div>';
    var msgBlock = document.getElementById("messageBlock");

    $(document).on("click","#createBtn",function(e){
        e.preventDefault();
        $.each($(".modal-body input"),function(key,value){
                $(value).val("");
        });
        $("#myModal").modal('show');
    });

    $(document).on("click","#submitBtn",function(){
        var allInputs = $(".modal-body input");
        var obj = {};

        $.each(allInputs,function(key,value){
            obj[value.name] = value.value;
        });

        $.ajax({
            type:"POST",
            url:"/backend/menugen/sitemenu/createMenu",
            data:obj,
            success:function(response){
                 var resp = JSON.parse(response);
                 if(resp === 'true'){
                     $.ajax({
                         type:"POST",
                         url:"/backend/menugen/sitemenu/ajaxmenublock",
                         success:function(response){
                             var resp = JSON.parse(response)
                             $("#myModal").modal('hide');
                             var rows;
                             for(var i in resp){
                                 rows +=
                                 "<tr id='"+resp[i].type+"'>" +
                                     "<td><a href='#' id='delLink' data-type='"+resp[i].type+"'><i class='icon-remove'></i></a></td>"+
                                     "<td><a href='/backend/menugen/sitemenu/view/type/"+resp[i].type+"'>"+resp[i].type+"</a></td>" +
                                 "</tr>"
                             }
                             $("#menuBlock table").html(rows);
                             $("#messageBlock").html(alertSuccess);
                             clear();
                         },
                         error:function(){
                             $("#myModal").modal('hide');
                             $("#messageBlock").html(alertError);
                             clear();
                         }
                     });
                 } else if(resp === 'false'){
                     $("#myModal").modal('hide');
                     $("#messageBlock").html(alertError);
                    clear();
                 }
             },
             error:function(){
                 $("#myModal").modal('hide');
                 $("#messageBlock").html(alertError);
                 clear();
             }
        });
    });


    $(document).on("click","#delLink",function(e){
        e.preventDefault();
        if(confirm("<?=Yii::t('backend','Внимание! Данная операция приведет к полному удалению меню!')?>")){
            var elem = document.getElementById($(this).closest("tr").attr("id"));
            $.ajax({
                type:"POST",
                url:"/backend/menugen/sitemenu/deletemenu",
                data:{
                    type:$(this).data("type")
                },
                success:function(){
                    $(elem).remove();
                    $("#messageBlock").html(alertSuccess);
                    clear();
                },
                error:function(){
                    $("#messageBlock").html(alertError);
                    clear();
                }
            });
        }
    });

    $(document).on("click","#cancelBtn",function(){
        $("#myModal").modal('hide');
        clear();
    });

    function clear(){
        setTimeout(function(){
            $(".alert").fadeOut(3000);
        },3000);
    }

</script>


