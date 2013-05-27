$(function(){
    bindListeners();
});

function changePageContent(data) {
    $('.full-form-content').html($($(data)[0]).html());
    $('#comments-block').html($($(data)[2]).html())
}

function bindListeners() {
    $('.contact-form button').click(function(){
        $.post($('.contact-form').attr('action'), $('.contact-form').serialize(), function(responce){
            changePageContent(responce)
            if($('.success-comment').length == 0)
                $('.contact-form .contact-form-block').show();
            else {
                setTimeout(function(){
                    $('.success-comment').slideToggle('fast');
                }, 5000)
            }
            bindListeners();

        })
        return false;
    })
    $('.comment-form button').click(function() {
        $.post($('.comment-form').attr('action'), $('.comment-form').serialize(), function(responce){
            changePageContent(responce)
            if($('.success-comment').length == 0)
                $('.comment-form .contact-form-block').show();
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
        $('.contact-form .contact-form-block').slideToggle('fast');
        return false;
        
    })
    
    $('.paginator a').click(function() {
        var href = $(this).attr('href');
        $.get(href, {}, function(data){
            changePageContent(data);
            bindListeners();
            $('.comment-form').attr('action', href);
        })
        return false;
    })
    
    $('#comments-block .comment a.add-comment').click(function() {
        if($('.comment-form #parent_id').val() != $(this).attr('post_id')) {
            $('.comment-form #parent_id').val($(this).attr('post_id'))
            $(this).after($('.comment-form'))
            $('.comment-form .contact-form-block').hide();
        }
        $('.comment-form .contact-form-block').slideToggle('fast');
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