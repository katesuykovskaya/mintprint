
$(document).ready(function() {

        //alert(location.pathname);
        
        var path = location.pathname;
        
        var myLink = $('.sublevel-li a');
        
        $(myLink).each(function(){
                var myHref= $(this).attr('href');
                if( path.match( myHref)) {
                     $(this).closest('ul').removeClass('sublevel-ul');
                     $(this).closest('ul').closest('ul').css("display","block");

                }
          }); 

        // Указываем переменные
   
        var accordion_head = $('.accordion > li > a'),
        accordion_body = $('.accordion li > .sub-menu'),

        level_li = $('.sublevel-li a');
        level_ul = $('.sublevel-ul');
    
        level_li.click(function(e) { 
                       
            var next=$(this).next();
            if(next.is('ul')){
                e.preventDefault();
                if (next.attr('class')!='sublevel-ul')
                {
                    //next.slideUp('fast', function(){
                        next.addClass('sublevel-ul');
                    //});
              
                    return false;
                }
                else
                {
                 //   next.slideDown('fast', function(){
                        next.removeClass('sublevel-ul');
                 //   });
                    return false;
                }             
            }             
            
        });
        

    
        //  Автоматически открывает первый раздел
        // Чтобы не открывался можно удалить

        //accordion_head.first().addClass('active').next().slideDown('normal');
   
        //полностью открытое меню
        //accordion_head.next().slideDown('normal');

        // Функция клика

        accordion_head.on('click', function(event) {

            // Скрывает открытый раздел по повторному клику
            
            //            if()
            event.preventDefault();
            if ($(this).attr('class') == 'active'){
                accordion_body.slideUp('normal')
                $(this).removeClass('active');
                return false;

            }

            // Открывает следующий, скрывая открытый

            if ($(this).attr('class') != 'active'){
                accordion_body.slideUp('normal');
                $(this).next().stop(true,true).slideToggle('normal');
                accordion_head.removeClass('active');
                $(this).addClass('active');
            }

        });


    });


                    
