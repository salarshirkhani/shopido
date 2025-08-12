<?php
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/woocommerce.php';

if ( ! function_exists('shopido_customizer_styles') ) {
    function shopido_customizer_styles() {
        $bg   = get_theme_mod('background_color', '#ffffff');
        $font = get_theme_mod('primary_font', 'Arial, sans-serif');

        // در صورت تمایل می‌تونی sanitize دقیق‌تر انجام بدی:
        // $bg = sanitize_hex_color($bg);

        echo '<style type="text/css">';
        echo 'body{background-color:' . esc_html($bg) . ';font-family:' . esc_html($font) . ';}';
        echo '</style>';
    }
}
add_action('wp_head', 'shopido_customizer_styles');
