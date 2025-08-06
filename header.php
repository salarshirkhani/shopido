<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    
    <?php
    // بارگذاری فونت‌ها
    function mytheme_customizer_styles() {
        // بارگذاری فونت شخصی
        $font_url = get_theme_mod('upload_font');
        if ($font_url) {
            echo '<link rel="stylesheet" type="text/css" href="' . esc_url($font_url) . '" />';
        }
        
        // بارگذاری فونت اصلی از تنظیمات
        $primary_font = get_theme_mod('primary_font', 'Arial, sans-serif');
        ?>
        <style type="text/css">
            body {
                font-family: <?php echo esc_attr($primary_font); ?>;
            }
        </style>
        <?php
    }
    add_action('wp_head', 'mytheme_customizer_styles');
    
    // فراخوانی سایر هدرها
    wp_head();
    ?>
</head>
<body <?php body_class(); ?>>
<header>
    <div class="logo">
        <?php the_custom_logo(); ?>
    </div>
    <nav>
        <?php wp_nav_menu(['theme_location' => 'main-menu']); ?>
    </nav>
</header>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <div class="logo">
        <?php the_custom_logo(); ?>
    </div>
    <nav>
        <?php wp_nav_menu(['theme_location' => 'main-menu']); ?>
    </nav>
</header>
