/**
 * Created by Kate on 28.08.14.
 */
$(document).ready(function(){
    $(document).on('click', '.logout:not(.ins-logout)', function(e){
        e.preventDefault();
        var _this = $(this);
        $.ajax({
            url: _this.attr('href'),
            success:function(response){
                try {
                    var res = $.parseJSON(response);
                    if(res.response)
                        location.href=_this.data('logoutUrl');
                    else
                        alert("Возникла ошибка");
                } catch(e){
                    console.log("error");
                }
            }
        });
    });

    $(document).on('click', '.ins-logout', function(e){
        e.preventDefault();
        var _this = $(this);
        $.ajax({
            url: _this.attr('href'),
            success:function(response){
                try {
                    var res = $.parseJSON(response);
                    if(res.response) {
                        // God forgive me for this!! - iframe in iframe
                        $('body').append('<div id="inss" style="display:none"><iframe width="0" height="0"><iframe src="'+_this.data('logout-url')+'"></iframe></iframe></div>');
                        location.href="/site/index";
                    }
                    else
                        alert("Возникла ошибка");
                }
                catch(e){
                    location.href="/site/index";
                }
            }
        });
    });
});