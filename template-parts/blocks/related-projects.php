<?php
/**
 * Related Projects Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'related-projects-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-related-projects';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}
?>
<section class="popular-product-sec with-abs-content">
	<div class="container">
		<div class="title">
			<h3><?php _e('Related Projects', 'readymix'); ?></h3>
			<div class="button-wrap display-desktop">
				<?php
				/*
				//$showcase_page = get_field('_readymix_default_pages', 'option');

				if ($showcase_page['_readymix_project_showcase_page']) { ?>
					<a href="<?php echo esc_url(get_permalink($showcase_page['_readymix_project_showcase_page']->ID)); ?>" class="arrow-link">
						<?php _e('See All', 'readymix'); ?>
						<span>
							<?php get_template_part('template-parts/svg-icons/button-arrows-long-arrow-right-light-gray', 'svg'); ?>
						</span>
					</a>
				<?php // } 
				
				*/?>
			</div>
		</div>

		<?php if ($featured_projects = get_field('_related_projects_projects')) { ?>
			<?php
			$nav_items = '';
			?>
			<div class="popular-product-slider clearfix ">
				<?php
				foreach ($featured_projects as $project) {
					$current_projects_type      = wp_get_post_terms($project->ID, 'readymix_projects_type');
					$current_concretes_type      = wp_get_post_terms($project->ID, 'readymix_projects_concrete_type');
					$featured_image = get_the_post_thumbnail($project, 'full');
				?>
					<div class="product-item">
						<div class="inner">
							<figure class="image-holder">
								<a href="<?php echo esc_url(get_permalink($project)); ?>" class="product-image">
									<span class="absolute-background-image"><?php echo $featured_image; ?></span>
								</a>
							</figure>
							<div class="abs-content">
								<ul class="location-tag">
									<?php if (is_array($current_projects_type)) { ?>
										<?php
										foreach ($current_projects_type as $current_project_type) {
											if (0 == $current_project_type->parent) {
										?>
												<li><?php echo $current_project_type->name; ?></li>
												<?php
												foreach ($current_projects_type as $_current_project_type) {
													if ($_current_project_type->parent == $current_project_type->term_id) {
												?>
														<li><?php echo $_current_project_type->name; ?></li>
										<?php
													} // end compare/check term parent
												} // end loop $current_projects_type as $_current_project_type
											} // enc check parent term
										} // end loop $current_projects_type
										?>

									<?php } ?>

									<?php if (is_array($current_concretes_type)) { ?>

										<?php
										foreach ($current_concretes_type as $current_concrete_type) {
											if (0 == $current_concrete_type->parent) {
										?>
												<li><?php echo $current_concrete_type->name; ?></li>
												<?php
												foreach ($current_concretes_type as $_current_concrete_type) {
													if ($_current_concrete_type->parent == $current_concrete_type->term_id) {
												?>
														<li><?php echo $_current_concrete_type->name; ?></li>
										<?php
													} // end compare/check term parent
												} // end loop $current_concretes_type as $_current_concrete_type
											} // enc check parent term
										} // end loop $current_concretes_type
										?>
									<?php } ?>
								</ul>
								<h6><?php echo $project->post_title; ?></h6>
							</div>
							<a class="stretched-link" href="<?php echo esc_url(get_permalink($project)); ?>"></a>
						</div>
					</div>

					<?php ob_start(); ?>

					<div class="nav-item">
						<?php get_template_part('template-parts/svg-icons/elements-carousel-selected-copy-2', 'svg'); ?>
					</div>

				<?php
					$nav_items .= ob_get_clean();
				}
				?>
			</div><!-- .popular-product-slider -->

			<div id="slider-nav-2" class="slider-nav slider-nav-2">
				<?php echo $nav_items; ?>
			</div><!-- .slider-nav -->
		<?php } ?>
	</div>

	<?php /* if (isset($featured_projects) && $featured_projects) { ?>
		<?php if ($showcase_page['_readymix_project_showcase_page']) { ?>
			<div class="button-wrap display-mobile text-center">
				<a href="<?php echo esc_url(get_permalink($showcase_page['_readymix_project_showcase_page']->ID)); ?>" class="arrow-link"><?php _e('See All', 'readymix'); ?>
					<span><?php get_template_part('template-parts/svg-icons/button-arrows-long-arrow-right-light-gray', 'svg'); ?></span>
				</a>
			</div>
		<?php } ?>
	<?php } */
	?>
</section><!-- popular-product-sec -->