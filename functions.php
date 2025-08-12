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

class Shopido_Options_Page {
    const OPTION_KEY = 'shopido_options';
    const PAGE_SLUG  = 'shopido-settings';

    public function __construct() {
        add_action('admin_menu',  [$this, 'menu']);
        add_action('admin_init',  [$this, 'register']);
        add_action('admin_enqueue_scripts', [$this, 'assets']);
    }

    public function menu() {
        add_menu_page(
            __('تنظیمات شاپیدو', 'shopido'),
            __('تنظیمات شاپیدو', 'shopido'),
            'manage_options',
            self::PAGE_SLUG,
            [$this, 'render'],
            'dashicons-admin-customizer',
            61
        );
    }

    public function register() {
        register_setting(
            'shopido_options_group',
            self::OPTION_KEY,
            ['sanitize_callback' => [$this, 'sanitize']]
        );
    }

    public function assets($hook) {
        if ($hook !== 'toplevel_page_' . self::PAGE_SLUG) return;
        // رنگ‌بردار + مدیا آپلودر
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_media();

        wp_enqueue_style('shopido-admin', get_template_directory_uri() . '/inc/admin/admin.css', [], '1.0');
        wp_enqueue_script('shopido-admin', get_template_directory_uri() . '/inc/admin/admin.js', ['jquery'], '1.0', true);
    }

    public function sanitize($input) {
        $out = [];

        // طرح‌بندی
        $out['primary_color']        = isset($input['primary_color']) ? sanitize_hex_color($input['primary_color']) : '';
        $out['body_font_family']     = isset($input['body_font_family']) ? sanitize_text_field($input['body_font_family']) : '';
        $out['heading_font_family']  = isset($input['heading_font_family']) ? sanitize_text_field($input['heading_font_family']) : '';
        $out['custom_font_name']     = isset($input['custom_font_name']) ? sanitize_text_field($input['custom_font_name']) : '';
        $out['custom_font_regular']  = isset($input['custom_font_regular']) ? esc_url_raw($input['custom_font_regular']) : '';
        $out['custom_font_bold']     = isset($input['custom_font_bold']) ? esc_url_raw($input['custom_font_bold']) : '';
        $out['font_display']         = isset($input['font_display']) ? sanitize_text_field($input['font_display']) : 'swap';
        $out['use_custom_font_for_body']    = !empty($input['use_custom_font_for_body']) ? 1 : 0;
        $out['use_custom_font_for_heading'] = !empty($input['use_custom_font_for_heading']) ? 1 : 0;

        // بهبود سرعت
        $out['disable_emojis']   = !empty($input['disable_emojis']) ? 1 : 0;
        $out['disable_embeds']   = !empty($input['disable_embeds']) ? 1 : 0;
        $out['enable_defer']     = !empty($input['enable_defer']) ? 1 : 0;
        $out['defer_handles']    = isset($input['defer_handles']) ? sanitize_text_field($input['defer_handles']) : '';
        $out['move_jquery_footer'] = !empty($input['move_jquery_footer']) ? 1 : 0;
        $out['preload_resources']  = isset($input['preload_resources']) ? implode("\n",
            array_filter(array_map('esc_url_raw', array_map('trim', explode("\n", $input['preload_resources']))))
        ) : '';
        $out['dns_prefetch'] = isset($input['dns_prefetch']) ? implode("\n",
            array_filter(array_map('esc_url_raw', array_map('trim', explode("\n", $input['dns_prefetch']))))
        ) : '';
        $out['add_preconnect'] = !empty($input['add_preconnect']) ? 1 : 0;

        return $out;
    }

    public function render() {
        if (!current_user_can('manage_options')) return;
        $opts = get_option(self::OPTION_KEY, []);
        ?>
        <div class="wrap shopido-wrap">
            <h1>تنظیمات شاپیدو</h1>
            <div class="shopido-container">
                <!-- ناوبری راست -->
                <aside class="shopido-nav">
                    <ul>
                        <li><a href="#layout" class="active">طرح‌بندی</a></li>
                        <li><a href="#performance">بهبود سرعت</a></li>
                    </ul>
                </aside>

                <!-- بدنه تنظیمات -->
                <main class="shopido-content">
                    <form method="post" action="options.php">
                        <?php settings_fields('shopido_options_group'); ?>

                        <!-- طرح‌بندی -->
                        <section id="layout" class="shopido-section">
                            <h2>طرح‌بندی</h2>

                            <div class="field">
                                <label>رنگ اصلی سایت</label>
                                <input type="text" class="shopido-color" name="<?= self::OPTION_KEY; ?>[primary_color]"
                                       value="<?= esc_attr($opts['primary_color'] ?? '#0ea5e9'); ?>" data-default-color="#0ea5e9">
                                <p class="desc">این رنگ به‌صورت متغیر CSS با نام <code>--shopido-primary</code> اعمال می‌شود.</p>
                            </div>

                            <div class="field">
                                <label>فونت بدنه (Body)</label>
                                <input type="text" name="<?= self::OPTION_KEY; ?>[body_font_family]"
                                       value="<?= esc_attr($opts['body_font_family'] ?? "system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial"); ?>">
                                <p class="desc">مثال: <code>IRANSansX, system-ui, -apple-system, ...</code></p>
                            </div>

                            <div class="field">
                                <label>فونت تیترها (Headings)</label>
                                <input type="text" name="<?= self::OPTION_KEY; ?>[heading_font_family]"
                                       value="<?= esc_attr($opts['heading_font_family'] ?? ($opts['body_font_family'] ?? '')); ?>">
                            </div>

                            <fieldset class="group">
                                <legend>آپلود فونت سفارشی (اختیاری)</legend>
                                <div class="field">
                                    <label>نام فونت (font-family)</label>
                                    <input type="text" name="<?= self::OPTION_KEY; ?>[custom_font_name]"
                                           value="<?= esc_attr($opts['custom_font_name'] ?? ''); ?>" placeholder="مثلاً: ShopidoFont">
                                </div>
                                <div class="field media">
                                    <label>فایل Regular (ترجیحاً .woff2)</label>
                                    <input type="url" id="custom_font_regular" name="<?= self::OPTION_KEY; ?>[custom_font_regular]"
                                           value="<?= esc_attr($opts['custom_font_regular'] ?? ''); ?>">
                                    <button class="button shopido-upload" data-target="#custom_font_regular">آپلود/انتخاب</button>
                                </div>
                                <div class="field media">
                                    <label>فایل Bold (اختیاری)</label>
                                    <input type="url" id="custom_font_bold" name="<?= self::OPTION_KEY; ?>[custom_font_bold]"
                                           value="<?= esc_attr($opts['custom_font_bold'] ?? ''); ?>">
                                    <button class="button shopido-upload" data-target="#custom_font_bold">آپلود/انتخاب</button>
                                </div>
                                <div class="field">
                                    <label>font-display</label>
                                    <select name="<?= self::OPTION_KEY; ?>[font_display]">
                                        <?php foreach (['swap','fallback','optional','block','auto'] as $d): ?>
                                            <option value="<?= esc_attr($d); ?>" <?= selected(($opts['font_display'] ?? 'swap'), $d); ?>><?= esc_html($d); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="field inline">
                                    <label><input type="checkbox" name="<?= self::OPTION_KEY; ?>[use_custom_font_for_body]" value="1" <?= checked(!empty($opts['use_custom_font_for_body'])); ?>> استفاده برای بدنه</label>
                                    <label><input type="checkbox" name="<?= self::OPTION_KEY; ?>[use_custom_font_for_heading]" value="1" <?= checked(!empty($opts['use_custom_font_for_heading'])); ?>> استفاده برای تیترها</label>
                                </div>
                            </fieldset>
                        </section>

                        <!-- بهبود سرعت -->
                        <section id="performance" class="shopido-section">
                            <h2>بهبود سرعت</h2>

                            <div class="field inline">
                                <label><input type="checkbox" name="<?= self::OPTION_KEY; ?>[disable_emojis]" value="1" <?= checked(!empty($opts['disable_emojis'])); ?>> غیرفعال‌سازی ایموجی‌های وردپرس</label>
                            </div>
                            <div class="field inline">
                                <label><input type="checkbox" name="<?= self::OPTION_KEY; ?>[disable_embeds]" value="1" <?= checked(!empty($opts['disable_embeds'])); ?>> غیرفعال‌سازی oEmbed و <code>wp-embed.js</code></label>
                            </div>
                            <div class="field inline">
                                <label><input type="checkbox" name="<?= self::OPTION_KEY; ?>[enable_defer]" value="1" <?= checked(!empty($opts['enable_defer'])); ?>> افزودن <code>defer</code> به اسکریپت‌ها</label>
                            </div>
                            <div class="field">
                                <label>هندل اسکریپت‌ها برای Defer (اختیاری)</label>
                                <input type="text" name="<?= self::OPTION_KEY; ?>[defer_handles]" value="<?= esc_attr($opts['defer_handles'] ?? ''); ?>" placeholder="مثال: swiper, theme, woocommerce">
                                <p class="desc">خالی بماند = همهٔ اسکریپت‌ها به‌جز jQuery.</p>
                            </div>
                            <div class="field inline">
                                <label><input type="checkbox" name="<?= self::OPTION_KEY; ?>[move_jquery_footer]" value="1" <?= checked(!empty($opts['move_jquery_footer'])); ?>> انتقال jQuery به فوتر</label>
                            </div>
                            <div class="field">
                                <label>Preload منابع (هر خط یک URL)</label>
                                <textarea rows="4" name="<?= self::OPTION_KEY; ?>[preload_resources]" placeholder="https://example.com/fonts/iransansx.woff2"><?= esc_textarea($opts['preload_resources'] ?? ''); ?></textarea>
                            </div>
                            <div class="field">
                                <label>DNS-Prefetch / Preconnect (هر خط یک دامنه)</label>
                                <textarea rows="3" name="<?= self::OPTION_KEY; ?>[dns_prefetch]" placeholder="//fonts.gstatic.com&#10;//cdn.example.com"><?= esc_textarea($opts['dns_prefetch'] ?? ''); ?></textarea>
                                <label class="inline"><input type="checkbox" name="<?= self::OPTION_KEY; ?>[add_preconnect]" value="1" <?= checked(!empty($opts['add_preconnect'])); ?>> علاوه بر <code>dns-prefetch</code>، <code>preconnect</code> هم اضافه کن</label>
                            </div>
                        </section>

                        <?php submit_button('ذخیره تنظیمات'); ?>
                    </form>
                </main>
            </div>
        </div>
        <?php
    }
}

new Shopido_Options_Page();
