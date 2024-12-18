<?php

/**
 * Find Installer Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'readymix-display-center-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'readymix-display-center';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

$style = '';

if ($color = get_field('section_color')) {
    $style = "background-color: {$color}";
}
$section_title = get_field('section_title');
$description = get_field('description');
?>
<section class="section-display-center section-common-default" style="<?php echo $style; ?>" id="<?php echo $id; ?>" >
    <div class="container">
        <div class="section-title">
            <h2><?php echo $section_title; ?></h2>
            <?php echo $description; ?>
        </div>
        <?php  get_template_part('template-parts/blocks/common-display-center'); ?>
    </div>
</section>