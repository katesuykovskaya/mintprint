$(document).ready(function(){
    //draggable photo
    $('.image-wrap').draggable({
        cursor: "move",
        scroll: false,
        helper: "clone",
        containment: ".content"
     }
    );
    $('.all-photos-thumbs').droppable({
        activeClass: "ui-state-hover",
        hoverClass: "ui-state-active",
        drop: function( event, ui ) {
            var img = ui.draggable.find('img').clone();

            dragAndClickPhoto(img);


            return false;
        }
    });
    //end draggable photo

    $('.removeAllPhoto').click(function(e){
        if(confirm(' Вы уверены?')) {
            location.href = '/order/orderTemp/clear';
        }
    });

    $('.go-print').on('click', function(e){
        if($(this).hasClass('disabled')) e.preventDefault();
    });

    //add all photo
    $('.addAllPhoto').click(function(){
        $(".all-photos-thumbs > div:not(div.full):gt(2)").remove();
        var photos = $('.tab:visible .not-album img');
        console.log(photos.length);
        if(photos.length == 0) {
            console.log('hhhh');
            alert("Фото отсутствуют. Обратите внимание, что Добавить все фото можно только из альбома");
        }
        else {
            photos.each(function(index){
            var img = $(this).clone();
            SendAjax(img);
            var newImg = createPhoto(img);
            $('.all-photos-thumbs').prepend(newImg);
        });}
    });

    //add one photo
    $(".my-viewport").on('click', '.image-wrap',  function(e){
        e.preventDefault();
        var img = $(this).find('img').clone();
        dragAndClickPhoto(img);
    });


    //delete photo
    $(".all-photos-thumbs").on('click', 'a.remove',  function(e){
        e.preventDefault();
        $(this).parent().remove();

        $.ajax({
            url: '/order/orderTemp/delete',
            type: 'post',
            data: {
                'OrderTemp[id]': $(this).data('id')
            },
            success: function(response) {
//                console.log(response);
                try {
                    var result = $.parseJSON(response);
                    var price = result.sum;
                    $('#price').text(price);
                } catch(e) {

                }
            }
        });

    });

});

function dragAndClickPhoto(img){

    SendAjax(img);
    var newImg = createPhoto(img);
    $('.all-photos-thumbs').prepend(newImg);

    if($(".all-photos-thumbs > div:not(div.full)").length > 3)
    {
        $(".all-photos-thumbs > .photo-wrap:last").remove();
    }
}
//load photos local
function ajaxLoadPhoto(originPath, iconPath, id, sum)
{
    var img = document.createElement("img");
    img.setAttribute("src", iconPath);
    img.onload = function() {
        var newImg = createPhoto($(img));
        $(newImg).find('.remove').attr('data-id', id);
        $(newImg).find('.photo')[0].setAttribute('href', '/order/orderTemp/update?id='+id);
        $('.all-photos-thumbs').prepend(newImg);
    };

    $('#price').text(sum);

    if($(".all-photos-thumbs > div:not(div.full)").length > 3)
    {
        $(".all-photos-thumbs > .photo-wrap:last").remove();
    }
}

function createPhoto(img)
{
    var size = JSON.parse(getImgSize(img));
    if(size.width == size.height)
    {
        var param = {'width': 97, 'height':97, 'handler': 'same'};
    }
    else if(size.width > size.height)
    {
        var marginLeft = Math.round((size.width - 97) / 2);
        var param = {'height': 97, 'marginLeft': marginLeft, 'handler': 'width'};
    }
    else if(size.width < size.height)
    {
        var marginTop = Math.round((size.height - 97) / 2);
        var param = {'width': 97, 'marginTop': marginTop, 'handler': 'height'};
    }
    var changeImg = img[0];
    switch (param.handler) {
        case 'same':
            $(changeImg).attr({'width': '97', 'height': '97'});
            break
        case 'width':
            $(changeImg).attr({'height': '97'});
            $(changeImg).css("margin-left","-"+param.marginLeft+"px");
            break
        case 'height':
            $(changeImg).attr({'width': '97'});
            $(changeImg).css("margin-top","-"+param.marginTop+"px");
            break
    }


    var newImg =  document.createElement('div');
    newImg.setAttribute('class', 'photo-wrap full');
    newImg.innerHTML = '<a href="#" class="remove"></a><a class="photo"></a>';
    $(newImg).find('.photo').append(changeImg);

    return newImg;
}

function getImgSize(imgSrc){
    return '{"width":'+imgSrc[0].width+',"height":'+imgSrc[0].height+'}';
}

function SendAjax(img) {
    $('.go-print').addClass('disabled');
    $.ajax({
        url: '/order/orderTemp/create',
        type: 'post',
        data: {
            'OrderTemp[img_url]': img.data('original'),
            'OrderTemp[thumb_url]': img.attr('src'),
            'OrderTemp[thumb_width]': img[0].naturalWidth,
            'OrderTemp[thumb_height]': img[0].naturalHeight
        },
        success: function(response) {
            $('.scroll-box').jScrollPane();
            try {
                var result = $.parseJSON(response);
                $('.go-print').removeClass('disabled');
                if(!result.res) {
                    if(typeof result.reason != 'undefined')
                        alert(result.reason);
                    else
                        alert('Не прошло сохранение');
                }
                else{
                    $(img).parent().siblings('.remove').attr('data-id', result.id);
                    $(img).parent().attr('href', '/order/orderTemp/update?id='+result.id);
                    $('#price').text(result.sum);
                }
            } catch(e) {
                alert('some error: watch site/index');
            }
        }
    });
}