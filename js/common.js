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
});
//TypeKit
(function(d) {
    var config = {
        kitId: 'usm0rds',
        scriptTimeout: 3000,
        async: true
    },
    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
})(document);