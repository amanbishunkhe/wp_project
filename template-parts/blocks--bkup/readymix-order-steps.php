<?php
/**
 * Order Steps Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'order-steps-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-order-steps';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}
$section_title = get_field( 'title' );
if ( have_rows( 'steps' ) ):
	?>
    <section class="section-steps" style="background-color: <?php echo get_field( 'section_color' ); ?>">
        <div class="container">
            <div class="section-title">
				<?php
				if ( $section_title ) {
					echo "<h2>" . $section_title . "</h2>";
				}
				?>
            </div><!-- section-title -->
            <div class="steps-wrap">
				<?php
				while ( have_rows( 'steps' ) ): the_row();
					?>
                    <div class="step">
						<?php
						$step_image = get_sub_field( "icon_image" );
						$content    = get_sub_field( "content" );
						?>
                        <div class="image">
							<?php
							echo wp_get_attachment_image( $step_image['id'], 'full', null, array( "class" => "svg" ) );
							?>
                        </div><!-- image -->
                        <div class="content">
							<?php echo $content; ?>
                        </div><!-- content -->
                    </div><!-- step -->
				<?php
				endwhile;
				?>
            </div><!-- steps-wrap -->
			<?php
			$button_show = get_field( 'show_buttons' );
			if ( have_rows( 'buttons' ) && $button_show ) {
				?>
                <div class="button-wrap">
					<?php
					while ( have_rows( 'buttons' ) ) {
						the_row();
						$button_details = get_sub_field( 'button_link' );
						$button_class   = get_sub_field( 'button_class' );
						$btn_class      = "";
						if ( $button_class ) {
							if ( $button_class == "outline" ) {
								$btn_class = "btn-outline-white";
							} elseif ( $button_class == "green" ) {
								$btn_class = "btn-green";
							}
						}
						?>
                        <a href="<?php echo $button_details['url']; ?>"
                           target="<?php echo $button_details['target']; ?>"
                           class="btn <?php echo $btn_class; ?>"><?php echo $button_details['title']; ?></a>
						<?php
					}
					?>
                </div><!-- button-wrap -->
				<?php
			}
			?>
        </div><!-- container -->
    </section><!-- section-steps -->
<?php
endif;
?>