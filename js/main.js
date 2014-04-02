$(document).ready(function(){
    $("#mainCarousel").carouFredSel({
//        auto: false,
        responsive	: true,
        pagination: '#mainCarouselPagination',
        scroll		: {
            fx			: "crossfade"
        },
        items		: {
            visible		: 1,
            width		: 900,
            height		: 350
        }
    });
//    $('#scrollbarY').tinyscrollbar();
    $('.photos-container').tinyscrollbar();
    $('.videos-container').tinyscrollbar();

    $('.photos-body a').fancybox();
});
