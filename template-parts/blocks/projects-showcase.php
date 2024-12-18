<?php

/**
 * Readymix Projects Showcase Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'readymix-projects-showcase-' . $block['id'];
if (!empty($block['anchor'])) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-projects-showcase';
if (!empty($block['className'])) {
	$className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
	$className .= ' align' . $block['align'];
}
$section_color       	= get_field('section_color');

if ($section_color) {
	$style = "style='background-color:" . $section_color . ";'";
}

$projects_query_args = array(
	'post_type'      =>'readymix_project',
	'posts_per_page' => -1,
	'status' => 'publish',
	'orderby' => 'DESC'
);
$projects_query = new WP_Query( $projects_query_args );  


if( $projects_query->have_posts() ):
?>
<section class="section-projects-showcase" <?php echo $style; ?>>
	<div class="container">
		<div class="gallery-grid showcase-grid clearfix">
			<?php
			while( $projects_query->have_posts())
			{
				$projects_query->the_post();
				$image_id = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'full' ); 
				$image_url = $image_id['0']; 
				$alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				$terms = get_the_terms( get_the_ID(), 'readymix_projects_type' );
				?>
				<div class="tile">
					<a href="<?php the_permalink(); ?>" class="image-holder">
						<div class="absolute-background-image">
							<img src="<?php echo $image_url; ?>" alt="<?php echo $alt_text; ?>">
						</div>
					</a>
					<div class="abs-content">
						<?php if( is_array( $terms ) && !empty( $terms ) ): ?>
						<ul class="location-tag">
							<?php
							foreach( $terms as $term ){
								?>
								<li><?php echo $term->name; ?></li>
								<?php
							}
							?>
						</ul>
						<?php endif; ?>
						<h6><?php the_title(); ?></h6>
					</div>
					<a href="<?php the_permalink(); ?>" class="stretched-link"></a>
				</div>
				<?php
				wp_reset_postdata();
			}
			?>			
		</div>
	</div>
</section>
<?php
endif;