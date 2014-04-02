<div class="about-container">
    <div class="about-left">
        <div class="about-cell">
            <?php $company_about = StaticPages::model()->findByPk(27); echo $company_about->translation->t_content;?>
        </div>

        <div class="about-cell bottom">
            <?php $why_us = StaticPages::model()->findByPk(28); echo $why_us->translation->t_content;?>
        </div>
    </div>

    <div class="about-right">

        <?php $this->widget('ext.widgets.AboutTabsWidget',array('parent'=>30))?>


        <div class="about-cell bottom">
            <?php $how_help=StaticPages::model()->findByPk(29);
                echo $how_help->translation->t_content;
            ?>
        </div>
    </div>
</div>