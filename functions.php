<?php
/**
 * readymix functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package readymix
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '2.0.8' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function readymix_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on readymix, use a find and replace
		* to change 'readymix' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'readymix', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );
	add_image_size('card-thumbnail', 376, 281, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'readymix' ),
			'menu-2' => esc_html__( 'Footer Top', 'readymix' ),
			'menu-3' => esc_html__( 'Footer Bottom', 'readymix' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'readymix_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
	add_post_type_support( 'page', 'excerpt' );

	// makes our theme WC compatible
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

add_action( 'after_setup_theme', 'readymix_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function readymix_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'readymix_content_width', 640 );
}

add_action( 'after_setup_theme', 'readymix_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function readymix_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'readymix' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'readymix' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}

add_action( 'widgets_init', 'readymix_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function readymix_scripts() {

	$min = ".min";
    if (SCRIPT_DEBUG == false) {
        $min = '';
    }

    $themeDir = get_theme_file_uri();


    wp_register_style('readymix-style', $themeDir . '/assets/css/main' . $min . '.css', array(), _S_VERSION, 'all');

	wp_enqueue_style('jquery-ui-style ', '//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');

    wp_register_script('readymix-vendor-js', $themeDir . '/assets/js/vendor' . $min . '.js', array('jquery'), _S_VERSION);
	
    wp_register_script('readymix-custom-js', $themeDir . '/assets/js/main' . $min . '.js', array('jquery'), _S_VERSION, true);

	wp_localize_script( 'readymix-custom-js', 'ReadymixAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce('readymix_nonce')));

	wp_enqueue_style('readymix-style');
    wp_enqueue_script('readymix-vendor-js');
    wp_enqueue_script('readymix-custom-js');

	global $post;
	$video_popup_page = $themeDir . '/ajax-popup.php';
    $ajax_url = admin_url('admin-ajax.php');
    $home_url = home_url('/');

    $current_page_id = '';
    if (isset($post->ID)) {
        $current_page_id = $post->ID;
    }

	$display_center_data = get_dynamic_taxonomy_data('display-center-state');
	$readymix_product_data = get_dynamic_product_taxonomy_data('readymix_state');
	//echo '<pre>';print_r($readymix_product_data);echo '</pre>';

	$google_map_style = get_field('_readymix_google_map_style', 'option');
    wp_localize_script('readymix-custom-js', 'readymixOptions', array(
      //  'videoPopupPage' => esc_url( add_query_arg( array( '_ppid' => get_the_ID() ), $video_popup_page ) ),
        'ajaxURL' => $ajax_url,
        'homeURL' => $home_url,
        'current_page_id' => $current_page_id,
        'mapMarker' => get_template_directory_uri() . '/images/iconfinder_map-marker_383108.png',
        'mapMarkerBig' => get_template_directory_uri() . '/images/iconfinder_map-marker_383108-big.png',
        'googleMapStyle' => $google_map_style ? $google_map_style : array(),
		'display_center_data' => $display_center_data,
		'readymix_product' => $readymix_product_data
    ));

	if(is_tax()) {
		$mapAPI = get_field('_readymix_google_map_api_key', 'option');
		//$mapAPI = 'AIzaSyAVKqz-EGgFEcay-7Salas8SSPrTn0P1Xg';
        if ($mapAPI) {
            // wp_enqueue_script( 'readymix-google-map-marker-cluster', 'https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js', '', '', true );
            wp_enqueue_script('readymix-google-map', 'https://maps.googleapis.com/maps/api/js?key=' . $mapAPI . '&callback=initMapReadymix', array('readymix-custom-js'), '', true);
        }
	}
	
	if( is_page( 'get-a-quote' ) ){
		$mapAPI = get_field('_readymix_google_map_api_key', 'option');
		wp_enqueue_script( 'readymix-google-map', 'https://maps.googleapis.com/maps/api/js?key=' . $mapAPI . '&callback=initAutocomplete&libraries=places&v=weekly', array( 'readymix-custom-js' ), '', true );
	}
	// Load google maps api for get a quote address autocomplete   		
	
	

	wp_enqueue_style( 'readymix-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'readymix-style', 'rtl', 'replace' );

	//wp_enqueue_script( 'readymix-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'readymix-faqs', get_template_directory_uri() . '/resources/js/custom/faqs.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'readymix_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/custom-post-type.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

if ( file_exists( get_template_directory() . "/inc/acf-functions.php" ) ) {
	require_once get_template_directory() . "/inc/acf-functions.php";
}

if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// Reading data from Gsheet.
require get_template_directory() . '/vendor/autoload.php';

/**
 * Init Download Brochure Handler.
 */
require get_template_directory() . '/brochure-download.php';


/**
 * To initialize Google Map
 */
add_action('wp_head', function() {
	?>
	<script type="text/javascript">
        function initMapReadymix() { 
            if( jQuery('body').hasClass('page-template-tpl-display-center') || jQuery('body').hasClass('tax-display-center-state') ) {
                jQuery(document.body).trigger('display_centre_init_map');
            }

            if (jQuery('.init-installer-map').length) {
                jQuery(document.body).trigger('init_installer_map');
            }
        }
    </script>
    <?php
    $ga_tracking_code = get_field( '_tracking_code', 'option' );

    if ( $ga_tracking_code ){
        echo $ga_tracking_code; 
    }
    ?>
    <?php
}, 9999 );


function readymix_default_page($page)
{
    $default_pages = get_field('_readymix_default_pages', 'option');

    if (isset($default_pages[$page]) && $default_pages[$page]) {
        return $default_pages[$page];
    }

    return '';
}

