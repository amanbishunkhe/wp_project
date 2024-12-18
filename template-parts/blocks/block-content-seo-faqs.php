<?php
/**
 * SEO and FAQs Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'columnsTextImage-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'theme-columns-textImage';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$style = '';
$title = get_field( 'title' );
$intro_text = get_field( 'intro_text' );
$hidden_text = get_field( 'hidden_text' );

$faqType = get_field( 'faqs' );
if($faqType == 'Custom FAQs') {
    $faqs = get_field( 'custom_faqs' );
} elseif($faqType == 'Popular FAQs') {
    $faqs = get_field( 'popular_faqs', 'option' );
} else {
    $faqs = '';
}


$text_alignment = get_field('text_align');
$text_color = get_field('text_color');

$bgColour = get_field( 'background_color' );
if ( $bgColour != 'none'){
    $style = "style='background-color:".$bgColour.";'";
}

$spacingTop = get_field( 'spacing_top' );
$spacingBtm = get_field( 'spacing_bottom' );

if($spacingTop === 'Half') {
    $spacingTop = ' spacingTop--half';
} elseif($spacingTop === 'None') {
    $spacingTop = ' spacingTop--none';
} else {
    $spacingTop = '';
}
if($spacingBtm === 'Half') {
    $spacingBtm = ' spacingBtm--half';
} elseif($spacingBtm === 'None') {
    $spacingBtm = ' spacingBtm--none';
} else {
    $spacingBtm = '';
}

?>


<section class="blockContent blockContent-short blockContent_seoFaqs fadeIn slideUp" <?php echo $style; ?>  id="<?php the_field('anchor_tag'); ?>">
    <div class="container">

        <div class="center middle">
            <div class="seo-block-inner">
            <div class="blockContent_seoFaqs-title">
                    <?php if($title):?>
                    <h3 class="h6"><?php echo $title;?></h2>
                    <?php endif;  ?>
                </div>

                <div class="blockContent_seoFaqs-content">

                    <div class="blockContent_seoFaqs-content--intro">
                        <?php echo $intro_text;?>
                    </div>

                    <div class="blockContent_seoFaqs-hidden">
                        <div class="blockContent_seoFaqs-hidden--text">
                            <?php echo $hidden_text;?>
                        </div>
                        
                        <div class="blockContent_seoFaqs-hidden--faqs">
                            <?php
                            if( $faqs ): ?>
                                <?php foreach( $faqs as $post ): 

                                    // Setup this post for WP functions (variable must be named $post).
                                    setup_postdata($post); ?>
                                    
                                    <div class="blockContent_seoFaqs-item fadeIn slideUp">
                                        <div class="inner">
                                            <div class="title">
                                                <h4 class="text-base"><?php echo get_the_title($post->ID); ?></h4>
                                                <div class="icon">
                                                    <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11 1L6 6.38462L1 1" stroke="#27BAA1" stroke-linecap="round"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="text">
                                                <?php echo $post->post_content; ?>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                                <?php 
                                // Reset the global post object so that the rest of the page works correctly.
                                wp_reset_postdata(); ?>
                            <?php endif; ?>

                        </div>
                    </div>
                    
                    <div class="blockContent_seoFaqs-content--btn text-center">
                        <a class="btn btn-link" href="#">Read more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>









<?php /*
$title        = get_field( '_faq_block_title' );
$description  = get_field( '_faq_block_description' );
$popular_only = get_field( '_faq_block_list_popular_faqs_only' );


$faq_page = quinbrook_default_page( '_quinbrook_faqs_page' );
$faqs     = get_field( '_faq_block_popular_faqs' );

$style          = '';
$section_colour = get_field( 'section_colour' );

if ( $section_colour ) {
	$style = "style='background-color:" . $section_colour . ";'";
}

$active_faq_topic = filter_input( INPUT_GET, '_tab' ); */
?>








<?php /*
<section id="<?php echo esc_attr( $id ); ?>"
         class="faq-wrapper <?php echo esc_attr( $className ); ?> <?php echo ( $active_faq_topic ) ? 'faq-do-scroll' : ''; ?>" <?php echo $style; ?>>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 title-col wow fadeInUp">
				<?php if ( $title ) { ?>
                    <h5><?php echo $title; ?></h5>
				<?php } ?>
            </div>
            <div class="col-lg-9 content-col wow fadeInUp">
				<?php if ( $description ) { ?>
                    <p class="Paragraph-Gray-16px-Left"><?php echo $description; ?></p>
				<?php } ?>
                <a href="javascript:void(0)" class="link collapsed content-show" data-toggle="collapse"
                   data-target="#collapse-faqs-list" aria-expanded="true" aria-controls="collapse-faqs-list">Read more
                    <img src="<?php echo get_template_directory_uri(); ?>/images/expand.svg" alt=""></a>
				<?php
				if ( $popular_only ) { // for popular block only
					if ( $faqs ) {
						?>
                        <div id="collapse-faqs-list" class="accordion-wrap collapse">
                            <div id="accordion">
								<?php foreach ( $faqs as $key => $faq ) { ?>
                                    <div class="card">
                                        <div class="card-header" id="heading<?php echo $key; ?>">
                                            <h5 class="mb-0">
                                                <button class="collapsed" data-toggle="collapse"
                                                        data-target="#collapse<?php echo $key; ?>"
                                                        aria-expanded="true"
                                                        aria-controls="collapse<?php echo $key; ?>">
													<?php echo $faq->post_title; ?>
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapse<?php echo $key; ?>" class="collapse"
                                             aria-labelledby="heading<?php echo $key; ?>"
                                             data-parent="#accordion">
                                            <div class="card-body">
												<?php echo apply_filters( 'the_content', $faq->post_content ); ?>
                                            </div>
                                        </div>
                                    </div>
								<?php } // end loop $faq ?>
                            </div><!-- accordion -->
                            <a href="javascript:void(0)" class="link collapsed content-hide" data-toggle="collapse"
                               data-target="#collapse-faqs-list" aria-expanded="true"
                               aria-controls="collapse-faqs-list">Close <img
                                        src="<?php echo get_template_directory_uri(); ?>/images/expand.svg" alt=""></a>
                        </div><!-- .accordion-wrap -->
						<?php
					} // end check $faqs
				}
				?>

            </div>
        </div><!-- .col-sm-12 -->
    </div><!-- .row -->
</section><!-- faq-wrapper -->
*/ ?>