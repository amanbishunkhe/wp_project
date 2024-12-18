(function ($) {

    var COMMON = {
        init: function () {
            this.cacheDOM();

            $(window).on('resize', this.reCalcOnResize.bind(this))
        },
        cacheDOM: function () {
            this.$body = $('body');
            this.windowWidth = $(window).width();
        },
        reCalcOnResize: function () {
            this.windowWidth = $(window).width();
        }
    };

    var mainNavigation = {
        init: function () {
            this.$body = $('body');
            this.$mainNavContainer = $('#site-navigation');
            this.$mainNavContainerMobile = $('#site-navigation-mob');
            this.$siteBranding = $('.site-branding ');
            this.$menuToggler = this.$siteBranding.find('.menu-toggle');
            this.$mainMenu = this.$mainNavContainer.find('#primary-menu');
            console.log(this.$menuToggler);
            this.$menuToggler.on('click', this.toggleMenu.bind(this));
        },
        toggleMenu: function (e) {
            e.preventDefault();
            this.$mainNavContainer.toggleClass('shown');
            this.$mainNavContainerMobile.toggleClass('shown');
            this.$menuToggler.toggleClass('active');
            this.$body.toggleClass('menu-open');
        }
    };

    $(function () {
        COMMON.init();
        mainNavigation.init();
    });

    // function for closing menu when click outside assigned selector
    jQuery.fn.clickOutside = function (callback) {
        var $me = this;
        $(document).mouseup(function (e) {
            if (!$me.is(e.target) && $me.has(e.target).length === 0) {
                callback.apply($me);
            }
        });
    };

    // $(window).on('load resize orientationchange', function () {
    $('.g-tooltip').each(function () {
        if ($(window).width() <= 1200) {
            $(this).on('click tap touchStart', function () {
                $(this).toggleClass('active');
            });
        }
    });

    $('.g-tooltip, .g-tooltip span').clickOutside(function () {
        $('.g-tooltip').removeClass('active');
    });

    // closes nav menu when clicked outside the main-navigation area
    $(window).on('load resize', function () {
        if ($(window).width() > 767) {
            $(".main-navigation, .menu-toggle").clickOutside(function () {
                $("body").removeClass("menu-open");
                $(".main-navigation").removeClass("shown");
                $(".menu-toggle").removeClass("active");
            });
        }
    });

    $('.topnav-close').on('click', function () {
        $('.top-nav').fadeOut(400);
    });

    // Setup variables
    // initialize skrollr if the window width is large enough

    var skinit;
    // parallex
    $(window).on('load', function () {
        if ($(window).width() >= 1200) {
            skinit = skrollr.init({
                mobileDeceleration: 0.01,
                forceHeight: false,
                mobileCheck: function () {
                    return false;
                }
            });
        }
    });
    $(window).on('resize', function () {
        if ($(window).width() >= 1200) {
            if (skinit == undefined) {
                skinit = skrollr.init({
                    mobileDeceleration: 0.01,
                    forceHeight: false,
                    mobileCheck: function () {
                        return false;
                    }
                });
            }
        } else {
            if (skinit != undefined) {
                skinit = skrollr.init().destroy();
            }
        }
    });

    /* =========================================
    // sticky header after header offset
    ========================================== */

    $(window).on('resize scroll', function () {
        var topHeaderHeight = $('#masthead').outerHeight(true);
        var mainHeaderHeight = $('.main-header').outerHeight(true);
        var headerHeight = (mainHeaderHeight + topHeaderHeight);

        if ($(window).scrollTop() >= headerHeight) {
            $('#masthead').addClass('stick-header-helper');
            setTimeout(function () {
                // $('#page').css('padding-top', topHeaderHeight + 'px');
                $('#masthead').addClass('stick-header');
                $('#masthead').removeClass('stick-header-helper');
            }, 10);
        } else {
            // $('#page').css('padding-top', '0');
            $('#masthead').removeClass('stick-header');
        }
    });


    // usp slider on mobile
    $uspSliderInit = false;
    function uspSlider() {
        if ($(window).width() < 768) {
            if (!$uspSliderInit) {
                if ($('.global-link-strip .usp-lists').length) {
                    $('.global-link-strip .usp-lists').slick({
                        infinite: false,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 2000,
                        speed: 800,
                        infinite: true,
                        arrows: false,
                        dots: false,
                    });
                    $uspSliderInit = true;
                }
            }
        }
        else {
            if ($uspSliderInit) {
                if ($('.global-link-strip .usp-lists').length) {
                    $('.global-link-strip .usp-lists').slick('unslick');
                }
                $uspSliderInit = false;
            }
        }
    }
    $(window).on('load', function () {
        uspSlider();
    });
    $(window).on('resize', function () {
        setTimeout(function () {
            uspSlider();
        }, 400)
    });

    // slick sync slider on mognific popup open 
    $('.latest-from-geo-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        // swipeToSlide: true,
        arrows: false,
        draggable: true,
        centerMode: true,
        infinite: true,
        focusOnSelect: true,
        variableWidth: true,
        accessibility: false,
        asNavFor: '#slider-nav-1',
        responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerMode: false,
                variableWidth: false,
            }
        }]
    });
    $('#slider-nav-1').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.latest-from-geo-slider',
        dots: false,
        arrows: true,
        infinite: true,
        centerMode: true,
        focusOnSelect: true
    });

    /**
     * Hero Slider Magnific Popup Gallery
     */
    if ($('.hero-slider-main').length) {
        $('.hero-slider-main').magnificPopup({
            delegate: 'a.abs-pop-icon',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
            }
        });
    }

    /*Floating label animation gform*/
    $("body").on('focus', 'input, textarea', function () {
        $(this).on('focus', function () {
            $(this).parent().parent('.gfield').addClass('active');
        });
        $(this).on('blur', function () {
            if ($(this).val().length == 0) {
                $(this).parent().parent('.gfield').removeClass('active');
            }
        });
        if ($(this).val() != '') $(this).parent('.css').addClass('active');
    });
    // twentytwenty-master before-after

    /*Floating label animation gform on document ready*/
    $('input, textarea').each(function () {
        if ($(this).val() != '') {
            $(this).parent().parent('.gfield').addClass('active');
        }
    });

    // select 2
    $(".gfield select").select2();
    $(document).on('gform_post_render', function (e, form_id) {
        $(".gfield select").select2();        

        if ($('div.validation_error').length > 0) {
            $('.gfield input, .gfield textarea').each(function () {
                if ($(this).val() != '') {
                    $(this).parent().parent('.gfield').addClass('active');
                }
            });
        }
        $('select').on('select2:select', function (e) {
            $(this).closest('li').find('.gfield_label').css('opacity', 0);
            if ($(this).find("option:selected").hasClass('gf_placeholder')) {
                $(this).closest('li').find('.gfield_label').css('opacity', 1);
                $(this).closest('li').find('.select2-selection__rendered').css('opacity', 0);
                $(this).select2('destroy');
                $(this).select2();
            } else {
                $(this).closest('li').find('.select2-selection__rendered').css('opacity', 1);

            }
        });

        //Validation fixed for upload type
        var validationHTML = $('.upload-wrapper .validation_message').html();
        var previewHTML = $('.upload-wrapper .ginput_preview').parent().html();
        var previewWrapId = $('.upload-wrapper .ginput_preview').parent().attr('id');
        $('.upload-wrapper .ginput_container .validation_message').remove();
        $('.upload-wrapper .ginput_container .ginput_preview').parent().remove();
        $('<div class="validation_message">' + validationHTML + '</div>').insertAfter('.upload-wrapper .gfield_label');
        if (previewHTML) {
            $('<div id="' + previewWrapId + '">' + previewHTML + '</div>').insertAfter('.upload-wrapper .gfield_label');
        }
    });
    

})(jQuery);