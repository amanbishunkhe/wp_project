<?php

/**
 * Why Readymix: Image and Content Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'why-image-and-content-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-why-image-and-content';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}
$style          = '';
$section_colour = get_field('section_colour');
if ($section_colour) {
    $style = "style='background-color:" . $section_colour . ";'";
}

$show_contact_details_sub_section = get_field('show_contact_details_sub_section');
$sub_sec_title = get_field('sub_sec_title');
$contact_type_details = get_field('contact_type_details');
//echo '<pre>';print_r($contact_type_details);echo '</pre>';
$show_social_link = get_field('show_social_link');
$button_arr = get_field('button_link');

$social_link_title = get_field('social_link_title', 'option');
$social_link_items = get_field('social_link_items', 'option');

$subsecclass = '';
if ($show_contact_details_sub_section == 1) {
    $subsecclass = 'section-info-right';
} else {
    $subsecclass = '';
}

if (have_rows('why_readymix')) :
?>
    <section class="section-lcontent-rimage <?php echo $subsecclass; ?> " <?php echo $style; ?> id="<?php echo $id; ?>" >
        <div class="container-fluid">
            <?php echo (($show_contact_details_sub_section == 1) ? '<div class="content-info-wrapper">' : ''); ?>
            <?php
            while (have_rows('why_readymix')) : the_row();

                $content_type = get_sub_field( 'why_readymix_image_or_video' );
            ?>
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <div class="content-block">
                            <h2 style="color:<?php echo get_sub_field('content_colour'); ?>">
                                <?php echo get_sub_field('title'); ?>
                            </h2>
                            <?php echo get_sub_field('content'); ?>
                            <?php
                            $show_btn  = get_sub_field('show_button');
                            $btn_text  = get_sub_field('button_text');
                            $btn_link  = get_sub_field('button_link');
                            $btn_class = get_sub_field('button_class');
                            if ($show_btn == true) {
                            ?>
                                <div class="button-wrap">
                                    <a href="<?php echo $btn_link ? esc_url($btn_link) : '#'; ?>" class="btn <?php echo $btn_class; ?>"><?php echo $btn_text; ?></a>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-6">
                        <?php if( 'Video' == $content_type ){ ?>
                            <div class="video-block">
                                
                                <?php 
                                    $iframe = get_sub_field( 'why_readymix_video' );

                                    // Use preg_match to find iframe src.
                                    preg_match('/src="(.+?)"/', $iframe, $matches);
                                    $src = $matches[1];
                                    
                                    // Add extra parameters to src and replace HTML.
                                    $params = array(
                                        'controls'  => 0,
                                        // 'fs'        => 0,
                                        'autoplay'  => 0,
                                        'loop'      => 1
                                    );
                                    $new_src = add_query_arg($params, $src);
                                    $iframe = str_replace($src, $new_src, $iframe);
                                    
                                    // Add extra attributes to iframe HTML.
                                    $attributes = 'frameborder="0"';
                                    $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);
                                    echo $iframe;
                                ?>
                            </div>
                        <?php } else { ?>
                            <div class="image-block">
                                <img src="<?php echo get_sub_field('image')['url']; ?>" alt="<?php echo get_sub_field('image')['alt']; ?>">
                                <img class="img-mobile" src="<?php echo get_sub_field('mobile_image')['url']; ?>" alt="<?php echo get_sub_field('mobile_image')['alt']; ?>">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php
            endwhile;
            ?>
            <?php if ($show_contact_details_sub_section == 1) : ?>
                <div class="readymix-contact-info-block">
                    <div class="block-inner">

                        <div class="contact-info">
                            <h5><?php echo $sub_sec_title; ?></h5>
                            <?php if (is_array($contact_type_details) && !empty($contact_type_details)) : ?>
                                <ul>
                                    <?php if (isset($contact_type_details['contact_address']) && $contact_type_details['contact_address']) : ?>

                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="22" viewBox="0 0 23 22" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1143 4.125C8.83971 4.125 6.98926 5.97545 6.98926 8.25C6.98926 10.5246 8.83971 12.375 11.1143 12.375C13.3888 12.375 15.2393 10.5246 15.2393 8.25C15.2393 5.97545 13.3888 4.125 11.1143 4.125ZM11.1143 11C9.59789 11 8.36426 9.76637 8.36426 8.25C8.36426 6.73363 9.59789 5.5 11.1143 5.5C12.6306 5.5 13.8643 6.73363 13.8643 8.25C13.8643 9.76637 12.6306 11 11.1143 11ZM11.1143 0C6.55789 0 2.86426 3.69364 2.86426 8.25C2.86426 11.5763 4.02313 12.5052 10.2664 21.5561C10.6761 22.1479 11.5524 22.148 11.9622 21.5561C18.2054 12.5052 19.3643 11.5763 19.3643 8.25C19.3643 3.69364 15.6706 0 11.1143 0ZM11.1143 20.3642C5.12893 11.7085 4.23926 11.0212 4.23926 8.25C4.23926 6.4136 4.95439 4.68716 6.2529 3.38864C7.55142 2.09013 9.27786 1.375 11.1143 1.375C12.9507 1.375 14.6771 2.09013 15.9756 3.38864C17.2741 4.68716 17.9893 6.4136 17.9893 8.25C17.9893 11.0211 17.1001 11.7077 11.1143 20.3642Z" fill="#1D221E"></path>
                                            </svg>
                                            <span><?php echo $contact_type_details['contact_address']; ?></span>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (isset($contact_type_details['email_link']) && $contact_type_details['email_link']) : ?>
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="22" viewBox="0 0 23 22" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.3073 3.66663H2.92188C1.87809 3.66663 1.03125 4.51347 1.03125 5.55725V16.901C1.03125 17.9448 1.87809 18.7916 2.92188 18.7916H19.3073C20.3511 18.7916 21.1979 17.9448 21.1979 16.901V5.55725C21.1979 4.51347 20.3511 3.66663 19.3073 3.66663ZM2.92187 4.92704H19.3073C19.6539 4.92704 19.9375 5.21064 19.9375 5.55725V7.18791C19.0749 7.91659 17.8421 8.92099 14.0057 11.9657C13.34 12.4935 12.0284 13.7657 11.1146 13.75C10.2008 13.7657 8.88522 12.4935 8.2235 11.9657C4.38711 8.92099 3.15426 7.91659 2.29167 7.18791V5.55725C2.29167 5.21064 2.57526 4.92704 2.92187 4.92704ZM19.3073 17.5312H2.92187C2.57526 17.5312 2.29167 17.2476 2.29167 16.901V8.82646C3.18971 9.56301 4.60768 10.7013 7.43968 12.9504C8.24713 13.5963 9.67298 15.0183 11.1146 15.0104C12.5483 15.0222 13.9623 13.6121 14.7895 12.9504C17.6215 10.7013 19.0395 9.56301 19.9375 8.82646V16.901C19.9375 17.2476 19.6539 17.5312 19.3073 17.5312Z" fill="#1D221E"></path>
                                            </svg>
                                            <span><a href="mailto:<?php echo $contact_type_details['email_link'] ?>"><?php echo $contact_type_details['email_link']; ?></a></span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <?php if ($show_social_link == 1) : ?>

                            <div class="social-links">
                                <?php if( !empty( $social_link_title ) ): ?>
                                <h5><?php echo $social_link_title; ?></h5>
                                <?php endif; ?>
                                <?php
                                if (is_array($social_link_items) && !empty($social_link_items)) :
                                ?>
                                    <ul>
                                        <?php
                                        foreach ($social_link_items as $key => $social_link_item) {
                                        ?>
                                            <li>
                                                <a href="<?php echo $social_link_item['item_link']; ?>" target="_blank">
                                                    <img src="<?php echo $social_link_item['social_icons']['url']; ?>" alt="<?php echo $social_link_item['social_icons']['alt']; ?>">
                                                </a>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php 
                        endif; 
                        
                        if( is_array( $button_arr ) && !empty( $button_arr ) ){
                            $button_url  = ( isset( $button_arr['url'] ) && $button_arr['url'] ) ? $button_arr['url'] : '';
                            $button_label  = ( isset( $button_arr['title'] ) && $button_arr['title'] ) ? $button_arr['title'] : __( 'Get A Quote', 'readymix' );
                        ?>
                            <div class="button-wrap">
                                <a href="<?php echo $button_url; ?>" class="btn btn-pink small"><?php echo $button_label; ?></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php echo (($show_contact_details_sub_section == 1) ? '</div">' : ''); ?>
        </div>
    </section>
<?php
endif;
