<?php
add_action( 'init', 'download_redirect' );
function download_redirect() {
	if ( isset( $_GET['print_id'] ) ) {

		// Get State ID
		if ( isset( $_GET['_state'] ) ) {
			$stateId = $_GET['_state'];
		} else {
			$stateId = null;
		}

		// Get Region ID
		if ( isset( $_GET['_region'] ) ) {
			$regionId = $_GET['_region'];
		} else {
			$regionId = null;
		}

		// Get Region ID
		if ( isset( $_GET['_stone'] ) ) {
			$stoneId = $_GET['_stone'];
		} else {
			$stoneId = null;
		}

        if(isset($_GET['_type'])) {
            $typeId = $_GET['_type'];
        }else {
            $typeId = null;
        }

        view_brochure($stateId, $regionId, $stoneId, $typeId);

	}
}

function view_brochure($state, $region, $stone, $type ) {
    
	// require_once("../vendor/autoload.php");
	// require_once __DIR__ . '/../vendor/autoload.php';
    $output = '<html>
    <head><title>Readymix - Download Brochure</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /></head>
    <style>
   
    @font-face {
        font-family: Poppins, sans-serif;
        src: local(Poppins-SemiBold), url(wp-content/themes/readymix/fonts/Poppins-SemiBold.woff2) format("woff2"), url(wp-content/themes/readymix/fonts/Poppins-SemiBold.woff) format("woff");
        font-weight: 600;
        font-style: normal; }
      
    @font-face {
        font-family: Poppins, sans-serif;
        src: local(Poppins-Bold), url(wp-content/themes/readymix/fonts/Poppins-Bold.woff2) format("woff2"), url(wp-content/themes/readymix/fonts/Poppins-Bold.woff) format("woff");
        font-weight: 600;
        font-style: normal; }

    @font-face {
        font-family: Nunito, sans-serif;
        src: local(Nunito-Regular), url(wp-content/themes/readymix/fonts/Nunito-Regular.woff2) format("woff2"), url(wp-content/themes/readymix/fonts/Nunito-Regular.woff) format("woff");
        font-weight: 400;
        font-style: normal; }

    @font-face {
        font-family: Nunito, sans-serif;
        src: local(Nunito-SemiBold), url(wp-content/themes/readymix/fonts/Nunito-SemiBold.woff2) format("woff2"), url(wp-content/themes/readymix/fonts/Nunito-SemiBold.woff) format("woff");
        font-weight: 600;
        font-style: normal; }

        body {
            font-family: Nunito, sans-serif;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
        }
        .printable {
        border-collapse: collapse;
        border: 1px solid #ddd;
        }
        .printable td {
        border:1px solid #ddd;
        padding:5px;
        }

    .page-banner {
        position:relative;
        height: 100px;
        overflow: hidden;
    }
    .page-banner img {
        object-fit: cover;
        height: 100px;
    }
    .page-banner-title {
        padding: 15px 0 25px;
        font-family: Poppins, serif;
        font-size: 11px;
        font-weight: 400;
        line-height: 1.23;
        color: #374255;
    }
    .page-banner-title .state {
        display: inline-block;        
        margin-right: 30px;
    }
    .page-banner-title .region {
        display: inline-block;
    }
    .page-banner-title span {
        display: block;
        color: #374255;
        font-family: Nunito, sans-serif;
        width: 200px;
        min-width: 200px;
        border-bottom: 1px solid #ececec;
    }

    .row {
        width: 100%;
        padding: 0px 0;
        clear: both;
    }
        .product-item {
        text-align: center;
        float: left;
        display: inline-block;
        width: 25%;
        margin: 0px 0px 15px;
    }
    .product-item .inner {
        overflow: hidden;
        margin: 0 3px;
        border-radius: 5px;
        position: relative;
    }
    .product-item .image-holder {
        margin: 0;
        background-color: grey;
        border-radius: 5px;
        overflow: hidden;
    }
    .product-item .image-holder .abs-bg-block {
        width: 100%;
        height: 170px;
        display: block;
       background-size: cover;
       background-position: center;
       border-radius: 5px 5px 0 0;
       overflow: hidden;
    }
    
    .product-item .detail {
        padding: 10px;
    }
    .product-item .detail .mata-cat {
        font-family: Nunito, sans-serif;
        font-size: 8px;
        font-weight: 600;
        line-height: 1;
        color: #8b8d8e;
        margin-bottom: 0;
        min-height: 50px;
    }
    .product-item .detail .product-name {
        display: block;
        font-size: 15px;
        line-height: 1.23;
        color: #374255;
        margin: 0;
        padding: 0;
        padding-top: 6px;
        font-weight: 400;   
    }   

      

    </style>
    <body>';

    $stateTerm = get_term_by('id', $state, 'readymix_state');
    if($stateTerm) {
        $stateTermName = $stateTerm->name . '';
    } else {
        $stateTermName = '';
    }
    $regionTerm = get_term_by('id', $region, 'readymix_state');
    if($regionTerm) {
        $regionTermName = '' . $regionTerm->name . '';
    } else {
        $regionTermName = '';
    }

    $typeTerm = get_term_by('id', $type, 'readymix_type');
    if($typeTerm) {
        $typeTermName = '' . $typeTerm->name . '';
    } else {
        $typeTermName = '';
    }

    $stoneTerm = get_term_by('id', $stone, 'readymix_type');
    if($stoneTerm) {
        $stoneTermName = $stoneTerm->name . '';
    } else {
        $stoneTermName = '';
    }
    // Show banner image
    if($stoneTermName == 'Driveways') {
        $bannerUrl = 'GEO_BrochureBannerImagery_3Driveways.jpg';
    } elseif($stoneTermName == 'Pools & Outdoor Entertainment' || $stoneTermName == 'Pools &amp; Outdoor Entertainment') {
        $bannerUrl = 'GEO_BrochureBannerImagery_3Pools&OutdoorEntertainment.jpg';
    } elseif($stoneTermName == 'Polished Floors') {
        $bannerUrl = 'GEO_BrochureBannerImagery_3IndoorsPolished.jpg';
    } elseif($stoneTermName == 'Coloured Concrete') {
        $bannerUrl = 'GEO_BrochureBannerImagery_3Coloured_Concrete.jpg';
    } elseif($stoneTermName == 'Polished / Honed Concrete') {
        $bannerUrl = 'GEO_BrochureBannerImagery_3ByTypePolished.jpg';
    } elseif($stoneTermName == 'Exposed Concrete') {
        $bannerUrl = 'GEO_BrochureBannerImagery_3Exposed.jpg';
    } elseif($stoneTermName == 'Readymix Pinnacle') {
        $bannerUrl = 'GEO_BrochureBannerImagery_5PinnacleRange.jpg';
    } else {
        $bannerUrl = 'GEO_BrochureBannerImagery_5Default.jpg';
    }
    
    $output .='
        <div class="page-banner" style="height: 100px;overflow:hidden;">
            <img alt="' . $stoneTermName . '" src="wp-content/themes/readymix/images/brochure/' . $bannerUrl . '" />
        </div>
    ';

    $separator = '';
    $reg_separator = '';
    if( !empty( $stateTermName ) )  {
        $separator = ' &nbsp; | &nbsp; ';
    }elseif( !empty( $regionTermName ) ){
        $reg_separator = ' &nbsp; | &nbsp; ';
    }else{
        $separator = '';
        $reg_separator = '';
    }

	$output .= '<div class="page-banner-title">
        <span class="state">' . $stateTermName . '</span> '.$separator.'
        <span class="region">' . $regionTermName . '</span> '.$reg_separator.'
        <span class="stone">' . $typeTermName . '</span>
    </div>';

    //post type and taxonomy
	$readymix_cpt_type = 'readymix_product';
    $readymix_taxonomy = 'readymix_state';
    $readymix_type_taxonomy = 'readymix_type';
    
    
	//Get states and regions(terms) of taxonmy(readymix state) 
	$states = get_terms(
		array(
			'taxonomy'   => $readymix_taxonomy,
			'hide_empty' => false
		)
	);

    $types = get_terms(
		array(
			'taxonomy'   => $readymix_type_taxonomy,
			'hide_empty' => false
		)
	);
	//default values of variables
	$args = array();
	$filters = array();
	$tax_query = array();
	$child_term_id = array(); 
	$parent_term_name = array();

	// Query argugments for products filtering listing for pages
	// for differenct conditions
	$paged = ( isset( $_GET['_paged'] ) && $_GET['_paged'] ) ? intval( $_GET['_paged'] ) : 1;

	// default args
	$args = array(
		'post_type'      => 'readymix_product',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		 'paged'          => intval( $paged ) ? intval( $paged ) : 1,
		// 'meta_key'		 => 'volume',
		// 'orderby'		 => 'meta_value_num',
		'order'			 => 'DESC',
	);

	//tax query args
    // state tax
    if ( $state ) {
        $tax_query[] = array(
            'taxonomy' => $readymix_taxonomy,
            'field'    => 'term_id',
            'terms'    => sanitize_text_field( $state )
        );

        $filters['_state'] = $state;
    }

    // state tax for region
    if ( $region ) {
        $tax_query[] = array(
            'taxonomy' => $readymix_taxonomy,
            'field'    => 'term_id',
            'terms'    => sanitize_text_field( $region )
        );

        $filters['_region'] = $region;
    }

    if ( $type ) {
        $tax_query[] = array(
            'taxonomy' => $readymix_type_taxonomy,
            'field'    => 'term_id',
            'terms'    => sanitize_text_field( $type )
        );

        $filters['_type'] = $type;
    }


  
    $stone_type = array();
	if ( $stone ) {
		$stone_type = $stone;
		$tax_query[] = array(
			'taxonomy' => 'readymix_type',
			'field'    => 'term_id',
			'terms'    => $stone_type
		);

	}

	// add tax query to args
	if ( ! empty( $tax_query ) ) {
		$args['tax_query'] = $tax_query;
    }
    
    // query products with supplied args
    $products = new WP_Query( $args );    

    if ( $products->have_posts() ) {
        global $post;						
        $pg_state = "";
        $pg_region = "";
        $pg_type = "";
        $query_arr_params  = "";
            //state dropdown filter used
        if( isset( $filters['_state'] ) && !empty( $filters['_state'] ) ){
            $pg_state = $filters['_state'];
        }
            //region dropdwon filter used
        if( isset( $filters['_region'] ) && !empty( $filters['_region'] ) ){
            $pg_region = $filters['_region']; 
        }

        if( isset( $filters['_type'] ) && !empty( $filters['_type'] ) ){
            $pg_type = $filters['_type']; 
        }
            //product link, add query args 
        $query_arr_params = array( 'pg_state' => $pg_state, 'pg_region' => $pg_region, 'pg_type'=>$pg_type  );

        $output .= '<div class="product-grid">';

        $counter=1;
        $total_posts = $products->found_posts;
       
        while ( $products->have_posts() ) {
            $products->the_post();
                //default fallback product card image
            $product_image = get_template_directory_uri() . '/images/image_4.jpg';
                //if featured product card image set
            $featured_image = get_the_post_thumbnail_url( '', 'card-thumbnail' );
            if ( !empty ( $featured_image) ){
                $product_image = $featured_image;
            }
            $title = get_the_title();

            $typeId = $_GET['_type'];
           
            //Display featured image as per the page
            /* if ( have_rows( '_product_featured_image', get_the_ID() ) ):
                 while( have_rows( '_product_featured_image', get_the_ID() ) ): the_row();

                     $types = get_sub_field( 'type' );
                    echo '<pre>';print_r($types);echo '</pre>';
                   
                    foreach ($types as $type) {
                        if ( $type->ID == get_the_ID()){
                            echo $product_image = get_sub_field( 'featured_image' )['url'];
                        }
                     }
                    
                endwhile;
             endif; */

			$featImageUrl = strstr($product_image, 'wp-content/'); // make the image path local
          
            $output .= '
                <div class="product-item">	
                    <div class="inner">
                        <div class="image-holder">
                            <div class="abs-bg-block" style="background-image: url('.$featImageUrl.');height: 120px;width:100%;"></div>
                        </div>
                        <div class="detail">
                            ';
            if ($typeId != 423) {
                    $output .= single_product_terms_listing($post, $readymix_taxonomy, $filters);
            }
            $output .= '         									
                            <h5 class="product-name" style="font-family: "Nunito", sans-serif;"><span>'. $title .'</span></h5>
                        </div>
                    </div>
                </div>
            ';
            
            // $output .= $counter;
           
            if($counter < $total_posts) {
              
                if ($counter < $total_posts && ($counter == 12 || (($counter - 12) % 16 == 0))) {
                    $output .= '<pagebreak />';
                }
                $counter++; 
            }
             
        } //  end loop $products->have_posts
        wp_reset_postdata();
        $output .= '</div>'; 
    } 

	// $output .= '<div>State ID: ' . $state . '</div>';
	// $output .= '<div>Region ID: ' . $region . '</div>';

	$output .= '
    </body>
    </html>';
    
    if($stateTermName && $regionTermName) {
        $filenameExport = 'Readymix-'. $stateTermName .'-'. $regionTermName .'-'. date("Ymd"). '.pdf';
    } elseif($stateTermName) {
        $filenameExport = 'Readymix-'. $stateTermName .'-'. date("Ymd"). '.pdf';
    } elseif($regionTermName) {
        $filenameExport = 'Readymix-'. $regionTermName .'-'. date("Ymd"). '.pdf';
    } else {
        $filenameExport = 'Readymix-Brochure-'. date("Ymd"). '.pdf';
    }
    
	// require_once __DIR__ . '/../vendor/mpdf/mpdf/src/Mpdf.php';
// 	require_once '/wp-content/themes/readymix/vendor/mpdf/mpdf/src/mpdf.php';
// 	require_once $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/readymix/vendor/mpdf/mpdf/src/Mpdf.php';


    // $mpdf=new mPDF('c', 'A4-L');
    $mpdf = new \Mpdf\Mpdf([
        // 'setAutoTopMargin' => 'stretch',
        'format' => 'A4',
        'margin_left' => 5,
        'margin_right' => 5,
        'margin_top' => 5,
        'margin_bottom' => 0
    ]);
    
    

	$mpdf->SetHTMLFooter( '
    <table width="100%" style="font-size: 9px;font-family: Poppins, serif;font-weight: 400;line-height: 1.1;background-color: #374255;color: #ffffff;padding: 20px;">
        <tr>
            <td width="33%">
                <img src="wp-content/themes/readymix/images/brochure/Readymix_logo_rev.svg" width="130" height="auto" />
            </td>
            <td width="33%" align="center" style="font-family: Nunito;">
                {PAGENO}/{nbpg}<br>
                {DATE j-m-Y}<br>
                <!--' . $stateTermName . ' &nbsp; | &nbsp; ' . $regionTermName . '-->
            </td>
            <td width="33%" style="text-align: right;font-family: Nunito;">
               <div style="display:inline-block;vertical-align:middle;">
                    <span style="display:inline;vertical-align:middle;"><a style="text-decoration: none;" href="#" target="_blank">&nbsp;<img src="wp-content/themes/readymix/images/brochure/social/Instagram@2x.png" width="15" height="auto" />&nbsp;</a>&nbsp;</span>
                    
                    <span style="display:inline;vertical-align:middle;"><a style="text-decoration: none;" href="#" target="_blank">&nbsp;<img src="wp-content/themes/readymix/images/brochure/social/fb@2x.png" width="15" height="auto" />&nbsp;</a></span>
                    <span style="display:inline;vertical-align:middle;"><a style="text-decoration: none;" href="#" target="_blank">&nbsp;<img src="wp-content/themes/readymix/images/brochure/social/youtube@2x.png" width="15" height="auto" />&nbsp;</a></span>
               </div>             
            </td>
        </tr>
    </table>');
   
    $mpdf->WriteHTML($output);
    // $mpdf->Output(['test.pdf']); //'readymix-Brochure-'. date("Ymd"). '.pdf'
    $mpdf->Output($filenameExport, \Mpdf\Output\Destination::INLINE);
    exit;   
}