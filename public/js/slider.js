jQuery(document).ready(function() {  
    var currentIndex = 0;
    $("a[rel=photo]").fancybox({
        'transitionIn'		: 'none',
        'transitionOut'		: 'none',
        'titlePosition' 	: 'over',
        'autoScale'			: true,
        'opacity'			: false,
        'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
            return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
        },
        'onComplete'           : function(title, currentEl) {
            currentIndex = currentEl
            $("#fancybox-title").css({
//                'top':'0px', 
//                'bottom':'auto'
            }); 
            $('.navigate-buttons').show();
            $('div.navigate-buttons').find('span.active').removeClass('active');
            $('div.navigate-buttons').find('span[alt='+currentEl+']').addClass('active');
            if(count_item<2) {
                $('.navigate-buttons').hide();
                $('#fancybox-content').height('425');
            }
            if($(this.orig.context).attr('contenttype')=='image') {
                $('#fancybox-content').find('object').remove();
                $('#fancybox-content').find('div').append('<img src="'+this.href+'"></img>');
            }
        },
        'onStart'               :function() {
            $('.navigate-buttons').hide();
        }
    });
    
    
    
    var show_at_page = 5;
    var count_item = $('#slider-inner').find('li').length
    var carousel_step = $('#slider-inner').find('li:first').width();
    $('ul#slider-inner').width(carousel_step*count_item);
    var current_item = show_at_page;
    if(count_item<=show_at_page) {
        $('.jcarousel-next').hide()
        $('.jcarousel-prev').hide()
        $('ul#slider-inner').css('margin-top', '0');
        $('ul#slider-inner').css('margin-bottom', '0');
        $('ul#slider-inner').css('margin-left', 'auto');
        $('ul#slider-inner').css('margin-right', 'auto');
    }
    
    function addNavigation() {
        var html = '<div class="navigate-buttons">';
        for(var i=0; i<count_item; i++) {
            html += '<span alt="'+i+'">'+(i+1)+'</span>';
        }
        html+='</div>'
        $('#fancybox-outer').append(html)
            
    }
    addNavigation();
    
    $('div.navigate-buttons').find('span').click(function(){
        var index = $(this).attr('alt');
        if(currentIndex==index) {
            return false;
        }
        currentIndex = index;
        $.fancybox.pos(parseInt(index));
        
    });
    
    $('.jcarousel-next').click(function(){
        if(current_item<count_item) {
            $('ul#slider-inner').animate({
                left:'-='+carousel_step
            }
            )
            current_item++;
        }
        
        checkArrows()
    })
    
    $('.jcarousel-prev').click(function(){

        if(current_item>show_at_page) {
            $('ul#slider-inner').animate({
                left:'+='+carousel_step
            }
            )
            current_item--;
        }
        
        checkArrows()
    })
    
    function checkArrows() {
        if(current_item>show_at_page) {
            $('.jcarousel-prev').removeAttr('disabled')
            $('.jcarousel-prev').removeClass('jcarousel-prev-disabled')
            $('.jcarousel-prev').removeClass('jcarousel-prev-disabled-horizontal')
        }
        
        if(current_item<count_item) {
            $('.jcarousel-next').removeAttr('disabled')
            $('.jcarousel-next').removeClass('jcarousel-prev-disabled')
            $('.jcarousel-next').removeClass('jcarousel-prev-disabled-horizontal')
        }
            
        if(current_item==count_item) {
            $('.jcarousel-next').attr('disabled', 'disabled')
            $('.jcarousel-next').addClass('jcarousel-prev-disabled')
            $('.jcarousel-next').addClass('jcarousel-prev-disabled-horizontal')
        }
        
        if(current_item==show_at_page) {
            $('.jcarousel-prev').attr('disabled', 'disabled')
            $('.jcarousel-prev').addClass('jcarousel-prev-disabled')
            $('.jcarousel-prev').addClass('jcarousel-prev-disabled-horizontal')
        }
    }
   
});


