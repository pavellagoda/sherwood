$(function(){
//    $('ul.menu ul').css('opacity', 0)
//    $('ul.menu li').mouseover(function(){
//        $('ul.menu ul').animate(
//        {
//            opacity:"1"
//        }, 
//        300
//        );
//    })
//    $('ul.menu li').mouseout(function(){
//        $('ul.menu ul').animate(
//        {
//            opacity:"0"
//        }, 
//        300
//        );
//    })
    $('a.delete-button').click(function(){
        if(confirm('Вы действительно хотите удалить эту запись?')) {
            return true
        } else {
            return false;
        }
    })

    $('div.files input[type="file"]').live('change', function(){
        console.log('change')
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
        console.log(margin + diff)
        $(this).find('div').css('margin-top', margin + diff);
    })
    
});
