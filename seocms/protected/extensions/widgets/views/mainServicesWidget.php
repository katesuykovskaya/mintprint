<?php
    Yii::app()->clientScript->registerScript(
        'tabs',
        '$(function() {
            var el = "<img class=tab-arrow src=img/arrow_down.png>";
            $( "#tabs" ).tabs({
                create: function( event, ui ) {
                    $(ui.tab[0]).append(el);
                },
                beforeActivate: function( event, ui ) {
                    $(".tab-arrow").remove();
                },
                activate: function( event, ui ) {
                    $(ui.newTab[0]).append(el);
                }
            });
        });',
        CClientScript::POS_END
    );
    $number = count($allPages);
?>
    <ul class="cf">
        <?php for($i=0;$i<$number;$i++):?>
        <li>
            <div class="link-wrapper cf">
                <a href="#tabs-<?=$i?>">
                    <?=CHtml::image('/uploads/StaticPages/'.$allPages[$i]['page_id'].'/'.$allPages[$i]['img'])?>
                    <span class="text"><?=$allPages[$i]['t_title']?></span>
                </a>
            </div>
        </li>
        <?php endfor?>
    </ul>

<?php for($i=0;$i<$number;$i++):?>
    <div id="tabs-<?=$i?>" class="tab">
        <?=$allPages[$i]['t_content']?>
    </div>
<?php endfor?>