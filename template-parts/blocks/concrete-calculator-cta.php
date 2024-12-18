<?php
/**
 * Concrete Calculator CTA Block.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'concrete-calulator-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-concrete-calulator';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}
?>
<section class="block-cta <?php echo $className; ?>" style="background-color:#ffffff;" id="<?php echo $id; ?>">
    <div class="container">
        <div class="cta-row wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <p>
				<?php echo get_field( '_concerete_calculator_cta_block_text' ); ?>
				<?php
				$link = 'javascript:void(0)';
				if ( $calculator_page = get_field( '_concerete_calculator_cta_block_button_link' ) ) {
					$link = esc_url( get_permalink( $calculator_page ) );
				}
				?>                
            </p>
			<div class="button-wrap">
				<a href="<?php echo $link; ?>" class="btn btn-outline-white">
					<?php echo get_field( '_concerete_calculator_cta_block_button_text' ); ?>
				</a>
			</div>
        </div>
    </div>
</section><!-- block-cta -->