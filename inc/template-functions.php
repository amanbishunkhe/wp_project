<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package readymix
 */

use function Complex\ln;

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function readymix_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}

	return $classes;
}

add_filter( 'body_class', 'readymix_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function readymix_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'readymix_pingback_header' );

add_filter(
	'gform_field_validation_1_7',
	function ( $result, $value, $form, $field ) {
		// add the phone validation and restrict Australian phone format
		$re = '/^(?:\+?(61))? ?(?:\((?=.*\)))?(0?[2-57-8])\)? ?(\d\d(?:[- ](?=\d{3})|(?!\d\d[- ]?\d[- ]))\d\d[- ]?\d[- ]?\d{3})$/m';
		if ( $result['is_valid'] == true && ! preg_match( $re, (string) $value ) ) {
			$result['is_valid'] = false;
			$result['message']  = 'Please enter the valid phone number';
		}

		return $result;
	},
	10,
	4
);


/**
 *  Function to list state region in product filter listing
 * @param type $post (redymix_product post object)
 * @param type $redymix_taxonomy (state taxonomy )
 * @param type $filter (state region filter values from dropdown)
 * @return HTML State region listing
 */
function single_product_terms_listing($post, $redymix_taxonomy, $filter = array())
{
    $output = '';
    //Get post parent and child in aray
    $parent_term_name = array();
    $child_term_id = array();
    $terms = wp_get_post_terms($post->ID, $redymix_taxonomy);
    foreach ($terms as $term) {
        if (0 == $term->parent) {
            $parent_term_name[$term->term_id] = $term->name;
        } else {
            $child_term_id[] = $term->term_id;
        }
    }
    // Listing state region mechanism on fresh load and filter
    foreach ($parent_term_name as $key => $value) {
        $output .= '<span class="mata-cat">';
        //Parent term "State"
        $output .= $value;
        //Child term 'Region' listing
        $args = array(
            'taxonomy' => $redymix_taxonomy,
            'orderby' => 'name',
            'order' => 'ASC',
            'parent' => $key,
            'include' => $child_term_id,
            'fields' => 'id=>name'
        );
        $child_terms = get_terms($args);
        $count = count($child_terms);

        //single region
        if ($count && $count == 1) {
            //filters selected
            if (isset($filter['_region']) && array_key_exists($filter['_region'], $child_terms)) {
                $filter_region_id = $filter['_region'];
                $output .= "<span>|</span>" . $child_terms[$filter_region_id];
            } //filters not selected
            else {
                $firstElement = array_key_first($child_terms);
                $output .= "<span>|</span>" . $child_terms[$firstElement];
            }
        } //multiple region
        elseif ($count >= 2) {
            //fiters selected
            if (isset($filter['_region']) && array_key_exists($filter['_region'], $child_terms)) {

                $filter_region_id = $filter['_region'];
                $output .= "<span>|</span>" . $child_terms[$filter_region_id] . __(' +More', 'redymix');
            } //filters not selected
            else {
                sort($child_terms);
                $firstElement = array_key_first($child_terms);
                $output .= "<span>|</span>" . $child_terms[$firstElement] . __(' +More', 'redymix');
            }
        }
        $output .= '</span><br>';
    }
    return $output;
}


/*
* List Tax terms in hierarchy
* @param PostID $postID which is the ID of current post
* @param Taxonomy Name $taxonomy_name whose terms is to be retrieved
* @param List Terms $list whether to return output in HTML li format or not
* @param Get Parent Only Term $parent_only retrieved pararent terms only.
* @return HTML output based on $list and $parent_only
*/
function list_hierarchical_terms( $postID, $taxonomy_name, $list = false, $parent_only = false ) {
	$post_id  = $postID;
	$taxonomy = $taxonomy_name;

	$tax_terms = wp_get_post_terms( $post_id, $taxonomy, array( "fields" => "ids" ) );

	if ( $tax_terms ) {

		$term_array = trim( implode( ',', (array) $tax_terms ), ' ,' );

		if ( $parent_only == true && $list == true ) {
			$neworderterms = get_terms( $taxonomy, 'orderby=none&parent=0&include=' . $term_array );
			$parent_terms  = '';
			foreach ( $neworderterms as $count => $orderterm ) {
				$parent_terms .= '<li data-state="' . strtolower( $orderterm->name ) . '">' . $orderterm->name . '</li>';
			}

			return $parent_terms;
		} else if ( $list == false ) {
			$tax_count     = count( $tax_terms );
			$neworderterms = get_terms( $taxonomy, 'orderby=none&include=' . $term_array );
			foreach ( $neworderterms as $count => $orderterm ) {
				echo $orderterm->name;
				if ( $count < $tax_count - 1 ) {
					echo "<span>|</span> ";
				}
			}

		} else {

			$neworderterms = get_terms( $taxonomy, 'orderby=none&include=' . $term_array );
			foreach ( $neworderterms as $count => $orderterm ) {
				?>
                <li><?php echo $orderterm->name; ?></li>
				<?php
			}

		}
	}
}


//Dynamic option field chocies for state
add_filter( "gform_pre_render_6", 'populate_with_installers_state_only' );

function populate_with_installers_state_only( $form ) {
	foreach ( $form['fields'] as &$field ) {
		if ( $field->type != 'select' || strpos( $field->cssClass, 'populate-installers-state' ) === false ) {
			continue;
		}

		global $post;
		$current_page_id = $post->ID;
		$taxonomy        = 'readymix_state';


		$current_terms = get_terms(
			array(
				'taxonomy' => $taxonomy,
				'parent'   => 0
			)
		);


		$choices = array();

		foreach ( $current_terms as $count => $current_term ) {
			// $choices[] = array( 'text' => $current_term->name, 'value' => $current_term->name, 'data-term_id' => $current_term->term_id );
			$choices[ $count ]['text']         = $current_term->name;
			$choices[ $count ]['value']        = $current_term->name;
			$choices[ $count ]['data-term_id'] = $current_term->term_id;
			$choices[ $count ]['isSelected']   = false;

			if ( isset( $_POST['input_9'] ) ) { // from Form 4
				if ( $_POST['input_9'] == $current_term->name ) {
					$choices[ $count ]['isSelected'] = true;
				}
			} 

		}

		// echo '<pre>';print_r($choices);echo '</pre>';
		// update 'Select a Post' to whatever you'd like the instructive option to be
		if ( $form['id'] === 6 ) {
			$field->placeholder = 'State or Territory*';
		}
		$field->choices = $choices;

	}
	return $form;
}


//Dynamic option field chocies for region
add_filter( "gform_pre_render_6", 'populate_with_installers_region_only' );
function populate_with_installers_region_only( $form ) {
	foreach ( $form['fields'] as &$field ) {

		if ( $field->type != 'select' || strpos( $field->cssClass, 'populate-installers-region' ) === false ) {
			continue;
		}

		global $post;
		$current_page_id = $post->ID;
		$taxonomy        = 'readymix_state';


		$current_terms = get_terms(
			array(
				'taxonomy' => $taxonomy,
			)
		);
		$choices       = array();
		$_counter      = 0;

		foreach ( $current_terms as $count => $current_term ) {
			if ( $current_term->parent != 0 ) {
				
				$choices[ $_counter ]['text']           = $current_term->name;
				$choices[ $_counter ]['value']          = $current_term->name;
				$choices[ $_counter ]['data-parent_id'] = $current_term->parent;
				$choices[ $_counter ]['isSelected']     = false;

				if ( isset( $_POST['input_25'] ) ) { // from Form 4
					if ( $_POST['input_25'] == $current_term->name ) {
						$choices[ $_counter ]['isSelected'] = true;
					}
				} 
				$_counter += 1;
			}
		}

		// update 'Select a Post' to whatever you'd like the instructive option to be
		// if ( $form['id'] === 4 ) {
		// 	$choices[]          = array(
		// 		'text'           => 'Other',
		// 		'value'          => 'other',
		// 		'value'          => 'other',
		// 		'data-parent_id' => '999',
		// 		'isSelected'     => false
		// 	);
		// 	$field->placeholder = 'Select your region*';
		// } else {
		// 	$field->placeholder = 'Select your region*';
		// }
		$field->placeholder = 'Select your region*';
		$field->choices = $choices;

	}

	return $form;
}

//Dynamic state for request popup
add_filter( "gform_pre_render_5", 'request_populate_with_installers_state_only' );
function request_populate_with_installers_state_only( $form ) {
	foreach ( $form['fields'] as &$field ) {
		if ( $field->type != 'select' || strpos( $field->cssClass, 'request-populate-installers-state' ) === false ) {
			continue;
		}

		global $post;
		$current_page_id = $post->ID;
		$taxonomy        = 'readymix_state';


		$current_terms = get_terms(
			array(
				'taxonomy' => $taxonomy,
				'parent'   => 0
			)
		);


		$choices = $field->choices;

		foreach ( $current_terms as $count => $current_term ) {

			$choices[ $count ]['text']         = $current_term->name;
			$choices[ $count ]['value']        = $current_term->name;
			$choices[ $count ]['data-term_id'] = $current_term->term_id;
			$choices[ $count ]['isSelected']   = false;

			if ( isset( $_POST['input_6'] ) ) { // from Form 5 & 7
				if ( $_POST['input_6'] == $current_term->name ) {
					$choices[ $count ]['isSelected'] = true;
				}
			}
		}

		// update 'Select a Post' to whatever you'd like the instructive option to be
		$field->placeholder = 'State*';
		$field->choices     = $choices;

	}

	return $form;
}


//Set the term id and parent id to state and region respectiverly on form
add_filter( 'gform_field_choice_markup_pre_render', function ( $value, $arg1, $arg2, $arg3, $arg4 ) {


	if ( isset( $arg1['data-term_id'] ) ) {
		$attr     = 'data-term_id="' . $arg1['data-term_id'] . '"';
		$selected = ( isset( $arg1['isSelected'] ) && $arg1['isSelected'] == true ) ? 'selected="selected"' : '';
		$value    = sprintf( '<option value="%s" %s %s>%s</option>', $arg1['value'], $selected, $attr, $arg1['text'] );

	} else if ( isset( $arg1['data-parent_id'] ) ) {
		$attr     = 'data-parent_id="' . $arg1['data-parent_id'] . '"';
		$selected = ( isset ( $arg1['isSelected'] ) && $arg1['isSelected'] == true ) ? 'selected="selected"' : '';
		$value    = sprintf( '<option value="%s" %s %s>%s</option>', $arg1['value'], $selected, $attr, $arg1['text'] );

	}

	return $value;
}, 10, 5 );


function moveLastToFirst($array) {
    if (count($array) > 1) {
        // Pop the last element from the array
        $lastElement = array_pop($array);
        // Prepend the last element to the beginning of the array
        array_unshift($array, $lastElement);
    }
    return $array;
}



function custom_acf_taxonomy_hierarchy( $args, $field, $post_id ){
    $args['parent'] = empty($_POST['parent']) ? 0 : $_POST['parent'];    
    return $args;
}
//add_filter('acf/fields/taxonomy/query/key=field_667be95e3c292', 'custom_acf_taxonomy_hierarchy',10,3);

/**
 * Localize of value for display center filter
 */
function get_dynamic_taxonomy_data($taxonomy) {
	$terms = get_terms(array(
		'taxonomy' => $taxonomy,
		'hide_empty' => false,
		'parent' => 0
	));
	
	$result = array();

	foreach ($terms as $term) {
		$children = get_terms(array(
			'taxonomy' => $taxonomy,
			'hide_empty' => false,
			'parent' => $term->term_id
		));
		
		$child_terms = array();
		foreach ($children as $child) {
			$child_terms[] = array(
				'id' => $child->slug, 
				'text' => $child->name,
				'href' => get_term_link($child->term_id)
			);
		}
		$result[$term->slug] = $child_terms;
	}
	
	return $result;
}


/**
 * Localize of value for geostone product filter
 */
function get_dynamic_product_taxonomy_data($taxonomy) {
	$terms = get_terms(array(
		'taxonomy' => $taxonomy,
		'hide_empty' => false,
		'parent' => 0
	));
	
	$result = array();

	foreach ($terms as $term) {
		$children = get_terms(array(
			'taxonomy' => $taxonomy,
			'hide_empty' => false,
			'parent' => $term->term_id
		));
		
		$child_terms = array();
		foreach ($children as $child) {
			$child_terms[] = array(
				'term_id' => $child->term_id,
				'id' => $child->term_id, 
				'text' => $child->name
			);
		}
		$result[$term->term_id] = $child_terms;
	}
	
	return $result;
}

/**	
 * get a quote form , email send based on state 
 * In gravity form this can be done from routing as well
 */
//add_filter( 'gform_notification_1', 'route_notifications_based_on_state', 10, 3 );
// function route_notifications_based_on_state( $notification, $form, $entry ) {
// 	$state_field_id = 20;
// 	$state          = rgar( $entry, $state_field_id );
// 	$email_addresses = array(// 		
// 		'ACT' => 'enquiries-qld@readymix.com.au',
// 		'QLD' => 'enquiries-qld@readymix.com.au',
// 		'VIC' => 'enquiries-vic@readymix.com.au',
// 		'SA'  => 'enquiries-sa@readymix.com.au',
// 		'NT'  => 'enquiries-qld@readymix.com.au',
// 		'WA'  => 'enquiries-qld@readymix.com.au',
// 		'TAS' => 'enquiries-qld@readymix.com.au'
// 	);

// 	if ( isset( $email_addresses[ $state ] ) ) {
// 		$notification['to'] = $email_addresses[ $state ];
// 	}else{
// 	//	$notification['to'] = 'info@readymix.com.au';
// 	}
// 	return $notification;
// }


// Address autocomplete for address fields in Get a Quote page
function google_address_autocomplete() {
    ?>
    <script type="text/javascript">

        let autocomplete;
        let address1Field;
        // let address2Field;
        // let postalField;

        function initAutocomplete() {
            if( !document.querySelector( '#gform_1' ) ) { // Check if get a quote popup form exists in the page
                return;
            }
            address1Field = document.querySelector("#input_1_24");
			address1Field.setAttribute('placeholder', '')
            // address2Field = document.querySelector("#input_4_34");
            // postalField = document.querySelector("#input_4_36");
			
            // Create the autocomplete object, restricting the search predictions to
            autocomplete = new google.maps.places.Autocomplete(address1Field, {
                componentRestrictions: {country: ["aus"]},
                fields: ["address_components", "geometry"],
                types: ["address"],
            });
            //address1Field.focus();
            // When the user selects an address from the drop-down, populate the
            // address fields in the form.
            autocomplete.addListener("place_changed", fillInAddress);
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
            const place = autocomplete.getPlace();
            let address1 = "";
            let postcode = "";

            // Get each component of the address from the place details,
            // and then fill-in the corresponding field on the form.
            // place.address_components are google.maps.GeocoderAddressComponent objects
            // which are documented at http://goo.gle/3l5i5Mr
			
            for (const component of place.address_components) {
                // @ts-ignore remove once typings fixed
                const componentType = component.types[0];
                switch (componentType) {
                    case "street_number": {
                        address1 = `${component.long_name} ${address1}`;
                        break;
                    }

                    case "route": {
                        address1 += component.short_name;
                        break;
                    }

                    case "postal_code": {
                        postcode = `${component.long_name}${postcode}`;
                        break;
                    }

                    case "postal_code_suffix": {
                        postcode = `${postcode}-${component.long_name}`;
                        break;
                    }

                    case "locality":
                        document.querySelector("#input_1_37").value = component.long_name; // Address 2
						document.querySelector("#input_1_37").value = component.short_name;
                        break;
                    case "administrative_area_level_2": {
                    
                        // State autopopulate field
                        document.querySelector("#field_1_37").classList.add('active');
                        document.querySelector("#input_1_37").value = component.long_name; 
                        break;
                    }
					case "administrative_area_level_1": {
                        // document.querySelector("#input_4_35").value = component.short_name; // state
                        document.querySelector("#input_1_20").value = component.short_name; // state state dropdown field
                        document.querySelector("#input_1_20").dispatchEvent(new Event('change'));
                        document.querySelector("#input_1_20").dispatchEvent(new Event('select2:select'));

                        // State autopopulate field
                        document.querySelector("#field_1_38").classList.add('active');
                        document.querySelector("#input_1_38").value = component.short_name; // state
                        // document.querySelector("#input_4_20").attr('disabled', true);
                        break;
                    }
                    // case "country":
                    //     document.querySelector("#input_1_37").value = component.long_name; // Country
                    //     break;
                }
            }

            address1Field.value = address1; // Address 1 from Google
           // postalField.value = postcode; // Post Code
            // address2Field.focus();
        }

        // Initialize on first load
        // window.initAutocomplete = initAutocomplete;

        // Initialize once the form has triggered error
        jQuery(document).on('gform_post_render', function (event, form_id, current_page) {
            if( form_id != 1 ){ // Return if gravity form being rendered is not get a quote page form.
                return false;
            }
            initAutocomplete();
			
        });
    </script>
    <?php
}

add_action( 'wp_footer', 'google_address_autocomplete', 10 );
