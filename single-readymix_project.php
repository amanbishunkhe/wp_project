<?php
/*
 * Single project default template
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php
	if (have_posts()) {
		while (have_posts()) {
			the_post();

			the_content();

		} // end loop while have_posts
	} // enc check have_posts
	?>
</main>
<?php
get_footer();
