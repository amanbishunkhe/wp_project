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
$className = 'readymix-features-block';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}
$section_title_content = get_field( 'title_content' );

$style = "";
$section_colour = get_field( 'section_colour' );
if ( $section_colour){
    $style = "style='background-color:".$section_colour.";'";
}

?>
    <section class="section-features" <?php echo $style;?>>
        <div class="container">
            <div class="features-wrapper">
                <div class="content-left">
                    <div class="content">
	                    <?php
	                    if ( $section_title_content ) {
		                    echo $section_title_content;
	                    }
	                    ?>
	                    <?php
	                    $button_show = get_field( 'has_button' );
	                    if ( $button_show ) {
		                    ?>
                            <div class="button-wrap">
			                    <?php
			                    $button_details = get_field( 'button' );
			                    ?>
                                <a href="<?php echo $button_details['url']; ?>"
                                   target="<?php echo $button_details['target']; ?>"
                                   class="btn btn-green"><?php echo $button_details['title']; ?></a>
                            </div><!-- button-wrap -->
		                    <?php
	                    }
	                    ?>
                    </div><!-- content -->
                </div><!-- content-left -->
                <div class="features-grid">
	                <?php
	                if ( have_rows( 'features_list' ) ):
		                while ( have_rows( 'features_list' ) ): the_row();
			                ?>
                            <div class="feature">
                                <div class="inner">
	                                <?php
	                                $step_image = get_sub_field( "icon" );
	                                $content    = get_sub_field( "content" );
	                                ?>
	                                <?php
	                                echo wp_get_attachment_image( $step_image['id'], 'full', null, array( "class" => "svg" ) );
	                                ?>
	                                <?php echo $content; ?>
                                </div><!-- inner -->
                            </div><!-- feature -->
		                <?php
		                endwhile;
	                endif;
	                ?>
                </div><!-- features-grid -->
				<?php
					$button_show = get_field( 'has_button' );
					if ( $button_show ) {
						?>
						<div class="button-wrap button-wrap-mobile">
							<?php
							$button_details = get_field( 'button' );
							?>
							<a href="<?php echo $button_details['url']; ?>"
								target="<?php echo $button_details['target']; ?>"
								class="btn btn-green"><?php echo $button_details['title']; ?></a>
						</div><!-- button-wrap -->
						<?php
					}
					?>
            </div><!-- features-wrapper -->
        </div><!-- container -->
    </section><!-- section-features -->
<?php
