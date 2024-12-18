<?php

/**
 * Readymix Projects Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'readymix-projects-block-' . $block['id'];
if (!empty($block['anchor'])) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-projects-block';
if (!empty($block['className'])) {
	$className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
	$className .= ' align' . $block['align'];
}

$section_title       = get_field('section_title');
$projects_to_display = get_field('projects_to_display');
$section_colour      = get_field('section_colour');
?>

<section class="section-latest-projects">
	<div class="container">
		<div class="section-title">
			<h2>Readymix Projects</h2>
		</div>
		<div class="button-wrap">
			<a href="#" class="arrow-link">
				<?php _e('See All', 'readymix'); ?>
				<span>
					<?php get_template_part('template-parts/svg-icons/button-arrows-long-arrow-right-light-gray', 'svg'); ?>
				</span>
			</a>
		</div>
	</div>
	<div class="latest-projects-slider">
		<div class="slide-card">
			<a href="#" class="video-poster popup-video">
				<span class="absolute-background-image">
					<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/05/e7158fbaf732c4392af308398e681dd9.jpg" alt="">
				</span>
				<svg xmlns="http://www.w3.org/2000/svg" width="105" height="105" viewBox="0 0 105 105" class="svg replaced-svg">
					<path fill="#FAFAFA" fill-rule="evenodd" d="M52.5 105c29.002 0 52.5-23.498 52.5-52.5S81.502 0 52.5 0 0 23.498 0 52.5 23.498 105 52.5 105zM4.375 52.5c0-26.446 21.411-48.125 48.125-48.125 26.446 0 48.125 21.411 48.125 48.125 0 26.446-21.411 48.125-48.125 48.125-26.446 0-48.125-21.411-48.125-48.125zm67.552-.58L44.864 35.469c-2.429-1.353-5.489.384-5.489 3.229V70.68c0 2.83 3.045 4.582 5.49 3.23l27.062-15.531c2.522-1.4 2.522-5.044 0-6.458z"></path>
				</svg>
			</a>
			<div class="detail">
				<h5>Lorem ipsum</h5>
				<h4 class="match-height">Lorem ipsum dolor sit amet consectetur. Cursus sem at orci enim. Vitae nullam.</h4>
				<a href="#" class="link-arrow">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="31" viewBox="0 0 30 31" class="svg replaced-svg">
						<g fill="none" fill-rule="evenodd">
							<path d="M0 0H30V30H0z" transform="translate(0 .738)"></path>
							<path fill="#374255" d="M19.246 8.831l-.331.332c-.22.22-.22.576 0 .795l3.934 3.912H5.229c-.31 0-.562.252-.562.562v.47c0 .31.252.562.562.562h17.62l-3.934 3.911c-.22.22-.22.576 0 .796l.331.33c.22.22.576.22.796 0l5.46-5.437c.22-.22.22-.575 0-.795l-5.46-5.438c-.22-.22-.576-.22-.796 0z" transform="translate(0 .738)"></path>
						</g>
					</svg>
				</a>
				<a href="#" class="stretched-link"></a>
			</div>
		</div>
		<div class="slide-card">
			<a href="#" class="video-poster popup-video">
				<span class="absolute-background-image">
					<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/05/e7158fbaf732c4392af308398e681dd9.jpg" alt="">
				</span>
			</a>
			<div class="detail">
				<h5>Lorem ipsum</h5>
				<h4 class="match-height">Lorem ipsum dolor sit amet consectetur. Cursus sem at orci enim. Vitae nullam.</h4>
				<a href="#" class="link-arrow">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="31" viewBox="0 0 30 31" class="svg replaced-svg">
						<g fill="none" fill-rule="evenodd">
							<path d="M0 0H30V30H0z" transform="translate(0 .738)"></path>
							<path fill="#374255" d="M19.246 8.831l-.331.332c-.22.22-.22.576 0 .795l3.934 3.912H5.229c-.31 0-.562.252-.562.562v.47c0 .31.252.562.562.562h17.62l-3.934 3.911c-.22.22-.22.576 0 .796l.331.33c.22.22.576.22.796 0l5.46-5.437c.22-.22.22-.575 0-.795l-5.46-5.438c-.22-.22-.576-.22-.796 0z" transform="translate(0 .738)"></path>
						</g>
					</svg>
				</a>
				<a href="#" class="stretched-link"></a>
			</div>
		</div>
		<div class="slide-card">
			<a href="#" class="video-poster popup-video">
				<span class="absolute-background-image">
					<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/05/e7158fbaf732c4392af308398e681dd9.jpg" alt="">
				</span>
			</a>
			<div class="detail">
				<h5>Lorem ipsum</h5>
				<h4 class="match-height">Lorem ipsum dolor sit amet consectetur. Cursus sem at orci enim. Vitae nullam.</h4>
				<a href="#" class="link-arrow">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="31" viewBox="0 0 30 31" class="svg replaced-svg">
						<g fill="none" fill-rule="evenodd">
							<path d="M0 0H30V30H0z" transform="translate(0 .738)"></path>
							<path fill="#374255" d="M19.246 8.831l-.331.332c-.22.22-.22.576 0 .795l3.934 3.912H5.229c-.31 0-.562.252-.562.562v.47c0 .31.252.562.562.562h17.62l-3.934 3.911c-.22.22-.22.576 0 .796l.331.33c.22.22.576.22.796 0l5.46-5.437c.22-.22.22-.575 0-.795l-5.46-5.438c-.22-.22-.576-.22-.796 0z" transform="translate(0 .738)"></path>
						</g>
					</svg>
				</a>
				<a href="#" class="stretched-link"></a>
			</div>
		</div>
		<div class="slide-card">
			<a href="#" class="video-poster popup-video">
				<span class="absolute-background-image">
					<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/05/e7158fbaf732c4392af308398e681dd9.jpg" alt="">
				</span>
			</a>
			<div class="detail">
				<h5>Lorem ipsum</h5>
				<h4 class="match-height">Lorem ipsum dolor sit amet consectetur. Cursus sem at orci enim. Vitae nullam.</h4>
				<a href="#" class="link-arrow">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="31" viewBox="0 0 30 31" class="svg replaced-svg">
						<g fill="none" fill-rule="evenodd">
							<path d="M0 0H30V30H0z" transform="translate(0 .738)"></path>
							<path fill="#374255" d="M19.246 8.831l-.331.332c-.22.22-.22.576 0 .795l3.934 3.912H5.229c-.31 0-.562.252-.562.562v.47c0 .31.252.562.562.562h17.62l-3.934 3.911c-.22.22-.22.576 0 .796l.331.33c.22.22.576.22.796 0l5.46-5.437c.22-.22.22-.575 0-.795l-5.46-5.438c-.22-.22-.576-.22-.796 0z" transform="translate(0 .738)"></path>
						</g>
					</svg>
				</a>
				<a href="#" class="stretched-link"></a>
			</div>
		</div>
		<div class="slide-card">
			<a href="#" class="video-poster popup-video">
				<span class="absolute-background-image">
					<img src="<?php echo home_url(); ?>/wp-content/uploads/2024/05/e7158fbaf732c4392af308398e681dd9.jpg" alt="">
				</span>
			</a>
			<div class="detail">
				<h5>Lorem ipsum</h5>
				<h4 class="match-height">Lorem ipsum dolor sit amet consectetur. Cursus sem at orci enim. Vitae nullam.</h4>
				<a href="#" class="link-arrow">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="31" viewBox="0 0 30 31" class="svg replaced-svg">
						<g fill="none" fill-rule="evenodd">
							<path d="M0 0H30V30H0z" transform="translate(0 .738)"></path>
							<path fill="#374255" d="M19.246 8.831l-.331.332c-.22.22-.22.576 0 .795l3.934 3.912H5.229c-.31 0-.562.252-.562.562v.47c0 .31.252.562.562.562h17.62l-3.934 3.911c-.22.22-.22.576 0 .796l.331.33c.22.22.576.22.796 0l5.46-5.437c.22-.22.22-.575 0-.795l-5.46-5.438c-.22-.22-.576-.22-.796 0z" transform="translate(0 .738)"></path>
						</g>
					</svg>
				</a>
				<a href="#" class="stretched-link"></a>
			</div>
		</div>
	</div>
	<div id="slider-nav-1" class="slider-nav">
		<div class="nav-item"><span></span></div>
		<div class="nav-item"><span></span></div>
		<div class="nav-item"><span></span></div>
		<div class="nav-item"><span></span></div>
		<div class="nav-item"><span></span></div>
	</div>
</section>