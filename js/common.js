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
        var countit;
        countit = 0;

        function myAnimate() {
            myVar = setInterval(slideit, 3500);
        }    
            
        function slideit() {
            countit++;
            // if(!!$('#soliloquy-66')){
               $('.soliloquy-active-slide .sol-slide-in').animate({ left: '+=63%' }, 500, 'swing');               
             //  $('.soliloquy-active-slide .sol-slide-down').animate({ right: '+=63%' }, 1500, 'swing');               
            // }

            
            //this moves the First Div to bounce around
            $(".soliloquy-active-slide .sol-slide-in").animate({ // Text out
               left: "-200px"
            }, 700, function () {
                $(this).parent().animate({ // Next  Image
                    
                }, 500, function () {
                    $(this).children(".soliloquy-active-slide .sol-slide-in").animate({ // Text in
                       // opacity: 1,
                            "left": "-20px"
                    }, 500);
                });
            });
            //this moves the 2nd Div to bounce around
            // $(".soliloquy-active-slide .sol-slide-down").animate({ // Text out
            //    left: "200px"
            // }, 700, function () {
            //     $(this).parent().animate({ // Next  Image
                    
            //     }, 500, function () {
            //         $('.soliloquy-active-slide .sol-slide-down').animate({ // Text in
            //            // opacity: 1,
            //                 "left": "0px"
            //         }, 500);
            //     });
            // });
            if(countit<0){
                clearInterval(interval);
            }
        }

        myAnimate();

});
try{Typekit.load({ async: true });}catch(e){}