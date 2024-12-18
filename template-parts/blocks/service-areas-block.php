<?php
/**
 * Popular Products Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'service-areas-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = '';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}

$section_color   = get_field( 'section_color' );
$section_title   = get_field( 'section_title' );
$section_content = get_field( 'section_content' );
?>

<section class="section-service-areas <?php echo $className; ?>" style="background-color: <?php echo $section_color; ?>;">
	<div class="container-fluid">
		<div class="services-area-wrapper">
			<div class="content-area">
				<?php
				if ( $section_title || $section_content ) :
					?>
					<div class="section-title">
						<?php if ( $section_title ) : ?>
							<h2><?php echo $section_title; ?></h2>
							<?php
						endif;

						if ( $section_content ) :
							echo $section_content;
						endif;
						?>
					</div>
				<?php endif; ?>

				<?php if ( have_rows( 'button_list' ) ) : ?>

					<ul class="nav-tabs">
					<?php
					while ( have_rows( 'button_list' ) ) :
						the_row();
						$buttons        = get_sub_field( 'buttons' );
						$data_id        = 'nav-item-' . str_replace( ' ', '-', strtolower( $buttons ) );
						$row_index      = get_row_index();
						$active_class   = $row_index == 1 ? ' active' : '';
						$has_content    = get_sub_field( 'has_content_below_the_button' );
						$button_content = get_sub_field( 'button_content' );
						?>
						<li class="nav-item <?php echo $active_class; ?>" data-id="<?php echo $data_id; ?>">
							<span class="title"><?php echo $buttons; ?></span>

							<?php if ( $has_content ) : ?>
								<p><?php echo $button_content; ?></p>
							<?php endif; ?>
						</li>
					<?php endwhile; ?>
					</ul>
				<?php endif; ?>
			</div>

			<?php if ( have_rows( 'button_list' ) ) : ?>
				<div class="image-area">

					<?php
					while ( have_rows( 'button_list' ) ) :
						the_row();
						$buttons        = get_sub_field( 'buttons' );
						$data_id        = 'nav-item-' . str_replace( ' ', '-', strtolower( $buttons ) );
						$map_image      = get_sub_field( 'map_image' );
						$row_index      = get_row_index();
						$active_class   = $row_index == 1 ? ' active' : '';
						$has_content    = get_sub_field( 'has_content_below_the_button' );
						$button_content = get_sub_field( 'button_content' );
						?>
						<div id="<?php echo $data_id; ?>" class="tab-content<?php echo $active_class; ?>">
							<?php if ( $buttons ) : ?>
								<div class="content">
									<h5 class="title"><?php echo $buttons; ?></h5>

									<?php if ( $has_content ) : ?>
										<p><?php echo $button_content; ?></p>
									<?php endif; ?>
								</div>
								<?php
							endif;

							if ( $map_image ) :
								?>
								<div class="img-holder">
									<?php echo wp_get_attachment_image( $map_image, 'full' ); ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>


