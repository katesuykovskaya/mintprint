<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="/assets/1d9b8fd5/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/assets/1d9b8fd5/css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="/assets/1d9b8fd5/css/bootstrap-yii.css" />
    <link rel="stylesheet" type="text/css" href="/assets/1d9b8fd5/css/jquery-ui-bootstrap.css" />
    <script type="text/javascript" src="/assets/9208e56e/jquery.js"></script>
    <script type="text/javascript" src="/assets/9208e56e/jquery.ba-bbq.js"></script>
    <script type="text/javascript" src="/assets/9208e56e/jquery.history.js"></script>
    <script type="text/javascript" src="/assets/9208e56e/jui/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/assets/1d9b8fd5/js/bootstrap.bootbox.min.js"></script>
    <script type="text/javascript" src="/assets/1d9b8fd5/js/bootstrap.js"></script>
    <title>SeoTM CMS :: Fitness City</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/css/unicorn/css/unicorn.main.css" />
    <link rel="stylesheet" href="/css/unicorn/css/unicorn.grey.css" class="skin-color" />
    <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css" />
</head>
<body>
<div id="header">
    <h2><a href="/backend">SeoTM CMS</a></h2>
</div>

<div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav btn-group">
        <li class="btn btn-inverse" ><a title="" href="/backend/rights"><i class="icon icon-user"></i> <span class="text">Права доступа</span></a></li>
        <li class="btn btn-inverse">
            <a href="/backend/feedback/feedback/maillist">
                <i class="icon icon-envelope"></i>
                <span class="text">Сообщения</span>
                <span class="label label-important">3</span>
            </a>
        </li>

        <li class="btn btn-inverse dropdown" id="menu-languages"><a href="#" data-toggle="dropdown" data-target="#menu-languages" class="dropdown-toggle"><span class="text">Язык</span><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a class="sAdd" title=""
                       href="/backend/pages/pages/grid/&PagesTranslate%5Blevel%5D=&PagesTranslate%5Bt_title%5D=&PagesTranslate%5Bt_desc%5D=&PagesTranslate%5Bt_h1%5D=&PagesTranslate%5Bt_lang%5D=ru&PagesTranslate%5Bpublished%5D=0&PagesTranslate%5Bt_mdesc%5D=&PagesTranslate%5Bt_mtitle%5D=&PagesTranslate%5Bt_mkeywords%5D=&PagesTranslate%5Bt_translit%5D=&page=1&ajax=pages-translate-grid"><img src="/img/icons/flags/16/RU.png" alt="" />Русский</a></li>
            </ul>
        </li>

        <li class="btn btn-inverse">
            <a title="" href="/backend/users/users/logout"><i class="icon icon-share-alt"></i> <span class="text">Выход</span></a>
        </li>
    </ul>
</div>

<!-- сайдбар с главным меню-->
<div id="sidebar">
    <ul>
        <li><a id="64" href="/backend/slider/slider/admin">Слайдер на главной</a></li>
        <li><a id="66" href="/backend/gallery/gallery/index">Управление галереями</a></li>
        <li><a id="65">Управление командами</a><ul>
                <li><a id="62" href="/backend/teams/teams/admin">Команды</a></li>
                <li><a id="61" href="/backend/teams/players/admin">Игроки</a></li>
            </ul>
        </li>
        <li><a id="67" href="/backend/news/news/admin">Новости</a></li>
        <li><a id="29" href="/backend/pages/pages/grid">Статические страницы</a></li>
        <li><a id="35" href="/backend/users/users/admin">Пользователи</a></li>
        <li><a id="7" href="/backend/feedback/feedback/maillist">Обратная связь</a></li>
        <li><a id="3" href="/backend/feedback/feedback/admin">Настройки почты</a></li>
        <li><a id="45">Мультиязычность</a><ul>
                <li><a id="60" href="/backend/multilanguage/source/manage">Управление языками</a></li>
                <li><a id="18" href="/backend/multilanguage/source/admin">Переводы</a></li>
            </ul>
        </li>
        <li><a id="11" href="/backend/menugen/default/usermenu">Управление Бэк-енд меню</a></li>
        <li><a id="59" href="/backend/menugen/sitemenu/index">Управление Меню сайта</a></li>
    </ul>
    </li>
    </ul>
    <script>
        //    var $ = jQuery;
        $(document).ready(function(){
            var target = $('#sidebar a');
            var cookie = jQuery.cookie("openMenu");
            var menuCookie = JSON.parse(cookie);
            menuCookie = menuCookie !== null ? menuCookie : [];
            var lngth = menuCookie.length;
            jQuery.cookie("openMenu",JSON.stringify(menuCookie),{ expires: 7, path: '/' });

            for(var i in menuCookie){
                menuCookie[i] = parseInt(menuCookie[i]);
            }

            target.each(function(index){
                var len=$(this).next().children('li').length;
                var id = parseInt($(this).attr("id"));

                if(len!=0){
                    $(this).append('<span class="label">'+len+'</span>');
                }

                if($(this).attr("href") === window.location.pathname)
                    $(this).addClass("active");

                if(lngth > 0){
                    if($.inArray(id,menuCookie) !== -1){
                        $(this).next().css("display","block");
                    } else {
                        $(this).next().css("display","none");
                    }
                }

            });

            target.click(function(){
                var node = $(this).next();
                var visible = $(this).next().css("display");
                var id = parseInt($(this).attr("id"));
                var cookie = JSON.parse($.cookie("openMenu"));
                var cookieLen = cookie.length;

                if(visible==='none'){
                    $(node).css("display","block");
                    if(cookieLen === 0){
                        cookie[0] = id;
                        $.cookie("openMenu",JSON.stringify(cookie),{ expires: 7, path: '/' });
                    } else {
                        if($.inArray(id,cookie) === -1){
                            cookie[cookieLen] = id;
                            $.cookie("openMenu",JSON.stringify(cookie),{ expires: 7, path: '/' });
                        }
                    }

                } else {
                    if($(this).next().text().length > 0){
                        $(node).css("display","none");
                        if(cookieLen === 1){
                            cookie = [];
                            $.cookie("openMenu",JSON.stringify(cookie),{ expires: 7, path: '/' });
                        } else {
                            var position = $.inArray(id,cookie);
                            var newCookie = cookie.splice(position,1);
                            $.cookie("openMenu",JSON.stringify(cookie),{ expires: 7, path: '/' });
                        }
                    } else {
                        $.cookie("openMenu",JSON.stringify(cookie),{ expires: 7, path: '/' });
                    }
                }

                if($(this).next().text().length > 0)
                {
                    return false;
                }

            });
        });

    </script>
</div>
<!--   конец главного меню	-->

<div id="content">
    <div id="content-header">
        <h1>Администрирование Fitness City</h1>
    </div>
    <!-- хлебные крошки -->
    <!--	<div id="breadcrumb">-->
    <!--        --><!--        <span class="pull-right span3">-->
    <!--            <em>-->
    <!--                --><!--            </em>-->
    <!--        </span>-->
    <!--    </div>-->
    <!-- конец хлебных крошек -->

    <div class="container-fluid">
        <div class="row">
            <ul class="breadcrumb span6">
                <li><a href="/backend">Главная</a></li>
                <li><span class="divider">/</span>Администрирование страниц</li>
            </ul>
        </div>

        <h3 class="page-header">Администрирование страниц</h3>

        <a class="btn btn-info" href="/backend/pages/pages/create">Создать страницу</a>
        <div id="pages-translate-grid" class="grid-view">

            <table class="items table table-striped table-bordered">
                <thead>
                <tr>
                    <th id="pages-translate-grid_c0">Уровень</th><th id="pages-translate-grid_c1"><a class="sort-link" href="/url/pages%2Fpages%2Fgrid%2F/PagesTranslate%5Blevel%5D//PagesTranslate%5Bt_title%5D//PagesTranslate%5Bt_desc%5D//PagesTranslate%5Bt_h1%5D//PagesTranslate%5Bt_lang%5D/ru/PagesTranslate%5Bpublished%5D/0/PagesTranslate%5Bt_mdesc%5D//PagesTranslate%5Bt_mtitle%5D//PagesTranslate%5Bt_mkeywords%5D//PagesTranslate%5Bt_translit%5D//page/1/ajax/pages-translate-grid/PagesTranslate_sort/t_title">Тайтл страницы<span class="caret"></span></a></th><th id="pages-translate-grid_c2"><a class="sort-link" href="/url/pages%2Fpages%2Fgrid%2F/PagesTranslate%5Blevel%5D//PagesTranslate%5Bt_title%5D//PagesTranslate%5Bt_desc%5D//PagesTranslate%5Bt_h1%5D//PagesTranslate%5Bt_lang%5D/ru/PagesTranslate%5Bpublished%5D/0/PagesTranslate%5Bt_mdesc%5D//PagesTranslate%5Bt_mtitle%5D//PagesTranslate%5Bt_mkeywords%5D//PagesTranslate%5Bt_translit%5D//page/1/ajax/pages-translate-grid/PagesTranslate_sort/t_desc">Описание<span class="caret"></span></a></th><th id="pages-translate-grid_c3"><a class="sort-link" href="/url/pages%2Fpages%2Fgrid%2F/PagesTranslate%5Blevel%5D//PagesTranslate%5Bt_title%5D//PagesTranslate%5Bt_desc%5D//PagesTranslate%5Bt_h1%5D//PagesTranslate%5Bt_lang%5D/ru/PagesTranslate%5Bpublished%5D/0/PagesTranslate%5Bt_mdesc%5D//PagesTranslate%5Bt_mtitle%5D//PagesTranslate%5Bt_mkeywords%5D//PagesTranslate%5Bt_translit%5D//page/1/ajax/pages-translate-grid/PagesTranslate_sort/t_h1">Заголовок h1<span class="caret"></span></a></th><th id="pages-translate-grid_c4"><a class="sort-link" href="/url/pages%2Fpages%2Fgrid%2F/PagesTranslate%5Blevel%5D//PagesTranslate%5Bt_title%5D//PagesTranslate%5Bt_desc%5D//PagesTranslate%5Bt_h1%5D//PagesTranslate%5Bt_lang%5D/ru/PagesTranslate%5Bpublished%5D/0/PagesTranslate%5Bt_mdesc%5D//PagesTranslate%5Bt_mtitle%5D//PagesTranslate%5Bt_mkeywords%5D//PagesTranslate%5Bt_translit%5D//page/1/ajax/pages-translate-grid/PagesTranslate_sort/t_lang">Язык<span class="caret"></span></a></th><th id="pages-translate-grid_c5"><a class="sort-link" href="/url/pages%2Fpages%2Fgrid%2F/PagesTranslate%5Blevel%5D//PagesTranslate%5Bt_title%5D//PagesTranslate%5Bt_desc%5D//PagesTranslate%5Bt_h1%5D//PagesTranslate%5Bt_lang%5D/ru/PagesTranslate%5Bpublished%5D/0/PagesTranslate%5Bt_mdesc%5D//PagesTranslate%5Bt_mtitle%5D//PagesTranslate%5Bt_mkeywords%5D//PagesTranslate%5Bt_translit%5D//page/1/ajax/pages-translate-grid/PagesTranslate_sort/published">Опубликована<span class="caret"></span></a></th><th id="pages-translate-grid_c6"><a class="sort-link" href="/url/pages%2Fpages%2Fgrid%2F/PagesTranslate%5Blevel%5D//PagesTranslate%5Bt_title%5D//PagesTranslate%5Bt_desc%5D//PagesTranslate%5Bt_h1%5D//PagesTranslate%5Bt_lang%5D/ru/PagesTranslate%5Bpublished%5D/0/PagesTranslate%5Bt_mdesc%5D//PagesTranslate%5Bt_mtitle%5D//PagesTranslate%5Bt_mkeywords%5D//PagesTranslate%5Bt_translit%5D//page/1/ajax/pages-translate-grid/PagesTranslate_sort/t_mdesc">Мета-Описание<span class="caret"></span></a></th><th id="pages-translate-grid_c7"><a class="sort-link" href="/url/pages%2Fpages%2Fgrid%2F/PagesTranslate%5Blevel%5D//PagesTranslate%5Bt_title%5D//PagesTranslate%5Bt_desc%5D//PagesTranslate%5Bt_h1%5D//PagesTranslate%5Bt_lang%5D/ru/PagesTranslate%5Bpublished%5D/0/PagesTranslate%5Bt_mdesc%5D//PagesTranslate%5Bt_mtitle%5D//PagesTranslate%5Bt_mkeywords%5D//PagesTranslate%5Bt_translit%5D//page/1/ajax/pages-translate-grid/PagesTranslate_sort/t_mtitle">Мета-Тайтл<span class="caret"></span></a></th><th id="pages-translate-grid_c8"><a class="sort-link" href="/url/pages%2Fpages%2Fgrid%2F/PagesTranslate%5Blevel%5D//PagesTranslate%5Bt_title%5D//PagesTranslate%5Bt_desc%5D//PagesTranslate%5Bt_h1%5D//PagesTranslate%5Bt_lang%5D/ru/PagesTranslate%5Bpublished%5D/0/PagesTranslate%5Bt_mdesc%5D//PagesTranslate%5Bt_mtitle%5D//PagesTranslate%5Bt_mkeywords%5D//PagesTranslate%5Bt_translit%5D//page/1/ajax/pages-translate-grid/PagesTranslate_sort/t_mkeywords">Ключевые Слова<span class="caret"></span></a></th><th id="pages-translate-grid_c9"><a class="sort-link" href="/url/pages%2Fpages%2Fgrid%2F/PagesTranslate%5Blevel%5D//PagesTranslate%5Bt_title%5D//PagesTranslate%5Bt_desc%5D//PagesTranslate%5Bt_h1%5D//PagesTranslate%5Bt_lang%5D/ru/PagesTranslate%5Bpublished%5D/0/PagesTranslate%5Bt_mdesc%5D//PagesTranslate%5Bt_mtitle%5D//PagesTranslate%5Bt_mkeywords%5D//PagesTranslate%5Bt_translit%5D//page/1/ajax/pages-translate-grid/PagesTranslate_sort/t_translit">Транслит<span class="caret"></span></a></th><th class="button-column" id="pages-translate-grid_c10">&nbsp;</th></tr>
                <tr class="filters">
                    <td><div class="filter-container"><select name="PagesTranslate[level]" id="PagesTranslate_level">
                                <option value=""></option>
                                <option value="7"> -  - with upload</option>
                                <option value="6"> -  - test</option>
                                <option value="1"> - Главный раздел</option>
                            </select></div></td><td><div class="filter-container"><input name="PagesTranslate[t_title]" id="PagesTranslate_t_title" type="text" value="" /></div></td><td><div class="filter-container"><input name="PagesTranslate[t_desc]" id="PagesTranslate_t_desc" type="text" value="" /></div></td><td><div class="filter-container"><input name="PagesTranslate[t_h1]" id="PagesTranslate_t_h1" type="text" value="" /></div></td><td><div class="filter-container"><select name="PagesTranslate[t_lang]" id="PagesTranslate_t_lang">
                                <option value=""></option>
                                <option value="ru" selected="selected">Русский</option>
                            </select></div></td><td><div class="filter-container"><select name="PagesTranslate[published]" id="PagesTranslate_published">
                                <option value="">Выберите статус</option>
                                <option value="0">Не опубликована</option>
                                <option value="1">Опубликована</option>
                            </select></div></td><td><div class="filter-container"><input name="PagesTranslate[t_mdesc]" id="PagesTranslate_t_mdesc" type="text" value="" /></div></td><td><div class="filter-container"><input name="PagesTranslate[t_mtitle]" id="PagesTranslate_t_mtitle" type="text" value="" /></div></td><td><div class="filter-container"><input name="PagesTranslate[t_mkeywords]" id="PagesTranslate_t_mkeywords" type="text" value="" /></div></td><td><div class="filter-container"><input name="PagesTranslate[t_translit]" id="PagesTranslate_t_translit" type="text" /></div></td><td>&nbsp;</td></tr>
                </thead>
                <tbody>
                <tr><td colspan="11" class="empty"><span class="empty">Нет результатов.</span></td></tr>
                </tbody>
            </table>

            <div  class="extended-summary"></div></div>		<div class="row-fluid">
            <div id="footer" class="span12">
                2014 &copy; </a>
                <div class="pull-right">
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/assets/ada258f/gridview/jquery.yiigridview.js"></script>
<script type="text/javascript" src="/assets/1d9b8fd5/js/jquery.stickytableheaders.js"></script>
<script type="text/javascript" src="/assets/1d9b8fd5/js/jquery.sortable.gridview.js"></script>
<script type="text/javascript">
    /*<![CDATA[*/
    jQuery(function($) {
        jQuery('a[rel="tooltip"]').tooltip();
        jQuery('a[rel="popover"]').popover();
        jQuery(document).on('click','#pages-translate-grid a.delete',function() {
            if(!confirm('Вы уверены, что хотите удалить данный элемент?')) return false;
            var th = this,
                afterDelete = function(){};
            jQuery('#pages-translate-grid').yiiGridView('update', {
                type: 'POST',
                url: jQuery(this).attr('href'),
                success: function(data) {
                    jQuery('#pages-translate-grid').yiiGridView('update');
                    afterDelete(th, true, data);
                },
                error: function(XHR) {
                    return afterDelete(th, false, XHR);
                }
            });
            return false;
        });
        jQuery('#pages-translate-grid').yiiGridView({'ajaxUpdate':['pages-translate-grid'],'ajaxVar':'ajax','pagerClass':'pagination','loadingClass':'grid-view-loading','filterClass':'filters','tableClass':'items table table-striped table-bordered','selectableRows':1,'enableHistory':true,'updateSelector':'{page}, {sort}','filterSelector':'{filter}','url':'grid','pageVar':'page','afterAjaxUpdate':function() {
            jQuery('.popover').remove();
            jQuery('a[rel="popover"]').popover();
            jQuery('.tooltip').remove();
            jQuery('a[rel="tooltip"]').tooltip();
        }});

        $grid = $("#pages-translate-grid");
        $('#pages-translate-grid table.items').stickyTableHeaders({fixedOffset:0});
        if($(".extended-summary", $grid).length)
        {
            $(".extended-summary", $grid).html($("#pages-translate-grid-extended-summary", $grid).html());
        }
        $.fn.yiiGridView.sortable('pages-translate-grid', '/backend/pages/pages/gridSave/sortableAttribute/page_id', function(id, position){});
        $.ajaxPrefilter(function (options, originalOptions, jqXHR) {
            var qs = $.deparam.querystring(options.url);
            if(qs.hasOwnProperty("ajax") && qs.ajax == "pages-translate-grid")
            {
                options.realsuccess = options.success;
                options.success = function(data)
                {
                    if(options.realsuccess) {
                        options.realsuccess(data);
                        var $data = $("<div>" + data + "</div>");
                        // we need to get the grid again... as it has been updated
                        if($(".extended-summary", $("#pages-translate-grid")))
                        {
                            $(".extended-summary", $("#pages-translate-grid")).html($("#pages-translate-grid-extended-summary", $data).html());
                        }
                        $('#pages-translate-grid table.items').stickyTableHeaders({fixedOffset:0});
                        $.fn.yiiGridView.sortable('pages-translate-grid', '/backend/pages/pages/gridSave/sortableAttribute/page_id', function(id, position){});
                    }
                }
            }
        });
    });
    /*]]>*/
</script>
</body>
</html>