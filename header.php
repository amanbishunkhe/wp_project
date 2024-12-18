<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package readymix
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<?php
	if (get_field('gta_head_script', 'option')) {
		echo get_field('gta_head_script', 'option');
	}
	?>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="facebook-domain-verification" content="3evi7cg2991jmcogtyv4zd0ifdvetm" />
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

</head>

<body <?php body_class('no-js'); ?>>
	<?php
	if (get_field('gta_body_script', 'option')) {
		echo get_field('gta_body_script', 'option');
	}
	?>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<?php
		$text_content              = get_field('hnc_text_content', 'option');
		$bg_color                  = get_field('hnc_background_color', 'option');
		$show_link                 = get_field('hnc_show_link', 'option');
		$link_details              = get_field('hnc_link', 'option');
		$global_get_a_quote_button = get_field('global_get_a_quote_button', 'option');
		$ezybiz_portal_textlink    = get_field('ezybiz_portal_textlink', 'options');
		$create_account_textlink   = get_field('create_account_textlink', 'options');
		$contact_us_button         = get_field('contact_us_button', 'options');
		$menu_call_textlink        = get_field('menu_call_textlink', 'options');
		?>
		<header id="masthead" class="site-header <?php echo (is_product() || is_cart() || is_checkout()) ? 'stick-header-fixed' : ''; ?>">
			<?php
			if (get_field('hnc_banner_active', 'option')) {
			?>
				<div class="top-nav banner-popup" style="background-color: <?php echo $bg_color; ?>;display: none">
					<div class="container">
						<div class="text">
							<?php
							if ($text_content) {
							?>
								<p>
									<?php
									echo $text_content;
									if ($show_link && !empty($link_details)) {
									?>
										<a href="<?php echo esc_url($link_details['url']); ?>"><?php echo $link_details['title']; ?></a>
									<?php
									}
									?>
								</p>
							<?php
							}
							?>
							<div class="topnav-close">
								<img src="<?php echo get_template_directory_uri(); ?>/images/icon-close.svg" alt="icon-close">
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			?>
			<div class="main-header">
				<div class="container">
					<div class="site-branding">
						<a href="javascript:void(0);" class="menu-toggle">
							<div class="burger"></div>
						</a>
						<?php

						$logo      = get_field('header_logo', 'options');
						$logo_home = get_field('header_logo_home_only', 'options');

						if (is_front_page()) :
						?>
							<a class="custom-logo-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
								<?php echo wp_get_attachment_image($logo_home['id'], 'full', '', array('class' => '')); ?>
							</a>
						<?php
						else :
						?>

							<a class="custom-logo-link" href="<?php echo esc_url(home_url('/')); ?>" rel="page">
								<?php echo wp_get_attachment_image($logo['id'], 'full', '', array('class' => '')); ?>
							</a>

						<?php
						endif;
						?>


						<?php
						if (is_front_page() && is_home()) :
						?>
							<h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
						<?php
						else :
						?>
							<p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
						<?php
						endif;
						$readymix_description = get_bloginfo('description', 'display');
						if ($readymix_description || is_customize_preview()) :
						?>
							<p class="site-description">
								<?php
								echo $readymix_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</p>
						<?php endif; ?>
						<div class="search-right">

							<?php if (!empty($ezybiz_portal_textlink)) : ?>
								<a href="<?php echo esc_url($ezybiz_portal_textlink['url']); ?>" class="btn btn-link btn-hide-mobile" target="<?php echo esc_attr($ezybiz_portal_textlink['target']); ?>"><?php echo esc_html($ezybiz_portal_textlink['title']); ?></a>
							<?php
							endif;

							if (!empty($create_account_textlink)) :
							?>
								<a href="<?php echo esc_url($create_account_textlink['url']); ?>" class="btn btn-link btn-hide-mobile" target="<?php echo esc_attr($create_account_textlink['target']); ?>"><?php echo esc_html($create_account_textlink['title']); ?></a>
							<?php
							endif;

							if (!empty($contact_us_button)) :
							?>
								<a href="<?php echo esc_url($contact_us_button['url']); ?>" class="btn btn-white small btn-contact btn-hide-mobile" target="<?php echo esc_attr($contact_us_button['target']); ?>"><?php echo esc_html($contact_us_button['title']); ?></a>
							<?php
							endif;

							if (!empty($global_get_a_quote_button)) :
							?>
								<a href="<?php echo esc_url($global_get_a_quote_button['url']); ?>" class="btn btn-pink small btn-quote btn-hide-mobile"><?php echo $global_get_a_quote_button['title']; ?></a>
							<?php endif; ?>
							<?php
								$global_contact_number = get_field('global_contact_number','option');
								?>
							<a href="tel:<?php echo esc_url($menu_call_textlink['url']); ?>" class="btn small btn-call-us"><?php echo esc_html($menu_call_textlink['title']); ?></a>
						</div>
					</div>
					<div class="header-nav-menu">
						<nav id="site-navigation" class="main-navigation desktop">
							<div class="menu-primary-menu-container">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'menu-1',
										'menu_id'        => 'primary-menu',
									)
								);
								?>

							</div>
						</nav>

						<?php if ($menu_call_textlink) : ?>
							<div class="button-wrap">
								<a href="tel:<?php echo esc_url($menu_call_textlink['url']); ?>" class="btn btn-link"><?php echo esc_html($menu_call_textlink['title']); ?></a>
							</div>
						<?php endif; ?>
					</div>
					<nav id="site-navigation-mob" class="main-navigation mobile">
						<div class="menu-primary-menu-mobile">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_id'        => 'primary-menu',
								)
							);
							?>
							<div class="search-right hide-desktop">

								<?php if (!empty($ezybiz_portal_textlink)) : ?>
									<a href="<?php echo esc_url($ezybiz_portal_textlink['url']); ?>" class="btn btn-link" target="<?php echo esc_attr($ezybiz_portal_textlink['target']); ?>"><?php echo esc_html($ezybiz_portal_textlink['title']); ?></a>
								<?php
								endif;

								if (!empty($create_account_textlink)) :
								?>
									<a href="<?php echo esc_url($create_account_textlink['url']); ?>" class="btn btn-link" target="<?php echo esc_attr($create_account_textlink['target']); ?>"><?php echo esc_html($create_account_textlink['title']); ?></a>
								<?php
								endif;
								?>
								<div class="mobile-menu-button">
									<?php
									if (!empty($contact_us_button)) :
									?>
										<a href="<?php echo esc_url($contact_us_button['url']); ?>" class="btn btn-white small btn-contact" target="<?php echo esc_attr($contact_us_button['target']); ?>"><?php echo esc_html($contact_us_button['title']); ?></a>
									<?php
									endif;

									if (!empty($global_get_a_quote_button)) :
									?>
										<a href="<?php echo esc_url($global_get_a_quote_button['url']); ?>" class="btn btn-pink small"><?php echo $global_get_a_quote_button['title']; ?></a>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<?php
						$show_cta    = get_field('_mobile_megamenu_cta_title', 'option');
						$title       = get_field('_mobile_megamenu_cta_title', 'option');
						$button_text = get_field('_mobile_megamenu_button_cta_text', 'option');
						echo $button_link = get_field('_mobile_megamenu_button_cta_link', 'option')['url'];
						$button_link = $button_link ? esc_url($button_link) : '#';
						if ($show_cta == true) {
						?>
							<ul class="menu-cta-wrap menu">
								<li>
									<div class="cta-box">
										<?php
										if ($show_cta) {
										?>
											<h4><?php echo $title; ?></h4>
										<?php
										}
										if ($button_link && $button_text) {
										?>
											<a href="<?php echo $button_link; ?>" class="btn btn-pink"><?php echo $button_text; ?></a>
										<?php
										}
										?>
									</div>
								</li>
							</ul>
						<?php
						}
						?>
					</nav>
				</div>
			</div>
		</header>