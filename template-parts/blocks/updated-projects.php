<?php
/**
 * Latest From readymix projects Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'latest-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-projects-block';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}
$section_title = get_field( 'section_title' );
$lastest_posts = get_field( 'latest_posts_to_display' );

$lastest_posts_count = count( $lastest_posts );

$style          = '';
$section_colour = get_field( 'section_colour' );

if ( $section_colour ) {
	$style = "style='background-color:" . $section_colour . ";'";
}
?>
<section class="section-latest-projects" <?php echo $style; ?>>
    <div class="container">
        <h2><?php echo $section_title; ?></h2>
    </div>
    <div class="latest-projects-slider">
		<?php
		$counter = 1;
		foreach ( $lastest_posts as $latest_post ):
			$link = get_the_permalink( $latest_post->ID );
            $current_projects_terms = wp_get_post_terms($latest_post->ID, 'readymix_projects_type' );

            $current_concrete_terms = wp_get_post_terms($latest_post->ID, 'readymix_projects_concrete_type' );
			?>
            <div class="slide-card">
                <a class="video-poster popup-video" data-slide="<?php echo $counter; ?>" href="<?php echo esc_url( $link ); ?>">
                <span class="absolute-background-image">
                    <?php echo get_the_post_thumbnail( $latest_post->ID, 'full' ); ?>
                </span>					
                </a>
                <div class="detail">	
                    
				    <ul class="location-tag">
                        <?php
                            if( is_array( $current_projects_terms ) ) {
                                foreach ( $current_projects_terms as $current_projects_term ) {
                                    // make sure display parent terms first
                                    if ( 0 == $current_projects_term->parent ) {
                                        ?>
                                        <li><h5><?php echo $current_projects_term->name; ?></h5></li>
                                        <?php
                                    }
                                } // end foreach loop
                            }
                            ?> 

                            <?php
                            if( is_array( $current_concrete_terms ) ) {
                                foreach ( $current_concrete_terms as $current_concrete_term ) {
                                    // make sure display parent terms first
                                    if ( 0 == $current_concrete_term->parent ) {
                                        ?>
                                        <li><h5><?php echo $current_concrete_term->name; ?></h5></li>
                                        <?php
                                    }
                                } // end foreach loop
                            }
                            ?>
                        </ul>
                    				
                    <h4><?php echo get_the_title( $latest_post->ID ); ?></h4>

                    <a class="link-arrow">
                        <img class="svg" src="<?php echo get_template_directory_uri(); ?>/images/buttons-arrows-long-arrow-right-light_4.svg" alt="">
                    </a>
                    <a href="<?php echo esc_url( $link ); ?>" class="stretched-link"></a>
						
                </div>				
            </div>
			<?php
			$counter ++;
		endforeach;
		?>
    </div><!-- .latest-from-geo-slider -->
    <div id="slider-nav-1" class="slider-nav">
		<?php
		$nav_count = 1;
		while ( $nav_count <= $lastest_posts_count ) {
			?>
            <div class="nav-item"><span></span></div>
			<?php
			$nav_count ++;
		}
		?>
    </div>
</section>