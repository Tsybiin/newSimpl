/*
1-  General Styles
2-  Parallax
3-  Navigation
4-  Flicker
5-  Slider
*/
jQuery(function($) {
    "use strict";
    /*=======================================
	General
	=======================================*/
    var xv_ww = $(window).width();


    /*=======================================
	Parallax
	=======================================*/
    if (xv_ww >= 768) {
        $.stellar({
            horizontalScrolling: false,
            verticalOffset: 0,
            responsive: true,
        });
    }
    /*=======================================
	Navigation
	=======================================*/
    $("body").on("click", ".nav-triger", function(e) {
        e.preventDefault();
        $(".main-menu").slideToggle();
        $(this).toggleClass('active');
        if ($(this).hasClass('active')) {
            $(this).find('span').removeClass("fa-navicon");
            $(this).find('span').addClass("fa-times");
        } else {
            $(this).find('span').removeClass("fa-times");
            $(this).find('span').addClass("fa-navicon");
        }
    });

    $("body").on("click", ".nav a[href^='#']", function(e) {
        e.preventDefault();
        var $this = $(this);
        $("body,html").animate({
            scrollTop: $($this.attr("href")).offset().top
        }, 500);
    });

    $("body").on("click", ".main-menu > li.parent", function(e) {
        if ($(window).width() < 1024) {
            e.preventDefault();
            e.stopImmediatePropagation();
            $(this).children("ul").slideToggle();
        }
    });

    //$(window).on("scroll", function(e) {
    //    if ($(window).scrollTop() > 50) {
    //        // > 100px from top - show div
    //        $(".navbar-custom").addClass("navbar_style");
    //    } else {
    //        // <= 100px from top - hide div
    //        $(".navbar-custom").removeClass("navbar_style");
    //    }
    //});




    /*=======================================
	Flicker
	=======================================*/
    if ($('#flicker-feed').length !== 0) {
        $('#flicker-feed').jflickrfeed({
            limit: $('#flicker-feed').data('limit'),
            qstrings: {
                id: $('#flicker-feed').attr('data-userID')
            },
            itemTemplate: '<li><a href="{{image_b}}" data-rel="prettyPhoto"><img alt="{{title}}" src="{{image_s}}" /></a></li>'
        }, function() {
            $("a[data-rel^='prettyPhoto']").prettyPhoto();
        });
    }

    /*=======================================
	Slider
	=======================================*/
    var owl = $(".owl-carousel");
    owl.each(function() {
        var $this = $(this),
            viewDots = $this.data("dots"),
            isLoop = $this.data("loop"),
            isNav = $this.data("nav"),
            viewSlides = +$this.data("slides"),
            viewSlides_md = +$this.data("slides-md"),
            viewSlides_sm = +$this.data("slides-sm"),
            slideMargin = +$this.data("margin"),
            slidesCenter = $this.data("center"),
            slidesHash = $this.data("hash"),
            nextIcon = $this.data("next"),
            prevIcon = $this.data("prev"),
            slideDrag = $this.data("drag"),
            slideFade = $this.data("fade"),
            slideAuto = $this.data("auto");

        $this.owlCarousel({
            loop: isLoop,
            margin: slideMargin,
            nav: isNav,
            dots: viewDots,
            center: slidesCenter,
            URLhashListener: slidesHash,
            mouseDrag: slideDrag,
            animateOut: slideFade,
            autoplay: slideAuto,
            autoHeight: true,
            navText: ["<i class='btn_prev fa " + prevIcon + "'></i>", "<i class='btn_next fa " + nextIcon + "'></i>"],
            responsive: {
                0: {
                    items: viewSlides_sm
                },
                600: {
                    items: viewSlides_md
                },
                1000: {
                    items: viewSlides
                }
            }
        }); /*owl end*/
    }); /*each*/

    $('.submit').click(function(e) {
        e.preventDefault();
     //   return false;
        var first_name = $('#first_name').val();
        var email = $('#email').val();
        var action = $('#action').val();

        //console.log(action);
       // console.log('jjjj');
        $(".error").remove();

        if (first_name.length < 1) {
            $('#first_name').before('<span class="error">Введите Имя</span>');
            return false;
        }

        if (email.length < 1) {
            $('#email').before('<span class="error">Введите email</span>');
            return false;
        } else {
            var regEx = /([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9_-]+)/;
            var validEmail = regEx.test(email);
            if (!validEmail) {
                $('#email').before('<span class="error">Введите корректный email</span>');
                return false;
            }
        }

  //  let    ajaxProcess = false;
        $.ajax({
            data: {
                action: action,
                first_name: first_name,
                email: email
                // sessid: $('.js-auth-form-sms [name=sessid]').val()
            },
            dataType: 'json',
            type: 'post',
            url: '/register',
            //beforeSend: function () {
            //    $codeInput.blur();
            //    $('.authorization-popup__preload').show();
            //    $('.authorization-popup__overlay').show();
            //    ajaxProcess = true;
            //},
            //complete: function () {
            //    $('.authorization-popup__preload').hide();
            //    $('.authorization-popup__overlay').hide();
            //    ajaxProcess = false;
            //},
            success: function (data) {
                ajaxProcess = true;
                console.log(data);
            //    if (data.success) {
            //        window.dataLayer = window.dataLayer || [];
            //        window.dataLayer.push({
            //            event: 'user.auth',
            //            eventCategory: data.new ? 'registration' : 'login',
            //            eventLabel: isBasketPage() ? 'checkout' : 'header',
            //            user_id: data.profile.id
            //        });
            //
            //        if (data.new && !isBasketPage()) {
            //            $('.authorization-popup__step').hide();
            //            $('.sms-profile-block').show();
            //            $('.authorization-popup-cross, .auth-popup-close').on('click', function() {
            //                location.reload();
            //            });
            //        } else {
            //            if(isBasketPage()) {
            //                location.replace('/order/delivery/');
            //            } else {
            //                location.reload();
            //            }
            //        }
            //    } else if (data.error) {
            //        $codeInput.addClass('error');
            //        $('.js-auth-code-error').html(data.error).show();
            //        setTimeout(function(){
            //            $('.js-cn1').focus();
            //        }, 2000);
            //    }
            }
        });

    });

}); /*end ready*/ /*end require*/