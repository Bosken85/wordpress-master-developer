<?php
/**
 * WordPress Master Developer Theme Functions
 *
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme constants
define('WP_MASTER_DEV_VERSION', '1.0.0');
define('WP_MASTER_DEV_THEME_DIR', get_template_directory());
define('WP_MASTER_DEV_THEME_URL', get_template_directory_uri());

/**
 * Theme Setup
 */
function wp_master_dev_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('custom-background');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'wp-master-dev'),
        'footer'  => esc_html__('Footer Menu', 'wp-master-dev'),
    ));

    // Set content width
    $GLOBALS['content_width'] = 1200;
}
add_action('after_setup_theme', 'wp_master_dev_setup');

/**
 * Enqueue Scripts and Styles
 */
function wp_master_dev_scripts() {
    // Enqueue styles
    wp_enqueue_style('wp-master-dev-style', get_stylesheet_uri(), array(), WP_MASTER_DEV_VERSION);
    wp_enqueue_style('wp-master-dev-main', WP_MASTER_DEV_THEME_URL . '/assets/css/main.css', array(), WP_MASTER_DEV_VERSION);
    
    // Enqueue scripts
    wp_enqueue_script('wp-master-dev-navigation', WP_MASTER_DEV_THEME_URL . '/assets/js/navigation.js', array(), WP_MASTER_DEV_VERSION, true);
    wp_enqueue_script('wp-master-dev-main', WP_MASTER_DEV_THEME_URL . '/assets/js/main.js', array(), WP_MASTER_DEV_VERSION, true);
    
    // Localize script for AJAX
    wp_localize_script('wp-master-dev-main', 'wpMasterDev', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('wp_master_dev_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'wp_master_dev_scripts');

/**
 * Register Widget Areas
 */
function wp_master_dev_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 1', 'wp-master-dev'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here to appear in the first footer column.', 'wp-master-dev'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 2', 'wp-master-dev'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add widgets here to appear in the second footer column.', 'wp-master-dev'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 3', 'wp-master-dev'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Add widgets here to appear in the third footer column.', 'wp-master-dev'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'wp_master_dev_widgets_init');

/**
 * Custom Post Types
 */
function wp_master_dev_custom_post_types() {
    // Services Post Type
    register_post_type('service', array(
        'labels' => array(
            'name'               => esc_html__('Services', 'wp-master-dev'),
            'singular_name'      => esc_html__('Service', 'wp-master-dev'),
            'menu_name'          => esc_html__('Services', 'wp-master-dev'),
            'add_new'            => esc_html__('Add New Service', 'wp-master-dev'),
            'add_new_item'       => esc_html__('Add New Service', 'wp-master-dev'),
            'edit_item'          => esc_html__('Edit Service', 'wp-master-dev'),
            'new_item'           => esc_html__('New Service', 'wp-master-dev'),
            'view_item'          => esc_html__('View Service', 'wp-master-dev'),
            'search_items'       => esc_html__('Search Services', 'wp-master-dev'),
            'not_found'          => esc_html__('No services found', 'wp-master-dev'),
            'not_found_in_trash' => esc_html__('No services found in trash', 'wp-master-dev'),
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-admin-tools',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite'      => array('slug' => 'services'),
    ));
    
    // Portfolio/Projects Post Type
    register_post_type('project', array(
        'labels' => array(
            'name'               => esc_html__('Projects', 'wp-master-dev'),
            'singular_name'      => esc_html__('Project', 'wp-master-dev'),
            'menu_name'          => esc_html__('Portfolio', 'wp-master-dev'),
            'add_new'            => esc_html__('Add New Project', 'wp-master-dev'),
            'add_new_item'       => esc_html__('Add New Project', 'wp-master-dev'),
            'edit_item'          => esc_html__('Edit Project', 'wp-master-dev'),
            'new_item'           => esc_html__('New Project', 'wp-master-dev'),
            'view_item'          => esc_html__('View Project', 'wp-master-dev'),
            'search_items'       => esc_html__('Search Projects', 'wp-master-dev'),
            'not_found'          => esc_html__('No projects found', 'wp-master-dev'),
            'not_found_in_trash' => esc_html__('No projects found in trash', 'wp-master-dev'),
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-portfolio',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite'      => array('slug' => 'portfolio'),
    ));
    
    // Testimonials Post Type
    register_post_type('testimonial', array(
        'labels' => array(
            'name'               => esc_html__('Testimonials', 'wp-master-dev'),
            'singular_name'      => esc_html__('Testimonial', 'wp-master-dev'),
            'menu_name'          => esc_html__('Testimonials', 'wp-master-dev'),
            'add_new'            => esc_html__('Add New Testimonial', 'wp-master-dev'),
            'add_new_item'       => esc_html__('Add New Testimonial', 'wp-master-dev'),
            'edit_item'          => esc_html__('Edit Testimonial', 'wp-master-dev'),
            'new_item'           => esc_html__('New Testimonial', 'wp-master-dev'),
            'view_item'          => esc_html__('View Testimonial', 'wp-master-dev'),
            'search_items'       => esc_html__('Search Testimonials', 'wp-master-dev'),
            'not_found'          => esc_html__('No testimonials found', 'wp-master-dev'),
            'not_found_in_trash' => esc_html__('No testimonials found in trash', 'wp-master-dev'),
        ),
        'public'       => false,
        'show_ui'      => true,
        'menu_icon'    => 'dashicons-format-quote',
        'supports'     => array('title', 'editor', 'thumbnail', 'custom-fields'),
    ));
}
add_action('init', 'wp_master_dev_custom_post_types');

/**
 * Custom Fields for Theme Options
 */
function wp_master_dev_add_theme_options() {
    // Add theme options page
    add_theme_page(
        esc_html__('Theme Options', 'wp-master-dev'),
        esc_html__('Theme Options', 'wp-master-dev'),
        'manage_options',
        'wp-master-dev-options',
        'wp_master_dev_options_page'
    );
}
add_action('admin_menu', 'wp_master_dev_add_theme_options');

/**
 * Theme Options Page
 */
function wp_master_dev_options_page() {
    if (isset($_POST['submit'])) {
        // Save options
        update_option('wp_master_dev_hero_title', sanitize_text_field($_POST['hero_title']));
        update_option('wp_master_dev_hero_subtitle', sanitize_textarea_field($_POST['hero_subtitle']));
        update_option('wp_master_dev_hero_description', sanitize_textarea_field($_POST['hero_description']));
        update_option('wp_master_dev_cta_text', sanitize_text_field($_POST['cta_text']));
        update_option('wp_master_dev_contact_email', sanitize_email($_POST['contact_email']));
        update_option('wp_master_dev_contact_phone', sanitize_text_field($_POST['contact_phone']));
        
        echo '<div class="notice notice-success"><p>' . esc_html__('Settings saved!', 'wp-master-dev') . '</p></div>';
    }
    
    // Get current values
    $hero_title = get_option('wp_master_dev_hero_title', 'WordPress Master Developer');
    $hero_subtitle = get_option('wp_master_dev_hero_subtitle', 'Expert AI assistant specializing in custom WordPress theme development from scratch');
    $hero_description = get_option('wp_master_dev_hero_description', 'Deep expertise in PHP, CSS, HTML, and JavaScript. Creating high-quality, performance-optimized WordPress themes that are fully integrated with WordPress core and built for security, scalability, and upgrade safety.');
    $cta_text = get_option('wp_master_dev_cta_text', 'Start Your Project');
    $contact_email = get_option('wp_master_dev_contact_email', 'contact@wpmaster.dev');
    $contact_phone = get_option('wp_master_dev_contact_phone', '+1 (555) 123-4567');
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Theme Options', 'wp-master-dev'); ?></h1>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row"><?php esc_html_e('Hero Title', 'wp-master-dev'); ?></th>
                    <td><input type="text" name="hero_title" value="<?php echo esc_attr($hero_title); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Hero Subtitle', 'wp-master-dev'); ?></th>
                    <td><input type="text" name="hero_subtitle" value="<?php echo esc_attr($hero_subtitle); ?>" class="large-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Hero Description', 'wp-master-dev'); ?></th>
                    <td><textarea name="hero_description" rows="4" class="large-text"><?php echo esc_textarea($hero_description); ?></textarea></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('CTA Button Text', 'wp-master-dev'); ?></th>
                    <td><input type="text" name="cta_text" value="<?php echo esc_attr($cta_text); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Contact Email', 'wp-master-dev'); ?></th>
                    <td><input type="email" name="contact_email" value="<?php echo esc_attr($contact_email); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Contact Phone', 'wp-master-dev'); ?></th>
                    <td><input type="text" name="contact_phone" value="<?php echo esc_attr($contact_phone); ?>" class="regular-text" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/**
 * Include additional theme files
 */
require_once WP_MASTER_DEV_THEME_DIR . '/inc/customizer.php';
require_once WP_MASTER_DEV_THEME_DIR . '/inc/template-functions.php';
require_once WP_MASTER_DEV_THEME_DIR . '/inc/theme-installer.php';

/**
 * Theme activation hook
 */
function wp_master_dev_activation() {
    // Flush rewrite rules
    flush_rewrite_rules();
    
    // Set default options
    if (!get_option('wp_master_dev_hero_title')) {
        update_option('wp_master_dev_hero_title', 'WordPress Master Developer');
        update_option('wp_master_dev_hero_subtitle', 'Expert AI assistant specializing in custom WordPress theme development from scratch');
        update_option('wp_master_dev_hero_description', 'Deep expertise in PHP, CSS, HTML, and JavaScript. Creating high-quality, performance-optimized WordPress themes that are fully integrated with WordPress core and built for security, scalability, and upgrade safety.');
        update_option('wp_master_dev_cta_text', 'Start Your Project');
        update_option('wp_master_dev_contact_email', 'contact@wpmaster.dev');
        update_option('wp_master_dev_contact_phone', '+1 (555) 123-4567');
    }
}
add_action('after_switch_theme', 'wp_master_dev_activation');
