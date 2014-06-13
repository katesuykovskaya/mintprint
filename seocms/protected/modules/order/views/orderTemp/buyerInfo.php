<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 12.06.14
 * Time: 10:49
 * @var $this OrderTempController
 */
?>
<section class="content buyer-info-form">
    <h1><?=Yii::t('frontend', 'Оплатите')?></h1>
    <p><?=Yii::t('frontend', 'Печать ваших замечательних фотографий')?></p>
    <div class="overflow-hidden forms-start">
        <div class="tree-forms left">
            <div class="overflow-hidden">
                <div class="left enter-wrap">
                    <h2><?=Yii::t('frontend', 'уже зарегистрированы?')?></h2>
                    <a href="#" class="continue-button"><?=Yii::t('frontend', 'Войти')?></a>
                </div>
                <div class="left create-profile-wrap">
                    <?php $this->renderPartial('application.common.modules.users.views.users._createAccount', array(
                        'createAccountModel'=>$createAccountModel
                    ))?>
                </div>
            </div>
            <div class="order-head-wrap">
                <h2><?=Yii::t('frontend', 'вы и ваш адрес')?></h2>
                <?php $this->renderPartial('application.modules.order.views.order._order', array(
                    'orderFormModel'=>$orderFormModel
                ))?>
            </div>
        </div>
        <div class="left total-basket-info">
            <p class="green-text"><?=Yii::t('frontend', 'Распечатать ваши замечательные фотографии')?></p>
            <p class="grey-text"><?=Yii::t('frontend', 'будет стоить - ')?></p>
            <div id="priceWrap" class="relative">
                <span id="price"><?=OrderTemp::CollectPrice($config['price'])?></span>
                <sup><?=$config['currency']?></sup>
            </div>
            <p class="grey-text">
                Через неделю фотографии пришлют по указанному адресу. Задавайте вопросы по телефону <?=Yii::t('frontend', 'PHONE')?>
            </p>
            <a class="back-button" href="javascript: history.back(); return false">назад</a>
        </div>
    </div>

</section>