<div class="header-and-content-wrap home-page">
    <header>
        <div class="header-wrap">
            <menu>
                <ul>
                    <li><a href="#">оплата и доставка</a></li>
                    <li><a href="#">новости</a></li>
                    <li><a href="#">главная</a></li>
                    <li><a href="#">о нас</a></li>
                </ul>
            </menu>
            <div class="right-buttons">
                <a id="profile" class="profile" href="#"></a>
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