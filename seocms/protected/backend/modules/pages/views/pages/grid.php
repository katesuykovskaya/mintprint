<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend', array('language'=>Yii::app()->language)))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Администрирование страниц')?></li>
    </ul>
</div>

<h3 class="page-header"><?php echo Yii::t('backend','Администрирование страниц');?></h3>

<?php echo CHtml::link(Yii::t('backend','Создать страницу'),$this->createUrl('/backend/pages/pages/create',array('language'=>Yii::app()->language)),array('class'=>'btn btn-info'));?>

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
                array(
                    'header'=>Yii::t('backend','Уровень'),
                    'name'=>'level',
                    'filter'=>StaticPages::model()->selectArray(true),
                    'value'=>'$data->page->page_id',
                ),
		        't_title',
                array(
                    'header'=>Yii::t('backend','Описание'),
                    'name'=>'t_desc',
                ),
                array(
                    'header'=>Yii::t('backend','Заголовок h1'),
                    'name'=>'t_h1',
                ),
                array(
                    'header'=>Yii::t('backend','Язык'),
                    'name'=>'t_lang',
                    'filter'=>StaticPages::getLangDropdown(),
                ),
                array(
                    'name'=>'published',
                    'value'=>'$data->published',
                    'filter'=>CHtml::dropDownList('PagesTranslate[published]', '', array(0=>'Не опубликована',1=>'Опубликована'),array('prompt'=>Yii::t('backend','Выберите статус'))),
                ),
//                't_mdesc',
//                't_mtitle',
//                't_mkeywords',
//                't_translit',
                array(
                    'header'=>Yii::t('backend','Мета-Описание'),
                    'name'=>'t_mdesc',
                ),array(
                    'header'=>Yii::t('backend','Мета-Тайтл'),
                    'name'=>'t_mtitle',
                ),array(
                    'header'=>Yii::t('backend','Ключевые Слова'),
                    'name'=>'t_mkeywords',
                ),array(
                    'header'=>Yii::t('backend','Транслит'),
                    'name'=>'t_translit',
                ),
                array(
                    'class'=>'CButtonColumn',
                    'updateButtonUrl'=>'Yii::app()->urlManager->createUrl("backend/pages/pages/update",array("id"=>$data->page_id,"language"=>Yii::app()->language))',
                    'viewButtonUrl'=>'Yii::app()->urlManager->createUrl("backend/pages/pages/view",array("id"=>$data->page_id,"language"=>Yii::app()->language))',
                    'deleteButtonUrl'=>'Yii::app()->urlManager->createUrl("backend/pages/pages/delete",array("id"=>$data->page_id,"language"=>Yii::app()->language))',
                ),
	),
));