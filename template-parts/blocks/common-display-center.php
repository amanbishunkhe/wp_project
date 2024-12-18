<?php
/** 
 * Display center template used in display center block and in taxonomy display center
 */
// get states for display center
$states = get_terms(
    array(
        'taxonomy' => 'display-center-state',
        'hide_empty' => false,
    )
);
?>
<div class="fliter-wrapper" id="display-center-filter">
    <div class="container">
        <input type="hidden" name="page_permalink" id="current-page-permalink"
            value="<?php the_permalink(); ?>">
        
        <!-- test on new dropdown using select2 -->
        <?php  ?>
        <div class="custom-select-option select-area state-region-drop">
            <h6 class="H6-Black-Left-Bold"><?php _e('Select your area', 'readymix'); ?></h6>
            <div class="filter-row">
            <div class="selection-option-list">
                <select name="" id="select_state" class="select-state select2">
                    <?php if( $states ): ?>
                        <option  value=""><?php _e('Select State', 'readymix'); ?></option>
                        <?php foreach( $states as $state ): 
                            if( 0 !== $state->parent  ){
                                continue;
                            }
                            ?>
                            <option value="<?php echo $state->slug ?>"><?php echo $state->name ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>    
                </select>
            </div>
            </div>

            <div class="filter-row filter-row-region disabled">
                <div class="selection-option-list">
                    <select name="" id="select_region" class="select-region ignore select2">
                        <?php if ($states) { ?>
                            <option value=""><?php _e('Select Region', 'readymix'); ?></option>
                            
                        <?php }  ?>
                    </select>
                </div>
            </div>

            <div class="filter-row  submit-wrap">
                <button class="btn btn-pink small" data-redirects="" id="display-center-submit" disabled><?php _e('Submit', 'readymix'); ?></button>
            </div>

        </div>
        <br><br>       
    </div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
        var url = window.location.href;
        var urlParts = url.split('/');
        var visitIndex = urlParts.indexOf('visit-display-centre');

        if (visitIndex !== -1) {
            var changed_state = urlParts[visitIndex + 1]; 
            var changed_region = urlParts[visitIndex + 2]; 
            if( changed_state){
                $('#select_state').val(changed_state).trigger('change');
            }
            setTimeout(function(){
                if( changed_region){
                    $('#select_region').val(changed_region).trigger('change');
                }
            },500);
        } 
    });
</script>