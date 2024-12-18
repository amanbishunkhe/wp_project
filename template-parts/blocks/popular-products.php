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

$section_title       = get_field('section_title');
$products_to_display = get_field('products_to_display');
$products_count      = is_countable($products_to_display) ? count($products_to_display) : 0;
$style               = '';
$section_colour      = get_field('section_colour');

if ($section_colour) {
	$style = "style='background-color:" . $section_colour . ";'";
}
?>
<section class="popular-product-sec" <?php echo $style; ?> id="<?php echo $id; ?>" >
	<div class="container">
		<div class="title">
			<h4 class="h2"><?php echo $section_title; ?></h4>
		</div>
		<div class="popular-product-slider clearfix">
			<?php
			if (is_array($products_to_display) || is_object($products_to_display)) :
				foreach ($products_to_display as $post) :
					// Setup this post for WP functions (variable must be named $post).
					setup_postdata($post);

			?>
					<div class="product-item">
						<div class="inner">

							<figure class="image-holder">
								<?php
								$featured_image = get_the_post_thumbnail($post->ID, 'full');
								$link           = get_permalink($post->ID);
								$post_type_check = get_post_type($post->ID);
								if ($post_type_check !== 'readymix_product') :
								?>
									<a href="<?php echo $link; ?>" class="product-image">
								<?php
								else:
									$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
									$thumbnail_url = wp_get_attachment_image_url( $post_thumbnail_id, 'full' );	
									?>									
									<a href="<?php echo $thumbnail_url; ?>" target="_blank" class="product-image-popup" >
									<?php
								endif;
									?>

									<span class="absolute-background-image">
										<?php
										if (!empty($featured_image)) {
											echo $featured_image;
										} else {
										?>
											<img src="<?php echo get_template_directory_uri() . '/images/dummy-popular-image.jpg' ?>" alt="dummy-popular-image">
										<?php
										}
										?>
									</span>
									<?php //if ($post_type_check !== 'readymix_product') : ?>
									</a>
								<?php //endif; ?>
							</figure>
							<div class="detail">
								<h5 class="product-name matchHeight1"><span><?php echo get_the_title($post->ID); ?></span>
								</h5>
							</div>
						</div>
					</div><!-- .product-item -->
			<?php
				endforeach;
			endif;
			wp_reset_postdata();
			?>

		</div><!-- .popular-product-slider -->

		<div id="slider-nav-2" class="slider-nav  slider-nav-2">
			<?php
			$nav_count = 1;
			while ($nav_count <= $products_count) {
			?>
				<div class="nav-item"><span></span></div>
			<?php
				$nav_count++;
			}
			?>
		</div>

		<?php
		if (get_field('show_button_below')) {
			$button = get_field('button');
			if (!empty($button)) {
				$btn_title = $button['title'];
				$btn_url   = $button['url'];
		?>
				<div class="btn-wrap text-center">
					<a href="<?php echo $btn_url; ?>" class="btn dark" target=""><?php echo $btn_title; ?></a>
				</div>
		<?php
			}
		}
		?>
	</div>
</section><!-- .popular-product-sec -->