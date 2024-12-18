<?php
/**
 * Why Readymix: Image and Content Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'why-image-and-content-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-why-image-and-content';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}
if ( have_rows( 'why_readymix' ) ):
	?>
    <section class="section-lcontent-rimage">
        <div class="container-fluid">
			<?php
			while ( have_rows( 'why_readymix' ) ): the_row();
				?>
                <div class="row">
                    <div class="col-lg-5">
                        <div class="content-block">
                            <h2 style="color:<?php echo get_sub_field( 'content_colour' ); ?>">
								<?php echo get_sub_field( 'title' ); ?>
                            </h2>
							<?php echo get_sub_field( 'content' ); ?>
							<?php
							$show_btn  = get_sub_field( 'show_button' );
							$btn_text  = get_sub_field( 'button_text' );
							$btn_link  = get_sub_field( 'button_link' );
							$btn_class = get_sub_field( 'button_class' );
							if ( $show_btn == true ) {
								?>
                                <div class="button-wrap">
                                    <a href="<?php echo $btn_link ? esc_url( $btn_link ) : '#'; ?>"
                                       class="btn <?php echo $btn_class; ?>"><?php echo $btn_text; ?></a>
                                </div><!-- button-wrap -->
								<?php
							}
							?>
                        </div><!-- content-block -->
                    </div><!-- col-lg-5 -->
                    <div class="col-lg-7">
                        <div class="image-block">
                            <img src="<?php echo get_sub_field( 'image' )['url']; ?>"
                                 alt="<?php echo get_sub_field( 'image' )['alt']; ?>">
                            <img class="img-mobile" src="<?php echo get_sub_field( 'mobile_image' )['url']; ?>"
                                 alt="<?php echo get_sub_field( 'mobile_image' )['alt']; ?>">
                        </div><!-- image-block -->
                    </div><!-- col-lg-7 -->
                </div><!-- row -->
			<?php
			endwhile;
			?>
        </div><!-- container-fluid -->
    </section><!-- section-lcontent-rimage -->
<?php
endif;
?>