<?php
/**
 * Brand Family Block.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'brand-family-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-brand-family';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}
$title_content  = get_field( 'title_content' );
$style          = '';
$section_colour = get_field( 'section_colour' );
if ( $section_colour ) {
	$style = "style='background-color:" . $section_colour . ";'";
}
?>
<section class="section-clients">
    <div class="container">
        <div class="section-title">
			<?php echo $title_content; ?>
        </div><!-- section-title -->
        <div class="clients-logo-grid">
			<?php
			if ( have_rows( 'brand_families' ) ) {
				?>

				<?php
				while ( have_rows( 'brand_families' ) ) {
					the_row();
					$logo = get_sub_field( 'logo' );
					$link = get_sub_field( 'link' );
					?>
                    <div class="logo test">
                        <a href="<?php echo esc_url( $link ); ?>" target="_blank">
							<?php
							echo wp_get_attachment_image( $logo['id'], 'full' );
							?>
                        </a>
                    </div><!-- button-wrap -->
					<?php
				}
				?>
				<?php
			}
			?>
        </div><!-- client-logo-grid -->
    </div><!-- container -->
</section><!-- section-clients -->
