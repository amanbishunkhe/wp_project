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

$use_from_global = get_field( 'use_from_global_option_' );
if ( $use_from_global ) {
	$title_content  = get_field( 'brand_family_title_content', 'option' );
	$style          = '';
	$section_colour = get_field( 'brand_family_section_colour', 'option' );
	if ( $section_colour ) {
		$style = "style='background-color:" . $section_colour . ";'";
	}
	?>
	<section class="section-clients<?php echo ($title_content ? '' : ' no-sec-title'); ?> <?php echo $className; ?>" <?php echo $style; ?> id="<?php echo $id; ?>" >
		<div class="container">
			<div class="section-title">
				<?php echo $title_content; ?>
			</div>
			<div class="clients-logo-grid">
				<?php
				$target_bl = '';
				if ( have_rows( 'brand_family_list', 'option' ) ) {
					while ( have_rows( 'brand_family_list', 'option' ) ) {
						the_row();
						$logo = get_sub_field( 'logo' );
						$link = get_sub_field( 'link' );
						$target_bl = 'target="_blank"';
						if( $link == '#'){
							$link = home_url();
							$target_bl = '';
						}
						?>
						<div class="logo readymix-ex-logo">
							<a href="<?php echo esc_url( $link ); ?>" <?php echo $target_bl; ?>>
								<?php
								echo wp_get_attachment_image( $logo['id'], 'full' );
								?>
							</a>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>
	</section>
	<?php
} else {
	$title_content  = get_field( 'title_content' );
	$style          = '';
	$section_colour = get_field( 'section_colour' );
	if ( $section_colour ) {
		$style = "style='background-color:" . $section_colour . ";'";
	}
	?>
	<section class="section-clients<?php echo ($title_content ? '' : ' no-sec-title'); ?>" <?php echo $style; ?>>
		<div class="container">
			<?php if ( $title_content ) : ?>
				<div class="section-title">
					<?php echo $title_content; ?>
				</div>
			<?php endif; ?>
			<div class="clients-logo-grid">
				<?php
				$target_bl = '';
				if ( have_rows( 'brand_families' ) ) {
					while ( have_rows( 'brand_families' ) ) {
						the_row();
						$logo = get_sub_field( 'logo' );
						$link = get_sub_field( 'link' );
						$target_bl = 'target="_blank"';
						if( $link == '#' ){
							$link = site_url();
							$target_bl = '';
						}
						?>
						<div class="logo">
							<a href="<?php echo esc_url( $link ); ?>" <?php echo $target_bl; ?> >
								<?php
								echo wp_get_attachment_image( $logo['id'], 'full' );
								?>
							</a>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>
	</section>
	<?php
}