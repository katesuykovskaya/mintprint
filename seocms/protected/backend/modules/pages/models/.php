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
                       href="/backend/order/orderHead/admin&OrderHead%5Bid%5D=&OrderHead%5Bname%5D=&OrderHead%5Bemail%5D=&OrderHead%5Bphone%5D=&OrderHead%5Baddress%5D=&OrderHead%5Bcity%5D=&OrderHead%5BphotoCount%5D=&OrderHead%5Bprice%5D=&OrderHead%5Bstatus%5D=new&OrderHead_page=1&ajax=order-head-grid"><img src="/img/icons/flags/16/RU.png" alt="" />Русский</a></li>
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
        <div class="span-19">
            <div id="content">
                <div id="order-head-grid" class="grid-view">
                    <div class="summary">Элементы 1—2 из 2.</div>
                    <table class="items table">
                        <thead>
                        <tr>
                            <th id="order-head-grid_c0"><a class="sort-link" href="/url/order%2ForderHead%2Fadmin/OrderHead%5Bid%5D//OrderHead%5Bname%5D//OrderHead%5Bemail%5D//OrderHead%5Bphone%5D//OrderHead%5Baddress%5D//OrderHead%5Bcity%5D//OrderHead%5BphotoCount%5D//OrderHead%5Bprice%5D//OrderHead%5Bstatus%5D/new/OrderHead_page/1/ajax/order-head-grid/OrderHead_sort/id">ID<span class="caret"></span></a></th><th id="order-head-grid_c1"><a class="sort-link" href="/url/order%2ForderHead%2Fadmin/OrderHead%5Bid%5D//OrderHead%5Bname%5D//OrderHead%5Bemail%5D//OrderHead%5Bphone%5D//OrderHead%5Baddress%5D//OrderHead%5Bcity%5D//OrderHead%5BphotoCount%5D//OrderHead%5Bprice%5D//OrderHead%5Bstatus%5D/new/OrderHead_page/1/ajax/order-head-grid/OrderHead_sort/name">Name<span class="caret"></span></a></th><th id="order-head-grid_c2"><a class="sort-link" href="/url/order%2ForderHead%2Fadmin/OrderHead%5Bid%5D//OrderHead%5Bname%5D//OrderHead%5Bemail%5D//OrderHead%5Bphone%5D//OrderHead%5Baddress%5D//OrderHead%5Bcity%5D//OrderHead%5BphotoCount%5D//OrderHead%5Bprice%5D//OrderHead%5Bstatus%5D/new/OrderHead_page/1/ajax/order-head-grid/OrderHead_sort/email">Email<span class="caret"></span></a></th><th id="order-head-grid_c3"><a class="sort-link" href="/url/order%2ForderHead%2Fadmin/OrderHead%5Bid%5D//OrderHead%5Bname%5D//OrderHead%5Bemail%5D//OrderHead%5Bphone%5D//OrderHead%5Baddress%5D//OrderHead%5Bcity%5D//OrderHead%5BphotoCount%5D//OrderHead%5Bprice%5D//OrderHead%5Bstatus%5D/new/OrderHead_page/1/ajax/order-head-grid/OrderHead_sort/phone">Phone<span class="caret"></span></a></th><th id="order-head-grid_c4"><a class="sort-link" href="/url/order%2ForderHead%2Fadmin/OrderHead%5Bid%5D//OrderHead%5Bname%5D//OrderHead%5Bemail%5D//OrderHead%5Bphone%5D//OrderHead%5Baddress%5D//OrderHead%5Bcity%5D//OrderHead%5BphotoCount%5D//OrderHead%5Bprice%5D//OrderHead%5Bstatus%5D/new/OrderHead_page/1/ajax/order-head-grid/OrderHead_sort/address">Address<span class="caret"></span></a></th><th id="order-head-grid_c5"><a class="sort-link" href="/url/order%2ForderHead%2Fadmin/OrderHead%5Bid%5D//OrderHead%5Bname%5D//OrderHead%5Bemail%5D//OrderHead%5Bphone%5D//OrderHead%5Baddress%5D//OrderHead%5Bcity%5D//OrderHead%5BphotoCount%5D//OrderHead%5Bprice%5D//OrderHead%5Bstatus%5D/new/OrderHead_page/1/ajax/order-head-grid/OrderHead_sort/city">City<span class="caret"></span></a></th><th id="order-head-grid_cphotoCount"><a class="sort-link" href="/url/order%2ForderHead%2Fadmin/OrderHead%5Bid%5D//OrderHead%5Bname%5D//OrderHead%5Bemail%5D//OrderHead%5Bphone%5D//OrderHead%5Baddress%5D//OrderHead%5Bcity%5D//OrderHead%5BphotoCount%5D//OrderHead%5Bprice%5D//OrderHead%5Bstatus%5D/new/OrderHead_page/1/ajax/order-head-grid/OrderHead_sort/photoCount">Photo Count<span class="caret"></span></a></th><th id="order-head-grid_cprice"><a class="sort-link" href="/url/order%2ForderHead%2Fadmin/OrderHead%5Bid%5D//OrderHead%5Bname%5D//OrderHead%5Bemail%5D//OrderHead%5Bphone%5D//OrderHead%5Baddress%5D//OrderHead%5Bcity%5D//OrderHead%5BphotoCount%5D//OrderHead%5Bprice%5D//OrderHead%5Bstatus%5D/new/OrderHead_page/1/ajax/order-head-grid/OrderHead_sort/photoCount">Price<span class="caret"></span></a></th><th id="order-head-grid_c6"><a class="sort-link" href="/url/order%2ForderHead%2Fadmin/OrderHead%5Bid%5D//OrderHead%5Bname%5D//OrderHead%5Bemail%5D//OrderHead%5Bphone%5D//OrderHead%5Baddress%5D//OrderHead%5Bcity%5D//OrderHead%5BphotoCount%5D//OrderHead%5Bprice%5D//OrderHead%5Bstatus%5D/new/OrderHead_page/1/ajax/order-head-grid/OrderHead_sort/status">Status<span class="caret"></span></a></th><th class="button-column" id="order-head-grid_c7">&nbsp;</th></tr>
                        <tr class="filters">
                            <td><div class="filter-container"><input name="OrderHead[id]" id="OrderHead_id" type="text" value="" /></div></td><td><div class="filter-container"><input name="OrderHead[name]" id="OrderHead_name" type="text" maxlength="255" value="" /></div></td><td><div class="filter-container"><input name="OrderHead[email]" id="OrderHead_email" type="text" maxlength="255" value="" /></div></td><td><div class="filter-container"><input name="OrderHead[phone]" id="OrderHead_phone" type="text" maxlength="60" value="" /></div></td><td><div class="filter-container"><input name="OrderHead[address]" id="OrderHead_address" type="text" maxlength="255" value="" /></div></td><td><div class="filter-container"><input name="OrderHead[city]" id="OrderHead_city" type="text" maxlength="128" value="" /></div></td><td><div class="filter-container"><input name="OrderHead[photoCount]" id="OrderHead_photoCount" type="text" value="" /></div></td><td><div class="filter-container"><input name="OrderHead[price]" id="OrderHead_price" type="text" value="" /></div></td><td><div class="filter-container"><input name="OrderHead[status]" id="OrderHead_status" type="text" value="new" /></div></td><td>&nbsp;</td></tr>
                        </thead>
                        <tbody>
                        <tr class="odd"><td>1</td><td>Alex</td><td>email@tt.test</td><td>389049485465</td><td>Manyilskogo</td><td>Zhytomyr</td><td>1</td><td>1 грн</td><td>new</td><td class="button-column"><a class="update" title="Редактировать" href="/backend/order/orderHead/update/id/1"><img src="/assets/ada258f/gridview/update.png" alt="Редактировать" /></a><a class="delete" title="Удалить" href="/backend/order/orderHead/delete/id/1"><img src="/assets/ada258f/gridview/delete.png" alt="Удалить" /></a></td></tr>
                        <tr class="even"><td>2</td><td>Alex2</td><td>email@tt.test</td><td>389049485465</td><td>Manyilskogo</td><td>Zhytomyr</td><td>1</td><td>2 грн</td><td>new</td><td class="button-column"><a class="update" title="Редактировать" href="/backend/order/orderHead/update/id/2"><img src="/assets/ada258f/gridview/update.png" alt="Редактировать" /></a><a class="delete" title="Удалить" href="/backend/order/orderHead/delete/id/2"><img src="/assets/ada258f/gridview/delete.png" alt="Удалить" /></a></td></tr>
                        </tbody>
                    </table>

                    <div  class="extended-summary"></div><div class="keys" style="display:none" title="/backend/order/orderHead/admin?OrderHead%5Bid%5D=&amp;OrderHead%5Bname%5D=&amp;OrderHead%5Bemail%5D=&amp;OrderHead%5Bphone%5D=&amp;OrderHead%5Baddress%5D=&amp;OrderHead%5Bcity%5D=&amp;OrderHead%5BphotoCount%5D=&amp;OrderHead%5Bprice%5D=&amp;OrderHead%5Bstatus%5D=new&amp;OrderHead_page=1&amp;ajax=order-head-grid"><span>1</span><span>2</span></div>
                </div>	</div><!-- content -->
        </div>
        <div class="span-5 last">
            <div id="sidebar">
            </div><!-- sidebar -->
        </div>
        <div class="row-fluid">
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
<script type="text/javascript">
    /*<![CDATA[*/
    jQuery(function($) {
        jQuery('a[rel="tooltip"]').tooltip();
        jQuery('a[rel="popover"]').popover();
        jQuery(document).on('click','#order-head-grid a.delete',function() {
            if(!confirm('Вы уверены, что хотите удалить данный элемент?')) return false;
            var th = this,
                afterDelete = function(){};
            jQuery('#order-head-grid').yiiGridView('update', {
                type: 'POST',
                url: jQuery(this).attr('href'),
                success: function(data) {
                    jQuery('#order-head-grid').yiiGridView('update');
                    afterDelete(th, true, data);
                },
                error: function(XHR) {
                    return afterDelete(th, false, XHR);
                }
            });
            return false;
        });
        jQuery('#order-head-grid').yiiGridView({'ajaxUpdate':['order-head-grid'],'ajaxVar':'ajax','pagerClass':'pagination','loadingClass':'grid-view-loading','filterClass':'filters','tableClass':'items table','selectableRows':1,'enableHistory':false,'updateSelector':'{page}, {sort}','filterSelector':'{filter}','pageVar':'OrderHead_page','afterAjaxUpdate':function() {
            jQuery('.popover').remove();
            jQuery('a[rel="popover"]').popover();
            jQuery('.tooltip').remove();
            jQuery('a[rel="tooltip"]').tooltip();
        }});

        $grid = $("#order-head-grid");

        if($(".extended-summary", $grid).length)
        {
            $(".extended-summary", $grid).html($("#order-head-grid-extended-summary", $grid).html());
        }

        $.ajaxPrefilter(function (options, originalOptions, jqXHR) {
            var qs = $.deparam.querystring(options.url);
            if(qs.hasOwnProperty("ajax") && qs.ajax == "order-head-grid")
            {
                options.realsuccess = options.success;
                options.success = function(data)
                {
                    if(options.realsuccess) {
                        options.realsuccess(data);
                        var $data = $("<div>" + data + "</div>");
                        // we need to get the grid again... as it has been updated
                        if($(".extended-summary", $("#order-head-grid")))
                        {
                            $(".extended-summary", $("#order-head-grid")).html($("#order-head-grid-extended-summary", $data).html());
                        }

                    }
                }
            }
        });
    });
    /*]]>*/
</script>
</body>
</html>