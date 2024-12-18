<?php
/**
 * Project Title Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'project-title-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-project-title';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}

global $post;
$show_tags    = get_field( '_title_area_display_tags' );
$show_socials = get_field( '_title_area_show_social_sharing' );
?>
<section class="title-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1><?php the_title(); ?></h1>
            </div>
        </div>
        <?php if ( $show_tags || $show_socials ) { ?>
            <div class="meta-wrap clearfix">
                <?php
                $current_projects_terms = wp_get_post_terms( get_the_ID(), 'readymix_projects_type' );

                $current_concrete_terms = wp_get_post_terms( get_the_ID(), 'readymix_projects_concrete_type' );
                ?>
                <?php if ( $show_tags  ) { ?>
                    <ul class="location-tag">
                      <?php
                      if( is_array( $current_projects_terms ) ) {
                        foreach ( $current_projects_terms as $current_projects_term ) {
                            // make sure display parent terms first
                            if ( 0 == $current_projects_term->parent ) {
                                ?>
                                <li><?php echo $current_projects_term->name; ?></li>
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
                                <li><?php echo $current_concrete_term->name; ?></li>
                                <?php
                            }
                        } // end foreach loop
                    }
                    ?>
                </ul>
            <?php } // end check $current_concrete_terms ?>

            <?php if ( $show_socials ) { ?>
                <div class="social-links">
                    <span class="title"><?php _e( 'Share', 'readymix' ); ?></span>
                    <a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>&description=<?php the_title(); ?>" target="_blank">
                     <?php get_template_part( 'template-parts/svg-icons/pintirest', 'svg' ) ?>
                 </a>
                 <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank">
                     <?php get_template_part( 'template-parts/svg-icons/facebook', 'svg' ) ?>
                 </a>
                 <a href="https://twitter.com/home?status=<?php the_permalink(); ?> <?php the_title(); ?>" target="_blank">
                     <?php get_template_part( 'template-parts/svg-icons/twitter', 'svg' ) ?>
                 </a>
             </div>
         <?php } ?>
     </div><!-- .meta-wrap -->
 <?php } // end check for tags and social shares ?>
</div>
</section><!-- .title-header -->