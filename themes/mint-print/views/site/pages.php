<div class="head-page">MINT PRINT</div>
<div class="wrapper-page">
        <div class="left-page">
            <div class="title-page">
                <?=$model->t_h1;?>
            </div>
            <div class="content-page">
                <?=$model->t_content;?>
            </div>
        </div>
        <div class="right-page">
            <div class="right-block-info">
                <div class="head-block-info">РЕШАЙТЕ СОХРАНИТЬ СВОИ ЛУЧШИЕ ВОСПОМИНАНИЯ</div>
                <div class="price-photo">Цена фотографии всего</div>
                <div id="priceWrap" class="relative">
                    <span id="price"><?=$conf['price']?></span><sup><?=$conf['currency']?></sup>
                </div>
                <div class="desc-photo">А воспоминания - бесценны. жмите на кнопку и посмотрите, как моменты вашей жизненной истории смотрятся в полароидных рамочках</div>
                <a href="<?=Yii::app()->createUrl('site/index')?>" class="watch-button">СМОТРЕТЬ МОИ ФОТО</a>
            </div>

        </div>
</div>