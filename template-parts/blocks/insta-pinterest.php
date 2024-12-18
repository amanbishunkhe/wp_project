<?php
/**
 * Instagram Pinterest Block Template.
 *
 */
// Create id attribute allowing for custom "anchor" value.
$id = 'insta-pinterest-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-insta-pinterest';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

if (get_field('instagram_or_pinterest') != false && get_field('instagram_or_pinterest') == 'Instagram') {
    ?>
    <section class="insta-wrap">
        <div class="container">
            <?php
            $insta_handle = '';
            $handle_name = '';
            $handle_link = '';

            $insta_handle = get_field('instagram_handle');
            if (!empty($insta_handle)) {
                $handle_name = $insta_handle['title'];
                $handle_link = $insta_handle['url'];
            }
            ?>
            <h4 class=""><?php the_field('instagram_title'); ?>
                <a href="<?php echo $handle_link; ?>" target="_blank"><?php echo $handle_name; ?></a>
            </h4>
        </div><!-- .container -->
        <?php
        if (get_field('instagram_embed_code') != false) {
            get_field('instagram_embed_code');
        }
        ?>
    </section><!-- .insta-wrap -->
<?php } ?>

<?php if (get_field('instagram_or_pinterest') != false && get_field('instagram_or_pinterest') == 'Pinterest') { ?>
    <section class="pinintrest-wrap">
        <div class="container">
            <h4 class=""><?php the_field('pinterest_title'); ?></h4>
            <div class="main-wrap custom-scroll-wrap">
                <?php
                if (get_field('pinterest_embed_code') != false) {
                    get_field('pinterest_embed_code');
                }
                ?>
            </div><!-- .main-wrap -->
        </div><!-- .continer -->
    </section><!-- .pinintrest-wrap -->
<?php } ?>



