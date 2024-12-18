<?php
/**
 * Why Readymix Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'signpost-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$title = get_field( 'title' );
$intro = get_field( 'intro' );

$style = '';
$section_colour = get_field( 'section_colour' );

if ( $section_colour){
    $style = "style='background-color:".$section_colour.";'";
}
?>

<section class="why-readymix clearfix" <?php echo $style; ?>>
    <?php
    if ($intro || $title){
        ?>
        <div class="title-row">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 wow fadeInUp">
                        <h2 style="max-width: none;"><?php echo $title; ?></h2>
                    </div>
                    <div class="col-lg-12 wow fadeInUp">
                        <?php echo $intro; ?>
                    </div>
                </div>
            </div>
        </div><!-- .title-row -->
        <?php
    }

    if ( have_rows( 'showcase_why' ) ):
        ?>
        <div class="grid-tiles">
            <div class="container">
                <div class="grid-wrap">
                    <?php
                    while ( have_rows( 'showcase_why' ) ): the_row();
                        ?>
                        <div class="tile wow fadeInUp">
                            <?php echo wp_get_attachment_image( get_sub_field('image')['id'], 'full', '', array('class'=>'bg-image') ); ?>
                            <span class="overlay"></span>
                            <?php
                            $showcase_link_detail = get_sub_field('link');                         
                            // $showcase_url = isset($showcase_link_detail['url'])? $showcase_link_detail['url'] : '';
                            $showcase_target = isset($showcase_link_detail['target'])? "target = ".$showcase_link_detail['target'] : '';  
                            ?>
                            <?php if( isset( $showcase_link_detail['url'] ) && !empty( $showcase_link_detail['url'] ) ): ?>
                            <a class="abs-link" href="<?php echo $showcase_url; ?>" <?php echo $showcase_target; ?> ></a>
                            <?php endif; ?>
                            <div class="tile-content">
                                <h3><?php echo get_sub_field('title'); ?></h3>
                                <p><?php echo get_sub_field('info'); ?></p>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
        <?php
    endif;
    ?>
    </section><!-- .why-readymix-sec -->