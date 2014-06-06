
<h3 class="page-header"><?php echo Yii::t('backend','Администрирование страниц');?></h3>

<?php echo CHtml::link(Yii::t('backend','Create new Page'),$this->createUrl('/backend/pages/pages/create',array('language'=>Yii::app()->language)),array('class'=>'btn btn-info'));?>

<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'pages-translate-grid',
        'type'=>'striped bordered',
        'sortableRows'=>true,
        'selectableRows'=>1,
        'afterSortableUpdate' => 'js:function(id, position){}',
	    'dataProvider'=>$model->search(),
    // -- аякс урл должен быть указан и указан правильно, чтобы после возврата пустого значения в поиске
    // -- не приходилось перезапускать грид обновлением страницы (возвращается undefined и грид вешается, при правильном аяксурл этого не происходит)
        'ajaxUrl'=>'grid',
    //--
        'sortableAttribute'=>'page_id',
        'sortableAction'=>'backend/pages/pages/gridSave',
        'sortableAjaxSave'=>true,
        'fixedHeader' => true,
	    'filter'=>$model,
        'enableHistory'=>true,  
	'columns'=>array(
//                array(
//                    'name'=>'id',
//                //    'value'=>'$data->page->page_id',
//                    'htmlOptions'=>array('style'=>'width:3%;'),
//                    ),
                array(
                    'name'=>'level',
                    'filter'=>StaticPages::model()->selectArray(true),
                    'value'=>'$data->page->page_id',
                ),
		't_title',
		't_desc',
                't_h1',
                array(
                    'name'=>'t_lang',
                    'filter'=>StaticPages::getLangDropdown(),
                ),
                array(
                    'name'=>'published',
                    'value'=>'$data->published',
                    'filter'=>CHtml::dropDownList('PagesTranslate[published]', '', array(0=>'Не опубликована',1=>'Опубликована'),array('prompt'=>Yii::t('backend','Выберите статус'))),
                ),
                't_mdesc',
                't_mtitle',
                't_mkeywords',
                't_translit',
		array(
			'class'=>'CButtonColumn',
            'updateButtonUrl'=>'Yii::app()->urlManager->createUrl("/backend/pages/pages/update",array("id"=>$data->page_id,"language"=>Yii::app()->language))',
            'viewButtonUrl'=>'Yii::app()->urlManager->createUrl("/backend/pages/pages/view",array("id"=>$data->page_id,"language"=>Yii::app()->language))',
            'deleteButtonUrl'=>'Yii::app()->urlManager->createUrl("/backend/pages/pages/delete",array("id"=>$data->page_id,"language"=>Yii::app()->language))',
		),
	),
)); 
?>