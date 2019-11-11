(function ($) {
    "use strict";
    $(".main-slider").owlCarousel({
        items: 1,
        loop: true,
        margin: 0,
        nav: true,
        smartSpeed: 900,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        navText: ["<i class='fa fa-arrow-left' aria-hidden='true'></i>", "<i class='fa fa-arrow-right' aria-hidden='true'></i>"]
    });
    $(function () {
        $(".video-player").YTPlayer();
    });
    /**swiper slider **/
    var swiper = new Swiper('.swiper-container', {
        effect: 'coverflow',
        loop: true,
        centeredSlides: true,
        slidesPerView: 2,
        initialSlide: 1,
        disableAutoResize: false,
        keyboardControl: true,
        mousewheelControl: true,
        lazyLoading: true,
        preventClicks: true,
        preventClicksPropagation: true,
        coverflow: {
            rotate: 0,
            stretch: 0,
            depth: 300,
            modifier: 2,
            slideShadows: true
        }
    });
    /**owlCarousel slider **/
    $('.mobile-slider').owlCarousel({
        loop: true,
        margin: 30,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 2,
                nav: false,
                loop: false
            },
            1000: {
                items: 3,
                nav: false,
                loop: false
            }
        }
    });
    $('.app-screenshots').owlCarousel({
        loop: true,
        margin: 0,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 2,
                nav: false,
                loop: false
            },
            1000: {
                items: 4,
                nav: false,
                loop: false
            }
        }
    });
    $('.blog-slider').owlCarousel({
        loop: true,
        margin: 30,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 2,
                nav: true,
                loop: false
            },
            1000: {
                items: 3,
                nav: true,
                loop: true
            }
        }
    });
    $(".owl-carousel").owlCarousel({
        items: 1,
        margin: 0,
        stagePadding: 0,
        smartSpeed: 450
    });

    /**tooltip & popovers **/
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

    /**video modal**/
    $('.video-popup').magnificPopup({
        type: 'iframe'

    });
    /**stellar**/
    $.stellar({
        horizontalScrolling: false,
        verticalOffset: 0
    });
    /**counter**/
    $('.counter').counterUp({
        delay: 50,
        time: 5000
    });
	
    $('.navbar-toggler').on('click', function () {
        $(this).toggleClass('open');
    });
	$('#navbarCollapse').on('show.bs.offcanvas', function (e) {
		$('.navbar-toggler').addClass('open');
		$('body').css('width', $(window).innerWidth()+'px');
	});
	$('#navbarCollapse').on('hide.bs.offcanvas', function (e) {
		$('.navbar-toggler').removeClass('open');
		$('body').css('overflow', 'auto'); 
		$('body').css('width', 'auto');
		$('body').css('width', '');
		
	})
   $(window).on('resize', function () {
	   $('body').css('width', '');
   });
    $('.zero-scrolltop').on('click', function () {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });

    /**auto close navbar-collapse on click a**/
    $('[data-scroll]').on('click', function () {
        $('.navbar-toggler:visible').click();
    });
    /**navbar sticky **/
    $(window).on('scroll', function () {
        var winTop = $(window).scrollTop();
        if (winTop >= 100) {
            $(".navbar-sticky").addClass("sticky-active");
        } else {
            $(".navbar-sticky").removeClass("sticky-active");
        }
        //back to top
        if ($(this).scrollTop() > 500) {
            $('.zero-scrolltop').fadeIn();
        } else {
            $('.zero-scrolltop').fadeOut();
        }

    });
    /**preloader **/
    $(window).on('load', function () {
        $('#preloader').addClass('d-none');
    });

    /**validate contact form on keyup and submit**/
    $("#contact-form").validate({
        rules: {
            contact_name: "required",
            contact_email: {
                required: true,
                email: true
            },
            contact_message: "required"
        },
        messages: {
            contact_name: "Please enter your full name",
            contact_email: "Please enter a valid email address",
            contact_message: "Please enter your message"
        },
        submitHandler: function () {
            var form = $("#contact-form");
            $.ajax({
                type: "POST",
                url: form.attr("action"),
                data: form.serialize(),
                success: function (response) {
                    //alert(response);
                    $('#contact-form')[0].reset();
                    $("#contact-result").html(response);
                }
            });
        }
    });

    /**validate mc form on keyup and submit**/
    $("#mc-form").validate({
        rules: {
            mc_email: {
                required: true,
                email: true
            },
        },
        messages: {
            mc_email: "Please enter a valid email address",
        },
        submitHandler: function () {
            var form = $("#mc-form");
            $.ajax({
                type: "POST",
                url: form.attr("action"),
                data: form.serialize(),
                success: function (response) {
                    //alert(response);
                    $('#mc-form')[0].reset();
                    $("#mc-result").html(response);
                }
            });
        }
    });

    /**animation**/
    window.wow = new WOW(
            {
                boxClass: 'wow',
                animateClass: 'animated',
                offset: 0,
                mobile: true,
                live: true
            }
    );
    window.wow.init();

    /**smooth scroll**/
    var scroll = new SmoothScroll('[data-scroll]', {
        // Selectors
        ignore: '[data-scroll-ignore]', // Selector for links to ignore (must be a valid CSS selector)
        header: '.navbar', // Selector for fixed headers (must be a valid CSS selector)
        // Speed & Easing
        speed: 500, // Integer. How fast to complete the scroll in milliseconds
        offset: 0, // Integer or Function returning an integer. How far to offset the scrolling anchor location in pixels
        easing: 'easeInOutCubic', // Easing pattern to use
        customEasing: function (time) {
        }, // Function. Custom easing pattern

        // Callback API
        before: function () {
        }, // Callback to run before scroll
        after: function () {
        } // Callback to run after scroll
    });
    /**Blog Single Post Slider**/
 $('.gallery-slider').flexslider({
        controlNav: false,
        directionNav: true,
        slideshowSpeed: 5000
    });
}(jQuery));
