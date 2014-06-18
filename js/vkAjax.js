/**
 * Created by Kate on 22.04.14.
 */
$(document).ready(function(){
    $(document).on('click', '.pager', function(e){
        e.preventDefault();
        var _this = $(this);
        $.ajax({
            type : 'get',
            data: { provider: _this.data('provider') },
            url : _this.attr('href'),
            beforeSend : function() {
                $('#photoLoader').css('display', 'inline-block');
            },
            success : function(response) {
                $('#photoLoader').css('display', 'none');
                $('.'+_this.data('provider')+'-tab .viewport').html(response);
            }
        });
    });

    $(document).on('click', '.instagram-more', function(e) {
        e.preventDefault();
        var _this = $(this);
        $.ajax({
            type: 'post',
            url: '/social/default/instagramViewMore',
            data:{url: _this.attr('href')},
            success: function(response) {

                $('.instagram-tab .viewport .instagram-more').before(response);
                $('.instagram-tab .viewport .instagram-more').last().remove();
            }
        });
    });
});
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}