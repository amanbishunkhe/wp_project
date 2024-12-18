<?php
/**
 * Usps Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'usps-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-usps';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}
$style          = '';
$section_colour = get_field( 'section_colour' );
$_use_global    = get_field( 'use_global' );
if ( $section_colour ) {
	$style = "style='background-color:" . $section_colour . ";'";
}
if ( $_use_global == true ) {


	if ( have_rows( 'usp_list', 'option' ) ):
		?>
        <section id="<?php echo $id; ?>" class="global-link-strip" <?php echo $style; ?>>
            <div class="container">
                <div class="usp-lists">
					<?php
					while ( have_rows( 'usp_list', 'option' ) ): the_row();
						?>
                        <div class="usp-list">
							<img src="<?php echo get_template_directory_uri(); ?>/images/icon-24-tick.svg" alt="icon-tick">
							<?php echo get_sub_field( 'label' ); ?>
						</div>
					<?php
					endwhile;
					?>
                </div>
            </div>
        </section>
	<?php
	endif;

} else {

	if ( have_rows( 'usps' ) ):
		?>
        <section class="global-link-strip" <?php echo $style; ?>>
            <div class="container">
                <ul>
					<?php
					while ( have_rows( 'usps' ) ): the_row();
						?>
                        <li>
							<img src="<?php echo get_template_directory_uri(); ?>/images/icon-24-tick.svg" alt="icon-tick">
							<?php echo get_sub_field( 'label' ); ?>
                        </li>
					<?php
					endwhile;
					?>
                </ul>
            </div>
        </section>
	<?php
	endif;
}