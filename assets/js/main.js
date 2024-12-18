function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
if (jQuery('body').hasClass('page-template-tpl-display-center') || jQuery('body').hasClass('tax-display-center-state')) {
  // initialize map
  var initMap = function initMap() {
    // request for Display Center Map
    jQuery(document.body).trigger('display_centre_init_map');
  };
}
(function ($) {
  // Display Center Object
  var DisplayCenter = {
    // initialize
    init: function init() {
      this.cacheDOM();
      this.getMapStyle();
      this.initMap();
      this.addAllMarkers();
      this.eventListener();
      this.individualMap();
    },
    cacheDOM: function cacheDOM() {
      this.map = null;
      this.markers = {};
      this.$mapHolder = $('#display_center_map');
      this.locations = this.$mapHolder.data('display_center');
      this.$displayCenters = $('.display-centers');
      this.$filterAll = $('.filter-all');
      this.mapStyle = [];
    },
    eventListener: function eventListener() {
      // this.$displayCenters.on('click', this.refreshMapMarkers.bind(this));
      $('#schedule-wrapper').on('click', '.centre-load-more', this.loadMore.bind(this));
      // this.$filterAll.on('click', this.filterAll.bind(this));
    },
    getMapStyle: function getMapStyle() {
      var _style = (typeof undefined === "undefined" ? "undefined" : _typeof(undefined)) !== _typeof(readymixOptions.googleMapStyle) ? readymixOptions.googleMapStyle : [];
      try {
        this.mapStyle = jQuery.parseJSON(_style);
      } catch (e) {
        this.mapStyle = [];
      }
    },
    filterAll: function filterAll(e) {
      e.preventDefault();
      var that = this,
        $this = $(e.currentTarget),
        href = $this.attr('href');
      this.map.setCenter({
        lat: -25.3740472,
        lng: 135.5987167
      });
      this.map.setZoom(4);
      $.each(this.markers, function () {
        this.setMap(that.map);
        this.setAnimation(google.maps.Animation.DROP);
      });
      $('.current-point').removeClass('current-point');
      this.refreshDisplayCentres(href, false);
    },
    loadMore: function loadMore(e) {
      e.preventDefault();
      var $this = $(e.currentTarget),
        href = $this.attr('href');
      this.refreshDisplayCentres(href, true);
    },
    refreshMapMarkers: function refreshMapMarkers(e) {
      e.preventDefault();
      var $this = $(e.currentTarget),
        that = this,
        center_point = $this.data('center_point'),
        display_centers = $this.data('display_centers');
      if ($this.hasClass('current-point')) {
        return;
      }
      $this.addClass('current-point').closest('#accordion-child').find('.current-point').not($this).removeClass('current-point');
      if (display_centers) {
        $.each(this.markers, function (index) {
          if (-1 === $.inArray(parseInt(index), display_centers)) {
            that.removeMarker(index);
          } else {
            if (null === this.getMap()) {
              this.setMap(that.map);
              this.setAnimation(google.maps.Animation.DROP);
            }
          }
        });
        // empty center_point, use bound to center the map
        if ((typeof undefined === "undefined" ? "undefined" : _typeof(undefined)) === _typeof(center_point) || '' === center_point) {
          this.autoCenter(null);
        } else {
          // center the map with position
          var position = new google.maps.LatLng(center_point.lat, center_point.lng);
          this.autoCenter(position);
        }
        this.refreshDisplayCentres($this.attr('data-href'), false);
      }
    },
    initMap: function initMap() {
      // create object literal to store map properties
      var myOptions = {
        zoom: 4,
        // set zoom level,
        center: {
          lat: -25.3740472,
          lng: 135.5987167
        },
        // Australia
        zoomControl: false,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: false,
        styles: this.mapStyle
      };
      // initialize Map
      this.map = new google.maps.Map(this.$mapHolder.get(0), myOptions);
    },
    addMarker: function addMarker(index, position) {
      // add marker to the position
      this.markers[index] = new google.maps.Marker({
        animation: google.maps.Animation.DROP,
        icon: readymixOptions.mapMarker,
        map: this.map,
        position: position,
        title: location.name
      });
    },
    addAllMarkers: function addAllMarkers() {
      // add all display center into map
      var that = this;
      $.each(this.locations, function () {
        var location = this;
        // should have both lat and lng
        if (location.lat && location.lng) {
          var position = new google.maps.LatLng(location.lat, location.lng);
          that.addMarker(location.id, position);
        }
      });

      // var markerCluster = new MarkerClusterer(this.map, this.markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
    },
    removeMarker: function removeMarker(index) {
      // remove specific marker from map
      if ((typeof undefined === "undefined" ? "undefined" : _typeof(undefined)) !== _typeof(this.markers[index])) {
        this.markers[index].setMap(null); // null : to disable the marker
      }
    },
    removeMarkers: function removeMarkers() {
      // remove all marker
      var that = this;
      $.each(this.markers, function (index) {
        that.removeMarker(index);
      });
    },
    autoCenter: function autoCenter(position) {
      // null : center map with marker bound area
      if (null === position) {
        var bounds = new google.maps.LatLngBounds();
        $.each(this.markers, function (index, marker) {
          bounds.extend(marker.position);
        });
        this.map.fitBounds(bounds);
      } else {
        // center wit position
        this.map.setCenter(position);
        this.map.setZoom(5);
      }
    },
    individualMap: function individualMap() {
      var that = this;
      $('.schedule-map').each(function () {
        var $this = $(this),
          id = $this.attr('id'),
          lat = $this.data('lat'),
          lng = $this.data('lng');
        if (lat && lng) {
          var myOptions = {
            zoom: 12,
            // set zoom level,
            center: {
              lat: lat,
              lng: lng
            },
            zoomControl: false,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: false,
            fullscreenControl: false,
            styles: that.mapStyle
          };
          // initialize Map
          var map = new google.maps.Map(document.getElementById(id), myOptions);
          var marker = new google.maps.Marker({
            position: myOptions.center,
            map: map,
            icon: readymixOptions.mapMarkerBig
          });
        }
      });
    },
    refreshDisplayCentres: function refreshDisplayCentres(href, append) {
      var $that = this;
      if ((typeof undefined === "undefined" ? "undefined" : _typeof(undefined)) !== _typeof(href) && href) {
        $('.location-wrap, #schedule-list-wrap').css({
          'opacity': '0.6',
          'pointer-events': 'none'
        });
        $('<div>').load(href + ' #schedule-wrapper', function (response) {
          var $this = $(this),
            $scheduleList = $this.find('#schedule-list-wrap'),
            $loadMore = $this.find('#display-centre-load-more');
          if ($loadMore.find('a.centre-load-more').length) {
            $('#display-centre-load-more').html($loadMore.html()).show();
          } else {
            $('#display-centre-load-more').hide();
          }
          if ($scheduleList.find('.schedule-list').length) {
            if (false === append) {
              $('#schedule-list-wrap').html($scheduleList.html()).closest('#schedule-wrapper').show();
            } else {
              $scheduleList.find('.schedule-list').each(function () {
                $('#schedule-list-wrap').append(this);
              });
            }
            $that.individualMap();
          } else {
            $('#schedule-wrapper').hide();
          }
          $('.location-wrap, #schedule-list-wrap').css({
            'opacity': '',
            'pointer-events': ''
          });
        });
      }
    }
  };

  // toggle div
  $("#schedule-wrapper").on('click', '.btn-transparent', function () {
    var $this = $(this);
    $this.closest('.schedule-list').find('.schedule-time, .schedule-map').toggle(1000);
    $this.toggleClass('active');
    console.log('$this');
  });

  // initialize Display Center Map.
  $(document.body).on('display_centre_init_map', function () {
    if ($('body').hasClass('page-template-tpl-display-center') || $('body').hasClass('tax-display-center-state')) {
      DisplayCenter.init();
    }
  });
})(jQuery);
(function ($) {
  // filter options
  $('#display-center-filter .selection-option-list').on('click', 'li', function (e) {
    e.preventDefault();
    var $this = $(this),
      term_id = $this.data('term_id'),
      text = $this.text(),
      tax = $this.data('tax'),
      $siblings = $this.siblings(),
      $parent = $this.parent(),
      isSubElement = $parent.hasClass('selection-option-list-sub-wrap');
    if ($this.hasClass('changed')) {
      return;
    }

    // Populate dynamic links on the submit button
    var $redirectsTo = $this.attr('data-permalink');
    $('#display-center-submit').attr('data-redirects', $redirectsTo);
    $('#display-center-submit').on('click', function () {
      var redirectURL = $(this).attr('data-redirects');
      window.location.href = redirectURL;
    });
    if (isSubElement) {
      $parent.parent().find('.always').addClass('trigger');
    } else {
      $siblings.filter('.always').addClass('trigger');
    }
    if (term_id) {
      $siblings.filter('.temp').removeClass('temp').show();
      if (isSubElement) {
        $this.hide().addClass('temp').parent().parent().find('.changed').text(text).show();
      } else {
        $this.hide().addClass('temp').siblings().filter('.changed').text(text).show();
      }
    } else {
      if (isSubElement) {
        $parent.parent().find('.changed').hide();
      } else {
        $parent.find('.changed').hide();
      }
      $siblings.filter('.temp').removeClass('temp').show();
    }
    if ($this.parent().hasClass('select-state')) {
      var $regions = $('#display-center-filter .select-region.ignore li');
      $('input[name="chosen[_region]"]').val('');
      $regions.removeClass('list-last');
      $regions.filter('.temp').hide().removeClass('temp');
      $regions.filter('.changed').hide();
      $regions.filter(':not(.always)').hide();
      $regions.filter('[data-parent_term="' + term_id + '"]').show().last().addClass('list-last');
      if (!$regions.filter('[data-parent_term="' + term_id + '"]').length) {
        $regions.filter('.not-available').show();
      }
      if ($regions.filter('[data-parent_term="' + term_id + '"]').length > 0) {
        setTimeout(function () {
          $('.filter-row-region').removeClass('disabled');
          $('#display-center-submit').prop('disabled', false);
        }, 1900);
      } else {
        $('.filter-row-region').addClass('disabled');
        $('#display-center-submit').prop('disabled', true);
      }
    }
    if (isSubElement) {
      if (!$parent.parent().find('.always').hasClass('trigger') && !$this.hasClass('trigger')) {
        return;
      }
    } else {
      if (!$siblings.filter('.always').hasClass('trigger') && !$this.hasClass('trigger')) {
        return;
      }
    }
    if ($this.hasClass('trigger')) {
      $this.removeClass('trigger');
    }
  });

  // start custom select option test for display center using select2
  if ($('.custom-select-option').length) {
    var populateStates = function populateStates(state) {
      var $region = $('#select_region');
      $region.empty();
      $region.append('<option value="">Select Region</option>');
      if (state in regionOptions) {
        regionOptions[state].forEach(function (region) {
          var option = new Option(region.text, region.id);
          $(option).attr('data-href', region.href);
          $region.append(option);
        });
      }
      $region.trigger('change');
    };
    // new display center js
    $('#select_state').select2();
    $('#select_region').select2();

    // data listing

    var regionOptions = readymixOptions.display_center_data;
    $('#select_state').on('change', function () {
      var selectedState = $(this).val();
      populateStates(selectedState);
      if ($('#select_region').parents('.filter-row-region').hasClass('disabled')) {
        $('.filter-row-region').removeClass('disabled');
      }
      $(this).addClass('selected-new');
    });
    $('#select_region').on('change', function () {
      var selectedRegion = $(this).val();
      if (selectedRegion != '') {
        $(this).parents('.filter-row-region').next().find('button').removeAttr('disabled', 'true');
      } else {
        $('.filter-row.submit-wrap').find('button').prop('disabled', true);
      }
      var redirectsTo = $(this).find(':selected').attr('data-href');
      $('#display-center-submit').attr('data-redirects', redirectsTo);
      $('#display-center-submit').on('click', function () {
        var redirectURL = $(this).attr('data-redirects');
        window.location.href = redirectURL;
      });

      // if (selectedregion != '') {
      //     $(this).parents('.filter-row-region').next().find('button').removeAttr('disabled', 'true');
      // }
      // else {
      //     $('.filter-row.submit-wrap').find('button').prop('disabled', true);
      // }
      // // Populate dynamic links on the submit button
      // var $redirectsTo = $(this).attr('data-href');
      // $('#display-center-submit').attr('data-redirects', $redirectsTo);
      // $('#display-center-submit').on('click', function () {
      //     var redirectURL = $(this).attr('data-redirects');
      //     window.location.href = redirectURL;
      // });
    });
  }
  // end custom select option test for display center using select2
})(jQuery);
(function ($) {
  var FAQs = {
    init: function init() {
      this.cacheDOM();
      this.eventListener();
      this.checkScroll();
    },
    cacheDOM: function cacheDOM() {
      this.$cardHolders = $('.toggle-content-wrap');
      this.$faqTopics = $('.faq-topics-sidebar .faq-topic');
      this.$scrollSelector = $('.faq-do-scroll');
    },
    eventListener: function eventListener() {
      this.$faqTopics.on('click', this.filterTopicFAQs.bind(this));
    },
    filterTopicFAQs: function filterTopicFAQs(e) {
      e.preventDefault();
      var $this = $(e.currentTarget),
        term_id = $this.attr('data-faq_topic'),
        $parent = $this.closest('.sibebar-toggle-wrapper'),
        $always = $this.parent().siblings().filter('.always'),
        $faqs = $parent.find('.faq-topic-' + term_id + '-contents');
      if ($this.hasClass('active')) {
        return;
      }
      $parent.find('.faq-topic.active').removeClass('active');
      $this.addClass('active');
      $faqs.addClass('active-content').siblings().removeClass('active-content');
      this.$cardHolders.find('.card button[data-toggle="collapse"]:not(.collapsed)').addClass('collapsed').attr('data-expanded', false);
      this.$cardHolders.find('.card .collapse.show').removeClass('show');
      $always.find('a').text($this.text());
      $always.siblings().show();
      $this.parent().hide();
    },
    // scroll to section if visited by topic
    checkScroll: function checkScroll() {
      if (this.$scrollSelector.length) {
        var $faqWrapper = $('.faq-wrapper');
        if (!$faqWrapper.length) {
          return;
        }
        $('html,body').animate({
          scrollTop: $faqWrapper.offset().top - $('#masthead').outerHeight(true) - 10
        }, 1000);
      }
    }
  };
  FAQs.init();
})(jQuery);
(function ($) {
  var supportSVG = {
    init: function init() {
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
    }
  };
  var COMMON = {
    init: function init() {
      this.cacheDOM();
      $(window).on('resize', this.reCalcOnResize.bind(this));
    },
    cacheDOM: function cacheDOM() {
      this.$body = $('body');
      this.windowWidth = $(window).width();
    },
    reCalcOnResize: function reCalcOnResize() {
      this.windowWidth = $(window).width();
    }
  };
  var mainNavigation = {
    init: function init() {
      this.$body = $('body');
      this.$mainNavContainer = $('#site-navigation');
      this.$mainNavContainerMobile = $('#site-navigation-mob');
      this.$siteBranding = $('.site-branding ');
      this.$menuToggler = this.$siteBranding.find('.menu-toggle');
      this.$mainMenu = this.$mainNavContainer.find('#primary-menu');
      //     console.log(this.$menuToggler);
      this.$menuToggler.on('click', this.toggleMenu.bind(this));
    },
    toggleMenu: function toggleMenu(e) {
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
    if (currentPageUrl == destPageUrl) {
      e.preventDefault();
    }
    $('html, body').animate({
      scrollTop: $('#' + gotoHash).offset().top - $('#masthead .main-header').outerHeight(true)
    }, 700);
  });

  // add class to banner if current page do not have banner section.
  if (!$('main.site-main > section:first-of-type').hasClass('hero-banner')) {
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
        $(this).addClass('active');
        $(this).next('ul.sub-menu').show(300);
        // $(this).next('ul.sub-menu').addClass('ccrpact');
      } else {
        $(this).removeClass('active');
        $(this).next('ul.sub-menu').hide(300);
      }
    }
  });
  $('.topnav-close').on('click', function () {
    // on popup close use ajax request to disable the popup
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
        mobileCheck: function mobileCheck() {
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
          mobileCheck: function mobileCheck() {
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
    var headerHeight = mainHeaderHeight + topHeaderHeight;
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
          $('.global-link-strip .usp-lists').slick(_defineProperty(_defineProperty(_defineProperty({
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            speed: 800
          }, "infinite", true), "arrows", false), "dots", false));
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
    if (getCookie("readymix_destory_top_banner_popup_1") == '' || typeof getCookie("readymix_destory_top_banner_popup_1") == "undefined") {
      $("body .banner-popup").show();
    }
  });
  $(window).on('resize', function () {
    setTimeout(function () {
      uspSlider();
    }, 400);
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
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
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
    });
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
            slidesToScroll: 1
          }
        }, {
          breakpoint: 567,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            adaptiveHeight: true
          }
        }]
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
        }]
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
      asNavFor: '.single-readymix_product #slider-nav-hero'
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
      asNavFor: '#slider-nav-hero'
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
  });

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
        variableWidth: false
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

  var clickElem = document.querySelector('.aside-list h5');
  if (clickElem) {
    clickElem.addEventListener('click', function () {
      this.classList.toggle('open');
      var asideContent = this.nextElementSibling;
      if (this.classList.contains('open')) {
        asideContent.style.height = asideContent.scrollHeight + 'px';
      } else {
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
      open: function open() {
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
function setCookie(cname, cvalue, exdays) {
  //function to set the cookie
  var d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  var expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
  //function to get the cookie
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
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
(function ($) {
  // filter options
  // $('#product-listing-filter .selection-option-list').on('click', 'li', function (e) {

  //     e.preventDefault();
  //     var $this = $(this),
  //         term_id = $this.data('term_id'),
  //         text = $this.text(),
  //         tax = $this.data('tax'),
  //         $hidden_input = $('input[name="chosen[' + tax + ']"]'),
  //         $siblings = $this.siblings();

  //     if ($this.hasClass('changed')) {
  //         return;
  //     }

  //     $siblings.filter('.always').addClass('trigger');

  //     if (term_id) {
  //         $siblings.filter('.temp').removeClass('temp').show();
  //         $this.hide().addClass('temp').siblings().filter('.changed').text(text).show();
  //     }
  //     else {
  //         $this.parent().find('.changed').hide();
  //         $siblings.filter('.temp').removeClass('temp').show();
  //     }

  //     if ($hidden_input.length) {
  //         $hidden_input.val(term_id);
  //     }

  //     if ($this.parent().hasClass('select-state')) {
  //         var $regions = $('#product-listing-filter .select-region.ignore li');
  //         $('input[name="chosen[_region]"]').val('');

  //         $regions.removeClass('list-last');
  //         $regions.filter('.temp').hide().removeClass('temp');
  //         $regions.filter('.changed').hide();
  //         $regions.filter(':not(.always)').hide();
  //         $regions.filter('[data-parent_term="' + term_id + '"]').show().last().addClass('list-last');

  //         if (!$regions.filter('[data-parent_term="' + term_id + '"]').length) {
  //             $regions.filter('.not-available').show();
  //         }

  //         setTimeout(function () {
  //             if ($hidden_input.val() == '') {
  //                 $('#submit-product-filter').attr('disabled', 'disabled');
  //             }
  //         }, 400);

  //     }

  //     if (!$siblings.filter('.always').hasClass('trigger') && !$this.hasClass('trigger')) {
  //         return;
  //     }

  //     if ($this.hasClass('trigger')) {
  //         $this.removeClass('trigger');
  //     }

  //     $('#submit-product-filter').removeAttr('disabled');
  //     // $(document.body).trigger('products_do_filter');

  // });

  $('#submit-product-filter').on('click', function (e) {
    $(document.body).trigger('products_do_filter');
  });

  // trigger filter option changed
  $(document.body).on('products_do_filter', function () {
    var $lister = $('#product-list-wrap'),
      $wrapper = $lister.closest('#product-list-wrapper'),
      $loadMore = $wrapper.find('#product-filter-load-more');
    $wrapper.css({
      'opacity': '0.6',
      'pointer-events': 'none'
    });
    var query_string = '';
    $('input.product-filter-chosen').each(function () {
      var $this = $(this),
        tax = $this.data('tax');
      if ('checkbox' === $this.attr('type')) {
        if ($this.prop('checked')) {
          query_string += '&' + tax + '[]=' + $this.val();
        }
      } else if ('' !== $this.val()) {
        query_string += '&' + tax + '=' + $this.val();
      }
    });
    var request_url = $('#current-page-permalink').val() + '?do_filter=yes' + query_string;
    if (history.pushState) {
      window.history.pushState({
        path: request_url
      }, '', request_url);
    }
    $chosenState = $('#chosen-state').val();
    $chosenRegion = $('#chosen-region').val();
    $chosenType = $('#chosen-type').val();
    if ($chosenState != '' || $chosenRegion != '' || $chosenType != '') {
      $('.select-download-brochure').show();
      $('.select-download-brochure a').css('opacity', 1);
    } else {
      $('.select-download-brochure').hide();
      $('.select-download-brochure a').css('opacity', 0);
    }

    // DOWNLOAD BROCHURE LINK
    var stone_id = '&_stone=' + $('.select-download-brochure a').attr('data-stone');
    var brochure_url = $('#current-page-permalink').val() + '?print_id=1' + query_string + stone_id;
    $('.select-download-brochure a').attr('href', brochure_url);
    $("<div>").load(request_url + ' #product-list-wrapper', function (response) {
      var $that = $(this),
        $product_list = $that.find('#product-list-wrap');
      $lister.html($product_list.html());
      var child_list = $product_list.find('.col-lg-3').length;
      if (child_list == 0) {
        $('.download-btn-wrap').hide();
        $('.product-message').show();
      } else {
        $('.download-btn-wrap').show();
        $('.product-message').hide();
      }
      if ($that.find('#product-filter-load-more').length) {
        $loadMore.html($that.find('#product-filter-load-more').html());
      }
      $wrapper.css({
        'opacity': '',
        'pointer-events': ''
      });
    });
  });

  // load more
  $('#product-list-wrapper').on('click', '.product-load-more', function (e) {
    e.preventDefault();
    var $this = $(this),
      request_url = $this.attr('href'),
      $lister = $('#product-list-wrap'),
      $wrapper = $lister.closest('#product-list-wrapper'),
      $loadMore = $wrapper.find('#product-filter-load-more');
    $wrapper.css({
      'opacity': '0.6',
      'pointer-events': 'none'
    });
    $("<div>").load(request_url + ' #product-list-wrapper', function (response) {
      var $that = $(this),
        $product_list = $that.find('#product-list-wrap');
      $lister.append($product_list.html());
      if ($that.find('#product-filter-load-more').length) {
        $loadMore.html($that.find('#product-filter-load-more').html());
      }
      $wrapper.css({
        'opacity': '',
        'pointer-events': ''
      });
    });
  });

  /*****new from select2 *******/
  if ($('.readymix-product-select-area').length) {
    $('#rp_select_state').select2();
    $('#rp_select_region').select2();
    $('#rp_select_type').select2();
  }
  var initialState = '362';
  var initialRegion = '363';
  var rp_regionOptions = readymixOptions.readymix_product;
  function populateStates(state) {
    var $rp_region = $('#rp_select_region');
    $rp_region.empty();
    $rp_region.append('<option value="">Select Region</option>');
    if (state in rp_regionOptions) {
      rp_regionOptions[state].forEach(function (region) {
        var option = new Option(region.text, region.id, region.term_id);
        $(option).attr('data-term-id', region.term_id);
        $rp_region.append(option);
      });
    }
    $rp_region.trigger('change');
    if (state === initialState) {
      $('#rp_select_region').val(initialRegion).trigger('change');
    }
  }
  $('#rp_select_state').on('change', function () {
    var selected_state = $(this).val();
    var selected_state_id = $(this).find(':selected').attr('data-term_id');
    $('input#chosen-state').val(selected_state_id);
    populateStates(selected_state);
  });
  $('#rp_select_region').on('change', function () {
    var selectedRegion = $(this).val();
    var selected_region_id = $(this).find('option:selected').attr('data-term-id');
    $('input#chosen-region').val(selected_region_id);
  });
  $('#rp_select_type').on('change', function () {
    var selectedtype = $(this).val();
    var selected_type_id = $(this).find(':selected').attr('data-term_id');
    $('input#chosen-type').val(selected_type_id);
    if (selectedtype) {
      $('#submit-product-filter').removeAttr('disabled');
    } else {
      $('#submit-product-filter').attr('disabled', 'disabled');
    }
  });
  $(document).ready(function () {
    $('#rp_select_state').val(initialState).trigger('change');
    $('#submit-product-filter').attr('disabled', 'disabled');
    //get value from URL parameter
    if ($('.lister-module').length > 0) {
      $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results == null) {
          return null;
        } else {
          return results[1] || 0;
        }
      };
      //check url parameter value
      if ($.urlParam('do_filter') == 'yes' || $.urlParam('_filter') == 'do') {
        var _state = $.urlParam('_state'),
          _region = $.urlParam('_region');
        _type = $.urlParam('_type');
        setTimeout(function () {
          if (_state) {
            $('#rp_select_state').val(_state).trigger('change');
          }
          if (_region) {
            $('#rp_select_region').val(_region).trigger('change');
          }
          if (_type) {
            $('#rp_select_type').val(_type).trigger('change');
          }
        }, 200);
      }
    }
  });
})(jQuery);