$(function(){
    bindListeners();
});

function bindListeners() {
    $('.contact-form button').click(function(){
        $.post($('.contact-form').attr('action'), $('.contact-form').serialize(), function(responce){
            $('.full-form-content').html($($(responce)[0]).html());
            if($('.success-comment').length == 0)
                $('.contact-form-block').show();
            else {
                setTimeout(function(){
                    $('.success-comment').slideToggle('fast');
                }, 5000)
            }
            bindListeners();

        })
        return false;
    })
    
    $('#show-contact-form').click(function(){
        $('.contact-form-block').slideToggle('fast');
        return false;
        
    })
    
    $('.captcha img').click(function(){
        $.ajax(
        {
            type: 'POST',
            url: '/backform/refresh-captcha',
            dataType: 'json',
            success: function(r)
            {
                $('#captcha-id').val(r.captcha);
                $('.captcha img').attr('src', '/img/captcha/'+r.captcha+'.png');
            }
        });
    });
}