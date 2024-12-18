<?php
// Create id attribute allowing for custom "anchor" value.
$id = 'title-content-block-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'intro-title-section';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}

$style          = '';
$section_colour = get_field( 'section_colour' );
$title_content  = get_field( 'title_content' );


if ( $section_colour ) {
	$style = "style='background-color:" . $section_colour . ";'";
}
?>

<section id="<?php echo $id; ?>" class="<?php echo $className; ?>" <?php echo $style; ?>>
    <div class="container">
		<div class="title-content">
			<?php
			if ( $title_content ) {
				echo $title_content;
			}
			?>
		</div><!-- title-content -->
    </div><!-- container -->
</section><!-- intro-title-content -->