<?php

/**
 * Concrete Calculator
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'concrete-calculator-' . $block['id'];
if (!empty($block['anchor'])) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-concrete-calculator';
if (!empty($block['className'])) {
	$className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
	$className .= ' align' . $block['align'];
}

$section_title    = get_field('title');
$section_subtitle = get_field('content');
$button           = get_field('button');
$image            = get_field('image');
?>
<section class="section-concrete-calculator <?php echo $className; ?>" style="background-color: <?php echo get_field('section_color');  ?>" id="<?php echo $id; ?>" >
	<div class="container">
		<div class="cc-wrapper">
			<div class="cc-content">
				<?php if ($section_title) : ?>
					<?php echo '<h3>' . $section_title . '</h3>'; ?>
				<?php
				endif;
				if ($section_subtitle) :
					echo $section_subtitle;
				endif;

				if ($button) :
				?>
					<div class="button-wrap">
						<a href="<?php echo $button['url']; ?>" target="<?php echo $button['target']; ?>" class="btn btn-white-houtline small"><?php echo $button['title']; ?></a>
					</div>
				<?php
				endif;
				?>
			</div>
			<?php
			if ($image) :
			?>
				<div class="cc-image">
					<?php echo wp_get_attachment_image($image, 'full'); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>