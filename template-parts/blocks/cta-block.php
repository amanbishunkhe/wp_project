<?php
/**
 * Find Installer Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'readymix-cta-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-cta';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}


$bg_image       = get_field( 'background_image' );
$title          = get_field( 'title' );
$intro          = get_field( 'intro' );
$btn_url_detail = get_field( 'button_url' );
$btn_url        = isset( $btn_url_detail['url'] ) ? $btn_url_detail['url'] : '#';
$btn_target     = isset( $btn_url_detail['target'] ) ? "target = " . $btn_url_detail['target'] : '';
$btn_text       = isset( $btn_url_detail['title'] ) ? $btn_url_detail['title'] : 'VISIT READYMIX';

$style          = '';
$section_colour = get_field( 'section_colour' );

if ( $section_colour ) {
	$style = "style='background-color:" . $section_colour . ";'";
}
?>
<section class="block" <?php echo $style; ?> id="<?php echo $id; ?>" >
    <div class="container">
        <div class="full-cta">
            <div class="absolute-background-image">
				<?php echo wp_get_attachment_image( $bg_image['id'], 'full' ); ?>
            </div>
            <div class="nest-inside">
                <h2><?php echo $title; ?></h2>
                <p><?php echo $intro; ?></p>
                <div class="button-wrap">
                    <a href="<?php echo $btn_url; ?>" class="btn btn-link link-white" <?php echo $btn_target; ?> ><?php echo $btn_text; ?> <img src="<?php echo get_template_directory_uri(); ?>/images/buttons-arrows-long-arrow-right-light.svg" alt="" class="svg"></a>
                </div>
            </div>
        </div><!-- .full-cta -->
    </div>
</section><!-- .block -->