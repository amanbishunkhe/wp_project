<?php

/**
 * Readymix Products with Details Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'readyMix-product-with-details-' . $block['id'];
if (!empty($block['anchor'])) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'readyMix-product-with-details';
if (!empty($block['className'])) {
	$className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
	$className .= ' align' . $block['align'];
}

$section_title       	= get_field('section_title');
$description       		= get_field('description');
$contac_us          	= get_field('contac_us');
$product_relationship   = get_field('product_relationship');

//echo '<pre>';print_r($product_relationship);echo '</pre>';

$section_colour      	= get_field('section__color');

if ($section_colour) {
	$style = "style='background-color:" . $section_colour . ";'";
}

?>
<section class="section-readymix-products" <?php echo $style; ?>>
	<div class="container">
		<?php if (($section_title || $description || $contac_us['url']) != '') : ?>
			<div class="section-title">
				<?php if (!empty($section_title)) : ?>
					<h2><?php echo $section_title; ?></h2>
				<?php endif; ?>
				<?php if (!empty($description)) : ?>
					<?php echo wpautop($description); ?>
				<?php endif; ?>
				<div class="button-wrap">
					<a class="btn btn-link" href="<?php echo ($contac_us['url']) ? $contac_us['url'] : '#'; ?>"><?php echo $contac_us['title']; ?></a>
				</div>
			</div>
		<?php endif; ?>

		<?php
		if (is_array($product_relationship) && !empty($product_relationship)) : ?>
			<div class="row">
				<?php
				foreach ($product_relationship as $post) :
					// Setup this post for WP functions (variable must be named $post).
					setup_postdata($post);
				?>
					<div class="col-md-6">
						<div class="product-item" id="post-<?php echo $post->ID; ?>">
							<div class="inner">
								<figure class="image-holder">
									<?php
									$featured_image = get_the_post_thumbnail($post->ID, 'full');
									$link           = get_permalink($post->ID);
									?>
									<a href="<?php echo $link; ?>" class="product-image">
										<span class="absolute-background-image">
											<?php
											if (!empty($featured_image)) {
												echo $featured_image;
											}else{
												?>
												<img src="<?php echo get_template_directory_uri().'/images/dummy-popular-image.jpg' ?>" alt="dummy-popular-image" >
												<?php
											}
											?>
										</span>
									</a>
								</figure>
								<div class="detail">
									<h5 class="product-name"><span><?php echo get_the_title($post->ID); ?></span>
									</h5>
									<?php if (!empty(get_the_excerpt($post->ID))) : ?>
										<p><?php echo get_the_excerpt($post->ID); ?></p>
									<?php endif; ?>
									<div class="button-wrap">
										<a class="btn btn-link btn-link-arrow icon-arrow-square" href="<?php the_permalink($post->ID); ?>"><span><?php echo esc_html('More Information', 'readymix'); ?></span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
				endforeach;
				wp_reset_postdata();
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php
