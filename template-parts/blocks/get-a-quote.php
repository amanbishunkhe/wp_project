<?php
/**
 * Why Readymix: Get a Quote Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'get-a-quote-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'get-a-quote';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}
$title_content   = get_field( 'text_content','option' );
$banner_bg_image = get_field( 'background_image','option' );
$banner_bg_image_mobile = get_field( 'background_image_mobile','option' );
?>
<section id="<?php echo $id; ?>" class="section-footer-cta <?php echo $className; ?>">
    <div class="banner-bg">
		<?php echo wp_get_attachment_image( $banner_bg_image['id'], 'full' ); ?>
		<?php echo wp_get_attachment_image( $banner_bg_image_mobile['id'], 'full', null, array( "class" => "img-mobile" ) ); ?>
    </div>
    <div class="container">
        <div class="cta-content">
			<?php 
			echo $title_content;
			
			$button_details = get_field( 'button','option' );
			if ( ! empty( $button_details ) ) {
				?>
                <div class="button-wrap">
                    <a href="<?php echo $button_details['url']; ?>"
                       target="<?php echo $button_details['target']; ?>"
                       class="btn btn-green"><?php echo $button_details['title']; ?></a>
                </div>
				<?php
			}
			?>
        </div>
    </div>
</section>