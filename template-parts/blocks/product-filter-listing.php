<?php
/**
 * Product Filter Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'product-filter-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-product-filter';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}

if (is_page()) { 
    $initial_load = true;

	//section background
	$style_bg       = '';
	$section_colour = get_field('section_colour');
	if ($section_colour) {
		$style_bg = "style='background-color:" . $section_colour . ";'";
	}
	//Get section title
	//For normal product lister page (e.g driveways)
	$section_title = get_field('section_name');


	//post type and taxonomy
	$readymix_cpt_type = 'readymix_product';
	$readymix_taxonomy = 'readymix_state';
	$readymix_type_taxonomy = 'readymix_type';

	//Get states and regions(terms) of taxonmy(readymix state)
	$states = get_terms(
		array(
			'taxonomy'   => $readymix_taxonomy,
			'hide_empty' => false
		)
	);

	$types = get_terms(
		array(
			'taxonomy'   => $readymix_type_taxonomy,
			'hide_empty' => false
		)
	);

	//default values of variables
	$args             = array();
	$filters          = array();
	$tax_query        = array();
	$child_term_id    = array();
	$parent_term_name = array();
	$type_term_name     = array();

	//Query argugments for products filtering listing for pages
	//for differenct conditions
	$paged = (isset($_GET['_paged']) && $_GET['_paged']) ? intval($_GET['_paged']) : 1;

	//default args
	$args = array(
		'post_type'      => 'readymix_product',
		'post_status'    => 'publish',
		'posts_per_page' => 20,
		'paged'          => intval($paged) ? intval($paged) : 1,
		// 'meta_key'       => 'volume',
		// 'orderby'        => 'meta_value_num',
		'order'          => 'DESC',
	);

	//tax query args
	//user has interacted with drop down filters
	if (isset($_GET['do_filter']) && 'yes' == $_GET['do_filter']) {
        $initial_load = false;

		$filters['do_filter'] = 'yes';

		// state tax
		if (isset($_GET['_state']) && $_GET['_state']) {
			$tax_query[] = array(
				'taxonomy' => $readymix_taxonomy,
				'field'    => 'term_id',
				'terms'    => sanitize_text_field($_GET['_state'])
			);

			$filters['_state'] = $_GET['_state'];
		}

		// state tax for region
		if (isset($_GET['_region']) && $_GET['_region']) {
			$tax_query[] = array(
				'taxonomy' => $readymix_taxonomy,
				'field'    => 'term_id',
				'terms'    => sanitize_text_field($_GET['_region'])
			);
			$filters['_region'] = $_GET['_region'];
		}

		// state type
		if (isset($_GET['_type']) && $_GET['_type']) {
			$tax_query[] = array(
				'taxonomy' => $readymix_type_taxonomy,
				'field'    => 'term_id',
				'terms'    => sanitize_text_field($_GET['_type'])
			);

			$filters['_type'] = $_GET['_type'];
		}
	} //user has not interacted with drop down filters
	else {

		//user comes to similar product page from other page (user used dropdown filter)
		//tax query for state
		if (isset($_GET['_state']) && $_GET['_state'] && !isset($_GET['do_filter'])) {
			$tax_query[] = array(
				'taxonomy' => $readymix_taxonomy,
				'field'    => 'term_id',
				'terms'    => sanitize_text_field($_GET['pg_state'])
			);
		}

		//user comes to similar product page from other page (user used dropdown filter)
		//tax query for regions
		if (isset($_GET['_region']) && $_GET['_region'] && !isset($_GET['do_filter'])) {
			$tax_query[] = array(
				'taxonomy' => $readymix_taxonomy,
				'field'    => 'term_id',
				'terms'    => sanitize_text_field($_GET['pg_region'])
			);
		}

		if( 
			( !isset($_GET['_state']) || !$_GET['_state'] ) &&
			( !isset($_GET['_region']) || !$_GET['_region'] ) &&
			( !isset($_GET['do_filter']) )
		) {
			$initial_load = true;
			$tax_query[] = array(
				'taxonomy' => $readymix_taxonomy,
				'field'    => 'term_id',
				'terms'    => 362
			);

			$tax_query[] = array(
				'taxonomy' => $readymix_taxonomy,
				'field'    => 'term_id',
				'terms'    => 363
			);
		}
	}

	$stone_type = array();
	if (get_field('list_by_product_range') != false && get_field('list_by_product_range') == 'Yes') {
		$stone_type  = get_field('product_range');
		$tax_query[] = array(
			'taxonomy' => 'readymix_type',
			'field'    => 'term_id',
			'terms'    => $stone_type
		);
	}


	// add tax query to args
	if (!empty($tax_query)) {
		$args['tax_query'] = $tax_query;
	}


	// query products with supplied args
	$products = new WP_Query($args);
	// '<pre>';print_r($products);echo '</pre>';

	$has_products = $products->have_posts();

	?>

	<!-- Product dropdown filter section -->
	<section class="lister-module" id="product-listing-filter" <?php echo $style_bg; ?>>
		<div class="container">
			<!-- section title -->
			<h4 class="H4-Black-Center"><?php echo $section_title; ?></h4>
			<!-- current permalink value -->
			<input type="hidden" name="page_permalink" id="current-page-permalink" value="<?php the_permalink(); ?>">

			<div class="filter-row has-bg readymix-product-select-area rp-state-region-drop">
				<div class="select-title"><?php _e('Select your area', 'readymix'); ?></div>
				<div class="selection-option-list">					
					<select id="rp_select_state" class="rp-select-state select2">
						<?php
						if (isset($_GET['_state']) && $_GET['_state']){
							$chosen_state    = "value=" . $_GET['_state'];
						}else{
							$chosen_state    = "value=" . 362;
						}						
						if( $states ): 						
						?>
							<option data-term_id=""  value=""><?php _e('Select State', 'readymix'); ?></option>
							<?php 
							foreach( $states as $state ): 
								if( 0 !== $state->parent  ){
									continue;
								}													
								?>
								<option data-term_id="<?php echo esc_attr($state->term_id); ?>" value="<?php echo $state->term_id; ?>"><?php echo $state->name ?></option>
							<?php endforeach; ?>
						<?php endif; ?>  
					</select>
					<input type="hidden" class="product-filter-chosen" name="chosen[_state]" data-tax="_state" id="chosen-state" <?php echo $chosen_state; ?>>
				</div>				
								
				<div class="selection-option-list rp-filter-row-region disabled">
					<select name="" id="rp_select_region" class="rp-select-region ignore select2">
						<?php 						
						if (isset($_GET['_region']) && $_GET['_region']){
							$chosen_region    = "value=" . $_GET['_region'];
						}else{
							$chosen_region    = "value=" . 363;
						}			
						$initial_load;					
						if ($states) { ?>
							<option value=""><?php _e('Select Region', 'readymix'); ?></option>
							
						<?php }  ?>
					</select>
					<input type="hidden" class="product-filter-chosen" name="chosen[_region]" data-tax="_region" id="chosen-region" <?php echo $chosen_region; ?>>
				</div>

				<div class="selection-option-list">					
					<select id="rp_select_type" class="rp-select-type select2">
						<?php 
						$chosen_type    = '';
						if (isset($_GET['_type']) && $_GET['_type']){
							$chosen_type    = "value=" . $_GET['_type'];
						}else{
							$chosen_type    = "value=" . '';
						}							
						if( $types ): ?>
							<option  value=""><?php _e('Select Type', 'readymix'); ?></option>
							<?php 
							$select_type_to_display = get_field('select_type_to_display');
							foreach( $types as $type ): 
								if( in_array( $type->term_id, $select_type_to_display ) ):
								?>
								<option value="<?php echo $type->term_id ?>" data-term_id="<?php echo $type->term_id; ?>"><?php echo $type->name ?></option>
								<?php 
								endif;
							endforeach; ?>
						<?php endif; ?>  
					</select>
					<input type="hidden" class="product-filter-chosen" name="chosen[_type]" data-tax="_type" id="chosen-type" <?php echo $chosen_type; ?>>
				</div>				

				<div class="btn-wrap select-download-brochure cus-pdf-download">
					<button class="btn btn-pink small" id="submit-product-filter" disabled><?php echo esc_html('Submit','readymix'); ?></button>
				</div>
			</div>			
			<div class="select-download-brochure download-btn-wrap">
				<a class="H6-Black-Left-Bold" href="?print_id=1&_stone=<?php the_field('product_range'); ?>" target="_blank" data-stone="<?php the_field('product_range'); ?>">
				<?php echo esc_html('Download Brochure','readymix'); ?>
					<img class="svg" src="<?php echo get_template_directory_uri(); ?>/images/download-broucher.svg" alt="">
				</a>
			</div>

			<div class='product-message' style="display:none"><?php echo esc_html('No products found','readymix'); ?></div>
		</div><!-- .container -->
	</section><!-- .lister-module -->
	<!-- Filter section ends-->

	<!-- Product listing section -->
	<section class="product-list-wrapper" id="product-list-wrapper" <?php echo $style_bg; ?>>
		<div class="container">
			<?php
			//Breadcrumb for single product page
			$pg_path_slug    = '';
			$current_page_id = get_the_ID();
			$current_pg_link = get_the_permalink();
			$site_url        = home_url('/');
			$str_length      = strlen($site_url);
			$pg_path_slug    = substr($current_pg_link, $str_length);
			if (!empty($pg_path_slug)) {
				$pg_path_slug = $pg_path_slug;
			}

			//echo '<pre>';print_r($products);echo '</pre>';
			?>
			<div class="product-list-wrap" id="product-list-wrap">
				<div class="row lister-layout">
					<?php
					if ($products->have_posts()) {
						global $post;
						$pg_state         = "";
						$pg_region        = "";
						$pg_type        = "";
						$query_arr_params = "";
						//state dropdown filter used
						if (isset($filters['_state']) && !empty($filters['_state'])) {
							$pg_state = $filters['_state'];
						}
						//region dropdwon filter used
						if (isset($filters['_region']) && !empty($filters['_region'])) {
							$pg_region = $filters['_region'];
						}
						if (isset($filters['_type']) && !empty($filters['_type'])) {
							$pg_type = $filters['_type'];
						}
						//product link, add query args
						$query_arr_params = array(
							'pg_path'   => $pg_path_slug,
							'pg_state'  => $pg_state,
							'pg_region' => $pg_region,
							'pg_type' => $pg_type
						);

						while ($products->have_posts()) {
							$products->the_post();
							//default fallback product card image
							$product_image = '<img src="' . get_template_directory_uri() . '/images/image_4.jpg' . '">';
							//if featured product card image set
							$featured_image = get_the_post_thumbnail(get_the_ID(), 'large');
							if (!empty($featured_image)) {
								$product_image = $featured_image;
							}
							//get product card image by type
							/*if ( get_field('show_concrete_type_image') != false && get_field('show_concrete_type_image') == "Yes" ) {
								if ( get_field('concrete_type') != false && get_field('concrete_type') != "none"){
									$get_image_type = 'image:_'.get_field('concrete_type');
									   if( get_field($get_image_type, $post->ID) != false ){
										$product_image = get_field( $get_image_type, $post->ID );
									}

								}
							}*/


							//Display featured image as per the page
							if (have_rows('_product_featured_image', get_the_ID())) :
								while (have_rows('_product_featured_image', get_the_ID())) : the_row();

									$types = get_sub_field('type');
									if ($types) {
										foreach ($types as $type) {
											if ($type->ID == $current_page_id) {
												$product_image = wp_get_attachment_image(get_sub_field('featured_image')['id'], 'full');
											}
										}
									}

								endwhile;
							endif;
					?>
							<div class="col-lg-3 col-6">
								<div class="product-list">
									<div class="product-item">
										<div class="inner">
											<figure class="image-holder">
												<?php
												do_action('product_inside_image_holder', get_the_ID());
												?>
												<a href="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(get_the_ID()), 'full'); ?>" class="product-image" tabindex="0">
													<span class="absolute-background-image"><?php echo $product_image; ?></span>
												</a>
											</figure>
											<div class="detail match-height">
												<?php
												if (isset($_GET['_type']) && $_GET['_type']) {
													$selected_type = $_GET['_type'];
												}	
												
												if( $selected_type != 423 ){
													//use function to display state region on product card
													echo single_product_terms_listing($post, $readymix_taxonomy, $filters);	
												}
												
												?>
												<h5 class="product-name"><span><?php echo get_the_title(); ?></span>
												</h5>
											</div><!-- .detail -->
										</div><!-- .inner -->
									</div><!-- .product-item  -->
								</div><!-- product-list -->
							</div>
					<?php
						} // end loop $products->have_posts
						wp_reset_postdata();
					} // end check $products->have_posts
					?>
				</div><!--  .row.lister-layou-->

			</div><!-- product-list-wrap -->

			<!-- load more  -->
			<div id="product-filter-load-more" class="btn-center-wrap">
				<?php
				if ($products->max_num_pages > $paged) {
					$load_more = get_field('_product_lister_load_more_button');
					if (!$load_more) {
						$load_more = __('Load More', 'readymix');
					}

					$filters['_paged'] = $paged + 1;

					$load_more_url = add_query_arg($filters, get_permalink());
				?>
					<a href="<?php echo esc_url($load_more_url); ?>" class="btn btn-green-houtline small product-load-more">
						<?php echo $load_more; ?>
					</a>
				<?php } // end for load more 
				?>
			</div>
			<!-- load more ends -->

		</div><!-- .container -->
	</section><!-- product-list-wrapper -->

<?php } //end check if page 
?>