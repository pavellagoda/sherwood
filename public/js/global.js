$(function(){
    $('a.delete-button').click(function(){
        if(confirm('Вы действительно хотите удалить эту запись?')) {
            return true
        } else {
            return false;
        }
    })

//    $('div.files input[type="file"]').live('change', function(){
//        
//        var addfile = true;
//        var filelist = $('div.files input[type="file"]');
//        for(var i = 0; i<filelist.length; i++ ) {
//            if($(filelist[i]).val()=='') {
//                addfile = false
//            }
//        }
//        if(addfile)
//            $('div.files').append('<input type="file" name="photo[]"/>');
//    })
});