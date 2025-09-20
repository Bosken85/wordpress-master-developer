<?php
/**
 * WordPress Master Developer Theme - Elementor Widgets Integration
 * 
 * Custom Elementor widgets that integrate with the theme:
 * - Hero Section Widget
 * - Services Grid Widget
 * - Contact Form Widget
 * - Testimonials Widget
 * - Portfolio Widget
 * 
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main Elementor Integration Class
 */
class WP_Master_Dev_Elementor_Integration {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('elementor/widgets/widgets_registered', array($this, 'register_widgets'));
        add_action('elementor/elements/categories_registered', array($this, 'register_widget_categories'));
        add_action('elementor/frontend/after_enqueue_styles', array($this, 'enqueue_widget_styles'));
        add_action('elementor/frontend/after_register_scripts', array($this, 'enqueue_widget_scripts'));
    }
    
    /**
     * Register widget categories
     */
    public function register_widget_categories($elements_manager) {
        $elements_manager->add_category(
            'wp-master-dev',
            array(
                'title' => esc_html__('WP Master Developer', 'wp-master-dev'),
                'icon' => 'fa fa-code',
            )
        );
    }
    
    /**
     * Register widgets
     */
    public function register_widgets($widgets_manager) {
        // Include widget files
        require_once get_template_directory() . '/inc/elementor-widgets/hero-widget.php';
        require_once get_template_directory() . '/inc/elementor-widgets/services-widget.php';
        require_once get_template_directory() . '/inc/elementor-widgets/contact-form-widget.php';
        require_once get_template_directory() . '/inc/elementor-widgets/testimonials-widget.php';
        require_once get_template_directory() . '/inc/elementor-widgets/portfolio-widget.php';
        
        // Register widgets
        $widgets_manager->register_widget_type(new \WP_Master_Dev_Hero_Widget());
        $widgets_manager->register_widget_type(new \WP_Master_Dev_Services_Widget());
        $widgets_manager->register_widget_type(new \WP_Master_Dev_Contact_Form_Widget());
        $widgets_manager->register_widget_type(new \WP_Master_Dev_Testimonials_Widget());
        $widgets_manager->register_widget_type(new \WP_Master_Dev_Portfolio_Widget());
    }
    
    /**
     * Enqueue widget styles
     */
    public function enqueue_widget_styles() {
        wp_enqueue_style(
            'wp-master-dev-elementor-widgets',
            get_template_directory_uri() . '/assets/css/elementor-widgets.css',
            array(),
            WP_MASTER_DEV_VERSION
        );
    }
    
    /**
     * Enqueue widget scripts
     */
    public function enqueue_widget_scripts() {
        wp_enqueue_script(
            'wp-master-dev-elementor-widgets',
            get_template_directory_uri() . '/assets/js/elementor-widgets.js',
            array('jquery', 'elementor-frontend'),
            WP_MASTER_DEV_VERSION,
            true
        );
    }
}

/**
 * Initialize Elementor integration if Elementor is active
 */
function wp_master_dev_init_elementor_integration() {
    if (did_action('elementor/loaded')) {
        new WP_Master_Dev_Elementor_Integration();
    }
}
add_action('init', 'wp_master_dev_init_elementor_integration');

/**
 * Check if Elementor is active and show admin notice if not
 */
function wp_master_dev_elementor_admin_notice() {
    if (!did_action('elementor/loaded') && current_user_can('activate_plugins')) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p>
                <strong><?php esc_html_e('WordPress Master Developer Theme', 'wp-master-dev'); ?></strong>
                <?php esc_html_e('works best with Elementor Page Builder. Please install and activate Elementor for the full experience.', 'wp-master-dev'); ?>
                <a href="<?php echo esc_url(admin_url('plugin-install.php?s=elementor&tab=search&type=term')); ?>" class="button button-primary">
                    <?php esc_html_e('Install Elementor', 'wp-master-dev'); ?>
                </a>
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'wp_master_dev_elementor_admin_notice');

/**
 * Add Elementor support for theme locations
 */
function wp_master_dev_elementor_theme_support() {
    if (did_action('elementor/loaded')) {
        // Add theme support for Elementor
        add_theme_support('elementor');
        
        // Add support for custom CSS
        add_theme_support('elementor-custom-css');
        
        // Add support for Elementor Pro features
        if (defined('ELEMENTOR_PRO_VERSION')) {
            add_theme_support('elementor-pro');
        }
    }
}
add_action('after_setup_theme', 'wp_master_dev_elementor_theme_support');

/**
 * Elementor compatibility fixes
 */
function wp_master_dev_elementor_compatibility() {
    if (did_action('elementor/loaded')) {
        // Remove theme's default styles from Elementor pages
        add_action('wp_enqueue_scripts', function() {
            if (\Elementor\Plugin::$instance->preview->is_preview_mode()) {
                // Dequeue theme styles that might conflict
                wp_dequeue_style('wp-master-dev-style');
                
                // Enqueue minimal Elementor-compatible styles
                wp_enqueue_style(
                    'wp-master-dev-elementor-compat',
                    get_template_directory_uri() . '/assets/css/elementor-compat.css',
                    array(),
                    WP_MASTER_DEV_VERSION
                );
            }
        }, 20);
        
        // Add custom Elementor breakpoints
        add_action('elementor/init', function() {
            \Elementor\Plugin::$instance->breakpoints->add_breakpoint('mobile', [
                'label' => esc_html__('Mobile', 'wp-master-dev'),
                'value' => 767,
                'default_value' => 767,
                'direction' => 'max',
            ]);
            
            \Elementor\Plugin::$instance->breakpoints->add_breakpoint('tablet', [
                'label' => esc_html__('Tablet', 'wp-master-dev'),
                'value' => 1024,
                'default_value' => 1024,
                'direction' => 'max',
            ]);
        });
    }
}
add_action('init', 'wp_master_dev_elementor_compatibility');

/**
 * Add custom CSS for Elementor integration
 */
function wp_master_dev_elementor_custom_css() {
    if (did_action('elementor/loaded')) {
        ?>
        <style>
        /* Elementor Integration Styles */
        .elementor-widget-wp-master-hero .wp-master-hero {
            margin: 0;
            padding: 80px 0;
        }
        
        .elementor-widget-wp-master-services .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .elementor-widget-wp-master-contact-form .contact-form {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .elementor-widget-wp-master-testimonials .testimonials-carousel {
            overflow: hidden;
        }
        
        .elementor-widget-wp-master-portfolio .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .elementor-widget-wp-master-services .services-grid {
                grid-template-columns: 1fr;
            }
            
            .elementor-widget-wp-master-portfolio .portfolio-grid {
                grid-template-columns: 1fr;
            }
        }
        </style>
        <?php
    }
}
add_action('wp_head', 'wp_master_dev_elementor_custom_css');

/**
 * Elementor Pro Theme Builder support
 */
function wp_master_dev_elementor_pro_support() {
    if (defined('ELEMENTOR_PRO_VERSION')) {
        // Add theme builder locations
        add_action('elementor/theme/register_locations', function($elementor_theme_manager) {
            $elementor_theme_manager->register_location('header');
            $elementor_theme_manager->register_location('footer');
            $elementor_theme_manager->register_location('single');
            $elementor_theme_manager->register_location('archive');
        });
        
        // Override theme templates with Elementor Pro
        add_action('template_redirect', function() {
            if (function_exists('elementor_theme_do_location')) {
                // Check if header is built with Elementor
                if (elementor_theme_do_location('header')) {
                    remove_action('wp_head', 'wp_master_dev_custom_header');
                }
                
                // Check if footer is built with Elementor
                if (elementor_theme_do_location('footer')) {
                    remove_action('wp_footer', 'wp_master_dev_custom_footer');
                }
            }
        });
    }
}
add_action('init', 'wp_master_dev_elementor_pro_support');
