<div class="header-and-content-wrap home-page">
    <header>
        <div class="header-wrap">
            <?php $this->widget('application.backend.modules.menugen.widgets.FrontMenu',array('menuName'=>'меню в head'))?>
            <div class="right-buttons">
                <a id="profile" class="profile" href="<?=!empty(Yii::app()->user->id) ? Yii::app()->createUrl('site/profile') : Yii::app()->createUrl('site/login')?>"><?=!empty(Yii::app()->user->id) ? Yii::app()->user->login : ''?></a>
                <a id="basket" class="basket" href="<?=Yii::app()->createUrl('order/orderTemp/basket')?>"></a>
            </div>
        </div>
        <div class="header-bg"></div>
    </header>
    <section class="content overflow-hidden" id="content">
        <div class="title-home">MINT PRINT<span>ПЕЧАТЬ ФОТОГРАФИИ ИЗ СОЦСЕТЕЙ</span></div>
        <div class="buttons-soc">
            <a href="#" class="inst"></a>
            <a href="#" class="fb"></a>
            <a href="#" class="vk"></a>
        </div>
        <a href="<?=Yii::app()->createUrl('site/index')?>" class="print-button">давайте печатать!</a>
        <div class="desc-button-print">Shoot  Print  Never forget</div>
    </section>
</div>