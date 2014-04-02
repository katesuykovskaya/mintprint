<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Создание меню'),$this->createUrl('backend/menugen/sitemenu/index',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Создание нового пункта меню')?></li>
    </ul>
</div>

<h3 class="page-header"><?php echo Yii::t('backend','Создание нового пункта меню');?></h3>

<?php if(Yii::app()->user->hasFlash('message_error')) :?>
    <div class="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h5><?php echo Yii::app()->user->getFlash('message_error');?></h5>
    </div>
<?php endif;?>
<div class="span10">
<?php echo CHtml::dropDownList('linkType','',array('page'=>'page','category'=>'category','url'=>'url'),array(
                                    'ajax'=>array(
                                        'type'=>'post',
                                        'url'=>$this->createUrl('backend/menugen/sitemenu/createItem',array('language'=>Yii::app()->language)),
                                        'update'=>'#menuForm',
                                        'data' => array(
                                            'linkType'=> 'js: $("#linkType option:selected").val()',
                                            'menuName'=>$_GET['type']

                                        ),
                                    ),
                                    'empty'=>Yii::t('backend','Выберите из списка'),
));?>
<div id="menuForm"></div>

</div>
