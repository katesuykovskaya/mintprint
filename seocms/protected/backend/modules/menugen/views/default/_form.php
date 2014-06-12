<?php
//Yii::import('application.backend.modules.menugen.models.Usersmenu');
Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
Yii::app()->clientScript->scriptMap['bootstrap.min.css'] = false;
?>
<h5 class="page-header"><?php echo Yii::t('backend','Добавление узла');?></h5>
     
<?php isset($_POST['create_root']) ? $createRoot=$_POST['create_root'] : $createRoot='';?>
<div id="categorydemo_form_con"   class="client-val-form">
<?php if ($createRoot=='true' && $model->isNewRecord) : ?>              
    <h3 id="create_header"><?php echo Yii::t('backend','Создание нового элемента меню');?></h3>
<?php elseif ($model->isNewRecord) : ?>     
    <h3 id="create_header"><?php echo Yii::t('backend','Создание нового элемента меню');?></h3>
     <?php  elseif (!$model->isNewRecord):  ?>     
    <h3 id="update_header"><?php echo Yii::t('backend','Изменение элемента меню');?><?php  echo $model->text;  ?> (ID:<?php   echo $model->id;  ?>) </h3>
    <?php   endif;  ?>
        <div id="success-categorydemo" class="notification success png_bg" style="display:none;">
                <a href="#" class="close">
<!--                    <img src="--><?php //echo Yii::app()->request->baseUrl.'/css/images/icons/cross_grey_small.png';  ?><!--"-->
<!--                          title="Close this notification" alt="close" />-->
                </a>
        </div>

<div  id="error-categorydemo" class="notification errorshow png_bg" style="display:none;">
<!--				<a href="#" class="close"><img src="--><?php //echo Yii::app()->request->baseUrl.'/css/images/icons/cross_grey_small.png';  ?><!--"-->
<!--                                                                title="Close this notification" alt="close" /></a>-->
</div>
<div>

<?php   
 $formId='categorydemo-form';
 $ajaxUrl=
 ($model->isNewRecord) ? 
            
            ( ($createRoot!='true') ? 
          
            Yii::app()->urlManager->createUrl('backend/menugen/default/create') :

            Yii::app()->urlManager->createUrl('backend/menugen/default/createRoot')):

            Yii::app()->urlManager->createUrl('backend/menugen/default/update');
 
$val_error_msg=Yii::t('backend','Error.UserMenu was not saved.');

$val_success_message=($model->isNewRecord)?

( ($createRoot!='true') ? 
        Yii::t('backend','UserMenu was created successfuly.') :

        Yii::t('backend','Root UserMenu was created successfuly.')) :
        
        Yii::t('backend','UserMenu was updated successfuly.');

$success='function(data){
    var response= jQuery.parseJSON (data);

    if (response.success ==true)
    {
         jQuery("#'.Usersmenu::ADMIN_TREE_CONTAINER_ID.'").jstree("refresh");
         $("#success-categorydemo")
        .fadeOut(1000, "linear",function(){
                                                             $(this)
                                                            .append("<div> '.$val_success_message.'</div>")
                                                            .fadeIn(2000, "linear")
                                                            }
                       );
      
$("#categorydemo-form").slideToggle(1500);
     
        }
         else {
                   $("#error-categorydemo")
                   .hide()
                    .show()
                    .css({"opacity": 1 })
                   .append("<div>"+response.message+"</div>").fadeIn(2000);

              jQuery("#'.Usersmenu::ADMIN_TREE_CONTAINER_ID.'").jstree("refresh");

                  }
                     }//function';

$js_afterValidate="js:function(form,data,hasError) {


        if (!hasError) {                         //if there is no error submit with  ajax
        jQuery.ajax({'type':'POST',
                              'url':'$ajaxUrl',
                         'cache':false,
                         'data':$(\"#$formId\").serialize(),
                         'success':$success
                           });
                         return false; //cancel submission with regular post request,ajax submission performed above.
    } //if has not error submit via ajax

else{
return false;       //if there is validation error don't send anything
    }                    //cancel submission with regular post request,validation has errors.

}";


$form=$this->beginWidget('CActiveForm', array(
     'id'=>'categorydemo-form',
  // 'enableAjaxValidation'=>true,
     'enableClientValidation'=>true,
     'focus'=>array($model,'text'),
     'errorMessageCssClass' => 'input-notification-error  error-simple png_bg',
     'clientOptions'=>array('validateOnSubmit'=>true,
                                        'validateOnType'=>false,
                                        'afterValidate'=>$js_afterValidate,
                                        'errorCssClass' => 'err',
                                        'successCssClass' => 'suc',
                                        'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){
                                                   if(!hasError){
                                                                    $("#success-"+attribute.id).fadeIn(500);
                                                                    $("label[for=\'Usersmenu_"+attribute.text+"\']").removeClass("error");
                                                                      }else {
                                                                                  $("label[for=\'Usersmenu_"+attribute.text+"\']").addClass("error");
                                                                                   $("#success-"+attribute.id).fadeOut(500);
                                                                                   }
                                                                                                                            }'
                                                                             ),
)); 

 ?>
<?php echo $form->errorSummary($model, '<div style="font-weight:bold">Please correct these errors:</div>', NULL, array('class' => 'errorsum notification errorshow png_bg')); ?><p class="note">Fields with <span class="required">*</span> are required.</p>

  

 <div>
  <?php echo $form->labelEx($model,'text'); ?>
  <?php  echo $form->textField($model,'text',array('size'=>60,'maxlength'=>128,'value'=>!empty($_POST['text']) ? $_POST['text']:$model->text,'style'=>'width:88%;'));?>
  <span  id="success-UserMenu_name"  class="hid input-notification-success  success png_bg"></span>
    <div><small></small> </div>
     <?php   echo $form->error($model,'text');  ?>    </div>


    <div>
        <?php echo $form->textField($model,'role',array('value'=>isset($_POST['role'])? $_POST['role']:'nothing posted'));?>
        <span  id="success-UserMenu_description"  class="hid input-notification-success  success png_bg"></span>
        <div><small></small> </div>
    </div>


<input type="hidden" name= "YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken; ?>"  />
<input type="hidden" name= "parent_id" value="<?php echo !empty($_POST['parent_id'])?$_POST['parent_id']:''; ?>"  />

  <?php  if (!$model->isNewRecord): ?>
        <input type="hidden" name= "update_id" value=" <?php echo !empty($_POST['update_id'])?$_POST['update_id']:''; ?>"  />
     <?php endif; ?>      
    
   <div>
 <?php   echo  CHtml::submitButton($model->isNewRecord ? Yii::t('backend','Создать') : Yii::t('backend','Сохранить'),array('class' => 'button align-right')); ?>	</div>
     
 <?php  $this->endWidget(); ?></div><!-- form -->

</div>
<script  type="text/javascript">
    
 //Close button:

		$(".close").click(
			function () {
				$(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
					$(this).slideUp(600);
				});
				return false;
			}
		);
</script>


