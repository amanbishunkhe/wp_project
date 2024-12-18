<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package readymix
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="error-404 not-found">
		<div class="container">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'readymix'); ?></h1>
			</header>
			<div class="page-content">
				<p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'readymix'); ?></p>
				<div class="button-wrap">
					<a href="<?php echo home_url(); ?>" class="btn btn-pink"><?php _e('Return to Homepage', 'readymix'); ?></a>
				</div>
				<?php
				// get_search_form();
				?>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
