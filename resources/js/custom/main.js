(function ($) {
    var supportSVG = {
        init: function () {
            $('img.custom-svg, .rm-svg').each(function () {
                var $img = jQuery(this);
                var imgID = $img.attr('id');
                var imgClass = $img.attr('class');
                var imgURL = $img.attr('src');
                var imgwidth = $img.attr('width');
                var imgheight = $img.attr('height');
                $.get(imgURL, function (data) {
                    // Get the SVG tag, ignore the rest
                    var $svg = $(data).find('svg');
                    // Add replaced image's ID to the new SVG
                    if (typeof imgID !== 'undefined') {
                        $svg = $svg.attr('id', imgID);
                    }

                    // Add replaced image's classes to the new SVG
                    if (typeof imgClass !== 'undefined') {
                        $svg = $svg.attr('class', imgClass + ' replaced-svg');
                        $svg = $svg.attr({
                            width: imgwidth,
                            height: imgheight
                        });
                    }
                    // Remove any invalid XML tags as per http://validator.w3.org
                    $svg = $svg.removeAttr('xmlns:a');
                    // Replace image with new SVG
                    $img.replaceWith($svg);
                }, 'xml');
            });
        },
    };
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
            //     console.log(this.$menuToggler);
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
        supportSVG.init();
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

    // scroll to hash value id on page load if page url has hash value
    $(window).on('load', function () {

        var hash = window.location.hash;
        if ('' != hash) {
            // if the URL has # anchor
            setTimeout(function () {
                $('html , body').animate({
                    scrollTop: $(hash).offset().top - $('#masthead .main-header').outerHeight(true)
                }, 700);
            }, 500);
        }
    });

    // $('.about-page-links li a[href^="#"]:not(a[href="#"])').click(function (e) {
    $('a[href^="#"]:not(a[href="#"])').click(function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top - $('#masthead .main-header').outerHeight(true)
        }, 700);
    });

    $('.menu-faq .sub-menu li > a').click(function (e) {
        // e.preventDefault();
        var $this = $(this);
        // store href value on rawhash 
        var rawhash = $this.attr('href');
        // take id after #
        var gotoHash = rawhash.split('#')[1];
        
        var currentPageUrl = window.location.href.split('#')[0];
        var destPageUrl = rawhash.split('#')[0];
        if(currentPageUrl == destPageUrl) {
            e.preventDefault();
        }
        
        $('html, body').animate({
            scrollTop: $('#' + gotoHash).offset().top - $('#masthead .main-header').outerHeight(true)
        }, 700);
    });

    // add class to banner if current page do not have banner section.
    if (!($('main.site-main > section:first-of-type').hasClass('hero-banner'))) {
        if (!$('body').hasClass('without-banner')) {
            $('body').addClass('without-banner');
        }
    }

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
    if ($('.total-estimate-wall').length) {
        $('.total-estimate-wall-inner').clickOutside(function () {
            $('.total-estimate-wall').removeClass('open');
        });
    }


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
    $(document).on('click', '.main-navigation ul.menu li a', function () {
        if ($('body').hasClass('menu-open')) {
            $("body").removeClass("menu-open");
            $(".main-navigation").removeClass("shown");
            $(".menu-toggle").removeClass("active");
        }
    });

    // mobile sub menu
    $('ul.sub-menu').hide();
    $('.main-navigation li.menu-item-has-children > a').after('<span class="sub-menu-toggle"></span>');
    $('span.sub-menu-toggle ').on('click', function (e) {
        if ($(window).width() < 1200) {
            if (!$(this).hasClass('active')) {
                $(this).addClass('active')
                $(this).next('ul.sub-menu').show(300);
                // $(this).next('ul.sub-menu').addClass('ccrpact');
            } else {
                $(this).removeClass('active')
                $(this).next('ul.sub-menu').hide(300);
            }
        }
    });

    $('.topnav-close').on('click', function () { // on popup close use ajax request to disable the popup
        // Set a cookie
        setCookie("readymix_destory_top_banner_popup_1", true, 1111);
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
        } else {
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
        if (getCookie("readymix_destory_top_banner_popup_1") == '' || typeof (getCookie("readymix_destory_top_banner_popup_1")) == "undefined") {
            $("body .banner-popup").show();
        }
    });
    $(window).on('resize', function () {
        setTimeout(function () {
            uspSlider();
        }, 400)
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
            $(this).parents('.gfield').addClass('active');
        }
    });

    // select 2
    $(".gfield select, #select-state select").select2();
    $(document).on('gform_post_render', function (e, form_id) {
        $(".gfield select").select2();

        if ($('div.gform_validation_error').length > 0) {
            $('.gfield input, .gfield textarea').each(function () {
                if ($(this).val() != '') {
                    $(this).parents('.gfield').addClass('active');
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

    // seo read more/less js
    $('.blockContent_seoFaqs-content--btn .btn').on('click touch', function (e) {
        $(this).text(function (i, text) {
            return text === "Read less" ? "Read more" : "Read less";
        })
        $(this).parent().prev().slideToggle();
        e.preventDefault();
        $(this).toggleClass('opened');
    });

    // mobile accordion toggle
    $('body').on("click", ".selection-option-list", function () {
        var is_open = $(this).hasClass("open");
        if (is_open) {
            $(this).removeClass("open");
        } else {
            $(this).addClass("open");
        }
    });

    /*
    ** 053224 **
    */

    // popular products slider
    var numSlick = 0;
    $(document.body).on('readymix_init_slider', function () {
        $('.popular-product-slider').each(function () {
            numSlick++;
            $(this).addClass('slider-num-' + numSlick).slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                arrows: false,
                infinite: true,
                asNavFor: '.slider-nav-2.slider-num-' + numSlick,
                responsive: [{
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 567,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        adaptiveHeight: true
                    }
                },
                ]
            });

        });
        //Similar product slider nav
        numSlick = 0;
        $('.slider-nav-2').each(function () {
            numSlick++;
            $(this).addClass('slider-num-' + numSlick).slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                dots: false,
                arrows: true,
                infinite: true,
                centerMode: true,
                focusOnSelect: true,
                asNavFor: '.popular-product-slider.slider-num-' + numSlick,
                responsive: [{
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        centerMode: false
                    }
                },]
            });
        });
    });
    $(document.body).trigger('readymix_init_slider');

    $(document).ready(function () {
        $('.single-readymix_product .hero-slider-main').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            infinite: true,
            asNavFor: '.single-readymix_product #slider-nav-hero',
        });
        $('.single-readymix_product  #slider-nav-hero').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.single-readymix_product .hero-slider-main',
            dots: false,
            arrows: true,
            infinite: true,
            centerMode: true,
            focusOnSelect: true
        });
    });

    $('.single-readymix_product .hero-slider-main').on('init', function (event, slick) {
        var that = $(this);
        $(this).addClass('animate-arrow');

        setTimeout(function () {
            that.removeClass('animate-arrow');
        }, 4000);
    });

    $(document).ready(function () {
        $('.hero-slider-main').not('.slick-initialized').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            infinite: true,
            asNavFor: '#slider-nav-hero',
        });
        $('#slider-nav-hero').not('.slick-initialized').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.hero-slider-main',
            dots: false,
            arrows: true,
            infinite: true,
            centerMode: true,
            focusOnSelect: true
        });
    });

    // service areas tab/accordion
    $('.section-service-areas .nav-tabs .nav-item').on('click', function () {
        var currentDataId = $(this).attr('data-id');
        $('.section-service-areas .nav-tabs .nav-item').removeClass('active');
        $(this).addClass('active');

        $('.section-service-areas .image-area .tab-content').removeClass('active');
        $('#' + currentDataId).addClass('active');
    });
    // mobile accordion
    $(window).on('load resize', function () {
        $('.section-service-areas .tab-content .content').on('click', function () {
            $('.section-service-areas .tab-content').removeClass('active');
            $(this).parent().addClass('active');
        });
    })

    // latest project slider
    $('.latest-projects-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        initialSlide: 1,
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
        initialSlide: 1,
        asNavFor: '.latest-projects-slider',
        dots: false,
        arrows: true,
        infinite: true,
        centerMode: true,
        focusOnSelect: true
    });

    //Add extra class to current slider and init magnific popup based on it.
    $(".latest-projects-slider").find('div.slick-current').addClass("current-slide");
    $('.latest-projects-slider').on('afterChange', function (event, slick, currentSlide, nextSlide) {
        $('div.slick-slide').removeClass("current-slide");
        $(".latest-projects-slider").find('div.slick-current').addClass("current-slide");
    });

    // toggle details 
    // $(document).on('click', '.aside-list h5', function () {
    //     $(this).next('ul').slideToggle();
    //     $(this).toggleClass('open');
    // });

    const clickElem = document.querySelector('.aside-list h5');
    if (clickElem) {
        clickElem.addEventListener('click', function () {
            this.classList.toggle('open');
            const asideContent = this.nextElementSibling;
            if (this.classList.contains('open')) {
                asideContent.style.height = asideContent.scrollHeight + 'px';
            }
            else {
                asideContent.style.height = '';
            }
        });
    }

    // open image on popup on product listing page.
    if ($('#product-list-wrapper').length) {
        $('#product-list-wrapper').magnificPopup({
            delegate: 'a.product-image',
            type: 'image'
        });
    }

    if ($('.popular-product-sec').length) {
        $('.popular-product-sec').magnificPopup({
            delegate: 'a.product-image-popup',
            type: 'image'
        });
    }

    $('.populate-installers-region .gfield_select').attr('disabled', 'disabled');
    var is_fields_populated_initially = true; // 
    $('.populate-installers-state select').on('select2:select', function (e) {
        if (is_fields_populated_initially == true) {
            $('.populate-installers-region .gfield_select').removeAttr('disabled');
        }
        // if (is_fields_populated_initially == true) { // detect if state changed by selecting from form and not set from 
        // console.log("state changed");
        var regionSelector = $('.populate-installers-region select');
        regionSelector.select2('destroy');
        regionSelector.children('option.gf_placeholder').prop('selected', true);
        regionSelector.children('option').not('.gf_placeholder').prop('disabled', true);
        var data = $(this).find("option:selected").data('term_id');
        regionSelector.children("option[data-parent_id^=" + data + "]").prop('disabled', false);
        regionSelector.select2();
        regionSelector.closest('li').find('.select2-selection__rendered').addClass('factor');

        // If other exists then add disabled to always show - field only shows on form 12
        regionSelector.children("option[data-parent_id^=" + 999 + "]").prop('disabled', false);

        is_fields_populated_initially = false;
    });

    //Request a call back popup.
    $('.contact-modal').magnificPopup({
        type: 'inline',
        fixedContentPos: true,
        callbacks: {
            open: function () {
                //Added to fix the issue with the close btn not appearing after form submit
                if ($('.mfp-close').length > 0) {
                    $('button.mfp-close').remove();
                    closeMarkup: $('.callback-form-wrap').append('<button title="Close (Esc)" type="button" class="mfp-close">×</button>');

                }
            }
        }
    });


    //check url parameter value
    // if ($.urlParam('do_filter') == 'yes' || $.urlParam('_filter') == 'do') {

    // 	var _state = $.urlParam('_state'),
    // 		_region = $.urlParam('_region');
    // 	_type = $.urlParam('_type');

    // //console.log( _state,'form url' );
    // 	setTimeout(function () {		

    // 		if (_state) {
    // 			$('.selection-option-list li[data-term_id="' + _state + '"]').trigger('click');
    // 			$('li[data-term_id="' + _state + '"]').parent().removeClass('open');
    // 		}
    // 		if (_region) {
    // 			$('.selection-option-list li[data-term_id="' + _region + '"]').trigger('click');
    // 			$('li[data-term_id="' + _region + '"]').parent().removeClass('open');
    // 		}

    // 		if (_type) {
    // 			$('.selection-option-list li[data-term_id="' + _type + '"]').trigger('click');
    // 			$('li[data-term_id="' + _type + '"]').parent().removeClass('open');
    // 		}

    // 	}, 200);

    // }

})(jQuery);

function setCookie(cname, cvalue, exdays) { //function to set the cookie
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) { //function to get the cookie
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


//