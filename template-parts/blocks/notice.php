<?php
$style = '';

if( $color = get_field( '_notice_block_background_colour' ) ) {
    $style = "background-color: {$color}";
}

?>

<section class="before-start-wrapper" style="<?php echo $style; ?>">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="H4-Black-Left">
					<?php if ( $icon = get_field( '_notice_block_title_icon' ) ) { ?>
                        <img class="svg" src="<?php echo esc_url( $icon ); ?>" alt="notice">
					<?php } ?>

					<?php
					if ( $title = get_field( '_notice_block_title' ) ) {
						echo $title;
					}
					?>
                </h2>

				<?php if ( $info = get_field( '_notice_block_info' ) ) { ?>
                    <p class="Paragraph-Gray-16px-Left"><?php echo $info; ?></p>
				<?php } ?>

				<?php if ( $notice = get_field( '_notice_block_notice' ) ) { ?>
                    <div class="notice-wrapper">
                        <p class="Paragraph-Gray-16px-Left"><?php echo $notice; ?></p>
                    </div>
				<?php } ?>

            </div>
        </div>
    </div>
</section>