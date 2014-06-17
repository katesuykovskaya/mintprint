/**
 * Created by Kate on 13.02.14.
 */
$(document).ready(function(){
    $('#delete').on('click', function(e){
        if(!confirm('Delete?')) {
            e.preventDefault();
        }
    });

    $('#cancel').on('click', function(e){
        e.preventDefault();
        history.back();
    });

//    var form = $('#<?=$form?>');
    var submits = $('input[type="submit"]'), url, name;
    var form = submits.closest('form');
    submits.each(function(){
        url = $(this).attr('data-url');
        name = $(this).attr('name');
        if(typeof url !== 'undefined') {
            $('<input>', {
                type: 'hidden',
                value: url,
                name: name+'_url'
            }).appendTo(form);
        }
    });
});