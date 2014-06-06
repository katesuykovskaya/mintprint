<h3 class="page-header">test</h3>

<?php
    echo CHtml::ajaxLink('ajaxLink',
        $this->createUrl('/backend/menugen/sitemenu/json',
            array('language'=>Yii::app()->language)),
            array('ajax'=>array(
                'type'=>'post',
                'url'=>$this->createUrl('/backend/menugen/sitemenu/json',
                    array('language'=>Yii::app()->language)),
                'dataType'=>'json',
                'success'=>'function(data){alert("yes");}'
            ))

    );

    $json = CJSON::decode(Yii::app()->request->getRawBody());

    echo CVarDumper::dump($json,3,true);
?>