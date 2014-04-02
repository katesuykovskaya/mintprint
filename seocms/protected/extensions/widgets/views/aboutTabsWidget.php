<?php
Yii::app()->clientScript->registerScript(
    'aboutTabs',
    '   $(function() {
        $( "#about-tabs" ).tabs({
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
?>
<div class="about-cell">

    <div id="about-tabs">

        <ul class="cf">
            <?php foreach($children as $key=>$page):?>
            <li><a href="#about-tabs-<?=$page->page_id?>"><?=$page->translation->t_title?></a></li>
            <?php endforeach ?>
        </ul>

        <?php foreach($children as $key=>$page):?>
        <div id="about-tabs-<?=$page->page_id?>" class="tab">
            <?php if($page->page_id == 31):?>

                <?php foreach($logos as $key=>$attach):?>
                    <div class="client-logo-wrapper">
                        <div class="center-vertical-alignment">
                            <img src="<?='/uploads/StaticPages/31/'.$attach->path?>" alt="<?=$attach->description?>"/>
                        </div>
                    </div>
                <?php endforeach ?>

            <?php else :?>
                <?=$page->translation->t_content?>
            <?php endif ?>
        </div>
        <?php endforeach ?>
    </div>

</div>