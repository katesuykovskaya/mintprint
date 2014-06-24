<?php
$level=0;

foreach($menu as $n=>$item)
{
    if($item->level==$level)
        echo CHtml::closeTag('li')."\n";
    else if($item->level>$level){
        echo CHtml::openTag('menu')."\n";
        echo CHtml::openTag('ul')."\n";
    }
    else
    {
        echo CHtml::closeTag('li')."\n";

        for($i=$level-$item->level;$i;$i--)
        {
            echo CHtml::closeTag('ul')."\n";
            echo CHtml::closeTag('li')."\n";
        }
    }
    echo CHtml::openTag('li');
    echo CHtml::link($item->translation[Yii::app()->language]->t_text,$item->translation[Yii::app()->language]->t_url);
    $level=$item->level;
}

for($i=$level;$i;$i--)
{
    echo CHtml::closeTag('li')."\n";
    echo CHtml::closeTag('ul')."\n";
    echo CHtml::closeTag('menu')."\n";
}
?>