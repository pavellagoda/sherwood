$(function(){
    var interval = null;
    $('a.delete-button').click(function(){
        if(confirm('Вы действительно хотите удалить эту запись?')) {
            return true
        } else {
            return false;
        }
    })
    
    $('a.new-window').click(function(){
        window.open(this.href); 
        return false;
    })
    
    $('input[type="checkbox"].moderate-comment').change(function() {
        var comment_id = $(this).attr('post_id');
        var moderate_val = !!$(this).attr('checked') * 1;
        $.post('/admin/comments/moderate', {
            comment_id:comment_id,
            moderate_val:moderate_val
        })
    })

    $('div.files input[type="file"]').live('change', function(){
        var addfile = true;
        var filelist = $('div.files input[type="file"]');
        for(var i = 0; i<filelist.length; i++ ) {
            if($(filelist[i]).val()=='') {
                addfile = false
            }
        }
        if(addfile) {
            var html_to_add = $('div.files #div-for-clone').html();
            $('div.files').append('<div class="div-for-clone">'+html_to_add+'</div>');
        }
    })
    
    $('.infoblock').each(function() {
        var margin = 0 - $(this).height();
        var diff = $(this).height()/2 - $(this).find('div').height()/2 
        $(this).find('div').css('margin-top', margin + diff);
    })
    
    $('.jcarousel-next-horizontal.logo-slider-arrow').mouseover(function() {
        interval = setInterval(function(){
            moveLogos('forward')
        }, 0.1)
    })
    $('.jcarousel-next-horizontal.logo-slider-arrow').mouseout(function() {
        clearInterval(interval);
    })
    
    $('.jcarousel-prev-horizontal.logo-slider-arrow').mouseover(function() {
        interval = setInterval(function(){
            moveLogos('back')
        }, 0.1)
    })
    $('.jcarousel-prev-horizontal.logo-slider-arrow').mouseout(function() {
        clearInterval(interval);
    })
    
    $('#logo-inner').width(0);
    $('#logo-inner li img').each(function(){
        if($(this).width() > 0){
            var w = $(this).parent().parent().width() +3
            $('#logo-inner').width($('#logo-inner').width() + w);
            testArrows();
        } else {
            $(this).load(function(){
                var w = $(this).parent().parent().width() +3
                $('#logo-inner').width($('#logo-inner').width() + w);
                testArrows();
            })
        }
    });
    
});

function testArrows() {
    if($('#logo-inner').width() <= $('.logos-container').width()) {
        $('.jcarousel-prev-horizontal.logo-slider-arrow').hide();
        $('.jcarousel-next-horizontal.logo-slider-arrow').hide();
    } else {
        $('.jcarousel-prev-horizontal.logo-slider-arrow').show();
        $('.jcarousel-next-horizontal.logo-slider-arrow').show();
    }
}

function moveLogos(direction) {
    
    var pos = $('#logo-inner').position().left;
    if(direction == 'back') {
        $('#logo-inner').css('left', (pos + 1)+'px')
    } else {
        $('#logo-inner').css('left', (pos - 1)+'px')
    }
    if($('#logo-inner').position().left>0) {
        $('#logo-inner').css('left', 0)
    }
    var maxLeft = $('.logos-container').width() - $('#logo-inner').width();
    if($('#logo-inner').position().left<maxLeft) {
        $('#logo-inner').css('left', maxLeft+'px');
    }
}
