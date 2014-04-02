<?php

//if($model){
////    echo CVarDumper::dump($model,5,true);
//    echo '<table class="table-bordered table-striped" style="width: 100%;">';
//    echo    '<thead>
//                <th>Тип</th>
//                <th>id</th>
//                <th>Язык</th>
//                <th>Перевод</th>
//            </thead>';
//foreach($model as $translation)
//    {
//            echo '<tr>';
//                echo '<td>'.Yii::t('main','Перевод').'</td>';
//                echo '<td>'.$translation->id.'</td>';
//                echo '<td>'.$translation->language.'</td>';
//                echo '<td>'.$translation->translation.'</td>';
////                echo '<td>'.CHtml::link(Yii::t('main','Изменить'),).'</td>';
//            echo '</tr>';
//    }
//    echo '</table>';
//}
//else
//    echo Yii::t('main','Нет переводов для выбранного элемента');



Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
Yii::app()->clientScript->registerCssFile($baseUrl.'/css/backend.css', CClientScript::POS_HEAD);

?>
<style>
    .table-equal-rows-width table {
        table-layout: fixed;
    }
    .table-equal-rows-width > table > td {
        width: 2%;
    }

</style>
<?php
//CVarDumper::dump($dataProvider, 5, true);

if(isset($dataProvider)) $this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'type'=>'striped bordered',
    'dataProvider' => $dataProvider,
    'template' => "{items}",
    'htmlOptions'=>array(
        'class'=>'table-equal-rows-width',
    ),
    'columns' =>
//    array_merge(array(array('class'=>'bootstrap.widgets.TbImageColumn')),$gridColumns),
    array(
        array(
            'name'=>'translation.t_fio',
            'header'=>Yii::t('backend','ФИО игрока'),
            'class'=>'bootstrap.widgets.TbJEditableColumn',
            'value'=>'$data->translation[Yii::app()->language]->t_fio',
            'jEditableOptions' => array(
                'type' => 'text',
                'cssclass'=>'input-large',
                // very important to get the attribute to update on the server!
                'submitdata' => array('attribute'=>'translation'),
//                'placeHolder'=>'--No translation--'
//                'cssclass' => 'form',
//                'width' => '180px'
            )
        ),
        array(
            'name' => 'birth_date',
            'value'=> 'Yii::app()->dateFormatter->format("dd-MM-yyyy","$data->birth_date")',
            'header'=>Yii::t('backend','Дата рождения'),
        ),
        array(
            'name'=>'country',
            'header'=>Yii::t('backend', 'Страна'),
            'value'=>'$data->translation[Yii::app()->language]->t_country',
        ),
    ),
));

