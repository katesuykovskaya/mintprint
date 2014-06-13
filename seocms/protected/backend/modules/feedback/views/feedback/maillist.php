<?php
    $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Обратная связь. Администрирование')?></li>
    </ul>
</div>

<h3 class="page-header"><?php echo Yii::t('backend','Обратная связь. Администрирование')?></h3>

<div class="row-fluid">
    <?php if(Yii::app()->user->hasFlash('success')) :?>
        <?php Yii::app()->clientScript->registerScript('myHideEffect',
              '$(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");',
              CClientScript::POS_READY);
        ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo Yii::app()->user->getFlash('success');?>
    </div>
    <?php endif?>

    <?php if(Yii::app()->user->hasFlash('error')) :?>
        <?php Yii::app()->clientScript->registerScript('myHideEffect',
                '$(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");',
                CClientScript::POS_READY);
        ?>
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo Yii::app()->user->getFlash('error');?>
        </div>
    <?php endif?>
</div>

<div>
    <?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
        'id'=>'feedback-grid',
        'type'=>'striped bordered',
        'dataProvider'=>$model->search(),
        'selectableRows'=>false,
        'filter'=>$model,
        'columns'=>array(
            'sender_mail'=>array(
                'header'=>Yii::t('backend','E-mail отправителя'),
                'name'=>'sender_mail',
                'value'=>'$data->sender_mail',
            ),
            'sender_name'=>array(
                'header'=>Yii::t('backend','Имя отправителя'),
                'name'=>'sender_name',
                'value'=>'$data->sender_name',
            ),
            'phone',
            'ip'=>array(
                'header'=>Yii::t('backend','IP-адрес'),
                'name'=>'ip',
                'filter'=>'',
                'value'=>'long2ip($data->ip)',
            ),
            'create_date'=>array(
                'header'=>Yii::t('backend','Дата создания'),
                'name'=>'create_date',
                'filter'=>''
            ),

            array(
                'header'=>Yii::t('backend','Кол-во элементов'),
                'filter'=>CHtml::dropDownList(
                        'pageSize',
                        $pageSize,
                        array(5=>5,10=>10,25=>25,50=>50,100=>100),
                        array('onchange'=>"$.fn.yiiGridView.update('feedback-grid',{ data:{pageSize: $(this).val() }})",)
                    ),
                'type'=>'raw',
                'value'=>'Chtml::link("<i class=icon-remove></i>",
                                    Yii::app()->urlManager->createUrl("backend/feedback/feedback/delete",array("id"=>$data->id,"language"=>Yii::app()->language)),array("confirm"=>Yii::t("backend","Удалить?"))).
                          Chtml::link("<i class=icon-search></i>",Yii::app()->urlManager->createUrl("backend/feedback/feedback/view",array("id"=>$data->id,"language"=>Yii::app()->language)))',
                'htmlOptions'=>array('style'=>'text-align: center'),
            )
        ),
    )); ?>
</div>


<script>
    $(document).on("click","#files",function(e){
        e.preventDefault();
        var tr = $(this).closest("tr");
        var id = $(this).data("id");
        var files = $(this).data("files");
        var attachLength = document.getElementsByClassName('attach_'+id).length;

        if(attachLength === 0){
            $.ajax({
                type:"POST",
                url:"/backend/feedback/feedback/getFiles",
                data:{
                    files:files,
                    id:id
                },
                success:function(response){
                    var resp = JSON.parse(response);
                    var files = resp.files;
                    var test = '';
                    $.each(files,function(key,value){
                        var elem =
                            "<tr class='attach_"+resp.id+"'>" +
                                "<td><img src='/uploads/thumbnail/"+files[key].name+"' style='float:left;' /></td>" +
                                "<td><strong>name:</strong> "+files[key].name+"<br /><strong>type:</strong> "+files[key].type+"<br /><strong>url:</strong> "+files[key].url+"</td>"+
                                "<td></td><td></td><td></td><td></td><td></td><td></td>"+
                                "</tr>";
                        test += elem;
                    });
                    test += "<tr class='attach_"+resp.id+"'><td colspan='8' style='text-align: center;'><a href='#' id='hideAttach' data-attach='"+resp.id+"'><i class='icon-arrow-up'></i>hide attachments</a></td></tr>";
                    $(test).insertAfter($(tr));
                }
            });
        }
    });

    $(document).on("click","#hideAttach",function(e){
        e.preventDefault();
        var id = $(this).data("attach");
        $(".attach_"+id).remove();
    });
</script>