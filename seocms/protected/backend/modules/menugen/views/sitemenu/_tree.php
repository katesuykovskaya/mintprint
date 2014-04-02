<?php
    $role = isset($role) ? $role : Yii::app()->session['role'];
    $baseUrl = isset($baseUrl) ? $baseUrl : Yii::app()->session['baseUrl'];
    $open_nodes = !empty($open_nodes) ? $open_nodes : Yii::app()->session['open_nodes'];

?>


<div id="<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>" >

</div>



<script  type="text/javascript">
$(function () {
$("#<?php echo Usersmenu::ADMIN_TREE_CONTAINER_ID;?>")
		.jstree({
                           "html_data" : {
	            "ajax" : {
                              "type":"POST",
 	                          "url" : "<?php echo $baseUrl;?>/backend/menugen/default/fetchTree",
                                 "data" : function (n) {
	                                              return {
                                                  id : n.attr ? n.attr("id") : 0,
                                                  "users":<?php echo Yii::app()->user->id;?>, //sending userid which menu we want to show, edit etc
                                                  "role":'<?=$role;?>',
                                                  "YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"
                                                  };
	                }
  	            }

	        },
        "core" : { "initially_open" : [ <?php echo $open_nodes;?> ],'open_parents':true}
		});//JSTREE FINALLY ENDS (PHEW!)

});
</script>

<?php
   echo Usersmenu::getButtons($role);
?>



