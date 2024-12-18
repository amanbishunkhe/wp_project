<?php
/**
 * Hero Slider Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'hero-slider-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-hero-slider';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}

if ( $hero_slider_images = get_field( '_hero_slider_images' ) ) {
	$nav_items = '';
	?>
    <section class="hero hero-slider">
        <div class="hero-slider-main">
			<?php 
            $count = 0;
            foreach ( $hero_slider_images as $key => $hero_slider_image ) { ?>
                <div class="hero-item" id="id-<?php echo( $key + 1 ); ?>">
                    <div class="bg-image slider-parallax"

                         data-top-bottom="transform: translateY(200px);"
                         data-center-bottom="transform: translateY(100px);"
                         data-center="transform: translateY(0px);"
                         data-center-top="transform: translateY(0px);"
                         data-bottom-top="transform: translateY(0px);"


                         data-anchor-target="#id-<?php echo( $key + 1 ); ?>"

                         >
                        <div class="absolute-background-image"><?php echo wp_get_attachment_image( $hero_slider_image['id'], 'full' ); ?></div>                        
                    </div>
                    <a href="<?php echo wp_get_attachment_image_url( $hero_slider_image['id'], 'full' ); ?>" class="abs-pop-icon">
	                        <?php get_template_part( 'template-parts/svg-icons/expand', 'svg' ) ?>
                        </a>
                </div>
				<?php
				
				ob_start();
				?>
                <div class="nav-item">
					<?php get_template_part( 'template-parts/svg-icons/elements-carousel-selected-copy-2', 'svg' ) ?>
                </div>
				<?php
				$nav_items .= ob_get_clean();
                $count++;
			}
			?>
        </div>

        <?php if( $count > 1 ) : ?>
            <div class="container hero-slider-container">
                <div id="slider-nav-hero" class="hero-nav slider-nav">
    				<?php echo $nav_items; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>
<?php } ?>