<?php
// لود استایل‌ها و اسکریپت‌ها
function mytheme_enqueue_scripts() {
    wp_enqueue_style('mytheme-style', get_stylesheet_uri());
    wp_enqueue_style('mytheme-main', get_template_directory_uri() . '/assets/css/main.css', [], '1.0', 'all');

    wp_enqueue_script('mytheme-main', get_template_directory_uri() . '/assets/js/main.js', ['jquery'], '1.0', true);
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');
