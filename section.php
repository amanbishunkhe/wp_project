<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'] ?? '';
    $blockData = $_POST['blockData'] ?? '';
    $totalCalc = $_POST['totalCalc'] ?? '';

    // Decoding our data to the JSON string
    $data = json_decode($blockData, true);
    $totalCalc = json_decode($totalCalc, true);

    $output = '<html>
    <head><title>Concrete Calculator </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /></head>
        <body>';

    $output .= '
        <div class="page-banner" style="height: 100px;overflow:hidden;">
            <h1> Concrete Calculator </h1>
        </div>
        <div class="calculator-shape-wrap">
        ';

    foreach ($data as $key => $block) {
        $index = $block['index'];
        $block_shape = $block['shape'];
        $areaValue = $block['areaValue'];
        $volumeValue = $block['volumeValue'];
        
        $shapes = array(
            'reactangle' => 'item-rectangle',
            'square'=>'item-square',
            'circle' => 'item-circle',
            'triangle' =>'item-triangle',
            'pentagon' => 'item-pentagon',
            'parallelogram' => 'item-parallelogram'
        );

        $output .= '
            <div class="shape-block" data-index="'.$index.'">';
                foreach ($shapes as $shape => $dataShape) {
                    $select_class = ( $shape === $block_shape ) ? 'active-shape': '';
                    $output .='
                    <div data-shape="'.$dataShape.'" class="'.$shape.'-'.$select_class.'">
                        <img src="" width="500" height="600">
                        <label>'.ucfirst($shape).'</label>
                    </div>
                    ';
                }
            
            $output .='
            </div>

            <div class="calculator-block" data-index="'.$index.'" data-shape="'.$block_shape.'">
                ';
            $output .= '
            <div class="image-block">';
            // Add images based on shape
            $image_src = '';
            if ($block_shape == 'square') {
                $image_src = 'http://localhost/readymix-revamp/wp-content/plugins/geostone-concrete-calculator/images/square-guide.png';
            } elseif ($block_shape == 'circle') {
                $image_src = 'http://localhost/readymix-revamp/wp-content/plugins/geostone-concrete-calculator/images/circle-guide.png';
            } elseif ($block_shape == 'rectangle') {
                $image_src = 'http://localhost/readymix-revamp/wp-content/plugins/geostone-concrete-calculator/images/rectangle-guide.png';
            } elseif ($block_shape == 'triangle') {
                $image_src = 'http://localhost/readymix-revamp/wp-content/plugins/geostone-concrete-calculator/images/triangle-guide.png';
            } elseif ($block_shape == 'pentagon') {
                $image_src = 'http://localhost/readymix-revamp/wp-content/plugins/geostone-concrete-calculator/images/pentagon-guide.png';
            } elseif ($block_shape == 'parallelogram') {
                $image_src = 'http://localhost/readymix-revamp/wp-content/plugins/geostone-concrete-calculator/images/parallelogram-guide.png';
            }
            $output .= '
                <img decoding="async" src="'.$image_src.'">
            </div>';

        $output .= '
            <div class="calculator-wrap">
                <div class="calculator-dimensions">
                    <h3>Enter dimensions</h3>';
                    foreach ($block['dimensions'] as $key => $dimension) {                        
                        $output .= '
                        <div class="form-row">
                            <div class="half-col first">
                                <label>
                                    <span>m</span>
                                    <input type="text" title="'.$dimension['title'].'" name="dimension[0][w]" value="'.$dimension['value'].'" data-shape_type="'.$dimension['title'].'" data-type="'.$dimension['title'].'">
                                </label>
                            </div>
                        </div>';
                    }
                    $output .= '
                    <div class="form-row">
                        <div class="half-col first">
                            <input type="button" class="geo-calculate-btn geo-calculate-0 calculated" value="Calculated" >
                        </div>
                    </div>
                    <h3 class="show-results">Estimate for shape</h3>
                    <div class="form-row show-results">
                        <div class="half-col first">
                            <label>
                                <span>XX m<sup>2</sup></span>
                                <input type="text" title="Area" class="dimension-area dimension-area-0" value="'.$areaValue.'" readonly="" data-shape_type="square">
                            </label>
                        </div>
                        <div class="half-col last">
                            <label>
                                <span>XX m<sup>3</sup></span>
                                <input type="text" title="Volume" class="dimension-volume dimension-volume-0" value="'.$volumeValue.'" readonly="" data-shape_type="square">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ';
    }
    $output .= '
        </div>';

    $output .= '
        <div class="total-estimate-wrapper">
            <div class="total-estimate-wrap">
                <div class="estimate-content">
                    <h2>Your Concrete Estimate</h2>
                    <p>
                        NOTE: The estimate does not take into account specific ground conditions on site. Remember to always confirm quantities with your installer prior to ordering concrete.                
                    </p>
                </div>
                <div class="total-calculation-wrap">
                    <div class="total-area">
                        <div class="wrap">
                            <small>Total Area</small>
                            <span class="total">
                                <span>'.$totalCalc['totalArea'].'</span> m<sup>2</sup>
                            </span><!-- total -->
                        </div>
                    </div><!-- total-area -->
                    <div class="total-volume">
                        <div class="wrap">
                            <small>Total Volume</small>
                            <span class="total">
                                <span>'.$totalCalc['totalVolume'].'</span> m<sup>3</sup>
                            </span><!-- total -->
                        </div>
                    </div><!-- total-volume -->
                </div>
            </div><!-- total-estimate-wrap -->
        </div>
    </body>
    </html>';

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4-L',
        'tempDir' => '/var/www/html/readymix-revamp/wp-content/themes/readymix/tmp/mpdf'
    ]);

    // Write HTML to PDF
    $mpdf->WriteHTML($output);

    // Output PDF directly to browser
    $mpdf->Output('filename.pdf', \Mpdf\Output\Destination::INLINE);
    
    exit();
}
