<?php
/* @var $this DefaultController */
/* @var $model SiteConfig */
?>

<h2 class="page-header"><?php echo Yii::t('backend','Конфигурация backend') ?></h2>


<?php if(Yii::app()->user->hasFlash('success')) :?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?=Yii::app()->user->getFlash('success')?>
        <?=Yii::t('backend','Чтобы изменения вступили в силу - сгенерируйте новый конфигурационный файл!')?>
        <hr /><a href="#" class="btn reconfig"><?=Yii::t('backend','Сгенерировать config')?></a>
    </div>
<?php endif?>

<?php if(Yii::app()->user->hasFlash('error')) :?>
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?=Yii::app()->user->getFlash('error')?>
    </div>
<?php endif?>

<?php if(Yii::app()->user->hasFlash('restore-success')) :?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?=Yii::app()->user->getFlash('restore-success')?>
    </div>
<?php endif?>

<?php if(Yii::app()->user->hasFlash('error')) :?>
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?=Yii::app()->user->getFlash('restore-error')?>
    </div>
<?php endif?>

<div style="margin: 20px 0;float: left;">
<a class="addLink btn" href="#" data-type="string"><?=Yii::t('backend','Добавить параметр конфигурации')?></a>
</div>

<table class="table table-striped table-bordered">
    <thead>
        <th>Param</th>
        <th>Label</th>
        <th>Value</th>
        <th>E</th>
        <th>D</th>
        <th>Default</th>
        <th>Type</th>
        <th>Data-Type</th>
        <th>Status</th>
        <th>Position</th>
    </thead>
    <tbody>
        <?php foreach($model as $key=>$config):?>
            <tr>
                <td><?=$config->param?></td>
                <td><?=$config->label?></td>
                <td>
                    <?php if($config->data_type !=='array') :?>
                        <?=$config->value?>
                    <?php else :?>
                        <?=$config->label.' Value'?>
                        <a class="extendedView"
                            href="#"
                            data-toggle="tooltip"
                            data-id="<?=$config->id?>"
                            data-configvalue="value"
                            data-contentType="array"
                            title="<?=Yii::t('backend','Посмотреть значение')?>"
                        >
                            <i class="icon-eye-open"></i>
                        </a>

                    <?php endif?>
                </td>
                <td>
                    <a class="extendedEdit"
                       href="#"
                       data-toggle="tooltip"
                       data-id="<?=$config->id?>"
                       data-configvalue="value"
                       data-contentType = "<?=$config->data_type?>"
                       title="<?=Yii::t('backend','Изменить значение')?>"
                        >
                        <i class="icon-pencil"></i>
                    </a>
                </td>
                <td>
                    <a class="itemRemove"
                       href="#"
                       data-toggle="tooltip"
                       data-id="<?=$config->id?>"
                       title="<?=Yii::t('backend','Удалить значение')?>"
                        >
                        <i class="icon-trash"></i>
                    </a>
                </td>
                <td>
                    <?php if($config->data_type !=='array') :?>
                        <?=$config->default?>
                    <?php else :?>
                        <?=$config->label.' Default Value'?>
                        <a class="extendedView"
                           href="#"
                           data-toggle="tooltip"
                           data-id="<?=$config->id?>"
                           data-configvalue="default"
                           data-contentType="array"
                           title="<?=Yii::t('backend','Посмотреть значение')?>"
                        >
                            <i class="icon-eye-open"></i>
                        </a>
                    <?php endif?>
                </td>
                <td><?=$config->type?></td>
                <td><?=$config->data_type?></td>
                <td>
                    <?=($config->status === 'enabled')
                        ? '<i class="icon-ok" data-toggle="tooltip" title="'.Yii::t("backend","Отключить").'"></i>'
                        : '<i class="icon-remove" data-toggle="tooltip" title="'.Yii::t("backend","Включить").'"></i>'?>
                </td>
                <td><a href="#" class="position" data-position="<?=$config->position?>" data-text="<?=$config->param?>"><?=$config->position?></a></td>
            </tr>
        <?php endforeach?>
    </tbody>
</table>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Modal header</h3>
    </div>
    <div class="modal-body">
    <pre id="editor">
    </pre>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?=Yii::t('backend','Закрыть')?></button>
        <button class="btn btn-primary" id="saveData"><?=Yii::t('backend','Изменить')?></button>
    </div>
</div>

<div class="span9">
    <a id="configPreview" href="#" class="btn">
        <?=Yii::t('backend','Предпросмотр')?>
    </a>
    <pre id="previewBlock" style="width: 900px; height: 600px;display: none;">
    </pre>
</div>

<script src="/js_plugins/ace-editor/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    /*one line height hardcoded to 15px*/
    $(document).on("click",".reconfig",function(e){
        e.preventDefault();
            justDoIt(1);
        var progressBar = '<div class="span10"><div class="progress progress-info progress-striped">'+
            '<div class="bar" style="width: 0%"></div>'+
            '</div>'+
            '<div class="barMessage"></div></div>';
        $(".reconfig").before(progressBar);
    });

    function justDoIt(step){
        $.ajax({
            type:"POST",
            url:"/backend/backendconfig/default/reconfig",
            data:{
                step:step
            },
            success:function(response){
                var resp = JSON.parse(response);
                var progress = resp.progress,
                    message = resp.message,
                    next = resp.nextHop;
                    $(".bar").css("width",progress+"%");
                    $(".barMessage").html(message);

                if(next !== false){
                    setTimeout(function(){
                        justDoIt(step+1);
                    },1000);
                } else {
                    setTimeout(function(){
                        $(".barMessage").html('<em class="alert alert-info">The page will now refresh</em>');
                        location.reload();
                    },2000);
                }
            }
        });
    }

    $(document).on("click",".extendedView",function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $.ajax({
            type:"POST",
            url:"/backend/backendconfig/default/ajaxconfig",
            data:{
                id:id,
                configValue:$(this).data("configvalue")
            },
            success:function(response){
                var resp = JSON.parse(response);

                var editor = ace.edit("editor");
                editor.setTheme("ace/theme/github");
                editor.getSession().setMode("ace/mode/php");
                var configValue = "<"+"?php\n"+resp+"\n?"+">";
                editor.session.setValue(configValue);
                var linesNum = editor.session.getLength();
                $("#editor").css("height",linesNum*15);
                editor.setReadOnly(true);  // false to make it editable
            }
        });
        $("#myModal .btn-primary").hide();
        $("#myModal").modal('show');
    });

    $(document).on("click",".extendedEdit",function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var type = $(this).data("contenttype");
        $("#saveData").attr("data-id",id);
        $("#saveData").attr("data-type",$(this).data("contenttype"));
        $("#saveData").attr("data-operation","edit");
        $.ajax({
            type:"POST",
            url:"/backend/backendconfig/default/ajaxconfig",
            data:{
                id:id,
                configValue:$(this).data("configvalue")
            },
            success:function(response){
                var resp = JSON.parse(response);

                if(type === 'array'){

                    var editor = ace.edit("editor");
                    editor.setTheme("ace/theme/github");
                    editor.getSession().setMode("ace/mode/php");
                    var configValue = "<"+"?php\n"+resp+"\n?"+">";
                    editor.session.setValue(configValue);
                    var linesNum = editor.session.getLength();
                    $("#editor").css("height",linesNum*15);
                    editor.setReadOnly(false);  // false to make it editable
                } else {
                    var content = '<label for="value">Value</label>' +
                                  '<input type="text" name="value" id="value" value="'+resp+'"/>';
                    $(".modal-body").html(content);
                }

            }
        });
        $("#myModal .btn-primary").show();
        $("#myModal").modal('show');
    });

    $(document).on("click","#saveData",function(){
        var type = $("#saveData").data("type");
        var operation = $(this).data("operation");
        var endVal ='';

        if(operation === 'edit'){
            if(type === 'array'){
                var editor = ace.edit("editor");
                var val = editor.session.getValue();
                var val2 = val.substr(val.search('\n'));
                endVal = val2.substr(0,val2.length-2);
            } else if(type === 'string'){
                endVal = $("#value").val();
            }

            $.ajax({
                type:"POST",
                url:"/backend/backendconfig/default/savedata",
                data:{
                    operation: operation,
                    newData: endVal,
                    id:$(this).data("id")
                },
                success:function(response){
                    $("#myModal").modal('hide');
                },
                error:function(response){
                }
            });
        } else if (operation === 'move') {
            $.ajax({
                type:"POST",
                url:"/backend/backendconfig/default/move",
                data : {
                    move:$("#configParams option:selected").val(),
                    current:$(this).data("current")
                },
                success:function(response){
                    if(response === 'successsuccess'){
                        $("#myModal").modal('hide');
                    }

                },
                error:function(response){
                }
            });
        } else if(operation === 'insert') {
            var obj = $("#newData").serialize();
            if(type === 'array'){
                var editor1 = ace.edit("editor1");
                var editor2 = ace.edit("editor2");
                var editor1Val = editor1.session.getValue();
                var editor1Val2 = editor1Val.substr(editor1Val.search('\n'));
                var endVal1 = editor1Val2.substr(0,editor1Val2.length-2);
                var editor2Val = editor2.session.getValue();
                var editor2Val2 = editor2Val.substr(editor2Val.search('\n'));
                var endVal2 = editor2Val2.substr(0,editor2Val2.length-2);
                obj += "&value="+endVal1;
                obj += "&default="+endVal2;
                $.ajax({
                    type:"POST",
                    url:"/backend/backendconfig/default/savedata",
                    data:obj,
                    success:function(response){
                        $("#myModal").modal('hide');
                    },
                    error:function(response){
                    }
                });
            } else if( type === 'string'){
                $.ajax({
                    type:"POST",
                    url:"/backend/backendconfig/default/savedata",
                    data:obj,
                    success:function(response){
                        $("#myModal").modal('hide');
                    },
                    error:function(response){
                    }
                });
            }
        }
    });

    $(document).on("click",".addLink",function(e){
        e.preventDefault();
        var type = $(this).data("type");
        $("#saveData").attr("data-type",type);
        $("#saveData").attr("data-operation","insert");
        var htmlContent = outputHtmlContent(type);
        $("#myModal .modal-body").html(htmlContent);

        if(type === 'array'){
            initTwoEditors();
        }

        $("#myModal").modal('show');

    });

    function outputHtmlContent(type){
        if(type === 'string'){
            var htmlContent =   '<form id="newData">'+
                                '<input type="radio" name="data_type" class="contentType" value="string" checked>String<br />'+
                                '<input type="radio" name="data_type" class="contentType" value="array">Array<hr />'+
                                '<label for="param">Parameter name</label>' +
                                '<input type="text" name="param"/><br />' +
                                '<label for="value">Element value</label>' +
                                '<input type="text" name="value"/><br />'+
                                '<label for="label">Element label</label>' +
                                '<input type="text" name="label"/><br />' +
                                '<label for="default">Default Element value</label>' +
                                '<input type="text" name="default"/><br />' +
                                '<label for="type">type</label>'+
                                '<select name="type">' +
                                    '<option>project parameter</option>' +
                                    '<option>component</option>' +
                                    '<option>module</option>' +
                                '</select><br />' +
                                '<input type="checkbox" name="status" checked /> Status'+
                                '</form><br />';
        } else if(type === 'array'){
            var htmlContent =   '<form id="newData">'+
                                '<input type="radio" name="data_type" class="contentType" value="string">String<br />'+
                                '<input type="radio" name="data_type" class="contentType" value="array" checked>Array<hr />'+
                                '<label for="param">Parameter name</label>' +
                                '<input type="text" name="param"/><br />' +
                                '<label for="value">Element value</label>' +
                                '<pre id="editor1" name="value"></pre>'+
                                '<label for="label">Element label</label>' +
                                '<input type="text" name="label" /><br />' +
                                '<label for="default">Default Element value</label>' +
                                '<pre name="default" id="editor2" name="default"></pre>'+
                                '<select name="type">' +
                                    '<option>project parameter</option>' +
                                    '<option>component</option>' +
                                    '<option>module</option>' +
                                '</select><br />'+
                                '<input type="checkbox" name="status" checked /> Status'+
                                '</form><br/>';
        }
        return htmlContent;
    }

    function initTwoEditors(){
        var configValue = "<"+"?php\narray(\n)\n?"+">";
//        var configValue =
//        "<"+"?php\nYii::setPathOfAlias('backend', dirname(dirname(__FILE__)));"+
//    +"\nreturn CMap::mergeArray('\n"+
//    +"(require dirname(dirname(__FILE__)).\"/../common/config/main.php\"), array(\n";
        var editor1 = ace.edit("editor1");
        editor1.setTheme("ace/theme/github");
        editor1.getSession().setMode("ace/mode/php");
        editor1.session.setValue(configValue);
        $("#editor1").css("height",'120');
        var editor2= ace.edit("editor2");
        editor2.setTheme("ace/theme/github");
        editor2.getSession().setMode("ace/mode/php");
        editor2.session.setValue(configValue);
        $("#editor2").css("height",'120');
    }

   $("#myModal").on('hidden',function(){
       /*need to be set because of ace editor hides array lines until scroll them*/
       location.reload();
   });

    $(document).on("click",".contentType",function(){
        var val = $(this).val();
        var htmlContent = outputHtmlContent(val);
        $("#myModal .modal-body").html(htmlContent);
        if(val === 'array')
            initTwoEditors();
        $("#saveData").attr("data-type",val);
    });

    $(document).on("click",".itemRemove",function(e){
        e.preventDefault();
        if(confirm('<?=Yii::t('backend','Удалить?')?>')){
            $.ajax({
                type:"POST",
                url:"/backend/backendconfig/default/delete",
                data:{
                    id: $(this).data("id")
                },
                success:function(response){
                    var resp = JSON.parse(response);
                    if(resp === 'success'){
                        location.reload();
                        var message = '<div class="alert alert-success">' +
                                      '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                                        '<span>Item was removed successfully</span>'+
                                       '</div>'
                    }
                },
                error: function(response){
                }
            });
        }
    });

    $(document).on("click","#configPreview",function(e){
        e.preventDefault();
        if($("#previewBlock").css("display") === 'none'){
            $("#previewBlock").css("display","block");
        } else {
            location.reload();
        }

        $.ajax({
            type:"POST",
            url:"/backend/backendconfig/default/preview",
            success:function(response){
                var resp = JSON.parse(response);

//                var config = '<'+'?php\nreturn array(\n';

            var config ="<"+"?php\nYii::setPathOfAlias('backend', dirname(dirname(__FILE__)));\n"+
            "return CMap::mergeArray(\n(require dirname(dirname(__FILE__)).\"/../common/config/main.php\"), array(\n";

                $.each(resp, function(index,value){
                        if(typeof value !== 'object'){
                            var re = /array\(/;
                            var re2 = /require\(/;
                            var re3 = /dirname\(/;
                            var found = value.match(re);
                            var found2 = value.match(re2);
                            var found3 = value.match(re3);
                            if(found === null && found2 === null && found3 === null)
                                config += "'"+index+"'"+' => '+"'"+value+"',\n";
                            else
                                config += "'"+index+"'"+' => '+value+",\n";
                        }
                    }
                );
                var components = "'"+'components'+"'"+'=>array(\n';

                $.each(resp.components,function(key,val){
                    components += "\t'"+key+"'=>"+val+",\n";
                });

                var total = config+'\n'+components+'\n),\n));';
                var editorPreview = ace.edit("previewBlock");
                editorPreview.setTheme("ace/theme/github");

                editorPreview.session.setMode("ace/mode/php");
                editorPreview.setReadOnly(true);
                editorPreview.session.setValue(total);
                $("#previewBlock").after('<a href="#" class="btn reconfig">Сгенерить config</a>');
            },
            error:function(response){
                var resp = JSON.parse(response);
            }
        });

    });

    $(document).on("click",".position",function(e){
        e.preventDefault();
        var position = $(this).data("position");
        $.ajax({
            type:"POST",
            url:"/backend/backendconfig/default/getlist",
            data:{
                pos:position
            },
            success:function(response){
                $(".modal-body").html(
                    '<label for="configParam">Разместить после:</label>'+response)
                ;
            },
            error:function(response){

            }
        });
        $("#myModalLabel").text($(this).data("text"));
        $("#saveData").attr("data-operation","move");
        $("#saveData").attr("data-current",position);
        $("#myModal").modal('show');
    });

</script>
