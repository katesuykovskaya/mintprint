<?php
/* @var $this DefaultController */
?>

<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Генерация backend-меню')?></li>
    </ul>
</div>

<h3 class="page-header"><?php echo Yii::t('backend','Генерация backend-меню');?></h3>

<!--Flash messages success-error -->

    <?php if(Yii::app()->user->hasFlash('menu_error')) : ?>
        <div class="row">
        <div class="alert alert-error span3 offset2">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo Yii::app()->user->getFlash('menu_error'); ?>
        </div>
            </div>
    <?php endif;?>

    <?php if(Yii::app()->user->hasFlash('menu_success')) : ?>
        <div class="row">
            <div class="alert alert-success span3 offset2">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo Yii::app()->user->getFlash('menu_success'); ?>
            </div>
        </div>
    <?php endif;?>

<!--end of flash-messages -->

<div class="well span4">
    <h4><?=Yii::t('backend','Доступы для роли: ')?></h4>
    <?php echo CHtml::form($this->createUrl('/menugen/default/previewMenu',array('language'=>Yii::app()->language)));?>
    <?php echo CHtml::dropDownList('usermenu','usermenu',CHtml::listData(AuthItem::model()->findAll('type=2'),'name','name'),array(
        'ajax'=>array(
            'type'=>'post',
            'url'=>$this->createUrl('/backend/menugen/default/ajaxUserItems',array('language'=>Yii::app()->language)),
            'update'=>'#ajaxRoles',
            'data' => array('dropname'=> 'js: $("#usermenu option:selected").val()'),
        ),
    ));?>
    <br />

    <div id="ajaxRoles">
    </div>

    <?=CHtml::endForm();?>

</div>

<div class="well span4">
    <h4><?=Yii::t('backend','Выберите роль: ')?></h4>
    <?php echo CHtml::form($this->createUrl('/backend/menugen/default/previewMenu',array('language'=>Yii::app()->language)));?>
    <?php echo CHtml::dropDownList('rolemenu','rolemenu',CHtml::listData(AuthItem::model()->findAll('type=2'),'name','name'),array(
        'ajax'=>array(
            'type'=>'post',
            'url'=>$this->createUrl('/backend/menugen/default/previewMenu',array('language'=>Yii::app()->language)),
            'update'=>'#previewMenu',
            'data' => array('dropname'=> 'js: $("#rolemenu option:selected").val()'),
        ),
    ));?>

    <br />
    <div id="previewMenu">

    </div>
    <?php echo CHtml::endForm();?>

</div>


<?php
    $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal'));
    echo CHtml::beginForm($this->createUrl('/backend/menugen/default/translateActions',array('language'=>Yii::app()->language)));
?>

<?php
    echo '<div class="modal-header"><h3 class="page-header">'.Yii::t('backend','Перевод').'</h3></div>';
    echo '<div class="modal-body">';

            echo CHtml::label(Yii::t('backend','SourceMsg'),'SourceMsg');
            echo CHtml::textField('SourceMsg','',array('class'=>'input-xlarge'));

            foreach(Yii::app()->params->languages as $language)
            {
                echo CHtml::label(Yii::t('backend',$language['lang']),"SourceMessage[$language[langcode]]");
                echo CHtml::textField("SourceMessage[$language[langcode]]",'',array('class'=>'input-xlarge'));
            }

    echo '</div>';
?>
<div class="modal-footer">
    <?php
        echo CHtml::submitButton('submit',array('class'=>'btn'));

        echo CHtml::endForm();

        $this->endWidget();
    ?>
</div>

<script>
    $(document).on("click",".modalLink",function(){
        $.ajax({
            type:"POST",
            url:"/backend/menugen/default/translateActions",
            data:{
                phrase:$(this).data("action")
            },
            success:function(response){
                var resp = JSON.parse(response);
                $('#SourceMsg').val(resp.sourceMsg);
                var count = resp.translateMsgs.length;
                for(var i =0; i < count; i++){
                    var lang = resp.translateMsgs[i].language;
                    var translation = resp.translateMsgs[i].translation;
                    $('#SourceMessage_'+lang).val(translation);
                }
            }
        });
      var myModal = $('#myModal');
       myModal.modal('show');
    });
</script>

