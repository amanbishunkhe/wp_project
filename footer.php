<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package readymix
 */
?>

<footer id="colophon" class="site-footer revamp">
	<section class="footer-nav">
		<div class="container">
			<div class="primary-row">
				<div class="row">
					<div class="col-xl-10 col-md-9">
						<div class="footer-menu">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-2',
									'container'      => '',
								)
							);
							?>
						</div>
					</div>
					<div class="col-xl-2 col-md-3">
						<div class="footer-info">
							<?php
							$contact = get_field("global_contact_number", "option");
							if ($contact) {
							?>
								<a href="tel:<?php echo $contact; ?>"><img src="<?php echo get_theme_file_uri() . '/images/phone.svg'; ?>" class="svg" alt=""> Call us <?php echo $contact; ?></a>
							<?php
							}
							?>
						</div>
					</div>
				</div>
				<br>
				<div class="newsletter-social-wrap">
					<div class="subscription-wrap">
						<?php
						$subscribe_info = get_field('subscribe_info', 'option');
						$subscribe_form = get_field('subscribe_form', 'option');
						if ($subscribe_info) {
						?>
							<span class="info"><?php echo $subscribe_info; ?></span>
						<?php
						}
						if ($subscribe_form) {
							echo do_shortcode($subscribe_form);
						}
						?>
					</div>
					<?php
					$footer_social_link_items = get_field('social_link_items', 'option');
					if( is_array($footer_social_link_items) && !empty( $footer_social_link_items ) ):
					?>
					<div class="social-links">
						<ul>
							<?php
							foreach ($footer_social_link_items as $key => $footer_social_link_item) {
								$showhide_item = $footer_social_link_item['showhide_item'];
								if( $showhide_item == 1 ):
								?>
								<li>
									<a href="<?php echo $footer_social_link_item['item_link']; ?>" target="_blank">
										<img src="<?php echo $footer_social_link_item['social_icons']['url']; ?>" class="" alt="<?php echo $footer_social_link_item['social_icons']['alt']; ?>">
									</a>
								</li>
								<?php
								endif;
							}
							?>
						</ul>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="secondary-row">
				<div class="row">

					<div class="col-xl-10 col-md-9">
						<div class="menu-wrap">
							<span class="copyright-text"><span>&copy; <?php bloginfo('name');
																		echo date(' Y'); ?></span></span>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-3',
									'container'      => '',
								)
							);
							?>
						</div>
					</div>
					<div class="col-xl-2 col-md-3">
						<?php
						$bottom_right_link = get_field("bottom_right_link", "option");
						if (!empty($bottom_right_link)) {
						?>
							<a href="<?php echo esc_url($bottom_right_link['url']); ?>" class="link" target='_blank'><?php // echo $bottom_right_link['title']; 
																														?>
								<svg width="129" height="28" viewBox="0 0 129 28" fill="none" xmlns="http://www.w3.org/2000/svg">
									<g clip-path="url(#clip0_302_3389)">
										<path d="M18.3217 0C14.6202 0 11.4511 2.39462 10.5933 6.08491C10.4158 6.87599 10.2933 7.89371 10.2933 9.292V12.0159H16.0569V5.82834H20.5866V15.8815C23.9078 14.8894 26.3502 11.785 26.3502 8.09041C26.3502 3.53635 22.8261 0 18.3217 0ZM7.9566 28C11.6581 28 14.8991 25.6054 15.7526 21.9151C15.9301 21.124 16.0526 20.1063 16.0526 18.708V15.9841H10.2891V22.1717H5.75934V12.1185C2.44233 13.1106 0 16.215 0 19.9053C0 24.6561 3.26208 28 7.9566 28Z" fill="white" />
										<path d="M35.2659 4.45146H36.1744L38.6336 10.1472H37.5941L37.0279 8.78317H34.387L33.8123 10.1472H32.8066L35.2659 4.45146ZM36.673 7.90229L35.7053 5.64022L34.7461 7.90229H36.6687H36.673ZM43.5859 4.49422H44.6296L46.3282 7.1668L48.0269 4.49422H49.0706V10.1472H48.0902V6.09349L46.3282 8.75751H46.2944L44.5451 6.10632V10.1472H43.5774V4.49422H43.5859ZM51.3143 4.49422H55.4553V5.38366H52.2946V6.85464H55.0961V7.75262H52.2946V9.26209H55.4975V10.1515H51.3143V4.4985V4.49422ZM57.4582 4.49422H58.5061L60.2047 7.1668L61.9034 4.49422H62.9471V10.1472H61.9667V6.09349L60.2047 8.75751H60.1709L58.4216 6.10632V10.1472H57.4539V4.49422H57.4582ZM65.1866 4.49422H67.6923C68.3303 4.49422 68.8332 4.67382 69.1543 4.99453C69.3994 5.24254 69.5304 5.55898 69.5304 5.931V5.9481C69.5304 6.62801 69.1459 6.99148 68.7318 7.20956C69.3867 7.43619 69.8388 7.81677 69.8388 8.58219V8.59929C69.8388 9.60846 69.0149 10.1515 67.7726 10.1515H65.1866V4.4985V4.49422ZM68.5458 6.09349C68.5458 5.64878 68.1951 5.3751 67.5655 5.3751H66.1542V6.87602H67.4937C68.1233 6.87602 68.5458 6.62373 68.5458 6.1106V6.09349ZM67.7092 7.71841H66.1542V9.27064H67.781C68.4444 9.27064 68.8585 9.00553 68.8585 8.49667V8.47956C68.8585 8.00491 68.4825 7.71841 67.7092 7.71841ZM71.7488 4.49422H75.8897V5.38366H72.7291V6.85464H75.5306V7.75262H72.7291V9.26209H75.932V10.1515H71.7488V4.4985V4.49422ZM77.8926 4.49422H80.3814C81.0829 4.49422 81.6364 4.70375 81.9956 5.05867C82.2914 5.36655 82.4604 5.78561 82.4604 6.27736V6.29447C82.4604 7.22239 81.9111 7.78256 81.1336 8.00491L82.6421 10.1472H81.4758L80.1026 8.17596H78.8729V10.1472H77.8926V4.49422ZM80.3096 7.29936C81.011 7.29936 81.4589 6.92733 81.4589 6.35433V6.33723C81.4589 5.73002 81.0279 5.40076 80.3012 5.40076H78.8729V7.29936H80.3096ZM87.4042 7.33784V7.32074C87.4042 5.73002 88.6169 4.39587 90.3325 4.39587C92.048 4.39587 93.2481 5.71292 93.2481 7.30363V7.32074C93.2481 8.91145 92.0353 10.2456 90.3198 10.2456C88.6042 10.2456 87.4042 8.92856 87.4042 7.33784ZM92.217 7.33784V7.32074C92.217 6.22178 91.4269 5.31524 90.3156 5.31524C89.2043 5.31524 88.431 6.20467 88.431 7.30363V7.32074C88.431 8.4197 89.2212 9.32196 90.3325 9.32196C91.4438 9.32196 92.217 8.43253 92.217 7.33356V7.33784ZM95.234 4.49422H99.3919V5.40076H96.2143V6.94444H99.0328V7.85097H96.2143V10.1515H95.234V4.4985V4.49422ZM33.1236 15.6121H35.2321V18.4771H38.0167V15.6121H40.1252V23.2621H38.0167V20.3543H35.2321V23.2621H33.1236V15.6121ZM41.9548 19.4606V19.4392C41.9548 17.2413 43.6746 15.4625 46.024 15.4625C48.3733 15.4625 50.072 17.2199 50.072 19.4179V19.4392C50.072 21.6372 48.3522 23.416 46.0028 23.416C43.6535 23.416 41.9548 21.6585 41.9548 19.4606ZM47.9212 19.4606V19.4392C47.9212 18.336 47.1691 17.3739 46.0028 17.3739C44.8366 17.3739 44.1183 18.3146 44.1183 19.4179V19.4392C44.1183 20.5425 44.8704 21.5046 46.024 21.5046C47.1775 21.5046 47.9212 20.5639 47.9212 19.4606ZM51.9988 15.6121H54.1073V21.4063H57.5934V23.2621H51.9988V15.6121ZM58.654 19.4606V19.4392C58.654 17.2114 60.3611 15.4625 62.664 15.4625C64.2189 15.4625 65.2204 16.1167 65.8922 17.0574L64.3034 18.2932C63.8682 17.7459 63.3696 17.3953 62.6386 17.3953C61.5738 17.3953 60.8216 18.3018 60.8216 19.4179V19.4392C60.8216 20.5852 61.5738 21.4832 62.6386 21.4832C63.433 21.4832 63.8978 21.1112 64.3542 20.5553L65.9429 21.6928C65.2246 22.6891 64.257 23.4203 62.571 23.4203C60.3949 23.4203 58.6455 21.7483 58.6455 19.4649L58.654 19.4606ZM67.8444 15.6121H69.9656V23.2621H67.8444V15.6121ZM72.146 15.6121H74.3728L76.3081 18.5755L78.2433 15.6121H80.4702V23.2621H78.3701V18.7893L76.3038 21.7826H76.2616L74.208 18.8107V23.2621H72.1417V15.6121H72.146ZM86.0013 19.4606V19.4392C86.0013 17.2114 87.7296 15.4625 90.062 15.4625C91.3888 15.4625 92.3311 15.8687 93.1297 16.5657L91.9001 18.0752C91.3593 17.6176 90.8311 17.3525 90.0747 17.3525C88.9845 17.3525 88.1437 18.2719 88.1437 19.4392V19.4606C88.1437 20.705 88.9972 21.5901 90.1973 21.5901C90.717 21.5901 91.1057 21.479 91.4057 21.2737V20.3458H89.9268V18.7936H93.3917V22.2273C92.5931 22.9029 91.4902 23.4203 90.1085 23.4203C87.7549 23.4203 86.0056 21.7826 86.0056 19.4649L86.0013 19.4606ZM95.3397 15.6121H98.9144C100.068 15.6121 100.871 15.92 101.378 16.4331C101.822 16.8821 102.046 17.4594 102.046 18.2163V18.2377C102.046 19.4179 101.429 20.1918 100.491 20.5981L102.295 23.2664H99.8863L98.3651 20.9487H97.4355V23.2664H95.3397V15.6164V15.6121ZM98.8257 19.2853C99.5271 19.2853 99.9497 18.9347 99.9497 18.3788V18.3574C99.9497 17.7459 99.506 17.438 98.8173 17.438H97.4355V19.2853H98.8299H98.8257ZM103.639 19.4606V19.4392C103.639 17.2413 105.388 15.4625 107.72 15.4625C110.053 15.4625 111.781 17.2242 111.781 19.4179V19.4392C111.781 21.6372 110.032 23.416 107.699 23.416C105.367 23.416 103.639 21.6585 103.639 19.4606ZM109.63 19.4606V19.4392C109.63 18.3232 108.853 17.3739 107.699 17.3739C106.546 17.3739 105.777 18.3146 105.777 19.4179V19.4392C105.777 20.5425 106.567 21.5046 107.72 21.5046C108.874 21.5046 109.63 20.5639 109.63 19.4606ZM113.56 19.9096V15.6164H115.677V19.8669C115.677 20.9701 116.226 21.4961 117.071 21.4961C117.916 21.4961 118.474 20.9915 118.474 19.9224V15.6164H120.591V19.8583C120.591 22.3171 119.197 23.4118 117.05 23.4118C114.904 23.4118 113.564 22.3085 113.564 19.9139L113.56 19.9096ZM122.619 15.6164H125.869C127.77 15.6164 129 16.6127 129 18.2932V18.3146C129 20.1277 127.627 21.0813 125.759 21.0813H124.711V23.2664H122.615V15.6164H122.619ZM125.717 19.4179C126.452 19.4179 126.917 19.0116 126.917 18.413V18.3916C126.917 17.7374 126.452 17.3953 125.708 17.3953H124.715V19.4179H125.721H125.717Z" fill="white" />
									</g>
									<defs>
										<clipPath id="clip0_302_3389">
											<rect width="129" height="28" fill="white" />
										</clipPath>
									</defs>
								</svg>

								<?php /*
                                <img class="svg"
                                     src="<?php echo get_theme_file_uri() . '/images/buttons-arrows-long-arrow-right-light.svg'; ?>"
                                     alt=""> */ ?>
							</a>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
</footer>
</div>

<?php wp_footer(); ?>

<?php /* ?>
<script>
	
function sendContentToServer(className) {    
    var xhr = new XMLHttpRequest();

    function getHtmlContentByClass(className) {
        var elements = document.getElementsByClassName(className);
        var content = '';

        for (var i = 0; i < elements.length; i++) {
            content += elements[i].outerHTML;
        }

        return content;
    }

    function getBlockData(outputWrapper) {
        let allBlockData = [];

        outputWrapper.forEach(function(block) {
            const dataIndex = block.getAttribute('data-index');
            const dataShape = block.getAttribute('data-shape');

            let blockData = {
                index: dataIndex,
                shape: dataShape,
                dimensions: {}
            };

            const areaInput = block.querySelector('.dimension-area');
            const volumeInput = block.querySelector('.dimension-volume');

            blockData.areaValue = areaInput ? areaInput.value : null;
            blockData.volumeValue = volumeInput ? volumeInput.value : null;

            block.querySelectorAll('input.dimension').forEach(function(input) {
                const name = input.getAttribute('name');                
                const placeholder = input.getAttribute('placeholder');
                const title = input.getAttribute('title');

                blockData.dimensions[name] = {
                    value: input.value,
                    placeholder: placeholder,
                    title: title
                };
            });

            allBlockData.push(blockData);
        });

        return allBlockData;
    }

    function getTotalCalculations() {
        const totalAreaElement = document.querySelector('.total-area .total span');
        const totalVolumeElement = document.querySelector('.total-volume .total span');

        return {
            totalArea: totalAreaElement ? totalAreaElement.textContent.trim() : null,
            totalVolume: totalVolumeElement ? totalVolumeElement.textContent.trim() : null
        };
    }

    var content = getHtmlContentByClass(className);
    var blockData = getBlockData(document.querySelectorAll('.calculator-block'));
    var totalCalc = getTotalCalculations();

    var formData = new FormData();
    formData.append('content', content);
    formData.append('blockData', JSON.stringify(blockData));
    formData.append('totalCalc', JSON.stringify(totalCalc));

    xhr.open('POST', '/readymix-revamp/wp-content/themes/readymix/section.php', true); 
	// Ensure the path is correct
    xhr.responseType = 'blob'; // Important for handling binary data

    xhr.onload = function() {
        if (xhr.status === 200) {
            var blob = new Blob([xhr.response], { type: 'application/pdf' });
            var url = URL.createObjectURL(blob);
            window.open(url, '_blank'); // Open PDF in a new tab
        } else {
            console.error('Failed to download PDF.');
        }
    };

    xhr.send(formData);
}


</script>
<?php */ ?>

<script type="text/javascript">
	jQuery(window).load(function($) {

		/* if (jQuery('#input_1_41').length > 0) {
			console.log(d360gclid);
			jQuery('#input_1_41').val(d360gclid);
		} */
	});
</script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
	var Tawk_API = Tawk_API || {},
		Tawk_LoadStart = new Date();
	(function() {
		var s1 = document.createElement("script"),
			s0 = document.getElementsByTagName("script")[0];
		s1.async = true;
		s1.src = 'https://embed.tawk.to/6489387ccc26a871b02264fc/1h2s09agc';
		s1.charset = 'UTF-8';
		s1.setAttribute('crossorigin', '*');
		s0.parentNode.insertBefore(s1, s0);
	})();
</script>
<!--End of Tawk.to Script-->

</body>

</html>