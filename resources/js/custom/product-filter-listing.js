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

        $wrapper.css({ 'opacity': '0.6', 'pointer-events': 'none' });

        var query_string = '';
        $('input.product-filter-chosen').each(function () {
            var $this = $(this),
                tax = $this.data('tax');

            if ('checkbox' === $this.attr('type')) {
                if ($this.prop('checked')) {
                    query_string += '&' + tax + '[]=' + $this.val();
                }
            }
            else if ('' !== $this.val()) {
                query_string += '&' + tax + '=' + $this.val();
            }
        });

        var request_url = $('#current-page-permalink').val() + '?do_filter=yes' + query_string;

        if (history.pushState) {
            window.history.pushState({ path: request_url }, '', request_url);
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
            if( child_list == 0 ){
                $('.download-btn-wrap').hide();
                $('.product-message').show();
            }else{
                $('.download-btn-wrap').show();
                $('.product-message').hide();
            }
        
            if ($that.find('#product-filter-load-more').length) {
                $loadMore.html($that.find('#product-filter-load-more').html());
            }   
            $wrapper.css({ 'opacity': '', 'pointer-events': '' });
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


        $wrapper.css({ 'opacity': '0.6', 'pointer-events': 'none' });

        $("<div>").load(request_url + ' #product-list-wrapper', function (response) {
            var $that = $(this),
                $product_list = $that.find('#product-list-wrap');

            $lister.append($product_list.html());

            if ($that.find('#product-filter-load-more').length) {
                $loadMore.html($that.find('#product-filter-load-more').html());
            }

            $wrapper.css({ 'opacity': '', 'pointer-events': '' });
        });

    });

    /*****new from select2 *******/
    if( $('.readymix-product-select-area').length ){
        $('#rp_select_state').select2();
        $('#rp_select_region').select2();
        $('#rp_select_type').select2();
    }

    const initialState = '362'; 
    const initialRegion = '363'; 

    const rp_regionOptions = readymixOptions.readymix_product;

    function populateStates(state) {
        let $rp_region = $('#rp_select_region');
        $rp_region.empty();
        $rp_region.append('<option value="">Select Region</option>');

        if (state in rp_regionOptions) {
            rp_regionOptions[state].forEach(function (region) {
                let option = new Option(region.text, region.id, region.term_id ); 
                $(option).attr('data-term-id', region.term_id);     
                $rp_region.append(option);              
            });       
        }
        $rp_region.trigger('change');
      
        if (state === initialState) {
            $('#rp_select_region').val(initialRegion).trigger('change');
        }      
    }

    $('#rp_select_state').on('change',function(){
        var selected_state = $(this).val();
        var selected_state_id = $(this).find(':selected').attr('data-term_id');       
        $('input#chosen-state').val(selected_state_id);
        populateStates(selected_state); 
    });

    $('#rp_select_region').on( 'change',function(){       
        var selectedRegion = $(this).val();
        var selected_region_id = $(this).find('option:selected').attr('data-term-id');   
        $('input#chosen-region').val(selected_region_id);
    } );

    $('#rp_select_type').on('change',function(){
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
            }   
            //check url parameter value
            if ($.urlParam('do_filter') == 'yes' || $.urlParam('_filter') == 'do') {
                var _state = $.urlParam('_state'),
                    _region = $.urlParam('_region');
                    _type = $.urlParam('_type');                    
                    setTimeout(function () {                        
                    if (_state) {
                        $('#rp_select_state').val( _state ).trigger('change');
                    }
                    if (_region) {
                        $('#rp_select_region').val( _region ).trigger('change');
                    }
                    if (_type) {
                        $('#rp_select_type').val( _type ).trigger('change');
                    }
                }, 200);

            }
        } 

    });

})(jQuery);	