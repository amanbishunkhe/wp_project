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
$id = 'popular-products-' . $block['id'];
if (!empty($block['anchor'])) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-popular-products';
if (!empty($block['className'])) {
	$className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
	$className .= ' align' . $block['align'];
}

$section_color    = get_field('section_color');
$section_title    = get_field('section_title');
$section_subtitle = get_field('section_subtitle');
?>
<section class="section-testimonial" style="background-color:<?php echo $section_color; ?>;">

	<div class="container">
		<?php if ($section_title || $section_subtitle) : ?>
			<div class="section-title">
				<?php if ($section_title) : ?>
					<h2 class="testimonial-section-title-h2"><?php echo $section_title; ?></h2>
				<?php
				endif;

				if ($section_subtitle) :
				?>
					<p class="testimonial-section-title-p"><?php echo $section_subtitle; ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<div class="row">
			<?php
			if (have_rows('testimonial_list')) :
				while (have_rows('testimonial_list')) :
					the_row();
					$card_color = get_sub_field('card_color');
			?>
					<div class="col-lg-4 col-md-6" >
						<div class="testimonial-card" style="background-color:<?php echo $card_color; ?>;">
							<div class="card-inner">
								<?php
								$quote  = get_sub_field('testimonials_content');
								$author = get_sub_field('author');
								
								if ($quote) {
									echo $quote;
								}
								if ($author) {
									echo '<span class="author">' . $author . '</span>';
								}
								?>
							</div>
						</div>
					</div>
			<?php
				endwhile;
			endif;
			?>
		</div>
	</div>
</section>