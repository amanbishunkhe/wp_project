if (jQuery('body').hasClass('page-template-tpl-display-center') ||
    jQuery('body').hasClass('tax-display-center-state')) {
    // initialize map
    function initMap() {
        // request for Display Center Map
        jQuery(document.body).trigger('display_centre_init_map');
    }
}

(function ($) {
    // Display Center Object
    var DisplayCenter = {
        // initialize
        init: function () {
            this.cacheDOM();
            this.getMapStyle();
            this.initMap();
            this.addAllMarkers();
            this.eventListener();
            this.individualMap();
        },
        cacheDOM: function () {
            this.map = null;
            this.markers = {};
            this.$mapHolder = $('#display_center_map');
            this.locations = this.$mapHolder.data('display_center');
            this.$displayCenters = $('.display-centers');
            this.$filterAll = $('.filter-all');
            this.mapStyle = [];
        },
        eventListener: function () {
            // this.$displayCenters.on('click', this.refreshMapMarkers.bind(this));
            $('#schedule-wrapper').on('click', '.centre-load-more', this.loadMore.bind(this));
            // this.$filterAll.on('click', this.filterAll.bind(this));
        },
        getMapStyle: function () {
            var _style = (typeof undefined !== typeof readymixOptions.googleMapStyle) ? readymixOptions.googleMapStyle : [];
            try {
                this.mapStyle = jQuery.parseJSON(_style);
            }
            catch (e) {
                this.mapStyle = [];
            }
        },
        filterAll: function (e) {
            e.preventDefault();
            var that = this,
                $this = $(e.currentTarget),
                href = $this.attr('href');

            this.map.setCenter({ lat: -25.3740472, lng: 135.5987167 });
            this.map.setZoom(4);

            $.each(this.markers, function () {
                this.setMap(that.map);
                this.setAnimation(google.maps.Animation.DROP);
            });

            $('.current-point').removeClass('current-point');
            this.refreshDisplayCentres(href, false);
        },
        loadMore: function (e) {
            e.preventDefault();
            var $this = $(e.currentTarget),
                href = $this.attr('href');

            this.refreshDisplayCentres(href, true);
        },
        refreshMapMarkers: function (e) {
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
                    }
                    else {
                        if (null === this.getMap()) {
                            this.setMap(that.map);
                            this.setAnimation(google.maps.Animation.DROP);
                        }
                    }
                });
                // empty center_point, use bound to center the map
                if (typeof undefined === typeof center_point || '' === center_point) {
                    this.autoCenter(null);
                }
                else {
                    // center the map with position
                    var position = new google.maps.LatLng(center_point.lat, center_point.lng);
                    this.autoCenter(position);
                }

                this.refreshDisplayCentres($this.attr('data-href'), false);
            }
        },
        initMap: function () {
            // create object literal to store map properties
            var myOptions = {
                zoom: 4, // set zoom level,
                center: { lat: -25.3740472, lng: 135.5987167 }, // Australia
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
        addMarker: function (index, position) {
            // add marker to the position
            this.markers[index] = new google.maps.Marker({
                animation: google.maps.Animation.DROP,
                icon: readymixOptions.mapMarker,
                map: this.map,
                position: position,
                title: location.name
            });
        },
        addAllMarkers: function () {
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
        removeMarker: function (index) {
            // remove specific marker from map
            if (typeof undefined !== typeof this.markers[index]) {
                this.markers[index].setMap(null); // null : to disable the marker
            }
        },
        removeMarkers: function () {
            // remove all marker
            var that = this;
            $.each(this.markers, function (index) {
                that.removeMarker(index);
            });
        },
        autoCenter: function (position) {
            // null : center map with marker bound area
            if (null === position) {
                var bounds = new google.maps.LatLngBounds();

                $.each(this.markers, function (index, marker) {
                    bounds.extend(marker.position);
                });

                this.map.fitBounds(bounds);
            }
            else {
                // center wit position
                this.map.setCenter(position);
                this.map.setZoom(5);
            }
        },
        individualMap: function () {
            var that = this;
            $('.schedule-map').each(function () {
                var $this = $(this),
                    id = $this.attr('id'),
                    lat = $this.data('lat'),
                    lng = $this.data('lng');

                if (lat && lng) {
                    var myOptions = {
                        zoom: 12, // set zoom level,
                        center: { lat: lat, lng: lng },
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
                        icon: readymixOptions.mapMarkerBig,
                    });
                }
            })
        },
        refreshDisplayCentres: function (href, append) {
            var $that = this;
            if (typeof undefined !== typeof href && href) {
                $('.location-wrap, #schedule-list-wrap').css({ 'opacity': '0.6', 'pointer-events': 'none' });
                $('<div>').load(href + ' #schedule-wrapper', function (response) {
                    var $this = $(this),
                        $scheduleList = $this.find('#schedule-list-wrap'),
                        $loadMore = $this.find('#display-centre-load-more');

                    if ($loadMore.find('a.centre-load-more').length) {
                        $('#display-centre-load-more').html($loadMore.html()).show();
                    }
                    else {
                        $('#display-centre-load-more').hide();
                    }

                    if ($scheduleList.find('.schedule-list').length) {
                        if (false === append) {
                            $('#schedule-list-wrap').html($scheduleList.html()).closest('#schedule-wrapper').show();
                        }
                        else {
                            $scheduleList.find('.schedule-list').each(function () {
                                $('#schedule-list-wrap').append(this);
                            });
                        }

                        $that.individualMap();
                    }
                    else {
                        $('#schedule-wrapper').hide();
                    }

                    $('.location-wrap, #schedule-list-wrap').css({ 'opacity': '', 'pointer-events': '' });
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
        }
        else {
            $siblings.filter('.always').addClass('trigger');
        }


        if (term_id) {
            $siblings.filter('.temp').removeClass('temp').show();
            if (isSubElement) {
                $this.hide().addClass('temp').parent().parent().find('.changed').text(text).show();
            }
            else {
                $this.hide().addClass('temp').siblings().filter('.changed').text(text).show();
            }
        }
        else {
            if (isSubElement) {
                $parent.parent().find('.changed').hide();
            }
            else {
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
        }
        else {
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

        // new display center js
        $('#select_state').select2();
        $('#select_region').select2();

        // data listing
       
        const regionOptions = readymixOptions.display_center_data;

        function populateStates(state) {
            let $region = $('#select_region');
            $region.empty();
            $region.append('<option value="">Select Region</option>');

            if (state in regionOptions) {
                regionOptions[state].forEach(function (region) {
                    let option = new Option(region.text, region.id);             
                    $(option).attr('data-href', region.href);
                    $region.append(option);
                });
            }
            $region.trigger('change');
        }

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
            }
            else {
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