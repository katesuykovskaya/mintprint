(function($){
    var originalPos = null;

    var fixHelperDimensions = function(e, tr) {
        originalPos = tr.prevAll().length;
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index)
        {
            $(this).width($originals.eq(index).width()+1).height($originals.eq(index).height())
            .css({
                "border-bottom":"1px solid #ddd"
            });
        });
        return $helper.css("border-right","1px solid #ddd");
    };

    /**
     * Returns the key values of the currently checked rows.
     * @param id string the ID of the grid view container
     * @param action string the action URL for save sortable rows
     * @param column_id string the ID of the column
     * @return array the key values of the currently checked rows.
     */
    $.fn.yiiGridView.sortable = function (id, action, callback)
    {
        var grid = $('#'+id) ;
        $("tbody", grid).sortable({
            helper: fixHelperDimensions,
            update: function(e,ui){
                // update keys
                var pos = $(ui.item).prevAll().length;
                if(originalPos !== null && originalPos != pos)
                {
                    var keys = grid.children(".keys").children("span");
                    var key = keys.eq(originalPos);
                    var sort = [];//sort number values from to
                    keys.each(function(i) {
                        sort[i] = $(this).attr('data-order');
                    });

                    if(originalPos < pos)
                    {
                        keys.eq(pos).after(key);
                    }
                    if(originalPos > pos)
                    {
                        keys.eq(pos).before(key);
                    }
                    originalPos = null;
                }
                var sortOrder = {};
                var selected = $('#PagesTranslate_level option:selected').val();
                var currentPage = $('.yiiPager > .active').text();
                var filters = '';
                var filterContainer = $('.filter-container > input');
                filterContainer.each(function(i){
                    filters+=$(this).attr('value')
                });
                if(filters.length>0) return false;
                keys = grid.children(".keys").children("span");
                keys.each(function(i) {
                    $(this).attr('data-order', sort[i]);
                    sortOrder[$(this).text()] = sort[i];
                });
                
                
                if(action.length)
                {
                    //список айдишек ...по-порядку отображения в таблице, рожной алгоритм использовать больно
                    //смежные элементы норм сортирует, а несмежные - через хитрый алгоритм
                    var newOrder = {};
                    var myKeys = grid.children(".keys").children("span");
                        myKeys.each(function(i) {
                        newOrder[i] = $(this).text();
                    });
                    
                    $.fn.yiiGridView.update(id,
                    {
                        type:'POST',
                        url:action,
                        data:{
                            sortOrder: sortOrder,
                            selected: selected,
                            newOrder: newOrder,
                            currentPage: currentPage,
                            filters: filters
                        },
                        //                        success:function(){
                        //                        grid.removeClass('grid-view-loading');
                        //                        }

                        success:function(response)
                        {
                            grid.removeClass('grid-view-loading');
                            try{
                                var response = $.parseJSON(response);
                                if(response.success && response.success=='ok')
                                    $('#content-header h1').html(response.html);
                            } catch (e) {
                                alert("Возникла ошибка. Попробуйте ещё раз или обратитесь к администрации." + e.message);
                            }
                        }

                    });
                    
                    
                    
                }
                if($.isFunction(callback))
                {
                    callback(sortOrder);
                }
            }
        }).disableSelection();
    };
})(jQuery);