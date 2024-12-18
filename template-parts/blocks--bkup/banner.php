<?php
/**
 * banner Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'landing-banner-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'hero hero-parallax landing-hero main-banner';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}
$banner_bg_image     = get_field( 'banner_bg_image' );
$banner_bg_image_mobile     = get_field( 'banner_bg_image_mobile' );
$banner_overlay_text = get_field( 'banner_overlay_text' );
$banner_has_cta      = get_field( 'banner_has_cta' );
?>
<section id="<?php echo $id; ?>" class="hero-banner <?php echo $className; ?>">
    <div class="banner-bg">
		<?php echo wp_get_attachment_image( $banner_bg_image['id'], 'full' ); ?>
		<?php echo wp_get_attachment_image( $banner_bg_image_mobile['id'], 'full', null, array("class"=>"img-mobile") ); ?>
    </div><!-- banner-bg -->
    <div class="container">
        <div class="banner-content">
			<?php
			if ( $banner_overlay_text ) {
				echo $banner_overlay_text;
			}
			if ( $banner_has_cta ) {
				$banner_cta_button = get_field( 'banner_cta_button' );
				?>
                <div class="button-wrap">
                    <a href="<?php echo $banner_cta_button['url']; ?>"
                       target="<?php echo $banner_cta_button['target']; ?>"
                       class="btn btn-white"><?php echo $banner_cta_button['title']; ?></a>
                </div>
				<?php
			}
			?>
        </div><!-- banner-content -->
    </div><!-- container -->
</section><!-- hero-banenr -->