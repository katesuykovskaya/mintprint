<?php
Yii::app()->clientScript->registerScript(
    'portfolioTabs',
    '        $(function() {
            $( "#portfolio-tabs" ).tabs({
                create: function( event, ui ) {
                    $(ui.tab[0]).addClass("active");
                },
                beforeActivate: function( event, ui ) {
                    $(ui.oldTab[0]).removeClass("active");
                },
                activate: function( event, ui ) {
                    $(ui.newTab[0]).addClass("active");
                }
            });
        });',
    CClientScript::POS_END
);

$number = count($allPages);
?>
<div id="portfolio-tabs">
    <ul class="links cf">
        <?php for($i=0;$i<$number;$i++):?>
        <li>
            <a href="#portfolio-tabs-<?=$allPages[$i]['page_id']?>"><?=$allPages[$i]['t_title']?></a>
        </li>
        <?php endfor ?>
    </ul>
    <?php foreach($content as $page_id=>$page):?>
    <div id="portfolio-tabs-<?=$page_id?>" class="tab">
            <div class="portfolio-row">
                <?php foreach($page as $key=>$data):?>
                    <?php
//                        if(is_file(Yii::getPathOfAlias('webroot').'/uploads/StaticPages/'.$data->page_id.'/'.$data->img)){
//                            $image = new EasyImage(Yii::getPathOfAlias('webroot').'/uploads/StaticPages/'.$data->page_id.'/'.$data->img);
//                            $image->resize(280,201,EasyImage::RESIZE_NONE);
//                            $image->save(Yii::getPathOfAlias('webroot').'/uploads/StaticPages/'.$data->page_id.'/thumb_'.$data->img);
//                            $all ='<a href="/uploads/StaticPages/'.$data->page_id.'/'.$data->img.'" data-lightbox="no-image-'.$data->page_id.'"><img src="/uploads/StaticPages/'.$data->page_id.'/thumb_'.$data->img.'"></a>';
//                        } else {
//                            $image = new EasyImage(Yii::getPathOfAlias('webroot').'/img/no_image.gif');
//                            $image->resize(280,201,EasyImage::RESIZE_NONE);
//                            $image->save(Yii::getPathOfAlias('webroot').'/img/thumb_no_image.gif');
//                            $all ='<a href="/img/no_image.gif" data-lightbox="no-image-'.$data->page_id.'"><img src="/img/thumb_no_image.gif"></a>';
//                        }
                    $image = is_file(Yii::getPathOfAlias('webroot').'/uploads/StaticPages/'.$data->page_id.'/'.$data->img)
                        ?
                            Yii::app()->easyImage->thumbOf(Yii::getPathOfAlias('webroot').'/uploads/StaticPages/'.$data->page_id.'/'.$data->img,
                                array(
                                    'resize' => array('width' => 280, 'height' => 201,'master'=>EasyImage::RESIZE_NONE),
                                    'savePath'=>'/uploads/StaticPages/'.$data->page_id.'/',
                                    'quality' => 100,
                                ))
                        :
                            Yii::app()->easyImage->thumbOf(Yii::getPathOfAlias('webroot').'/img/no_image.gif',
                                array(
                                    'resize' => array('width' => 280, 'height' => 201,'master'=>EasyImage::RESIZE_NONE),
                                    'savePath'=>'/img/',
                                    'quality' => 100,
                                ));
                    $all = is_file(Yii::getPathOfAlias('webroot').'/uploads/StaticPages/'.$data->page_id.'/'.$data->img)
                        ?
                            '<a href="/uploads/StaticPages/'.$data->page_id.'/'.$data->img.'" data-lightbox="'.$data->page_id.'">
                            '.$image.'</a>'
                        :
                            '<a href="/img/no_image.gif" data-lightbox="no-image-'.$data->page_id.'">'.$image.'</a>';
                    ?>

                <div class="portfolio-item">
                    <figure><?=$all?>
                        <figcaption><a><?=$data->translation->t_title?></a></figcaption>
                        <?=$data->translation->t_content?>
                    </figure>
                </div>
                <?php endforeach; ?>
            </div>
    </div>
    <?php endforeach; ?>
</div>