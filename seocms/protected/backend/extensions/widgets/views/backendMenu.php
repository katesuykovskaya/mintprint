<?php
$level=0;

    foreach($menu as $n=>$category){

        if($category['level']==$level)
            echo CHtml::closeTag('li')."\n";

        else if($category['level'] > $level)
            echo CHtml::openTag('ul')."\n";

        else{
            echo CHtml::closeTag('li')."\n";

            for($i=$level-$category['level'];$i;$i--){
                echo CHtml::closeTag('ul')."\n";
                echo CHtml::closeTag('li')."\n";
            }
        }

        echo CHtml::openTag('li');
        echo CHtml::link(Yii::t('backend',$category['text']),Yii::app()->urlManager->createUrl($category['url'],array('language'=>Yii::app()->language)),array('id'=>$category['id']));
        $level=$category['level'];
    }

    for($i=$level;$i;$i--){
        echo CHtml::closeTag('li')."\n";
        echo CHtml::closeTag('ul')."\n";
    }
?>
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
