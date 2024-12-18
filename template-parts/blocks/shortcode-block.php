<?php
/**
 * Shortcode Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'shortcode-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-shortcode';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}

$style = '';
if( $color = get_field( '_shortcode_block_background_color' ) ) {
	$style = "background-color: {$color};";
}
?>
<section class="calculator-block-wrapper" style="<?php echo $style; ?>">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<?php if ( $title = get_field( '_shortcode_block_title' ) ) { ?>
					<h4 class="H4-Black-Left"><?php echo $title; ?></h4>
				<?php } ?>

				<?php if ( $description = get_field( '_shortcode_block_info' ) ) { ?>
					<p class="Paragraph-Gray-16px-Left"><?php echo $description; ?></p>
				<?php } ?>
			</div>
			<div class="col-sm-12">
				<?php
				if( $shortcode = get_field( '_shortcode_block_shortcode' ) ) {
					echo do_shortcode( $shortcode );
				}
				?>
			</div>
		</div>
	</div>
</section>