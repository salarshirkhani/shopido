<?php
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/woocommerce.php';

function mytheme_customizer_styles() {
    ?>
    <style type="text/css">
        body {
            background-color: <?php echo get_theme_mod('background_color', '#ffffff'); ?>;
            font-family: <?php echo get_theme_mod('primary_font', 'Arial, sans-serif'); ?>;
        }
    </style>
    <?php
}

add_action('wp_head', 'mytheme_customizer_styles');
