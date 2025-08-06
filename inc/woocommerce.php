<?php
// تنظیمات ووکامرس و قالب‌بندی محصولات
function mytheme_woocommerce_setup() {
    // غیرفعال‌کردن استایل‌های پیش‌فرض ووکامرس
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
}
add_action('after_setup_theme', 'mytheme_woocommerce_setup');

// لود استایل اختصاصی ووکامرس
function mytheme_woocommerce_enqueue() {
    wp_enqueue_style('mytheme-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', [], '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'mytheme_woocommerce_enqueue');
