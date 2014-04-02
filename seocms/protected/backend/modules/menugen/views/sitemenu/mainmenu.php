<?php
$type = 'mainmenu';
//$baseUrl = isset($baseUrl) ? $baseUrl : Yii::app()->session['baseUrl'];
//$open_nodes = !empty($open_nodes) ? $open_nodes : Yii::app()->session['open_nodes'];

?>

<span id="newSessCss"></span>

<h3 class="page-header"><?php echo Yii::t('backend','Редактирование меню')." ".$type;?></h3>

<div class="row-fluid">
    <div class="row-fluid">
        <span class="span3 offset3" id="operationMessage">
        </span>
    </div>

    <div class="row-fluid" style="margin-bottom: 30px;">
        <?php
            echo CHtml::link(
                Yii::t('backend','Создать'),
                $this->createUrl('backend/menugen/sitemenu/createItem',array('language'=>Yii::app()->language)),
                array('class'=>'btn btn-success')
            );
        ?>
    </div>

<!--    <div id="menuGrid">-->
        <!--
        ОБЯЗАТЕЛЬНО проверить необходимость передачи $menu в метод!!!! скорее всего избыточно и нужнотолько для выбора меню
        которое будет отображено, но это должно происходить не здесь!!!!
        !>
<!--        --><?//=Sitemenu::drawGrid($menu);?>

<!--    </div>-->
    <div class="row-fluid">
        <div id="ajaxMenuGrid">
            <?php
//                Sitemenu::drawAjaxGrid(Yii::app()->language);
                Sitemenu::drawAjaxGrid2(Yii::app()->language);
            ?>
        </div>
    </div>

<script type="text/javascript">

    var row = document.getElementsByTagName('tr');

    $(document).ready(function(){
        var rows = $('.table tbody').children();
        var rowsNum = rows.length;
        var nodes = new Array();

        for(var x=0; x < rowsNum; x++){
            nodes[x] = $(rows[x]).attr("data-rowid");
        }

        $("table").attr("nodes",nodes);

        var sessionArr = "<?php echo $sessionArr = isset(Yii::app()->session['openNodes']) ? implode(',',Yii::app()->session['openNodes']) : null;?>";
        sessionArr = sessionArr.split(',');
        for(var z=0; z < sessionArr.length; z++){
            sessionArr[z] = parseInt(sessionArr[z]);
        }

        $.each(rows,function(index){

            if(rows[index].hasAttribute("children")){
                rows[index].cells[0].innerHTML = "<i class='icon-folder-open'></i>";
                var rowChildren = $(rows[index]).attr("children");
                if(rowChildren !== undefined && rowChildren !== ""){
                    var id = parseInt($(rows[index]).attr("data-rowid"));
                    var parent = parseInt($(rows[index]).attr("parent"));

                    if($.inArray(id,sessionArr) !== -1){
                        var rrrow = $("#row-"+parent)[0];

                        if(rrrow != undefined)
                            rrrow.firstChild.innerHTML = "<i class='icon-minus'></i>";
                    }
                }
            } else {
                var id = parseInt($(rows[index]).attr("data-rowid"));
                var parent = parseInt($(rows[index]).attr("parent"));

                if($.inArray(id,sessionArr) !== -1){
                    var rrrow = $("#row-"+parent)[0];
                    if(rrrow != undefined)
                        rrrow.firstChild.innerHTML = "<i class='icon-minus'></i>";
                }
            }
        });

    });

    $(document).on("click",".icon-folder-open",function(){
        $(this).removeClass("icon-folder-open");
        var currentRow = $(this).closest("tr");
        var nodes = ($("table").attr("nodes")).split(',');

        $.ajax({
            type:"POST",
            url:"/<?=Yii::app()->language?>/backend/menugen/sitemenu/ajaxMenuGrid",
            data:{
                children: $(this).closest('tr').attr("children"),
                openNodes: nodes,
                output: true
            },
            beforeSend:function(){
                $(currentRow).find(':first').html("<img src='/img/loader.gif' />")
            },
            success:function(response){

                var data = JSON.parse(response)
                var resp = data.data;
                var childs = data.descendants;
                var num = resp.length;

                for(var i=0; i < num; i++ )
                {
                    if(resp[i].t_hide == 1 || resp[i].t_hide == 2)
                        var status = "<a href='#'><i class='icon-remove' data-state="+resp[i].t_hide+" data-source_id="+resp[i].id+"></i></a>";
                    else if (resp[i].t_hide == 0)
                        status = "<a href='#'><i class='icon-ok' data-state='0' data-source_id="+resp[i].id+"></i></a>";

                    var padding = resp[i].level < 6 ? parseInt((resp[i].level-1)*20) : 100;
                    var id = parseInt(resp[i].source_id);
                    nodes[nodes.length]=id;
                    $("table").attr("nodes",nodes);
                    var childrenArr = childs[id].children;
                    var descendantsArr = childs[id].descendants;
                    var iconFolder = childrenArr.length != 0 ? "<i class='icon-folder-open'></i>" : '';

                    var insertRow = "<tr id='row-"+resp[i].source_id+"' parent="+data.parent+" data-rowid="+resp[i].source_id+" children="+childrenArr+" descendants="+descendantsArr+" style='padding-left:"+padding+"px;'>" +
                        "<td>"+iconFolder+"</td>"+
                        "<td style='padding-left:"+padding+"px;'><a href=<?='/'.Yii::app()->language.'/';?>backend/menugen/sitemenu/updatemenu/id/"+resp[i].source_id+">"+resp[i].t_text+"</a></td>"+
                        "<td>"+resp[i].id+"</td>"+
                        "<td>"+resp[i].t_url+"</td>"+
                        "<td>"+resp[i].link_type+"</td>"+
                        "<td><i class='icon-trash' data-toggle='tooltip' title='<?=Yii::t('backend','Удалить');?>' data-id="+resp[i].id+"></i></span>"+
                        "<td>" +status+"</span>"+
                      "</tr>";

                    $(insertRow).fadeIn(function(){
                        $(this).insertAfter(currentRow);
                    });
                }
            },
            complete:function(){
                $(currentRow).find(':first').html("<i class='icon-minus'></i>")
            }
        });
     });

    $(document).on("click",".icon-minus",function(){
        $(this).removeClass("icon-minus");
        $(this).addClass("icon-folder-open");

        var rowDescendants = $(this).closest('tr').attr('descendants');

        var descendants = rowDescendants.split(",");

        for(var val in descendants){
            descendants[val]= parseInt(descendants[val]);
        }

        var rows = $("tbody").children();
        var newNodes = new Array();
        rows.each(function(index){
            var id = parseInt($(rows[index]).attr("data-rowid"));
            if(descendants.indexOf(id) != -1){
                $(rows[index]).fadeOut('slow',function(){
                    $(rows[index].remove());
                });
            } else {
                newNodes.push(id);
                $("table").attr("nodes",newNodes);
            }
        });
        $.ajax({
            type:"POST",
            url:"/<?php echo Yii::app()->language;?>/backend/menugen/sitemenu/ajaxMenuGrid",
            data:{
                openNodes: newNodes
            }
        });
    });

    $(document).on("click",".icon-ok,.icon-remove",function(){

        /* First state frid was #menuGrid*/
        var curRow = $(this).closest("tr");
        $.ajax({
            type:"POST",
            url:"<?=$this->createUrl('backend/menugen/sitemenu/toglemenu',array('language'=>Yii::app()->language))?>",
            data:{
                state:$(this).data('state'),
                itemid:$(this).data('source_id'),
                language:"<?=Yii::app()->language?>"
            },
            success:function(response){
                var resp = $.parseJSON(response);
                var row = $(curRow).get(0);
                var lastCell = row.cells[row.cells.length-1];
                if(resp.isItRight === true ){
                    var rowid = $(row).attr("data-rowid");
                    var inner = resp.state === 1 || resp.state === 2 ?
                        '<a href="#"><i class="icon-remove" data-state='+resp.state+' data-source_id='+resp.rowid+'></i></a>':
                            '<a href="#"><i class="icon-ok" data-state="0" data-source_id='+resp.rowid+'></i></a>';
                    if(resp.itemArray.length === 1)
                        lastCell.innerHTML = inner;
                    else
                    {
                       var rowsArray = $("tbody").children();

                       $.each(rowsArray,function(index){
                           var myRow = $(rowsArray).get(index);
                           var myRowId = $(myRow).attr("data-rowid");
                           var lastTd = myRow.cells[myRow.cells.length-1];

                           $.each(resp.all,function(i){
                               if(parseInt(resp.all[i].source_id) == parseInt(myRowId)){
                                   switch(parseInt(resp.all[i].t_hide)){

                                       case 0:
                                           lastTd.innerHTML = '<a href="#"><i class="icon-ok" data-state="0" data-source_id='+myRowId+'></i></a>';
                                           break;

                                       case 1:
                                           lastTd.innerHTML = '<a href="#"><i class="icon-remove" data-state="1" data-source_id='+myRowId+'></i></a>';
                                           break;

                                       case 2:
                                           lastTd.innerHTML = '<a href="#"><i class="icon-remove" data-state="2" data-source_id='+myRowId+'></i></a>';
                                           break;
                                   }
                               }
                           });
                       });
                    }
                } else if (resp.isItRight == false ){
                    var rowid = $(row).attr("data-rowid");
                    var inner = resp.state === 1 ?
                        '<a href="#"><i class="icon-remove" data-state="1" data-source_id='+rowid+'></i></a>':
                        '<a href="#"><i class="icon-ok" data-state="0" data-source_id='+rowid+'></i></a>' ;

                    lastCell.innerHTML = inner;
                }
            }
        });
    });

    $(document).on("click",".icon-trash",function(){
        var curRow = $(this).closest("tr");
        var id = $(curRow).data("rowid");
        var parentId = $(curRow).attr("parent");
        var parent = $("#row-"+parentId);
        var parentsChildren = $(parent).attr("children");
        var parentsDescendants = $(parent).attr("descendants");

        $.ajax({
            type:"POST",
            url:"<?=$this->createUrl('backend/menugen/sitemenu/remove');?>",
            data:{
                id : $(this).data('id'),
                token: "<?=Yii::app()->request->csrfToken?>"
            },

            success: function(response){
                var resp = $.parseJSON(response);

                if(resp.wellDone === true){

                    $(curRow).remove();
                    $("#operationMessage").append(
                        "<div class='alert alert-success'><?=Yii::t('backend','Удалено!');?>"+
                            "<a href='#' class='close' data-dismiss='alert'>&times;</a>"+
                            "</div>");
                    setTimeout(function(){
                        $('.alert-success').fadeOut();
                    },2000);

                        if(parentsChildren != undefined){
                            var childArr = parentsChildren.split(',');

                            for(var i = 0; i < childArr.length; i++){
                                childArr[i] = parseInt(childArr[i],10);
                            }

                            var descArr = parentsDescendants.split(',');

                            for(var j = 0; j < descArr.length; j++){
                                descArr[j] = parseInt(descArr[j],10);
                            }

                            var childIndex = childArr.indexOf(id);
                            var descIndex = descArr.indexOf(id);

                            childArr.splice(childIndex,1);
                            descArr.splice(descIndex,1);

                            if(childArr.length !== 0){
                                $(parent).attr("children",childArr);
                                $(parent).attr("descendants",descArr);
                            } else {
                                $(parent).removeAttr("children");
                                $(parent).removeAttr("descendants");
                                $(parent).children().get(0).innerHTML='';
                            }
                        }
                } else if(resp.wellDone === false){
                    $("#operationMessage").append(
                        "<div class='alert alert-error'><?=Yii::t('backend','Произошла ошибка!');?>"+
                            "<a href='#' class='close' data-dismiss='alert'>&times;</a>"+
                            "</div>"
                    );
                    setTimeout(function(){
                        $('.alert-error').fadeOut();
                    },2000);
                }
            }
        });
    });

</script>



