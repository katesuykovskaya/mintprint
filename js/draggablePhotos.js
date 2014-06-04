$(document).ready(function(){
    //add all photo
    $('.addAllPhoto').click(function(){
        $(".all-photos-thumbs > div:not(div.full):gt(2)").remove();

        $('.tab:visible img').each(function(index){
            var img = $(this).clone();
            var newImg = createPhoto(img);
            $('.all-photos-thumbs').prepend(newImg);
        });

    });

    //add one photo
    $(".my-viewport").on('click', '.image-wrap',  function(e){
        e.preventDefault();
        var img = $(this).find('img').clone();
        var newImg = createPhoto(img);

        $('.all-photos-thumbs').prepend(newImg);

        if($(".all-photos-thumbs > div:not(div.full)").length > 3)
        {
            $(".all-photos-thumbs > .photo-wrap:last").remove();
        }
    });


    //delete photo
    $(".all-photos-thumbs").on('click', 'a.remove',  function(e){
        e.preventDefault();
        $(this).parent().remove();
    });

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
        newImg.innerHTML = '<a href="#" class="remove"></a><div class="photo"></div>';
        $(newImg).find('.photo').append(changeImg);

        return newImg;
    }

    function getImgSize(imgSrc){
        return '{"width":'+imgSrc[0].width+',"height":'+imgSrc[0].height+'}';
    }

});