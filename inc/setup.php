<?php
// فعال‌سازی قابلیت‌های قالب
function mytheme_setup() {
    load_theme_textdomain('mytheme', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('custom-logo');

    // منوهای وردپرس
    register_nav_menus([
        'main-menu' => __('Main Menu', 'mytheme'),
        'footer-menu' => __('Footer Menu', 'mytheme'),
    ]);
}
add_action('after_setup_theme', 'mytheme_setup');
