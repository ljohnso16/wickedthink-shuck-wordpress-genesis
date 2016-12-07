jQuery(document).ready(function ($) {
    $("ul.menu-mobile").before('<div id="primary-menu-toggle" class="menu-toggle primary"><a class="toggle-switch show" href="#"><span>Show Menu</span></a></div>');
    $("#primary-menu-toggle .show").click(function () {
        if ($(".menu-mobile").is(":hidden")) {
            $(".menu-mobile").slideDown(500);
            $(this).attr("class", "toggle-switch hide").attr("title", "Hide Menu");
            $("#primary-menu-toggle span").replaceWith("<span>Hide Menu</span>")
        } else {
            $(".menu-mobile").hide(500);
            $(this).attr("class", "toggle-switch show").attr("title", "Show Menu");
            $("#primary-menu-toggle span").replaceWith("<span>Show Menu</span>")
        }
    });
    
    jQuery(".scroll, .gototop a").click(function (e) {
        e.preventDefault();
        jQuery("html,body").animate({
            scrollTop: jQuery(this.hash).offset().top
        }, 500)
    })

   
//hover for image block on all pages 
$('.project-item').hover(
        function(){
            $(this).find('.hover-text').slideDown(250);
        },
        function(){
            $(this).find('.hover-text').fadeOut(100);
        }
    );   


    var myVar;
    function myAnimate() {
        myVar = setInterval(slideit, 1000);
    }    
        
    function slideit() {
        if($('.soliloquy-active-slide .sol-slide-in').position().left != 0){//checks if the css is off screen
            $('.soliloquy-active-slide .sol-slide-in').animate({ left: '0' }, 500, 'swing');
        }
        if($('.soliloquy-active-slide .sol-slide-down').position().top != 0){//checks if the css is off screen
            $('.soliloquy-active-slide .sol-slide-down').animate({ top: '0' }, 500, 'swing');
        }
        
        //the following statments are mostly giant selectors, (we want to select any NOT active slides) then we just remove any additional styling done above
        $('.sol-slide-in').not('.soliloquy-active-slide .sol-slide-in').attr('style', '');
        $('.sol-slide-down').not('.soliloquy-active-slide .sol-slide-down').attr('style', '');
    }
    myAnimate();

})
try{Typekit.load({ async: true });}catch(e){}