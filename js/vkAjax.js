/**
 * Created by Kate on 22.04.14.
 */
$(document).ready(function(){
    $(document).on('click', '.pager', function(e){
        e.preventDefault();
        var _this = $(this);
        $.ajax({
            type : 'get',
            url : _this.attr('href'),
            beforeSend : function() {
            },
            success : function(response) {
                $('#photos'+_this.data('provider')).html(response);
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