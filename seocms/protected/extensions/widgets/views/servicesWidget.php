<div class="serviceBlock cf">
    <h1>Услуги</h1>
    <ul class="column">
<?php foreach($allPages as $page):?>
<?php
    $number = count($allPages);
    $imageParams =   array(
        'resize' => array('width' => 212, 'height' => 123, EasyImage::RESIZE_AUTO),
//        'background' => '#ffffff',
        'type' => 'png',
        'savePath'=>'/uploads/StaticPages/'.$page['page_id'].'/',
    );
    $imageName = '/uploads/StaticPages/'.$page['page_id'].DIRECTORY_SEPARATOR.$page['img'];
?>
        <li>
            <?=Yii::app()->easyImage->thumbOf($imageName,$imageParams);?>
            <h4><?=$page['t_title']?></h4>
            <ul>
                <?=$page['t_content']?>
            </ul>
        </li>
    <?php endforeach?>
    </ul>
</div>