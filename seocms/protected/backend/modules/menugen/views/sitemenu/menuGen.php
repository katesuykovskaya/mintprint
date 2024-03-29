<?php
    $role = isset($role) ? $role : Yii::app()->session['menurole'];
    $baseUrl = isset($baseUrl) ? $baseUrl : Yii::app()->session['baseUrl'];
    $open_nodes = !empty($open_nodes) ? $open_nodes : Yii::app()->session['open_nodes'];

?>


<h3 class="page-header"><?php echo Yii::t('backend','Редактирование меню')." ".$role;?></h3>

<div id="<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>" >

</div>



<script  type="text/javascript">
$(function () {
$("#<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>")
		.jstree({
                           "html_data" : {
	            "ajax" : {
                                 "type":"POST",
 	                             "url" : "<?php echo $baseUrl;?>/backend/menugen/default/fetchTree ",
                                 "data" : function (n) {
	                          return {
                                                  id : n.attr ? n.attr("id") : 0,
                                                  "users":<?php echo Yii::app()->user->id;?>, //sending userid which menu we want to show, edit etc
                                                  "role" : '<?php echo $role;?>',
                                                  "YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"
                                                   };
	                }
  	            }
	        },

"contextmenu":  { 'items': {

"create" : {
	"label"	: "Создать",
	"action" : function (obj) { this.create(obj); },
        "separator_after": false
	},
    "remove" : {
        "label"	: "Delete",
        "action" : function (obj) {
            $('<div title="Delete Confirmation">\n\
                     <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>\n\
                    Categorydemo <span style="color:#FF73B4;font-weight:bold;">'+(obj).attr('rel')+'</span> and all it\'s subcategories will be deleted.Are you sure?</div>')
                .dialog({
                    resizable: false,
                    height:170,
                    modal: true,
                    buttons: {
                        "Delete": function() {
                            jQuery("#<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>").jstree("remove",obj);
                            $( this ).dialog( "close" );
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });

        }
    }//remove
 
                  }//items
                  },
                  
                  
                  //end of context menu

			// the `plugins` array allows you to configure the active plugins on this instance
			"plugins" : ["themes","html_data","contextmenu","crrm","dnd"],
			// each plugin you have included can have its own config object
//////////
/////// В этом месте был найден глюк какой-то, закоментил $open_nodes
			"core" : { "initially_open" : [ <?php echo $open_nodes;?> ],'open_parents':true}
///////////
////////////////////////////////////////////////////////////////////////////

			// it makes sense to configure a plugin only if overriding the defaults

		})

                ///EVENTS

        //creating NEw Node ---->

<?php if(Yii::app()->user->checkaccess(Yii::app()->user->role)) : ?>

    .bind("remove.jstree", function (e, data) {
        $.ajax({
            type:"POST",
            url:"<?php echo $baseUrl;?>/backend/menugen/default/remove",
            data:{
                "id" : data.rslt.obj.attr("id").replace("node_",""),
                "YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"
            },
            beforeSend : function(){
                $("#<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>").addClass("ajax-sending");
            },
            complete: function(){
                $("#<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>").removeClass("ajax-sending");
            },
            success:function (r) {  response= $.parseJSON(r);
                if(!response.success) {
                    $.jstree.rollback(data.rlbk);
                };
            }
        });
    })

<?php endif ?>

        .bind("create.jstree", function (e, data) {
                           newname=data.rslt.name;
                           parent_id=data.rslt.parent.attr("id").replace("node_","");
            $.ajax({
                    type: "POST",
                    url: "<?php echo $baseUrl;?>/backend/menugen/default/returnForm",
                    data:{   'name': newname,
                            'userid':'<?=Yii::app()->user->id;?>',
                            'role': '<?php echo $role;?>',
                             'parent_id':   parent_id,
                             "YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"
                                                          },
                           beforeSend : function(){
                                                     $("#<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>").addClass("ajax-sending");
                                                             },
                           complete : function(){
                                                       $("#<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>").removeClass("ajax-sending");
                                                             },
                           success: function(data){

                        $.fancybox(data,
                        {    "transitionIn"	:	"elastic",
                            "transitionOut"    :      "elastic",
                             "speedIn"		:	600,
                            "speedOut"		:	200,
                            "overlayShow"	:	false,
                            "hideOnContentClick": false,
                             "onClosed":    function(){
                                                                       } //onclosed function
                        })//fancybox

                    } //success
                });//ajax

	})
.bind("move_node.jstree", function (e, data) {
		data.rslt.o.each(function (i) {

                //jstree provides a whole  bunch of properties for the move_node event
                //not all are needed for this view,but they are there if you need them.
                //Commented out logs  are for debugging and exploration of jstree.

                 next= jQuery.jstree._reference('#<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>')._get_next (this, true);
                 previous= jQuery.jstree._reference('#<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>')._get_prev(this,true);

                    pos=data.rslt.cp;
                    moved_node=$(this).attr('id').replace("node_","");
                    next_node=next!=false?$(next).attr('id').replace("node_",""):false;
                    previous_node= previous!=false?$(previous).attr('id').replace("node_",""):false;
                    new_parent=$(data.rslt.np).attr('id').replace("node_","");
                    old_parent=$(data.rslt.op).attr('id').replace("node_","");
                    ref_node=$(data.rslt.r).attr('id').replace("node_","");
                    ot=data.rslt.ot;
                    rt=data.rslt.rt;
                    copy= typeof data.rslt.cy!='undefined'?data.rslt.cy:false;
                   copied_node= (typeof $(data.rslt.oc).attr('id') !='undefined')? $(data.rslt.oc).attr('id').replace("node_",""):'UNDEFINED';
                   new_parent_root=data.rslt.cr!=-1?$(data.rslt.cr).attr('id').replace("node_",""):'root';
                   replaced_node= (typeof $(data.rslt.or).attr('id') !='undefined')? $(data.rslt.or).attr('id').replace("node_",""):'UNDEFINED';


			$.ajax({
				async : false,
				type: 'POST',
				url: "<?php echo $baseUrl;?>/backend/menugen/default/moveCopy",

				data : {
					"moved_node" : moved_node,
                                        "new_parent":new_parent,
                                        "new_parent_root":new_parent_root,
                                         "old_parent":old_parent,
                                         "pos" : pos,
                                         "previous_node":previous_node,
                                          "next_node":next_node,
                                          "copy" : copy,
                                          "copied_node":copied_node,
                                          "replaced_node":replaced_node,
				         "YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"
                                                          },
                           beforeSend : function(){
                                                     $("#<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>").addClass("ajax-sending");
                                                             },
                          complete : function(){
                                                       $("#<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>").removeClass("ajax-sending");
                                                             },
				success : function (r) {
                                    response=$.parseJSON(r);
					if(!response.success) {
						$.jstree.rollback(data.rlbk);
                                                 alert(response.message);
					}
					else {
                                          //if it's a copy
                                          if  (data.rslt.cy){
						$(data.rslt.oc).attr("id", "node_" + response.id);                         
						if(data.rslt.cy && $(data.rslt.oc).children("UL").length) {
							data.inst.refresh(data.inst._get_parent(data.rslt.oc));
						}
                                          }
					}
				}
			}); //ajax

		});//each function
	});   //bind move event

                ;//JSTREE FINALLY ENDS (PHEW!)

//BINDING EVENTS FOR THE ADD ROOT AND REFRESH BUTTONS.
   $("#add_root").click(function () {
	$.ajax({
        type: 'POST',
        url:"<?=$baseUrl;?>/backend/menugen/default/returnForm",
		data:	{
		    "create_root" : true,
		    "YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"
                         },
                beforeSend : function(){
                    $("#<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>").addClass("ajax-sending");
                                        },
                complete : function(){
                    $("#<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>").removeClass("ajax-sending");
                                     },
                success:    function(data){

                        $.fancybox(data,
                        {    "transitionIn"	:	"elastic",
                            "transitionOut"    :      "elastic",
                             "speedIn"		:	600,
                            "speedOut"		:	200,
                            "overlayShow"	:	false,
                            "hideOnContentClick": false,
                             "onClosed":    function(){
                                                                       } //onclosed function
                        })//fancybox

                    } //function

		});//post
	});//click function

              $("#reload").click(function () {
		jQuery("#<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>").jstree("refresh");
	});
});
</script>




