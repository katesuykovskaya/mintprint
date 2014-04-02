<?php
Yii::app()->clientScript->registerScript(
    'serviceTabs',
    '        $(function() {
            $( "#service-tabs" ).tabs({
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
$number=count($allPages);
?>
    <ul class="cf">
        <?php for($i=0;$i<$number;$i++):?>
        <li>
            <div class="service-link-wrapper">
                <a href="#service-tabs-<?=$i?>">
                    <?=$allPages[$i]['t_title']?>
                </a>
            </div>
        </li>
        <?php endfor ?>
    </ul>

<?php for($i=0;$i<$number;$i++):?>
    <div id="service-tabs-<?=$i?>" class="tab">
        <?=$allPages[$i]['t_content']?>
    </div>
<?php endfor ?>
