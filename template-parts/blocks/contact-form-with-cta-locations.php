<?php
/**
 * Contact form with CTA and Locations Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'contact-form-with-cta-locations-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-contact-form-with-cta-locations';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}

?>

<div class="quote-form-wrapper" id="<?php echo $id; ?>" >
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="enquiry-wrapper wow fadeInUp">
                    <h4 class="H5-Black-Left"><?php echo get_field( 'section_title' ); ?></h4>
                    <p class="Paragraph-Gray-16px-Left">
						<?php echo get_field( 'info_text' ); ?>
                    </p>

					<?php
					if ( get_field( 'show_info_list' ) == false ) {
						$phone            = get_field( 'phone_number' );
						$request_cta_txt  = get_field( 'request_cta_text' );
						$request_cta_form = get_field( 'request_cta_form' );
						if ( $phone ) {
							?>
                            <div class="actions">
                                <a href="tel:<?php echo $phone; ?>" class="phone"><img
                                            class="svg"
                                            src="<?php echo get_template_directory_uri(); ?>/images/icons-phone-color-primary.svg"
                                            alt=""> <?php echo $phone; ?></a>
								<?php
								if ( $request_cta_txt ) {
									?>
                                    <a href="#callback-module"
                                       class="btn btn-pink light small contact-modal"><?php echo $request_cta_txt; ?></a>
									<?php
								}
								?>
                            </div>
							<?php
						}
						if ( $request_cta_txt ) {
							?>

                            <div id="callback-module" class="mfp-hide callback-form-wrap">
								<?php echo do_shortcode( $request_cta_form ); ?>
                            </div>
							<?php
						}
					} else {
						if ( have_rows( 'info_list' ) ):
							?>
                            <ul>
								<?php
								while ( have_rows( 'info_list' ) ): the_row();
									?>
                                    <li>
										<?php echo get_sub_field( 'list' ); ?>
                                    </li>
								<?php
								endwhile;
								?>
                            </ul>
						<?php
						endif;
					}
					?>
                    <div class="form-main-wrapper">
                        <div class="form-main">
							<?php
							$enquiry_form    = get_field( 'enquiry_form' );
							$show_disclaimer = get_field( 'show_disclaimer' );
							$disclaimer_text = get_field( 'disclaimer_text' );
							if ( $enquiry_form ) {
								echo do_shortcode( $enquiry_form );
							}
							if ( $show_disclaimer == true && $disclaimer_text ) {
								?>

                                <div class="disclaimer-wrap">
                                    <strong><?php echo $disclaimer_text;?></strong>
	                                <?php
	                                $disclaimer_link = get_field( 'disclaimer_link' );
	                                if ( ! empty( $disclaimer_link ) ) {
		                                ?>
                                        <a href="<?php echo esc_url( $disclaimer_link['url'] ); ?>" class="link"
                                           target='_blank'><?php echo $disclaimer_link['title']; ?>
                                            <img class="svg"
                                                 src="<?php echo get_theme_file_uri() . '/images/buttons-arrows-long-arrow-right-light-pink.svg'; ?>"
                                                 alt=""></a>
		                                <?php
	                                }
	                                ?>
                                </div><!-- disclaimer-wrap -->
								<?php
							}
							?>
                        </div><!-- form-main -->
                    </div><!-- form-main-wrapper -->
                </div><!-- enquiry-wrapper -->
            </div>

			<?php
			$show_cta_section= get_field('show_cta_section');
				$show_title = get_field( 'show_title' );
				$cta_title = get_field( 'cta_box_title' );
				$cta_info_text = get_field( 'cta_info_text' );
				$cta_btn_text = get_field( 'cta_button_text' );
				$cta_btn_link = get_field( 'cta_button_link' );

			?>
            <div class="col-md-5">
                <div class="calulate-address-wrapper">
					
					<?php if( $show_cta_section == 'Yes' ): ?>
					<div class="quote-calculate-wrapper">
							<?php
							$term = term_exists('qld','display-center-state');
							if( $term !==0 && $term !== null ){
								$default_display_center_link = get_term_link('qld','display-center-state');
							}
							
							if ( $show_title ==  true && $cta_title ) {
								?>
								<h5 class="H5-Black-Left wow fadeInUp">
									<?php echo $cta_title; ?>
								</h5>
								<?php
							}

							if ( $show_title == false ){
							?>
								<h5 class="H5-Black-Left wow fadeInUp">
									<?php echo $cta_info_text; ?>
								</h5>

								<?php
							}else{
								?>
								<p class="wow fadeInUp">
									<?php echo $cta_info_text; ?>
								</p>
								<?php
							}


							if ($cta_btn_text) {							
								?>
								<a href="<?php echo $cta_btn_link ? esc_url($cta_btn_link) : $default_display_center_link; ?>"
								class="btn btn-pink light small wow fadeInUp">
								<?php echo $cta_btn_text; ?>
							
								</a>
								<?php
							}
						?>
					</div><!-- quote-calculate-wrapper -->
					<?php endif; ?>

					<?php
					$show_location     = get_field( 'show_location' );
					$location_title    = get_field( 'location_title' );
					$location_subtitle = get_field( 'location_subtitle' );
					if ( $show_location == 'Yes' ) {
						?>
                        <div class="quote-address">
							<?php
							if ( $location_title ) {
								?>
                                <h5 class="H6-Black-Left-Bold wow fadeInUp">
									<?php echo $location_title; ?>
                                </h5>
								<?php
							}
							if ( $location_subtitle ) {
								?>
                                <h4 class="H5-Black-Left wow fadeInUp">
									<?php echo $location_subtitle; ?>
                                </h4>
								<?php
							}
							if ( have_rows( 'location_info' ) ):
								?>
                                <ul class="wow fadeInUp">
									<?php
									while ( have_rows( 'location_info' ) ): the_row();
										?>
                                        <li>
                                            <div class="icon">
                                                <img class="svg" src="<?php echo get_sub_field( 'icon' )['url']; ?>">
                                            </div>
                                            <div class="list">
												<?php
												$info      = get_sub_field( 'info' );
												$info_type = get_sub_field( 'info_type' );
												if ( $info_type == 'Text' ) {
													echo $info;
												} else if ( $info_type == 'Phone' ) {
													?>
                                                    <a href="tel:<?php echo $info; ?>"><?php echo $info; ?></a>
													<?php
												} else if ( $info_type == 'Link' ) {
													?>
                                                    <a href="<?php echo $info ? esc_url( $info ) : '#'; ?>"
                                                       target="_blank"><?php echo esc_html( $info ); ?></a>
													<?php
												}
												?>
                                            </div>
                                        </li>
									<?php
									endwhile;
									?>
                                </ul>
							<?php
							endif;
							?>

                        </div><!-- quote-address -->
						<?php
					}
					?>
                </div><!-- calulate-address-wrapper -->
            </div>
        </div>
    </div>
</div><!-- quote-form-wrapper -->