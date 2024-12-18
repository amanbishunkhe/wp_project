<?php
/**
 * Why Stone: Image and Content Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'zig-zag-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'zig-zag';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}

$section_containter_size = get_field( 'section_containter_size' );

if ( $section_containter_size == 1 ) {
	$class = 'full-width';
} else {
	$class = 'container-width';
}
?>
<section class="left-right-wrapper <?php echo $class; ?>" id="<?php echo $id; ?>" >
	<?php
	if ( have_rows( 'zig_zag_contents' ) ) :
		?>
		<div class="container">
			<div class="left-right-main-wrap">
				<?php
				while ( have_rows( 'zig_zag_contents' ) ) :
					the_row();
					?>
					<div class="<?php echo strtolower( ( get_sub_field( 'image_position' ) ) ); ?>-image text-wrap wow fadeInUp" style="background-color: <?php echo get_sub_field( 'section_color' ); ?>">
						<div class="img-wrap">
							<img src="<?php echo get_sub_field( 'image' )['url']; ?>" alt="<?php echo get_sub_field( 'image' )['alt']; ?>">
						</div>
						<div class="content-wrap" style="color:<?php echo get_sub_field( 'content_colour' ); ?>">
							<h4 class="<?php echo ($section_containter_size == 1 ? 'h2' : ''); ?>" style="color:<?php echo get_sub_field( 'content_colour' ); ?>">
								<?php echo get_sub_field( 'title' ); ?> 
							</h4>
							<?php echo get_sub_field( 'content' ); ?>
							<?php
							$show_btn  = get_sub_field( 'show_button' );
							$btn_text  = get_sub_field( 'button_text' );
							$btn_link  = get_sub_field( 'button_link' );
							$btn_class = get_sub_field( 'button_class' );
							if ( $show_btn == true ) {
								?>
								<div class="button-wrap">
									<a href="<?php echo $btn_link ? esc_url( $btn_link ) : '#'; ?>" class="btn btn-link <?php echo $btn_class; ?> <?php echo ($section_containter_size == 1 ? 'btn-outline-white' : ''); ?>"><?php echo $btn_text; ?></a>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php
				endwhile;
				?>
			</div>
		</div>
	<?php endif; ?>
</section>
