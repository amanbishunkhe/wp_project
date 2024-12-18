<?php
/**
 * Project Content Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'project-content-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-project-content';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}

global $post;

$project_details['application']       = get_field('_project_showcase_content_application');
$project_details['product']           = get_field('_project_showcase_content_product');
$project_details['location']          = get_field('_project_showcase_content_location');
$project_details['installer_int_ext'] = get_field('_project_showcase_content_installer_internal_external');
$project_details['polisher_link']     = get_field('_project_showcase_content_polishers');
$project_details['architect']         = get_field('_project_showcase_content_architect');
$project_details['architect_link']    = get_field('_project_showcase_content_architect_link');
$project_details['builder']           = get_field('_project_showcase_content_builder');
$project_details['builder_link']      = get_field('_project_showcase_content_builder_link');
$project_details['photographer']      = get_field('_project_showcase_content_photographer');
$project_details['photographer_link'] = get_field('_project_showcase_content_photographer_link');
$project_details['concrete']          = true;

// clean array
$project_details = array_filter($project_details);
?>
<div class="gradient-bg">
	<div class="content-sec clearfix">

		<section class="intro-module">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-5 order-md-12">
						<?php if ($project_details) { ?>
							<div class="right-block wow fadeInUp">
								<div class="aside-list">
									<h5><?php _e('Project Details', 'readymix'); ?></h5>
									<div class="aside-content">
										<ul>
											<?php if (isset($project_details['application']) && $project_details['application']) { ?>
												<li>
													<div class="caption"><?php _e('Application', 'readymix'); ?></div>
													<div class="info"><?php echo $project_details['application']; ?></div>
												</li>
											<?php } // end application 
											?>

											<?php if (isset($project_details['product']) && 0 < count($project_details['product'])) { ?>
												<li>
													<div class="caption"><?php _e('Product', 'readymix'); ?></div>
													<div class="info">
														<?php foreach ($project_details['product'] as $product) { ?>
															<a href="<?php echo esc_url(get_the_permalink($product)); ?>">
																<?php
																echo trim($product->post_title);
																if (end($project_details['product']) !== $product) {
																	echo ', ';
																} ?>
															</a>
														<?php } ?>
													</div>
												</li>
											<?php } // end product 
											?>

											<?php
											if (isset($project_details['concrete']) && true === $project_details['concrete']) {
												if ($concrete_type = wp_get_post_terms($post->ID, 'readymix_projects_concrete_type')) {
													if (!is_wp_error($concrete_type)) {
											?>
														<li>
															<div class="caption"><?php _e('Concrete Type', 'readymix'); ?></div>
															<div class="info"><?php echo $concrete_type[0]->name; ?></div>
														</li>
											<?php
													}
												}
											} // end concrete
											?>

											<?php if (isset($project_details['location']) && $project_details['location']) { ?>
												<li>
													<div class="caption"><?php _e('Location', 'readymix'); ?></div>
													<div class="info"><?php echo $project_details['location']; ?></div>
												</li>
											<?php } // end location 
											?>

											<?php /* if ( isset( $project_details['installer_int_ext'] ) && $project_details['installer_int_ext'] ) { ?>
												<li>
													<div class="caption"><?php _e( 'Installer', 'readymix' ); ?></div>
													<div class="info">
														<?php
														$name = '';
														$link = '';
														$ext  = false;
														if ( 'internal' == $project_details['installer_int_ext'] ) {
															$installer = get_field( '_project_showcase_content_installer' );
															$name      = $installer->post_title;
															$link      = esc_url( get_permalink( $installer ) );
														} else {
															$installer = get_field( '_project_showcase_content_external_installer' );
															$name      = ( isset( $installer['_project_showcase_content_external_installer_name'] ) && ( $installer['_project_showcase_content_external_installer_name'] ) ) ? $installer['_project_showcase_content_external_installer_name'] : '';
															$link      = ( isset( $installer['_project_showcase_content_external_installer_website'] ) && ( $installer['_project_showcase_content_external_installer_website'] ) ) ? esc_url( $installer['_project_showcase_content_external_installer_website'] ) : '';
															if( $link ) {
																$ext = 'target="_blank"';
															}
														}
														?>
														<a href="<?php echo $link ? $link : 'javascript:void(0);'; ?>" <?php echo $ext; ?>>
															<?php
															echo $name;
															if ( $link ) {
																get_template_part( 'template-parts/svg-icons/button-arrows-long-arrow-right-light-gray', 'svg' );
															}
															?>
														</a>
													</div>
												</li>
											<?php } // end installer */ ?>

											<?php

											if (isset($project_details['installer_int_ext']) && $project_details['installer_int_ext']) {
												$name = '';
												$link = '';
												//$ext  = false;
												if ('internal' == $project_details['installer_int_ext']) {
													$installer = get_field('_project_showcase_content_installer');
													$name      = $installer->post_title;
													$link      = esc_url(get_permalink($installer));
												} else {
													$installer = get_field('_project_showcase_content_external_installer');
													$name      = (isset($installer['_project_showcase_content_external_installer_name']) && ($installer['_project_showcase_content_external_installer_name'])) ? $installer['_project_showcase_content_external_installer_name'] : '';
													$link      = (isset($installer['_project_showcase_content_external_installer_website']) && ($installer['_project_showcase_content_external_installer_website'])) ? esc_url($installer['_project_showcase_content_external_installer_website']) : '';
													if ($link) {
														$ext = 'target="_blank"';
													}
												}

												if ($name) {
											?>
													<li>
														<div class="caption"><?php _e('Installer', 'readymix'); ?></div>
														<div class="info">
															<a href="<?php echo $link ? $link : 'javascript:void(0);'; ?>" <?php echo $ext; ?>>
																<?php echo $name; ?>
															</a>
														</div>
													</li>
											<?php
												}
											} // end installer
											?>


											<?php if (isset($project_details['polisher_link']) && $project_details['polisher_link']) { ?>
												<li>
													<div class="caption"><?php _e('Polisher', 'readymix'); ?></div>
													<div class="info">
														<?php

														$polisher = $project_details['polisher_link'];
														$name      = $polisher->post_title;
														$link      = esc_url(get_the_permalink($polisher));
														?>
														<a href="<?php echo $link ? $link : 'javascript:void(0);'; ?>" <?php echo $ext; ?>>
															<?php
															echo $name;
															if ($link) {
																get_template_part('template-parts/svg-icons/button-arrows-long-arrow-right-light-gray', 'svg');
															}
															?>
														</a>
													</div>
												</li>
											<?php } // end polisher 
											?>

											<?php if (isset($project_details['architect']) && $project_details['architect']) { ?>
												<?php
												$style = '';
												$link  = 'javascript:void(0);';
												if (isset($project_details['architect_link']) && $project_details['architect_link']) {
													$link = esc_url($project_details['architect_link']);
												} else {
													$style = 'style="pointer-events: none;"';
												}
												?>
												<li>
													<div class="caption"><?php _e('Architect', 'readymix'); ?></div>
													<div class="info">
														<a href="<?php echo $link; ?>" <?php echo $style; ?> target="_blank">
															<?php if ('' === $style) { ?>
																<?php get_template_part('template-parts/svg-icons/icon-globe', 'svg'); ?>
															<?php } ?>
															<?php echo $project_details['architect']; ?>
														</a>
													</div>
												</li>
											<?php } // end architect 
											?>

											<?php if (isset($project_details['builder']) && $project_details['builder']) { ?>
												<?php
												$style = '';
												$link  = 'javascript:void(0);';
												if (isset($project_details['builder_link']) && $project_details['builder_link']) {
													$link = esc_url($project_details['builder_link']);
												} else {
													$style = 'style="pointer-events: none;"';
												}
												?>
												<li>
													<div class="caption"><?php _e('Builder', 'readymix'); ?></div>
													<div class="info">
														<a href="<?php echo $link; ?>" <?php echo $style; ?>>
															<?php if ('' === $style) { ?>
																<?php get_template_part('template-parts/svg-icons/icon-globe', 'svg'); ?>
															<?php } ?>
															<?php echo $project_details['builder']; ?>
														</a>
													</div>
												</li>
											<?php } // end builder 
											?>

											<?php if (isset($project_details['photographer']) && $project_details['photographer']) { ?>
												<?php
												$style = '';
												$link  = 'javascript:void(0);';
												if (isset($project_details['photographer_link']) && $project_details['photographer_link']) {
													$link = esc_url($project_details['photographer_link']);
												} else {
													$style = 'style="pointer-events: none;"';
												}
												?>
												<li>
													<div class="caption"><?php _e('Photographer', 'readymix'); ?></div>
													<div class="info">
														<a href="<?php echo $link; ?>" <?php echo $style; ?>>
															<?php if ('' === $style) { ?>
																<?php get_template_part('template-parts/svg-icons/icon-globe', 'svg'); ?>
															<?php } ?>
															<?php echo $project_details['photographer']; ?>
														</a>
													</div>
												</li>
											<?php } // end photographer 
											?>
										</ul>
									</div>
								</div>
							</div><!-- right-block -->
						<?php } // end check $project_details 
						?>
					</div><!-- /.col-md-5 -->

					<div class="col-lg-8 col-md-7 order-md-1">
						<?php if (have_rows('_project_showcase_content_project_contents')) { ?>
							<div class="left-block wow fadeInUp">
								<?php
								while (have_rows('_project_showcase_content_project_contents')) {
									the_row();
									$row_layout = get_row_layout();
									if ('_project_showcase_content_flexible_layout_title' == $row_layout) {
										if ($title = get_sub_field('_project_showcase_content_flexible_layout_title_title')) {
								?>
											<h4 class="H5-Black-Left"><?php echo $title; ?></h4>
										<?php
										}
									} else if ('_project_showcase_content_flexible_layout_blockquote' == $row_layout) {
										$blockquote = get_sub_field('_project_showcase_content_flexible_layout_blockquote_blockquote');
										$author     = get_sub_field('_project_showcase_content_flexible_layout_blockquote_author');
										$position   = get_sub_field('_project_showcase_content_flexible_layout_blockquote_position');
										?>
										<blockquote>
											<?php echo $blockquote; ?>
											<?php if ($author) { ?>
												<span class="author"><?php echo $author; ?></span>
											<?php } ?>

											<?php if ($position) { ?>
												<span class="designation"><?php echo $position; ?></span>
											<?php } ?>
										</blockquote>
										<?php
									} else if ('_project_showcase_content_flexible_layout_content' == $row_layout) {
										the_sub_field('_project_showcase_content_flexible_layout_content_content');
									} else if ('_project_showcase_content_flexible_layout_featured_product' == $row_layout) {
										if ($products = get_field('_project_showcase_content_product')) {
										?>
											<div class="featured-products">
												<h4><?php _e('Products Featured', 'readymix'); ?></h4>
												<?php
												foreach ($products as $product) {
													$locations     = wp_get_post_terms($product->ID, 'readymix_state');
													$product_image = '';
													if (has_post_thumbnail($product)) {
														$product_image = get_the_post_thumbnail($product, 'thumbnail');
													}
												?>
													<div class="featured-product-item">
														<a href="<?php echo esc_url(get_permalink($product)); ?>">
															<span class="img-col absolute-background-image">
																<?php echo $product_image; ?>
															</span>
														</a>
														<div class="detail clearfix">
															<div class="inner">
																<?php if (is_array($locations)) { ?>
																	<ul class="location-tag">
																		<?php
																		foreach ($locations as $location) {
																			if (0 == $location->parent) {
																		?>
																				<li><?php echo $location->name; ?></li>
																				<?php
																				foreach ($locations as $_location) {
																					if ($_location->parent == $location->term_id) {
																				?>
																						<li><?php echo $_location->name; ?></li>
																			<?php
																						break;
																					} // end compare/check term parent
																				} // end loop $locations as $_location
																				break;
																			} // enc check parent term
																		} // end loop $locations

																		if (count($locations) > 2) {
																			?>
																			<li><?php _e('+more', 'readymix'); ?></li>
																		<?php
																		}
																		?>
																	</ul>
																<?php } ?>
																<h4>
																	<a href="<?php echo esc_url(get_permalink($product)); ?>">
																		<?php echo $product->post_title; ?>
																	</a>
																</h4>
															</div>
														</div>
													</div><!-- .featured-product-item -->
												<?php } // end loop $products 
												?>
											</div><!-- .featured-products -->
								<?php
										} // end check $products
									} // end compare $row_layout
								} // end loop while have_rows "_project_showcase_content_project_contents"
								?>
							</div><!-- left-block -->
						<?php } // end check have_rows "_project_showcase_content_project_contents" 
						?>
					</div><!-- /.col-md-7 -->
				</div><!-- /.row -->
			</div><!-- /.container -->
		</section><!-- two-block-wrapper -->

	</div><!-- content-sec -->
</div>