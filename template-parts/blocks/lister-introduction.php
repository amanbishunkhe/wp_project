<?php
/**
 * Product Lister Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'lister-introduction-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-lister-introduction';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

$title = get_field( 'title' );
$info = get_field( 'info' );
$has_button = get_field( 'has_buttons' );

$style = '';
$section_colour = get_field( 'section_colour' );

if ( $section_colour){
    $style = "style='background-color:".$section_colour.";'";
}
?>

<section class="intro-module" <?php echo $section_colour; ?>>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 content-col  match-height wow fadeInUp">
                <h2><?php echo $title; ?></h2>
                <p class="Paragraph-Gray-16px-Left"><?php echo $info; ?></p>

                <?php
                /* $suitable = get_field( 'suitable_for' );
                if (!empty ( $suitable) ){
                    ?>
                    <h6>Suitable for:</h6>
                    <p><?php echo $suitable; ?></p>
                    <?php
                } */

                if ( $has_button == 'Yes' ){
                    if ( have_rows( 'buttons' ) ):
                        ?> 
                        <div class="button-wrap">
                            <?php
                            while ( have_rows('buttons') ): the_row();
                                $button_link = get_sub_field( 'button_link' ); 
                                $link_target = isset($button_link['target'])? "target = ".$button_link['target'] : '';  
                                ?>
                                <a href="<?php echo $button_link ? esc_url( $button_link['url'] ): '#'; ?>"  class="btn <?php echo get_sub_field('button_class'); ?>" <?php echo $link_target; ?>><?php echo get_sub_field( 'button_label' ); ?> </a>
                                <?php
                            endwhile;
                            ?>
                        </div>
                        <?php

                    endif;
                }
                ?>
            </div>
            <div class="col-lg-6 list-col match-height  wow fadeInUp">
                <ul>
                    <?php
                    if ( have_rows( 'points_to_list') ):
                        while ( have_rows( 'points_to_list' )): the_row();
                            $tick_type = get_sub_field( 'tick_type' );

                            if ( $tick_type == 'Default'){
                                $src = get_template_directory_uri().'/images/icons-check.svg';
                            }else{
                               $src = get_sub_field( 'image' );
                           }
                           ?>
                           <li class="Paragraph-Gray-16px-Left"><img class="svg" src="<?php echo $src; ?> " alt=""><?php echo get_sub_field( 'point' ); ?>
                       </li>
                       <?php
                   endwhile;
               endif;
               ?>
           </ul>

           <?php
           if ( $has_button == 'Yes' ){
            if ( have_rows( 'buttons' ) ):
                ?>
                <div class="button-wrap">
                    <?php
                    while ( have_rows('buttons') ): the_row();
                        $button_link = get_sub_field( 'button_link' );
                        $link_target = isset($button_link['target'])? "target = ".$button_link['target'] : '';
                        ?>
                        <a href="<?php echo $button_link ? esc_url( $button_link['url'] ): '#'; ?>"  class="btn <?php echo get_sub_field('button_class'); ?>" <?php echo $link_target; ?>><?php echo get_sub_field( 'button_label' ); ?> </a>
                        <?php
                    endwhile;
                    ?>
                </div>
                <?php

            endif;
        }
        ?>
    </div>
</div>
</div>
    </section><!-- .intro-module -->