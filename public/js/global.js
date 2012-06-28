$(function(){
    
    var Instance3 = new ImageFlow();
    Instance3.init({ 
        ImageFlowID:'instance_imageflow', 
        captions:false, 
        slider:false, 
        reflections:false, 
        imageFocusMax:2,
        reflectionP:0.4, 
        opacity:true, 
        startID:3, 
        startAnimation:true, 
        imageFocusM:1.5 ,
        onClick: function(){return false;}
    }); 
    
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
});
