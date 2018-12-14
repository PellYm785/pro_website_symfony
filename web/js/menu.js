var $menu = $('#menu');
var $displayerMenu = $("#container-icon-menu");
var $hiderMenu = $('#close-menu');
var widthMenu = $menu.width()+100;
var $listLiMenu = $('#menu').children('ul').children('li');

$menu.css("right", - widthMenu);
$hiderMenu.css("right", -(widthMenu+15));

$displayerMenu.click(function(){
    $menu.animate({
        right: "0px"
    });

    $hiderMenu.animate({
        right: "15px"
    });
});

$hiderMenu.click(function(){
    $menu.animate({
        right: -widthMenu+"px"
    });

    $hiderMenu.animate({
        right: -(widthMenu+15)+"px"
    });
});

$(window).resize(function(){
    if($(window).width() > 1024){
        switcher.disable();
    }else{
        menu_hide = true;
        switcher.build();
        switcher.enable();
        switcher.replace();
    }
});


$listLiMenu.each(function(index, element){
    $(element).click(function(){
        if(!$(element).hasClass('selected')){
            $('li').removeClass("selected");
            $(element).addClass('selected');
            $('section').removeClass("show");
            $('section').addClass("hide");
            $('#'+$(element).data('link')).removeClass("hide");
            $('#'+$(element).data('link')).addClass("show");
            resizeAndReplaceBackContent();
            $('#background-content').css('height', $('#content').height()+50);
            if($(element)[0].id == 'CV_in' && $(window).width() < 1024){
                switcher.build();
            }else{
                switcher.destroy();
            }
        }
    });
});


