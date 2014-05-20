<!DOCTYPE html>
<html lang="<?=Yii::app()->language?>">
    <head>
	<title><?php echo Yii::t('backend','SeoTM CMS :: '.Yii::app()->name)?></title>
	<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="/css/unicorn/css/unicorn.main.css" />
	<link rel="stylesheet" href="/css/unicorn/css/unicorn.grey.css" class="skin-color" />
    <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css" />
    </head>
    <body>
	<div id="header">
	    <h2><?=CHtml::link('SeoTM CMS',Yii::app()->urlManager->createUrl('backend',array('language'=>Yii::app()->language)));?></h2>
	</div>

	<div id="user-nav" class="navbar navbar-inverse">
        <ul class="nav btn-group">
            <?php if(Yii::app()->user->role == 'admin') :?>
            <li class="btn btn-inverse" ><a title="" href="/backend/rights"><i class="icon icon-user"></i> <span class="text"><?=Yii::t('backend','Права доступа')?></span></a></li>
            <?php endif;?>
            <?php Yii::import('application.backend.modules.feedback.models.*');
            $count = Feedback::getMaillistCount();
            ?>
            <li class="btn btn-inverse">
                <a href="<?=Yii::app()->createUrl('backend/feedback/feedback/maillist', ['language'=>Yii::app()->language])?>">
                    <i class="icon icon-envelope"></i>
                    <span class="text"><?=Yii::t('backend','Сообщения')?></span>
                    <span class="label label-important"><?=$count?></span>
                </a>
            </li>

            <li class="btn btn-inverse dropdown" id="menu-languages"><a href="#" data-toggle="dropdown" data-target="#menu-languages" class="dropdown-toggle"><span class="text"><?=Yii::t('backend','Язык')?></span><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php foreach(Yii::app()->params->languages as $language) : ?>
                        <?php
                            $url = explode('url=',Yii::app()->request->queryString);
                            $url = isset($url[1]) ? 'backend/'.$url[1] : 'backend/';
                        ?>
                    <li><a class="sAdd" title=""
                        href="<?php echo $this->createUrl($url,array('language'=>$language['langcode']));?>"><?php echo CHtml::image('/img/icons/flags/16/'.$language['countrycode'].'.png').Yii::t('backend',$language['lang']);?></a></li>
                    <?php endforeach;?>
                </ul>
            </li>

            <li class="btn btn-inverse">
                <a title="" href="<?php echo $this->createUrl('backend/users/users/logout',array('language'=>Yii::app()->language));?>"><i class="icon icon-share-alt"></i> <span class="text"><?=Yii::t('backend','Выход')?></span></a>
            </li>
        </ul>
    </div>

       <!-- сайдбар с главным меню-->
    <div id="sidebar">
        <?php Yii::app()->controller->widget('application.backend.extensions.widgets.BackendMenu');?>
    </div>
    <!--   конец главного меню	-->

	<div id="content">
	    <div id="content-header">
            <h1><?php echo Yii::t('backend','Администрирование '.Yii::app()->name);?></h1>
	    </div>
        <!-- хлебные крошки -->
<!--	<div id="breadcrumb">-->
<!--        --><?php
//            if(isset(Yii::app()->controller->module->id))
//                echo CHtml::link(ucfirst(Yii::t('backend',Yii::app()->controller->module->id)));
//            echo CHtml::link(ucfirst(Yii::t('backend',isset(Yii::app()->controller->id) ? Yii::app()->controller->id : '')));
//            echo '<strong>'.CHtml::link(Yii::t('backend',ucfirst(isset(Yii::app()->controller->action->id) ? Yii::app()->controller->action->id : ''))).'</strong>';
//        ?>
<!--        <span class="pull-right span3">-->
<!--            <em>-->
<!--                --><?php
//                    if(!Yii::app()->user->isGuest) {
//                        echo isset($_SESSION['name']) ? Yii::t('backend','Добро пожаловать, '.$_SESSION['name'].'!') : Yii::t('backend','Добро пожаловать, '.Yii::app()->user->login.'!');
//                    }
//                ?>
<!--            </em>-->
<!--        </span>-->
<!--    </div>-->
    <!-- конец хлебных крошек -->
                    
    <div class="container-fluid">
        <?=$content;?>
		<div class="row-fluid">
		    <div id="footer" class="span12">
			<?=date('Y')?> &copy; </a>
                <div class="pull-right">
            <?php //CController::widget('backend.modules.users.widgets.UserSocial');?>
                </div>
		    </div>
		</div>
    </div>
	</div>
    <script src="/js/jquery.cookie.js"></script>
    </body>
</html>