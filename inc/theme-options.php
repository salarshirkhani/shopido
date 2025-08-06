<?php
function mytheme_customize_register($wp_customize) {
    // تنظیمات رنگ
    $wp_customize->add_section('colors_section', array(
        'title' => __('Colors', 'mytheme'),
        'priority' => 30,
    ));

    // رنگ پس‌زمینه
    $wp_customize->add_setting('background_color', array(
        'default' => '#ffffff',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'background_color', array(
        'label' => __('Background Color', 'mytheme'),
        'section' => 'colors_section',
        'settings' => 'background_color',
    )));

    // تنظیمات فونت
    $wp_customize->add_section('fonts_section', array(
        'title' => __('Fonts', 'mytheme'),
        'priority' => 40,
    ));

    // فونت اصلی
    $wp_customize->add_setting('primary_font', array(
        'default' => 'Arial, sans-serif',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('primary_font', array(
        'label' => __('Primary Font', 'mytheme'),
        'section' => 'fonts_section',
        'type' => 'text',
    ));

    // تنظیم فونت آپلودی
    $wp_customize->add_setting('upload_font', array(
        'default' => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'upload_font', array(
        'label' => __('Upload Custom Font', 'mytheme'),
        'section' => 'fonts_section',
        'settings' => 'upload_font',
    )));
}

add_action('customize_register', 'mytheme_customize_register');
