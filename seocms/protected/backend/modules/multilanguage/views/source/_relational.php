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


$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'type'=>'striped bordered',
    'dataProvider' => $dataProvider,
    'template' => "{items}",
    'columns' =>
//    array_merge(array(array('class'=>'bootstrap.widgets.TbImageColumn')),$gridColumns),
    array(
        array(
            'name'=>'translation',
            'header'=>Yii::t('main','Перевод'),
            'headerHtmlOptions' => array('style' => 'width:80px'),
            'class'=>'bootstrap.widgets.TbJEditableColumn',
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
//        'translation_id',
//        'id',
        array(
            'header'=>Yii::t("backend","Язык"),
            'type'=>'html',
            'value'=>'SourceMessage::getFlagImage($data->language)'

        ),
//        'translation',

    ),
));

