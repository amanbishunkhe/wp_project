<?php
/**
 * Guided Selling Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'guided-selling-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-guided-selling';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}
$bg_image = get_field( 'background_image' );
$bg_image_mobile = get_field( 'background_image_mobile' );
$title    = get_field( 'title' );
$intro    = get_field( 'intro' );
$style          = '';
$section_colour = get_field( 'section_colour' );
if ( $section_colour ) {
	$style = "style='background-color:" . $section_colour . ";'";
}
?>
<section id="cta-parallax" class="parallax-cta cta-right" <?php echo $style; ?>>
    <div class="absolute-background-image skrollable skrollable-between"
        data-bottom-top="top: -100px"
        data-center="top: 0px;"
        data-top-bottom="top: 100px"
        data-anchor-target="#cta-parallax">
                 <img src="<?php echo wp_get_attachment_image_url( $bg_image['id'], 'full' ); ?>" alt="">
                 <img class="img-mobile" src="<?php echo wp_get_attachment_image_url( $bg_image_mobile['id'], 'full' ); ?>" alt="">
    </div><!-- bcg -->
    <div class="container clearfix">
        <div class="cta-box wow fadeInUp">
            <h3><?php echo $title; ?></h3>
            <p><?php echo $intro; ?></p>
        </div><!-- cta-box -->
    </div><!-- container -->
</section><!-- parallax-cta -->
