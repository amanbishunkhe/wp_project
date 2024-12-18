<?php
/**
 * Readymix Woocommerce Product Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'woocommerce-products-block-' . $block['id'];
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
$section_color = get_field( 'section_color' );
$section_title = get_field( 'section_title' );
$category_option = get_field('wc_select_category','option');  
$no_cat_class = '';
if( !empty( $category_option ) ){
    $no_cat_class = '';
}else{
    $no_cat_class = 'section-product-alt'; 
}

if ( $section_color){
    $style = "style='background-color:".$section_color.";'";
}else{
    $style = "";
}
?>
<section class="section-products <?php echo $no_cat_class; ?> " <?php echo $style ?>>
    <div class="container">
        <?php if( !empty( $section_title ) ): ?>
        <div class="section-title" >
            <h2><?php echo $section_title ; ?></h2>
        </div>
        <?php endif; ?>
        <div class="products-grid">
            <?php           
            $add_to_cart_class = '';
            if( is_shop() ){
                $add_to_cart_class = 'no-cart-btn';
                $wc_products_args = array(
                    'post_type' => 'product',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                 );
            }else{
                $add_to_cart_class = '';
                $wc_products_args = array();
                if( !empty( $category_option ) ){
                   $wc_products_args =  array( 
                      'post_type' => 'product',
                      'post_status' => 'publish',
                      'posts_per_page' => 4,
                      'tax_query' => array(
                            array(
                               'taxonomy' => 'product_cat',
                               'field'    => 'term_id',
                               'terms'    => $category_option,
                               ),
                      ),
                   );
                }else{
                   $wc_products_args = array(
                      'post_type' => 'product',
                      'posts_per_page' => 4,
                      'post_status' => 'publish',
                   );
                }    
            }
   
            $wc_products_query = new WP_Query( $wc_products_args );

            while ($wc_products_query->have_posts()) {
                $wc_products_query->the_post();
                $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
                // $full_size_image   = wp_get_attachment_image_src($post_thumbnail_id, 'full');
                $terms = get_the_terms(get_the_ID(), 'product_cat');
                $product = wc_get_product( get_the_ID() );
                ?>
                <div class="product-card product-card-<?php echo get_the_ID(); ?>">
                    <div class="card-inner">
                        <div class="card-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                if( has_post_thumbnail() ){
                                    echo get_the_post_thumbnail('', 'large');   
                                }else{
                                    ?>
                                    <img src="<?php echo get_template_directory_uri().'/images/woocommerce-placeholder.png'; ?>" >
                                    <?php
                                } 
                                ?>
                            </a>
                        </div>
                        <div class="card-content <?php echo $add_to_cart_class; ?>">
                            <div class="content-inner">
                                <h3>
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    <?php if( is_array( $terms ) && !empty( $terms ) ): ?>
                                    <div class="category">
                                        <?php 
                                        foreach ($terms as $key => $term) {
                                            ?>
                                            <span><?php echo $term->name; ?></span>
                                            <?php
                                        }
                                        ?>                                        
                                    </div>
                                    <?php endif; ?>
                                </h3>
                                <?php if ($price_html = $product->get_price_html()) : ?>
                                    <div class="price"><?php echo $price_html; ?></div>
                                <?php endif; ?>
                            </div>
                            <?php // if( ! is_shop() ): ?>
                            <div class="button-wrap">
                                <?php woocommerce_template_loop_add_to_cart(); ?>
                            </div>
                            <?php // endif; ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>