<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Seotm.ru.vbox</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css" >
    <link rel="stylesheet" type="text/css" href="css/normalize.css" >
    <link rel="stylesheet" type="text/css" href="css/lightbox.css" >
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css" >
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="/js/html5.js"></script>
    <script type="text/javascript" src="/js/jquery.carouFredSel-6.2.1-packed.js"></script>

    <link href='http://fonts.googleapis.com/css?family=Scada:400italic,700italic,400,700&subset=latin,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="/js/lightbox.js"></script>
</head>
<body>
<header id="header">
    <div class="header">
        <div class="logo"></div>

        <nav>
            <?php $this->widget('application.backend.modules.menugen.widgets.FrontMenu',array('menuName'=>'Меню в хедере'))?>
        </nav>
        <div class="send-request">
            <a class="a_demo_three" href="#">
                <?=Yii::t('frontend','Отправить запрос')?>
            </a>
        </div>
    </div>
</header>

<section class="sliderWrapper">
    <?php
    $this->widget('ext.carouFredSel.ECarouFredSel', array(
        'id' => 'carousel',
        'target' => '#megaslider',
        'config' => array(
            'items' => 1,
            'direction'=> "right",
            'circular'=> true,
            'scroll' => array(
                'items' => 1,
                'easing' => 'linear',
                'duration' => 1000,
//                'pauseDuration' => 1500,
                'pauseOnHover' => true,
//                'fx' => 'crossfade',
            'event'=>'click'
            ),
            'prev'=>array (
                'button'=> ".arrow-left",
                    'key'=> "left"
            ),
            'next'=> array(
                'button' => ".arrow-right",
                    'key'=> "right"
            ),
        )
    ));
    ?>
    <div id="megaslider">
        <?php
        Yii::import('application.backend.modules.attach.models.Attachment');
            foreach(Attachment::model()->findAllByAttributes(array('attachment_entity'=>'StaticPages','entity_id'=>12),array('order'=>'position')) as $key=>$image){
                echo CHtml::image('/uploads/StaticPages/12/'.$image->path,$image->description);
            }

        ?>
    </div>
    <div class="sw-wrapper">
        <div class="switchers">
            <img src="/img/left.png" class="arrow-left" />
            <img src="/img/right.png" class="arrow-right" />
        </div>
    </div>
</section>

<section id="services" class="main-services">
    <div id="tabs">
    <?php
    $this->widget('ext.widgets.MainServicesWidget',array(
        'pages'=>array(9,10,11)
    ));
    ?>

    </div>

</section>

<section>
    <div class="services">

        <?=$content?>
        <!-- service tabs -->

        <div id="service-tabs">
            <?php
            $this->widget('ext.widgets.ServiceTabsWidget',array(
                'pages'=>array(13,14,15)
            ));
            ?>
        </div>

        <!-- service tabs end -->
    </div>

</section>

<section id="portfolio">

<div class="portfolio-wrapper">

<h1>Портфолио</h1>

<?php $this->widget('ext.widgets.PortfolioWidget',array(
    'pages'=>array(16,17,18,19)
))?>

</section>

<section id="about">
    <div class="about-wrapper">
        <?php
            $this->widget('ext.widgets.AboutWidget');
        ?>
    </div>
</section>

<section id="contacts">


    <div class="contacts-wrapper">


        <article class="left-bar">
            <?php
                $page = StaticPages::model()->findByPk(34);
                echo $page->translation->t_content;
            ?>
        </article>

        <form class="right-bar">

            <div class="left-side-form">

                <strong>Отправить запрос</strong>

                <p>
                    <label>
                        Имя: <mark>*</mark>
                        <input type="text" name="name" required="required"/>
                    </label>
                </p>

                <p>
                    <label>
                        Телефон:
                        <input type="tel" name="telephone"/>
                    </label>
                </p>

                <p>
                    <label>
                        E-mail <mark>*</mark>
                        <input type="email" name="email" required="required"/>
                    </label>
                </p>

                <p>
                    <label>
                        Сайт: <mark>*</mark>
                        <input type="url" name="site" required="required"/>
                    </label>
                </p>

                <p> Что вас интересует?
                    <mark>*</mark>
                </p>

                <p>
                    <input id="development" type="checkbox" name="development" class="styled-checkbox" checked=""/>
                    <label> Разработка сайта </label>
                    <span class="clear"></span>
                </p>

                <p>
                    <input id="optimization" type="checkbox" name="optimization" class="styled-checkbox"/>
                    <label>  Оптимизация и продвижение сайта </label>
                    <span class="clear"></span>
                </p>
            </div>

            <div class="right-side-form">

                <p>
                    <label>
                        Текст сообщения <mark>*</mark>
                        <textarea name="message" required="required"></textarea>
                    </label>
                </p>

                <div style="height: 30px; margin: 10px 0 0 0;">

                    <div class="upload-button-wrapper float-left" >
                        <button class="general-sizes showed-button">Прикрепить файл</button>
                        <input class="general-sizes hidden-input" type="file" id="fileInput" name="file" />
                    </div>

                    <span id="filePath">Файл не выбран</span>

                            <span class="blue-button-wrapper border-radius-10 float-right" style="min-width: 20%;">
                                <button type="submit" class="button border-radius-10 gradient-blue-darkblue">Отправить</button>
                            </span>

                    <span class="float-right file-caption">(техзадание, структура)</span>

                </div>
            </div>
        </form>
    </div>

</section>

<footer>
    <div class="footer">
        &copy; <?=date('Y')?> Все права защищены Компания Seotm.
    </div>
</footer>
</body>
</html>