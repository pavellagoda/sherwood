$(function(){
    $('div.gallery img').first().addClass('start');
    $('div.gallery img').slidingGallery({
        container: $('div.gallery')
    });
})