<?php
/**
 * FAQ Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'faq-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'faq';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}

$title        = get_field( '_faq_block_title' );
$description  = get_field( '_faq_block_description' );
$popular_only = get_field( '_faq_block_list_popular_faqs_only' );

$post_id = get_the_ID(); 
$block_id = esc_attr( $block['id'] );
$unique_block_id = esc_attr( $block['metadata']['name'] );

$active_faq_topic = filter_input( INPUT_GET, '_tab' );

?>
<section class="faq-wrapper <?php echo ( $active_faq_topic ) ? 'faq-do-scroll' : ''; ?>" id="<?php echo $id; ?>">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
				<?php if ( $title ) { ?>
                    <h2 class="H4-Black-Left"><?php echo $title; ?></h2>
				<?php } ?>

				<?php if ( $description ) { ?>
                    <p class="Paragraph-Gray-16px-Left"><?php echo $description; ?></p>
				<?php } ?>

				<?php
				if ( $popular_only ) { // for popular block only
					if ( $faqs ) {
						?>
                        <div class="accordion-wrap">
                            <div id="accordion">
								<?php foreach ( $faqs as $key => $faq ) { ?>
                                    <div class="card">
                                        <div class="card-header" id="heading<?php echo $key; ?>">
                                            <h5 class="mb-0">
                                                <button class="collapsed" data-toggle="collapse"
                                                        data-target="#collapse<?php echo $key; ?>"
                                                        aria-expanded="true"
                                                        aria-controls="collapse<?php echo $key; ?>">
													<?php echo $faq->post_title; ?>
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapse<?php echo $key; ?>" class="collapse"
                                             aria-labelledby="heading<?php echo $key; ?>"
                                             data-parent="#accordion">
                                            <div class="card-body">
												<?php echo apply_filters( 'the_content', $faq->post_content ); ?>

												<?php
												if ( $links = get_field( '_faq_links', $faq->ID ) ) {
													foreach ( $links as $link ) {
														$_link      = $link['_faq_link'];
														$new_window = $link['_faq_link__new_window'];
														?>
                                                        <a href="<?php echo $_link ? esc_url( $_link ) : ''; ?>"
                                                           class="arrow-link" <?php echo ( $new_window ) ? 'target="_blank"' : ''; ?>>
															<?php echo $link['_faq_link_text']; ?>
                                                            <span>
                                                                <?php locate_template( 'template-parts/svg-icons/buttons-arrows-long-arrow-right-light.svg', true, false ); ?>
                                                            </span>
                                                        </a>
                                                        <br/>
														<?php
													}
												} // end check $links
												?>
                                            </div>
                                        </div>
                                    </div>
								<?php } // end loop $faq ?>
                            </div><!-- accordion -->

							<?php /* if ( $faq_page ) { ?>
                                <div class="link-wrap">
                                    <a href="<?php echo esc_url( get_permalink( $faq_page ) ); ?>" class="arrow-link">
										<?php _e( 'See All', 'readymix' ); ?>
                                        <span>
                                        <?php locate_template( 'template-parts/svg-icons/buttons-arrows-long-arrow-right-light.svg', true, false ); ?>
                                    </span>
                                    </a>
                                </div><!-- .link-wrap -->
							<?php } // end check $faq_page */ ?>

                        </div><!-- .accordion-wrap -->
						<?php
					} // end check $faqs
				} else { ?>
					<?php
                    $faq_topics = get_field( 'choose_faq_terms' );

					/* $faq_topics = get_terms(
						array(
							'taxonomy'   => 'faq-topic',
							'hide_empty' => false,
                            // 'orderby' => 'term_order',
                            // 'order' => 'DESC'
						)
					); */

					if ( $faq_topics ) { // check $faq_topics
						?>
                        <div class="sibebar-toggle-wrapper" id="first-faq" >
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="sibebar faq-topics-sidebar">
                                        <h4 class="mobile-visible"><?php _e( 'Filter by topic', 'readymix' ); ?></h4>
                                        <div class="filter-row-sidebar">
                                            <ul class="selection-option-list ">
                                                 <li class="always">
                                                     <a href="javascript:void(0);">
                                                         <?php
                                                         if( $active_faq_topic ) {
                                                             foreach( $faq_topics as $faq_topic ) {
                                                                 if( intval( $active_faq_topic ) === $faq_topic->term_id ) {
                                                                     echo $faq_topic->name;
                                                                 }
                                                             }
                                                         }
                                                         else {
	                                                         echo $faq_topics[0]->name;
                                                         }
                                                         ?>
                                                     </a>
                                                 </li>
                                                 <?php foreach ( $faq_topics as $key => $faq_topic ) { ?>
                                                    <?php
                                                    $active = '';
                                                    if( $active_faq_topic ) {
                                                        if( intval( $active_faq_topic ) === $faq_topic->term_id ) {
                                                            $active = 'active';
                                                        }
                                                    }
                                                    else {
                                                        if( 0 === $key ) {
                                                            $active = 'active';
                                                        }
                                                    }
                                                    ?>
                                                    <li <?php echo ( 0 === $key ) ? 'style="display: none;"' : ''; ?>>
                                                        <a href="javascript:void(0)"
                                                        data-faq_topic="<?php echo $faq_topic->term_id; ?>"
                                                        class="faq-topic <?php echo $active; ?>">
                                                        <?php echo $faq_topic->name; ?>
                                                    </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div><!-- sibebar -->
                                </div>

                                <div class="col-md-8">
									<?php foreach ( $faq_topics as $key => $faq_topic ) { ?>
										<?php
										$term_id = $faq_topic->term_id;
										$faqs    = get_posts(
											array(
												'post_type'      => 'faq',
												'post_status'    => 'publish',
												'posts_per_page' => - 1,
												'tax_query'      => array(
													array(
														'taxonomy' => $faq_topic->taxonomy,
														'field'    => 'slug',
														'terms'    => $faq_topic->slug
													)
												)
											)
										);

										$faq_active = '';
										if( $active_faq_topic ) {
											if( intval( $active_faq_topic ) === $faq_topic->term_id ) {
												$faq_active = 'active-content';
											}
										}
										else {
											if( 0 === $key ) {
												$faq_active = 'active-content';
											}
										}
										?>
                                        <div class="toggle-content-wrap faq-topic-<?php echo $term_id; ?>-contents <?php echo $faq_active; ?>">
                                            <h4 class="H5-Black-Left"><?php echo $faq_topic->name; ?></h4>
											<?php if ( $faqs ) { ?>
                                                <div class="accordion-wrap">
                                                    <div id="accordion-<?php echo $term_id; ?>">
														<?php foreach ( $faqs as $faq_key => $faq ) { ?>
                                                            <div class="card">
                                                                <div class="card-header"
                                                                     id="heading<?php echo $faq->ID; ?>">
                                                                    <h5 class="mb-0">
                                                                        <button class="collapsed"
                                                                                data-toggle="collapse"
                                                                                type="button"
                                                                                data-target="#<?php echo $term_id ?>-collapse<?php echo $faq->ID; ?>"
                                                                                aria-expanded="false"
                                                                                aria-controls="collapse<?php echo $faq->ID; ?>">
																			<?php echo $faq->post_title; ?>
                                                                        </button>
                                                                    </h5>
                                                                </div>

                                                                <div id="<?php echo $term_id ?>-collapse<?php echo $faq->ID; ?>"
                                                                     class="collapse <?php // echo ( 0 === $faq_key ) ? 'show' : ''; ?>"
                                                                     aria-labelledby="heading<?php echo $faq->ID; ?>"
                                                                     data-parent="#accordion-<?php echo $term_id; ?>">
                                                                    <div class="card-body">
																		<?php echo apply_filters( 'the_content', $faq->post_content ); ?>

																		<?php
																		if ( $links = get_field( '_faq_links', $faq->ID ) ) {
																			foreach ( $links as $link ) {
																				$_link      = $link['_faq_link'];
																				$new_window = $link['_faq_link__new_window'];
																				?>
                                                                                <div class="button-wrap">
                                                                                    <a href="<?php echo $_link ? esc_url( $_link ) : ''; ?>"
                                                                                    class="btn btn-link" <?php echo ( $new_window ) ? 'target="_blank"' : ''; ?>>
                                                                                        <?php echo $link['_faq_link_text']; ?>
                                                                                    </a>
                                                                                </div>
                                                                                <?php
																			}
																		} // end check $links
																		?>

                                                                    </div><!-- card-body -->
                                                                </div><!-- collapse<?php echo $faq->ID; ?> -->
                                                            </div><!-- card -->
														<?php } // end loop $faqs ?>
                                                    </div><!-- accordion -->
                                                </div>
											<?php } // end check $faqs ?>
                                        </div><!-- toggle-content-wrap -->
									<?php } // end loop $faq_topics ?>
                                </div><!-- col-md-8 -->
                            </div><!-- row -->
                        </div><!-- sibebar-toggle-wrapper -->
					<?php } // end check $faq_topics 
                    
                    ?>
				<?php } // end check else for $popular_only ?>

            </div>
        </div><!-- .col-sm-12 -->
    </div><!-- .row -->
</section><!-- faq-wrapper -->
