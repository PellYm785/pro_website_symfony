
var switcher = new Switch('.section-cv') ;

$('video').css('width', $(window).width());
$('header').ready(function (){
    setTimeout(resizeAndReplaceBackContent, 15);
});



$(window).resize(function() {
    $('video').css('width', $(window).width());
    setTimeout(resizeAndReplaceBackContent, 15);
});





function resizeAndReplaceBackContent(){
    var content_offset = $('#content').offset();

    $('#background-content').css('height', $('#content').height()+50);
    $('#background-content').css('width', $('#content').width());
    $('#background-content').css('top', content_offset.top);
    $('#background-content').css('left', content_offset.left);
}
