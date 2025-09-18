<?php
/**
 * WordPress Master Developer Theme Customizer
 *
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function wp_master_dev_customize_register($wp_customize) {
    
    // Add theme options panel
    $wp_customize->add_panel('wp_master_dev_theme_options', array(
        'title'       => esc_html__('Theme Options', 'wp-master-dev'),
        'description' => esc_html__('Customize your WordPress Master Developer theme settings.', 'wp-master-dev'),
        'priority'    => 30,
    ));

    // Hero Section
    $wp_customize->add_section('wp_master_dev_hero', array(
        'title'    => esc_html__('Hero Section', 'wp-master-dev'),
        'panel'    => 'wp_master_dev_theme_options',
        'priority' => 10,
    ));

    // Hero Background Image
    $wp_customize->add_setting('hero_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label'    => esc_html__('Hero Background Image', 'wp-master-dev'),
        'section'  => 'wp_master_dev_hero',
        'settings' => 'hero_background_image',
    )));

    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default'           => 'WordPress Master Developer',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_title', array(
        'label'    => esc_html__('Hero Title', 'wp-master-dev'),
        'section'  => 'wp_master_dev_hero',
        'type'     => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => 'Expert AI assistant specializing in custom WordPress theme development from scratch',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label'    => esc_html__('Hero Subtitle', 'wp-master-dev'),
        'section'  => 'wp_master_dev_hero',
        'type'     => 'textarea',
    ));

    // Hero Description
    $wp_customize->add_setting('hero_description', array(
        'default'           => 'Deep expertise in PHP, CSS, HTML, and JavaScript. Creating high-quality, performance-optimized WordPress themes that are fully integrated with WordPress core and built for security, scalability, and upgrade safety.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_description', array(
        'label'    => esc_html__('Hero Description', 'wp-master-dev'),
        'section'  => 'wp_master_dev_hero',
        'type'     => 'textarea',
    ));

    // Hero Button Text
    $wp_customize->add_setting('hero_button_text', array(
        'default'           => 'Start Your Project',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_button_text', array(
        'label'    => esc_html__('Hero Button Text', 'wp-master-dev'),
        'section'  => 'wp_master_dev_hero',
        'type'     => 'text',
    ));

    // Colors Section
    $wp_customize->add_section('wp_master_dev_colors', array(
        'title'    => esc_html__('Colors', 'wp-master-dev'),
        'panel'    => 'wp_master_dev_theme_options',
        'priority' => 20,
    ));

    // Primary Color
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#2563eb',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'    => esc_html__('Primary Color', 'wp-master-dev'),
        'section'  => 'wp_master_dev_colors',
        'settings' => 'primary_color',
    )));

    // Accent Color
    $wp_customize->add_setting('accent_color', array(
        'default'           => '#f59e0b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label'    => esc_html__('Accent Color', 'wp-master-dev'),
        'section'  => 'wp_master_dev_colors',
        'settings' => 'accent_color',
    )));

    // Contact Information Section
    $wp_customize->add_section('wp_master_dev_contact', array(
        'title'    => esc_html__('Contact Information', 'wp-master-dev'),
        'panel'    => 'wp_master_dev_theme_options',
        'priority' => 30,
    ));

    // Contact Email
    $wp_customize->add_setting('contact_email', array(
        'default'           => 'contact@wpmaster.dev',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('contact_email', array(
        'label'    => esc_html__('Contact Email', 'wp-master-dev'),
        'section'  => 'wp_master_dev_contact',
        'type'     => 'email',
    ));

    // Contact Phone
    $wp_customize->add_setting('contact_phone', array(
        'default'           => '+1 (555) 123-4567',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('contact_phone', array(
        'label'    => esc_html__('Contact Phone', 'wp-master-dev'),
        'section'  => 'wp_master_dev_contact',
        'type'     => 'text',
    ));

    // Business Address
    $wp_customize->add_setting('business_address', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('business_address', array(
        'label'    => esc_html__('Business Address', 'wp-master-dev'),
        'section'  => 'wp_master_dev_contact',
        'type'     => 'textarea',
    ));

    // Social Media Section
    $wp_customize->add_section('wp_master_dev_social', array(
        'title'    => esc_html__('Social Media', 'wp-master-dev'),
        'panel'    => 'wp_master_dev_theme_options',
        'priority' => 40,
    ));

    // Social media links
    $social_networks = array(
        'facebook'  => 'Facebook',
        'twitter'   => 'Twitter',
        'linkedin'  => 'LinkedIn',
        'github'    => 'GitHub',
        'instagram' => 'Instagram',
        'youtube'   => 'YouTube',
    );

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting("social_{$network}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control("social_{$network}", array(
            'label'    => sprintf(esc_html__('%s URL', 'wp-master-dev'), $label),
            'section'  => 'wp_master_dev_social',
            'type'     => 'url',
        ));
    }

    // Footer Section
    $wp_customize->add_section('wp_master_dev_footer', array(
        'title'    => esc_html__('Footer', 'wp-master-dev'),
        'panel'    => 'wp_master_dev_theme_options',
        'priority' => 50,
    ));

    // Footer Copyright Text
    $wp_customize->add_setting('footer_copyright', array(
        'default'           => sprintf(esc_html__('© %s WordPress Master Developer. All rights reserved.', 'wp-master-dev'), date('Y')),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_copyright', array(
        'label'    => esc_html__('Copyright Text', 'wp-master-dev'),
        'section'  => 'wp_master_dev_footer',
        'type'     => 'textarea',
    ));

    // Footer Description
    $wp_customize->add_setting('footer_description', array(
        'default'           => 'Professional WordPress development services with modern design and expert implementation.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_description', array(
        'label'    => esc_html__('Footer Description', 'wp-master-dev'),
        'section'  => 'wp_master_dev_footer',
        'type'     => 'textarea',
    ));

    // Typography Section
    $wp_customize->add_section('wp_master_dev_typography', array(
        'title'    => esc_html__('Typography', 'wp-master-dev'),
        'panel'    => 'wp_master_dev_theme_options',
        'priority' => 60,
    ));

    // Google Fonts
    $wp_customize->add_setting('google_fonts', array(
        'default'           => 'Inter:300,400,500,600,700',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('google_fonts', array(
        'label'       => esc_html__('Google Fonts', 'wp-master-dev'),
        'description' => esc_html__('Enter Google Fonts family and weights (e.g., Inter:300,400,500,600,700)', 'wp-master-dev'),
        'section'     => 'wp_master_dev_typography',
        'type'        => 'text',
    ));

    // Layout Section
    $wp_customize->add_section('wp_master_dev_layout', array(
        'title'    => esc_html__('Layout', 'wp-master-dev'),
        'panel'    => 'wp_master_dev_theme_options',
        'priority' => 70,
    ));

    // Container Width
    $wp_customize->add_setting('container_width', array(
        'default'           => '1200',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('container_width', array(
        'label'       => esc_html__('Container Max Width (px)', 'wp-master-dev'),
        'description' => esc_html__('Maximum width for the main content container.', 'wp-master-dev'),
        'section'     => 'wp_master_dev_layout',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1920,
            'step' => 10,
        ),
    ));

    // Enable Boxed Layout
    $wp_customize->add_setting('boxed_layout', array(
        'default'           => false,
        'sanitize_callback' => 'wp_master_dev_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boxed_layout', array(
        'label'    => esc_html__('Enable Boxed Layout', 'wp-master-dev'),
        'section'  => 'wp_master_dev_layout',
        'type'     => 'checkbox',
    ));

    // Performance Section
    $wp_customize->add_section('wp_master_dev_performance', array(
        'title'    => esc_html__('Performance', 'wp-master-dev'),
        'panel'    => 'wp_master_dev_theme_options',
        'priority' => 80,
    ));

    // Preload Google Fonts
    $wp_customize->add_setting('preload_fonts', array(
        'default'           => true,
        'sanitize_callback' => 'wp_master_dev_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('preload_fonts', array(
        'label'       => esc_html__('Preload Google Fonts', 'wp-master-dev'),
        'description' => esc_html__('Preload Google Fonts for better performance.', 'wp-master-dev'),
        'section'     => 'wp_master_dev_performance',
        'type'        => 'checkbox',
    ));

    // Minify CSS
    $wp_customize->add_setting('minify_css', array(
        'default'           => false,
        'sanitize_callback' => 'wp_master_dev_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('minify_css', array(
        'label'       => esc_html__('Minify CSS', 'wp-master-dev'),
        'description' => esc_html__('Minify CSS output for better performance.', 'wp-master-dev'),
        'section'     => 'wp_master_dev_performance',
        'type'        => 'checkbox',
    ));

    // Modify existing settings for postMessage transport
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector'        => '.site-title',
            'render_callback' => 'wp_master_dev_customize_partial_blogname',
        ));
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'wp_master_dev_customize_partial_blogdescription',
        ));
    }
}
add_action('customize_register', 'wp_master_dev_customize_register');

/**
 * Render the site title for the selective refresh partial.
 */
function wp_master_dev_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function wp_master_dev_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Sanitize checkbox values.
 */
function wp_master_dev_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Sanitize select options.
 */
function wp_master_dev_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function wp_master_dev_customize_preview_js() {
    wp_enqueue_script('wp-master-dev-customizer', WP_MASTER_DEV_THEME_URL . '/assets/js/customizer.js', array('customize-preview'), WP_MASTER_DEV_VERSION, true);
}
add_action('customize_preview_init', 'wp_master_dev_customize_preview_js');

/**
 * Enqueue customizer control scripts.
 */
function wp_master_dev_customize_controls_js() {
    wp_enqueue_script('wp-master-dev-customizer-controls', WP_MASTER_DEV_THEME_URL . '/assets/js/customizer-controls.js', array('customize-controls'), WP_MASTER_DEV_VERSION, true);
}
add_action('customize_controls_enqueue_scripts', 'wp_master_dev_customize_controls_js');

/**
 * Output customizer CSS variables.
 */
function wp_master_dev_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#2563eb');
    $accent_color = get_theme_mod('accent_color', '#f59e0b');
    $container_width = get_theme_mod('container_width', '1200');
    
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
            --accent-color: <?php echo esc_attr($accent_color); ?>;
            --container-width: <?php echo esc_attr($container_width); ?>px;
        }
        
        .container {
            max-width: var(--container-width);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: color-mix(in srgb, var(--primary-color) 85%, black);
            border-color: color-mix(in srgb, var(--primary-color) 85%, black);
        }
        
        .nav-menu a:hover,
        .nav-menu a:focus,
        .nav-menu .current-menu-item > a,
        .nav-menu .current_page_item > a {
            color: var(--accent-color);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, color-mix(in srgb, var(--primary-color) 80%, white) 100%);
        }
    </style>
    <?php
}
add_action('wp_head', 'wp_master_dev_customizer_css');

/**
 * Enqueue Google Fonts based on customizer settings.
 */
function wp_master_dev_google_fonts() {
    $google_fonts = get_theme_mod('google_fonts', 'Inter:300,400,500,600,700');
    $preload_fonts = get_theme_mod('preload_fonts', true);
    
    if ($google_fonts) {
        $font_url = 'https://fonts.googleapis.com/css2?family=' . str_replace(' ', '+', $google_fonts) . '&display=swap';
        
        if ($preload_fonts) {
            echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
            echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        }
        
        wp_enqueue_style('wp-master-dev-google-fonts', $font_url, array(), null);
    }
}
add_action('wp_enqueue_scripts', 'wp_master_dev_google_fonts', 1);
