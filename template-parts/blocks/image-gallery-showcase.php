<?php
/**
 * Image Gallery Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'image-gallery-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-image-gallery';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}

$title_content = get_field('_image_gallery_section_title_content');
$intro = get_field('_image_gallery_section_intro');
$layout_count = get_field('_image_gallery_section_layout_option');
$showcase_layout = get_field('_image_gallery_section_showcase_' . strtolower($layout_count));

$style = '';
$section_colour = get_field('section_colour');

if ($section_colour) {
	$style = "style='background-color:" . $section_colour . ";'";
}
$section_identifier = "bl-" . $block['id'];
?>

<section class="showcase-layout magnificpopup-slider-<?php echo $section_identifier; ?> with-intro option-<?php echo $layout_count; ?>" <?php echo $style; ?>>
	<div class="title-row">
		<div class="container">
			<?php
			if ($title_content) {
				?>
				<div class="title-content text-center">
					<h3><?php echo $title_content; ?></h3>
				</div><!-- section-title -->
				<?php
			}
			?>
		</div><!-- container -->
	</div>
	<div class="container">
		<?php
		$counter = 1;
		if ($showcase_layout):
			foreach ($showcase_layout as $image):

				if ($counter <= 5) {
					$_image = $image["_image_gallery_section_showcase_{$layout_count}_image"]['id'];
					$video = '';
					if ($isVideo = $image["_image_gallery_section_showcase_{$layout_count}_is_video"]) {
						$video = isset($image["_image_gallery_section_showcase_{$layout_count}_video"]) ? $image["_image_gallery_section_showcase_{$layout_count}_video"] : '';
					}
					?>
					<a href="<?php echo $video ? esc_url($video) : esc_url($_image['url']); ?>" class="box box-<?php echo $counter; ?> wow fadeInUp <?php echo $video ? 'video-link12' : ''; ?>"
						data-slide="<?php echo $counter; ?>">
						<?php echo wp_get_attachment_image($_image, 'full', '', array('class' => 'bg-image')); ?>
						<?php
						if (!$video) {
							?>
							<span class="abs-pop-icon">
								<?php get_template_part('template-parts/svg-icons/expand', 'svg'); ?>
							</span>
							<?php
						}
						?>
					</a>
					<?php
					$counter++;
				}
			endforeach;
		endif;
		?>
	</div>
</section>

<div id="" class="mfp-hide global-gallery-module">
	<?php
	$popup_content = '';
	$nav_items = '';
	foreach ($showcase_layout as $image):
		ob_start();
		?>
		<div class="slide-card">
			<?php
			$_image = $image["_image_gallery_section_showcase_{$layout_count}_image"]['id'];
			$_associated_product = $image["_image_gallery_{$layout_count}_associated_product"];
			$video = '';
			if ($isVideo = $image["_image_gallery_section_showcase_{$layout_count}_is_video"]) {
				$video = isset($image["_image_gallery_section_showcase_{$layout_count}_video"]) ? $image["_image_gallery_section_showcase_{$layout_count}_video"] : '';
			}

			$id = '';
			if (!empty($video)) {
				$url_components = parse_url($video);

				if (isset($url_components['query'])) {
					parse_str($url_components['query'], $params);
					$id = $params['v'];
				}
			}

			if ($id) {
				$video_url = 'https://www.youtube.com/embed/' . $id;
			} else {
				$video_url = $video;
			}

			if ($video) {
				?>
				<div class="iframe-wrapper">
					<iframe width="728" height="410" src="<?php echo $video_url; ?>" frameborder="0"
						allow="accelerometer; autoplay; encrypted-media;gyroscope; picture-in-picture" allowfullscreen
						class="mfp-iframe"></iframe>
				</div>
				<?php
			} else {
				?>
				<?php
				if (!empty($_associated_product) & is_array($_associated_product)) {
					$_associated_product_count = count($_associated_product);
					?>
					<div class="img-with-block">
						<img src="<?php echo wp_get_attachment_image_url($_image, 'full'); ?>">
						<div class="associated-products-list-holder">
							<?php
							if ($_associated_product_count > 2) {
								?>
								<div class="overflow-arrow top">
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="8" viewBox="0 0 14 8" fill="none">
										<path d="M1 1L7 7L13 1" stroke="black" stroke-width="2" stroke-linecap="round"
											stroke-linejoin="round" />
									</svg>
								</div>
								<?php
							}
							?>
							<div class="associated-products-list">
								<?php
								foreach ($_associated_product as $_product) {
									if (isset($_product->ID)) {
										?>
										<div class="product-item product-item-img-showcase">
											<div class="inner">
												<figure class="image-holder">
													<?php
													$product_image = home_url() . '/wp-content/uploads/2020/06/image_4.jpg';
													$featured_image = get_the_post_thumbnail($_product->ID);
													if (!empty($featured_image)) {
														$product_image = $featured_image;
													}
													$link = esc_url(get_the_permalink($_product->ID));
													?>
													<a href="<?php echo $link; ?>" class="product-image">
														<span class="absolute-background-image">
															<?php
															if (!empty($featured_image)) {
																echo get_the_post_thumbnail($_product->ID, 'full');
															} else {
																echo '<img scr="' . $product_image . '" height="" width="" alt="product-image">';
															}
															?>
														</span>
													</a>
												</figure>
												<div class="detail">
													<span class="mata-cat matchHeight">
														<?php
														//list_hierarchical_terms( $post->ID, 'geostone_state', false, false);
														echo single_product_terms_listing($_associated_product, 'readymix_state', $filter = array()); ?>
													</span>
													<h5 class="product-name matchHeight1">
														<span>
															<?php echo get_the_title($_product->ID); ?>
														</span>
													</h5>
												</div>
											</div>
										</div><!-- .product-item -->
										<?php
									}
								}
								?>
							</div>
							<?php
							if ($_associated_product_count > 2) {
								?>
								<div class="overflow-arrow bottom">
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="8" viewBox="0 0 14 8" fill="none">
										<path d="M1 1L7 7L13 1" stroke="black" stroke-width="2" stroke-linecap="round"
											stroke-linejoin="round" />
									</svg>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php
				} else {
					?>
					<img src="<?php echo wp_get_attachment_image_url($_image, 'full'); ?>">
					<?php
				}
			}
			?>
		</div>
		<?php
		$popup_content .= ob_get_clean();

		ob_start();
		?>
		<div class="nav-item">
			<img class="svg" src="<?php echo get_template_directory_uri(); ?>/images/elements-carousel-unselected-copy-3.svg"
				alt="">
		</div>
		<?php
		$nav_items .= ob_get_clean();
	endforeach;
	?>
	<?php
	$compiled_content = '';
	ob_start();
	?>
	<div id="slider-on-magnificPopup" class="white-popup">
		<div class="popup-wrapper">
			<div class="custom-ajax-popup-<?php echo $section_identifier; ?>">
				<?php echo $popup_content; ?>
			</div>
			<div id="popup-slider-nav-<?php echo $section_identifier; ?>" class="slider-nav">
				<?php echo $nav_items; ?>
			</div><!-- .slider-nav -->
		</div>
	</div>
	<?php
	$compiled_content .= ob_get_clean();
	?>
</div>
<?php
$compiled_content = trim($compiled_content);
$compiled_content = str_replace(array("\n", "\r"), '', $compiled_content);
?>
<script type="text/javascript">

	(function ($) {
		var productHeight;


		$('.magnificpopup-slider-<?php echo $section_identifier; ?> .container a').on('click', function (e) {
			e.preventDefault();

			$.magnificPopup.open({
				items: {
					src: '<?php echo $compiled_content; ?>',
					type: 'inline'
				},
				callbacks: {
					open: function () {

						var $popupContent = $(this.content);

						$popupContent.find('.associated-products-list').on('scroll', function () {
							var $element = $(this);
							var maxScroll = $element[0].scrollHeight - $element.innerHeight() - 1;
							console.log(maxScroll);
							console.log($element.scrollTop());

							if ($element.scrollTop() > 60) {
								$element.parent('.associated-products-list-holder').addClass('top-reached');
							} else {
								$element.parent('.associated-products-list-holder').removeClass('top-reached');
							}

							if ($element.scrollTop() >= maxScroll) {
								$element.parent('.associated-products-list-holder').addClass('bottom-reached');
							}else{
								$element.parent('.associated-products-list-holder').removeClass('bottom-reached');
							}
						});

						$('.custom-ajax-popup-<?php echo $section_identifier; ?>').slick({
							dots: false,
							arrows: false,
							infinite: true,
							draggable: false,
							adaptiveHeight: true,
							slidesToShow: 1,
							slidesToScroll: 1,
							draggable: true,
						});

						$('#popup-slider-nav-<?php echo $section_identifier; ?>').slick({
							draggable: true,
							slidesToShow: 4,
							slidesToScroll: 1,
							asNavFor: '.custom-ajax-popup-<?php echo $section_identifier; ?>',
							dots: false,
							arrows: true,
							infinite: true,
							focusOnSelect: true
						});

                        //define if the image is portrait or landscape on #slider-on-magnificPopup
                        function checkImageShape() {
                            var imgs = $("#slider-on-magnificPopup .img-with-block > img");

                            imgs.each(function() {
                                var img = $(this);
                                var width = img.width();
                                var height = img.height();

                                if (width > height) {
                                    img.addClass('landscape');
                                } else {
                                    img.addClass('portrait');
                                }
                            });
                        }
                        checkImageShape();


						$('#popup-slider-nav-<?php echo $section_identifier; ?>').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
							$('iframe').each(function () {
								$(this).attr('src', $(this).attr('src'));
							});
						});
					}
				},
				fixedBgPos: true,
				fixedContentPos: true,
			});
			var slideno = $(this).data('slide');
			$('.custom-ajax-popup-<?php echo $section_identifier; ?>').slick('slickGoTo', slideno - 1);
			$('#popup-slider-nav-<?php echo $section_identifier; ?>').slick('slickGoTo', slideno - 1);

		});
	})(jQuery);
</script>