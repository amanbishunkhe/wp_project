<?php get_header(); ?>

<main id="primary" class="site-main">
	<?php
	/**
	 * Taxonomy display-center-state template
	 */
	$query_obj = get_queried_object();
	$queried_term_id = $query_obj->term_id;
	$queried_term_parent = $query_obj->parent;

	$parent_term = ($queried_term_parent != 0) ? get_term($queried_term_parent) : $query_obj;

	?>
	<div class="section-display-center section-common-default" style="background-color: #fafafa;">
		<?php
		get_template_part('template-parts/blocks/common-display-center');
		?>
		<div class="location-wrapper">
			<div class="container">
				<div class="location-wrap">
					<?php
					// args to get display centers
					$display_center_args = array(
						'post_type' => 'display-center',
						'post_status' => 'publish',
						'posts_per_page' => -1,
						'tax_query' => array(
							array(
								'taxonomy' => 'display-center-state',
								'field' => 'term_id',
								'terms' => $queried_term_id
							)
						),
					);					

					$latLngs = array();
					// request all display center
					$all_display_centers = get_posts($display_center_args);
					// check
					if ($all_display_centers) {
						// loop
						foreach ($all_display_centers as $key => $display_center) {
							$location = get_field('_display_centre_google_map', $display_center->ID);
							if (isset($location['lat']) && isset($location['lng'])) {
								$latLngs[] = array(
									'name' => htmlentities2($display_center->post_title),
									'id' => $display_center->ID,
									'lat' => htmlentities2($location['lat']),
									'lng' => htmlentities2($location['lng'])
								);
							}
						}
					}
					?>

					<div class="map" id="display_center_map"
					data-display_center='<?php echo wp_json_encode($latLngs); ?>' style="display:none;"></div>
					<script>
						// initialize Map

					</script>
				</div>
			</div>
		</div>

		<?php
		$filter = array();

		// current paged
		$paged = (isset($_GET['_paged']) && intval($_GET['_paged'])) ? intval($_GET['_paged']) : 1;
		$display_name = get_field('_display_center_state_region_full_name', $query_obj);
		if (!$display_name) {
			$display_name = $query_obj->name;
		}

		// WP Query args
		$args = array(
			'post_type' => 'display-center',
			'post_status' => 'publish',
			'posts_per_page' => 7,
			'paged' => $paged,
			'tax_query' => array(
				array(
					'taxonomy' => 'display-center-state',
					'field' => 'term_id',
					'terms' => $queried_term_id
				)
			),
		);


		// for load more
		$filter['_paged'] = $paged + 1;
		// query filtered display centres
		$display_centers = new WP_Query($args);	
		?>

		<section class="schedule-wrapper" id="schedule-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

						<div id="schedule-list-wrap">
							<?php if ($display_centers->have_posts()) { // is valid query? ?>
								<h3><?php _e(sprintf('%s Display Centres', $display_name), 'readymix'); ?></h3>
								<?php
								// loop
								while ($display_centers->have_posts()) {
									$display_centers->the_post(); // setup post data
									$location = get_field('_display_centre_google_map', get_the_ID());
									$lat = '';
									$lng = '';
									$google_map_address = isset($location['address']) ? $location['address'] : '';
									if (isset($location['lat']) && isset($location['lng'])) {
										$lat = $location['lat'];
										$lng = $location['lng'];
									}
									/*$lat = get_field( '_display_centre_latitude', get_the_ID() ); // latitude
																																													$lng = get_field( '_display_centre_longitude', get_the_ID() ); // longitude*/
									?>
									<div class="schedule-list">
										<div class="schedule-address">
											<h5><?php the_title(); ?></h5>
											<ul>
												<?php if ($full_address = get_field('_display_center_full_address', get_the_ID())) { ?>
													<li>
														<div class="icon">
															<?php get_template_part('template-parts/svg-icons/icon-location', 'svg'); ?>
														</div>
														<div class="list"><?php echo $full_address; ?></div>
													</li>
												<?php } ?>

												<?php if ($contact_number = get_field('_display_centre_contact_number', get_the_ID())) { ?>
													<li>
														<div class="icon">
															<?php get_template_part('template-parts/svg-icons/icon-phone', 'svg'); ?>
														</div>
														<div class="list">
															<a
																href="tel:<?php echo $contact_number; ?>"><?php echo $contact_number; ?></a>
														</div>
													</li>
												<?php } ?>

												<?php if ($website = get_field('_display_centre_website', get_the_ID())) { ?>
													<li>
														<div class="icon">
															<?php get_template_part('template-parts/svg-icons/icon-globe', 'svg'); ?>
														</div>
														<div class="list">
															<a href="<?php echo esc_url($website); ?>"
																target="_blank"><?php _e('Visit Website', 'readymix'); ?></a>
														</div>
													</li>
												<?php } ?>
											</ul>

											<?php if (isset($full_address) && $full_address) { ?>
												<?php
												if ($google_map_address) {
													$address = urlencode(get_the_title() . ', ' . $google_map_address); // encode for URL
												} else {
													$address = urlencode(get_the_title() . ', ' . $full_address); // encode for URL
												}
												$google = "https://www.google.com/maps/search/{$address}/"; // google search parameter
												?>
												<div class="btn-wrap">
													<a href="<?php echo esc_url($google); ?>" target="_blank"
														class="btn btn-pink small"><?php _e('Get Directions', 'readymix'); ?></a>
													<a href="javascript:void(0)" class="btn-transparent btn btn-link">
														<span><?php _e('See Details', 'readymix'); ?></span>
														<span><?php _e('Hide Details', 'readymix'); ?></span>
													</a>
												</div>
											<?php } ?>
										</div><!-- address -->

										<div class="schedule-time">
											<?php
											// opening hours
											$opening_hours = get_field('_display_centre_opening_hours', get_the_ID());

											if ($opening_hours = get_field('_display_centre_opening_hours', get_the_ID())) {
												$days = array(
													'monday' => __('Mon', 'readymix'),
													'tuesday' => __('Tues', 'readymix'),
													'wednesday' => __('Wed', 'readymix'),
													'thursday' => __('Thurs', 'gestone'),
													'friday' => __('Fri', 'readymix'),
													'saturday' => __('Sat', 'readymix'),
													'sunday' => __('Sun', 'readymix')
												);
												?>
												<h6 class="H6-Black-Left-Bold">
													<?php _e('Opening Hours', 'readymix'); ?>
												</h6>
												<ul>
													<?php
													foreach ($days as $key => $day) {
														$_key = "_display_centre_opening_hour_{$key}";
														if (isset($opening_hours[$_key]) && $opening_hours[$_key]) {
															?>
															<li>
																<span class="day"><?php echo $day; ?></span>
																<span class="time"><?php echo $opening_hours[$_key]; ?></span>
															</li>
															<?php
														} // end check day opening hour
													} // end loop days
													?>
												</ul>
											<?php } // end $opening_hours ?>
										</div><!-- schedule -->

										<div class="schedule-map" id="display_center_individual_map_<?php the_ID(); ?>"
											data-lat="<?php echo $lat; ?>" data-lng="<?php echo $lng; ?>">
										</div><!-- /#display_center_individual_map_<?php the_ID(); ?> -->
									</div><!-- schedule-list -->
									<?php
								} // end loop $display_centers->have_posts;
								wp_reset_postdata();
								?>
							<?php }else{
								?>
								<div class="product-message" style="">No results available</div>
								<?php
							} // end check $display_centers->have_posts; ?>
						</div><!-- /#schedule-list-wrap -->

						<div class="btn-wrap center" id="display-centre-load-more"
							style="<?php echo ($display_centers->max_num_pages > $paged) ? '' : 'display: none;'; ?>">
							<?php if ($display_centers->max_num_pages > $paged) { ?>
								<a href="<?php echo esc_url(add_query_arg($filter, get_term_link($queried_term_id))); ?>"
									class="btn btn-green-houtline small centre-load-more"><?php _e('Load More', 'readymix'); ?></a>
							<?php } ?>
						</div>

					</div>
				</div>
			</div>
		</section>


		<?php
		// $bg_image = get_field('_tax_installer_background_image', 'option');
		// $title = get_field('_tax_installer_title', 'option');
		// $intro = get_field('_tax_installer_intro', 'option');
		// $btn_text = get_field('_tax_installer_button_text', 'option');
		// $btn_url_detail = get_field('_tax_installer_button_url', 'option');
		// $btn_url = isset($btn_url_detail['url']) ? $btn_url_detail['url'] : '#';
		// $btn_target = isset($btn_url_detail['target']) ? "target = " . $btn_url_detail['target'] : '';

		// $style = '';
		// $section_colour = get_field('_tax_installer_section_colour', 'option');

		// if ($section_colour) {
		// 	$style = "style='background-color:" . $section_colour . ";'";
		// }
		?>
</main>
<?php
get_footer();