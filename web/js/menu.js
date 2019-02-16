var $menu = $('#menu');
var $displayerMenu = $("#container-icon-menu");
var $hiderMenu = $('#close-menu');
var widthMenu = $menu.width()+100;

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

resizeAndReplaceBackContent();
$('#background-content').css('height', $('#content').height()+50);

