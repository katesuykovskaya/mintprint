<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Мультиязычность. Словарь.')?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend','Мультиязычность. Словарь.')?></h3>

<div class="row-fluid">
   <div class="span2">
    <?php echo CHtml::link(Yii::t('backend','Новая фраза'),$this->createUrl('/backend/multilanguage/source/create'),array('class'=>'btn btn-success'));?>
   </div>
    <div id="message" class="span5 offset1">

        <?php if(Yii::app()->user->hasFlash('success')) : ?>

            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo Yii::app()->user->getFlash('success');?>
            </div>

        <?php elseif(Yii::app()->user->hasFlash('error')) : ?>

        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo Yii::app()->user->getFlash('error');?>
        </div>

        <?php endif?>

    </div>
</div>
<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'source-message-grid',
    'type'=>'striped bordered',
	'dataProvider'=>$model->search(),
	'filter'=>$model,

        'columns'=>
        array_merge(array(
                array(
                    'class'=>'bootstrap.widgets.TbRelationalColumn',
                    'name' => Yii::t("backend","Все переводы"),
                    'filter'=>'',
                    'url' => $this->createUrl('multilanguage/source/relational'),
                    'value'=> 'Yii::t("backend","Все переводы")',
//                    'afterAjaxUpdate' => 'js:function(tr,rowid,data){
//                            bootbox.alert("I have afterAjax events too!
//                            This will only happen once for row with id: "+rowid);
//                          }'
                )
            ),
                array(
//                    'id',
                    array(
                        'name'=>'category',
                        'header'=>Yii::t('main','Словарь'),
                        'value'=>'$data->category',
                        'filter'=>$model->categoryList,
                    ),
                    'message'=>array(
                        'header'=>Yii::t("backend","Исходная фраза"),
                        'name'=>'message',
                        'value'=>'$data->message',
                    ),
                    'translationField'=>array(
                        'header'=>Yii::t("backend","Перевод"),
                        'value'=>function($data,$row){
                            return isset($data->messages[Yii::app()->language]->translation) ? $data->messages[Yii::app()->language]->translation : null;
                        },

                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'header'=>Yii::t('backend','Удаление'),
                        'buttons'=>array(
                            'delete'=>array(
                                'url'=>'Yii::app()->urlManager->createUrl("backend/multilanguage/source/delete",array("id"=>$data->id,"language"=>Yii::app()->language))'
                            ),
                            'update'=>array(
                                'url'=>'Yii::app()->urlManager->createUrl("backend/multilanguage/source/update",array("id"=>$data->id,"language"=>Yii::app()->language))'
                            ),
                            'view'=>array(
                                'visible'=>'0',
                            )
                        ),

                    ),
                )
        )
));
?>


