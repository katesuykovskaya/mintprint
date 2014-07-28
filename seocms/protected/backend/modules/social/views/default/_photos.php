<?php
/**
 * Created by PhpStorm.
 * User: chosen1
 * Date: 31.03.14
 * Time: 12:42
 * @var $this DefaultController
 */

$len = count($photos);
for($i=1; $i < $len; $i++) {
    echo CHtml::image($photos[$i]['src_big'],$photos[$i]['text']);
}