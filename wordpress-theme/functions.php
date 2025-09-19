<?php
/**
 * WordPress Master Developer Theme functions and definitions
 * Modular asset management with npm package integration
 *
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Theme version for cache busting
define( 'WP_MASTER_DEV_VERSION', '1.0.0' );

/**
 * Theme setup
 */
function wp_master_dev_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support( 'post-thumbnails' );

    // Add support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );

    // Add support for custom header
    add_theme_support( 'custom-header', array(
        'default-image'      => get_template_directory_uri() . '/assets/images/hero-bg.png',
        'width'              => 1920,
        'height'             => 1080,
        'flex-width'         => true,
        'flex-height'        => true,
        'uploads'            => true,
        'header-text'        => false,
    ) );

    // Add support for custom background
    add_theme_support( 'custom-background', array(
        'default-color' => 'ffffff',
    ) );

    // Add theme support for selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for core custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'wp-master-dev' ),
        'footer'  => esc_html__( 'Footer Menu', 'wp-master-dev' ),
    ) );

    // Add support for HTML5 markup
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add support for post formats
    add_theme_support( 'post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'status',
        'audio',
        'chat',
    ) );

    // Set up the WordPress core custom background feature
    add_theme_support( 'custom-background', apply_filters( 'wp_master_dev_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ) ) );

    // Add support for editor styles
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor-style.css' );

    // Add support for responsive embeds
    add_theme_support( 'responsive-embeds' );

    // Add support for wide alignment
    add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'wp_master_dev_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet
 */
function wp_master_dev_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'wp_master_dev_content_width', 1200 );
}
add_action( 'after_setup_theme', 'wp_master_dev_content_width', 0 );

/**
 * Enqueue scripts and styles with modular approach
 */
function wp_master_dev_scripts() {
    $theme_version = WP_MASTER_DEV_VERSION;
    
    // Check if we're in development mode
    $is_development = defined( 'WP_DEBUG' ) && WP_DEBUG;
    
    // Main stylesheet (compiled from SCSS with Bootstrap)
    wp_enqueue_style( 
        'wp-master-dev-style', 
        get_template_directory_uri() . '/assets/css/main.css', 
        array(), 
        $theme_version 
    );

    // Bootstrap CSS (from node_modules, included in main.css via SCSS)
    // No separate enqueue needed as it's compiled into main.css

    // Main JavaScript (compiled with webpack, includes Bootstrap JS)
    wp_enqueue_script( 
        'wp-master-dev-main', 
        get_template_directory_uri() . '/assets/js/main.js', 
        array(), 
        $theme_version, 
        true 
    );

    // Navigation JavaScript (modular)
    wp_enqueue_script( 
        'wp-master-dev-navigation', 
        get_template_directory_uri() . '/assets/js/navigation.js', 
        array( 'wp-master-dev-main' ), 
        $theme_version, 
        true 
    );

    // Localize script for AJAX and theme data
    wp_localize_script( 'wp-master-dev-main', 'wpMasterDev', array(
        'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
        'nonce'      => wp_create_nonce( 'wp_master_dev_nonce' ),
        'themeUrl'   => get_template_directory_uri(),
        'homeUrl'    => home_url( '/' ),
        'isRTL'      => is_rtl(),
        'language'   => get_locale(),
    ) );

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // Conditional scripts for specific pages
    if ( is_page_template( 'page-contact.php' ) ) {
        wp_enqueue_script( 
            'wp-master-dev-contact', 
            get_template_directory_uri() . '/assets/js/contact.js', 
            array( 'wp-master-dev-main' ), 
            $theme_version, 
            true 
        );
    }

    // Admin bar adjustments
    if ( is_admin_bar_showing() ) {
        wp_add_inline_style( 'wp-master-dev-style', '
            .site-header { top: 32px; }
            @media screen and (max-width: 782px) {
                .site-header { top: 46px; }
            }
        ' );
    }
}
add_action( 'wp_enqueue_scripts', 'wp_master_dev_scripts' );

/**
 * Enqueue admin scripts and styles
 */
function wp_master_dev_admin_scripts( $hook ) {
    // Only load on theme customizer and theme pages
    if ( 'customize.php' === $hook || 'themes.php' === $hook ) {
        wp_enqueue_script( 
            'wp-master-dev-admin', 
            get_template_directory_uri() . '/assets/js/admin.js', 
            array( 'jquery' ), 
            WP_MASTER_DEV_VERSION, 
            true 
        );
        
        wp_enqueue_style( 
            'wp-master-dev-admin-style', 
            get_template_directory_uri() . '/assets/css/admin.css', 
            array(), 
            WP_MASTER_DEV_VERSION 
        );
    }
}
add_action( 'admin_enqueue_scripts', 'wp_master_dev_admin_scripts' );

/**
 * Register widget areas
 */
function wp_master_dev_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 1', 'wp-master-dev' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Add widgets here to appear in the first footer column.', 'wp-master-dev' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 2', 'wp-master-dev' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Add widgets here to appear in the second footer column.', 'wp-master-dev' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 3', 'wp-master-dev' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Add widgets here to appear in the third footer column.', 'wp-master-dev' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 4', 'wp-master-dev' ),
        'id'            => 'footer-4',
        'description'   => esc_html__( 'Add widgets here to appear in the fourth footer column.', 'wp-master-dev' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'wp_master_dev_widgets_init' );

/**
 * Register custom post types
 */
function wp_master_dev_register_post_types() {
    // Services post type
    register_post_type( 'service', array(
        'labels' => array(
            'name'               => esc_html__( 'Services', 'wp-master-dev' ),
            'singular_name'      => esc_html__( 'Service', 'wp-master-dev' ),
            'menu_name'          => esc_html__( 'Services', 'wp-master-dev' ),
            'add_new'            => esc_html__( 'Add New', 'wp-master-dev' ),
            'add_new_item'       => esc_html__( 'Add New Service', 'wp-master-dev' ),
            'edit_item'          => esc_html__( 'Edit Service', 'wp-master-dev' ),
            'new_item'           => esc_html__( 'New Service', 'wp-master-dev' ),
            'view_item'          => esc_html__( 'View Service', 'wp-master-dev' ),
            'search_items'       => esc_html__( 'Search Services', 'wp-master-dev' ),
            'not_found'          => esc_html__( 'No services found', 'wp-master-dev' ),
            'not_found_in_trash' => esc_html__( 'No services found in Trash', 'wp-master-dev' ),
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-admin-tools',
        'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'show_in_rest' => true,
    ) );

    // Projects post type
    register_post_type( 'project', array(
        'labels' => array(
            'name'               => esc_html__( 'Projects', 'wp-master-dev' ),
            'singular_name'      => esc_html__( 'Project', 'wp-master-dev' ),
            'menu_name'          => esc_html__( 'Projects', 'wp-master-dev' ),
            'add_new'            => esc_html__( 'Add New', 'wp-master-dev' ),
            'add_new_item'       => esc_html__( 'Add New Project', 'wp-master-dev' ),
            'edit_item'          => esc_html__( 'Edit Project', 'wp-master-dev' ),
            'new_item'           => esc_html__( 'New Project', 'wp-master-dev' ),
            'view_item'          => esc_html__( 'View Project', 'wp-master-dev' ),
            'search_items'       => esc_html__( 'Search Projects', 'wp-master-dev' ),
            'not_found'          => esc_html__( 'No projects found', 'wp-master-dev' ),
            'not_found_in_trash' => esc_html__( 'No projects found in Trash', 'wp-master-dev' ),
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-portfolio',
        'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'show_in_rest' => true,
    ) );

    // Testimonials post type
    register_post_type( 'testimonial', array(
        'labels' => array(
            'name'               => esc_html__( 'Testimonials', 'wp-master-dev' ),
            'singular_name'      => esc_html__( 'Testimonial', 'wp-master-dev' ),
            'menu_name'          => esc_html__( 'Testimonials', 'wp-master-dev' ),
            'add_new'            => esc_html__( 'Add New', 'wp-master-dev' ),
            'add_new_item'       => esc_html__( 'Add New Testimonial', 'wp-master-dev' ),
            'edit_item'          => esc_html__( 'Edit Testimonial', 'wp-master-dev' ),
            'new_item'           => esc_html__( 'New Testimonial', 'wp-master-dev' ),
            'view_item'          => esc_html__( 'View Testimonial', 'wp-master-dev' ),
            'search_items'       => esc_html__( 'Search Testimonials', 'wp-master-dev' ),
            'not_found'          => esc_html__( 'No testimonials found', 'wp-master-dev' ),
            'not_found_in_trash' => esc_html__( 'No testimonials found in Trash', 'wp-master-dev' ),
        ),
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-format-quote',
        'supports'     => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'show_in_rest' => true,
    ) );
}
add_action( 'init', 'wp_master_dev_register_post_types' );

/**
 * Contact form handler
 */
function wp_master_dev_handle_contact_form() {
    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['nonce'], 'wp_master_dev_nonce' ) ) {
        wp_die( esc_html__( 'Security check failed', 'wp-master-dev' ) );
    }

    // Sanitize form data
    $name    = sanitize_text_field( $_POST['name'] );
    $email   = sanitize_email( $_POST['email'] );
    $subject = sanitize_text_field( $_POST['subject'] );
    $message = sanitize_textarea_field( $_POST['message'] );

    // Validate required fields
    if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
        wp_send_json_error( array( 'message' => esc_html__( 'Please fill in all required fields.', 'wp-master-dev' ) ) );
    }

    // Validate email
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => esc_html__( 'Please enter a valid email address.', 'wp-master-dev' ) ) );
    }

    // Prepare email
    $to      = get_option( 'admin_email' );
    $headers = array( 'Content-Type: text/html; charset=UTF-8' );
    
    $email_subject = sprintf( esc_html__( 'Contact Form: %s', 'wp-master-dev' ), $subject );
    $email_message = sprintf(
        '<h3>%s</h3><p><strong>%s:</strong> %s</p><p><strong>%s:</strong> %s</p><p><strong>%s:</strong></p><p>%s</p>',
        esc_html__( 'New Contact Form Submission', 'wp-master-dev' ),
        esc_html__( 'Name', 'wp-master-dev' ),
        esc_html( $name ),
        esc_html__( 'Email', 'wp-master-dev' ),
        esc_html( $email ),
        esc_html__( 'Message', 'wp-master-dev' ),
        wp_kses_post( wpautop( $message ) )
    );

    // Send email
    if ( wp_mail( $to, $email_subject, $email_message, $headers ) ) {
        wp_send_json_success( array( 'message' => esc_html__( 'Thank you! Your message has been sent successfully.', 'wp-master-dev' ) ) );
    } else {
        wp_send_json_error( array( 'message' => esc_html__( 'Sorry, there was an error sending your message. Please try again.', 'wp-master-dev' ) ) );
    }
}
add_action( 'wp_ajax_wp_master_dev_contact_form', 'wp_master_dev_handle_contact_form' );
add_action( 'wp_ajax_nopriv_wp_master_dev_contact_form', 'wp_master_dev_handle_contact_form' );

/**
 * Custom Walker for Desktop Navigation Menu
 */
class WP_Master_Dev_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        
        // Add active class for current page
        if ( in_array( 'current-menu-item', $classes ) || in_array( 'current_page_item', $classes ) ) {
            $class_names .= ' active';
        }
        
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $item_output = isset( $args->before ) ? $args->before : '';
        $item_output .= '<a' . $attributes .'>';
        $item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . apply_filters( 'the_title', $item->title, $item->ID ) . ( isset( $args->link_after ) ? $args->link_after : '' );
        $item_output .= '</a>';
        $item_output .= isset( $args->after ) ? $args->after : '';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}

/**
 * Custom Walker for Mobile Navigation Menu
 */
class WP_Master_Dev_Walker_Mobile_Nav_Menu extends Walker_Nav_Menu {
    
    function start_lvl( &$output, $depth = 0, $args = null ) {
        // No sub-menus in mobile for simplicity
    }

    function end_lvl( &$output, $depth = 0, $args = null ) {
        // No sub-menus in mobile for simplicity
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        if ( $depth > 0 ) return; // Only show top-level items in mobile

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        
        // Add active class for current page
        $active_class = '';
        if ( in_array( 'current-menu-item', $classes ) || in_array( 'current_page_item', $classes ) ) {
            $active_class = ' active';
        }

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $output .= '<a' . $attributes . ' class="mobile-nav-link' . $active_class . '">';
        $output .= apply_filters( 'the_title', $item->title, $item->ID );
        $output .= '</a>';
    }

    function end_el( &$output, $item, $depth = 0, $args = null ) {
        // No closing tag needed for mobile links
    }
}

/**
 * Default menu fallback for desktop navigation
 */
function wp_master_dev_default_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '" class="' . ( is_front_page() ? 'active' : '' ) . '">Home</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/about' ) ) . '" class="' . ( is_page( 'about' ) ? 'active' : '' ) . '">About Us</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/services' ) ) . '" class="' . ( is_page( 'services' ) ? 'active' : '' ) . '">Services</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/contact' ) ) . '" class="' . ( is_page( 'contact' ) ? 'active' : '' ) . '">Contact</a></li>';
    echo '</ul>';
}

/**
 * Default menu fallback for mobile navigation
 */
function wp_master_dev_mobile_default_menu() {
    echo '<div class="mobile-nav-links">';
    echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="mobile-nav-link' . ( is_front_page() ? ' active' : '' ) . '">Home</a>';
    echo '<a href="' . esc_url( home_url( '/about' ) ) . '" class="mobile-nav-link' . ( is_page( 'about' ) ? ' active' : '' ) . '">About Us</a>';
    echo '<a href="' . esc_url( home_url( '/services' ) ) . '" class="mobile-nav-link' . ( is_page( 'services' ) ? ' active' : '' ) . '">Services</a>';
    echo '<a href="' . esc_url( home_url( '/contact' ) ) . '" class="mobile-nav-link' . ( is_page( 'contact' ) ? ' active' : '' ) . '">Contact</a>';
    echo '</div>';
}

/**
 * Include theme customizer
 */
if ( file_exists( get_template_directory() . '/inc/customizer.php' ) ) {
    require get_template_directory() . '/inc/customizer.php';
}

/**
 * Include template functions
 */
if ( file_exists( get_template_directory() . '/inc/template-functions.php' ) ) {
    require get_template_directory() . '/inc/template-functions.php';
}

/**
 * Include theme installer
 */
if ( file_exists( get_template_directory() . '/inc/theme-installer.php' ) ) {
    require get_template_directory() . '/inc/theme-installer.php';
}

/**
 * Add body classes for styling
 */
function wp_master_dev_body_classes( $classes ) {
    // Add class for mobile menu state
    $classes[] = 'has-mobile-menu';
    
    // Add class for current page
    if ( is_front_page() ) {
        $classes[] = 'is-home-page';
    }
    
    return $classes;
}
add_filter( 'body_class', 'wp_master_dev_body_classes' );

/**
 * Performance optimizations
 */
function wp_master_dev_preload_hints() {
    // Preload critical fonts
    echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
    echo '<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"></noscript>';
    
    // Preload hero background
    echo '<link rel="preload" href="' . get_template_directory_uri() . '/assets/images/hero-bg.png" as="image">';
    
    // DNS prefetch for external resources
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">';
}
add_action( 'wp_head', 'wp_master_dev_preload_hints', 1 );

/**
 * Security enhancements
 */
function wp_master_dev_security_headers() {
    // Add security headers
    header( 'X-Content-Type-Options: nosniff' );
    header( 'X-Frame-Options: SAMEORIGIN' );
    header( 'X-XSS-Protection: 1; mode=block' );
}
add_action( 'send_headers', 'wp_master_dev_security_headers' );

/**
 * Custom excerpt length
 */
function wp_master_dev_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'wp_master_dev_excerpt_length' );

/**
 * Custom excerpt more
 */
function wp_master_dev_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'wp_master_dev_excerpt_more' );

/**
 * Development helper: Check if npm packages are built
 */
function wp_master_dev_check_assets() {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        $css_file = get_template_directory() . '/assets/css/main.css';
        $js_file = get_template_directory() . '/assets/js/main.js';
        
        if ( ! file_exists( $css_file ) || ! file_exists( $js_file ) ) {
            add_action( 'admin_notices', function() {
                echo '<div class="notice notice-warning"><p>';
                echo '<strong>WordPress Master Developer Theme:</strong> ';
                echo 'Assets not found. Please run <code>npm install && npm run build</code> in the theme directory.';
                echo '</p></div>';
            });
        }
    }
}
add_action( 'admin_init', 'wp_master_dev_check_assets' );
?>
