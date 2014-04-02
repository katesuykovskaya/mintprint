<h1>PageTree</h1>


<div style="margin-bottom: 70px;" >
<div style="float:left">
    <!--
  <input id="reload"  type="button" style="display:block; clear: both;" value="Refresh"class="client-val-form button">
    -->
</div>
<div style="float:left">
  <!--
    <input id="add_root" type="button" style="display:block; clear: both;" value="Create Root" class="client-val-form button">
-->  
</div>

</div>

<?php
    //echo CVarDumper::dump(StaticPages::printULTree(), $depth=5, $highlight=true);
?>
<!--The tree will be rendered in this div-->

<div id="<?php echo StaticPages::PAGES_TREE_CONTAINER_ID;?>" >

</div>



<script  type="text/javascript">
$(function () {
    $("#<?php echo StaticPages::PAGES_TREE_CONTAINER_ID;?>")
		.jstree({
                           "html_data" : {
	            "ajax" : {
                                 "type":"POST",
 	                          "url" : "<?php echo $baseUrl;?>/backend/pages/pages/fetchTree",
                                 "data" : function (n) {
	                          return {
                                                  page_id : n.attr ? n.attr("page_id") : 0,
                                                  "YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"
                                                   };
	                }
  	            }
	        }
             });
         });                   
</script>










