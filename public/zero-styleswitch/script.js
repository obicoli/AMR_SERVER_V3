(function ($) {
    "use strict";
    /*Zero Style Switcher*/
    $(".zero-holder a").on("click", function (e) {
        e.preventDefault();
        var zerostyle = "assets/css/" + $(this).data("switchcolor");
         var zerogradient = $(this).data("gradient");
         if(zerogradient) {
              $('body').addClass("gradient");
         }
         else
         {
            $('body').removeClass("gradient");  
         }
        $("#zero_color").attr("href", zerostyle);
        $(this).parent().parent().find("a").removeClass("active");
        $(this).addClass("active");
    });
    jQuery('.zero-switcher .zero-icon').click(function () {
        if (jQuery('.zero-switcher').hasClass("active")) {
            jQuery('.zero-switcher').animate({"left": "-105px"}, function () {
                jQuery('.zero-switcher').toggleClass("active");
            });
        } else {
            jQuery('.zero-switcher').animate({"left": "0px"}, function () {
                jQuery('.zero-switcher').toggleClass("active");
            });
        }
    });
}(jQuery));