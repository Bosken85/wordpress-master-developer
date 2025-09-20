<?php
/**
 * WordPress Master Developer Theme - Enhanced Setup Wizard
 * 
 * Implements a comprehensive setup wizard with:
 * - Required vs Optional plugin management
 * - Theme options configuration
 * - Content import (only when user chooses)
 * 
 * @package WordPress_Master_Developer
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class WP_Master_Dev_Setup_Wizard {
    
    /**
     * Required plugins for theme functionality
     */
    private $required_plugins = [
        'elementor' => [
            'name' => 'Elementor',
            'slug' => 'elementor/elementor.php',
            'source' => 'repo', // WordPress.org repository
            'required' => true,
            'version' => '3.0.0',
            'description' => 'Page builder for creating custom layouts and designs.'
        ],
        'advanced-custom-fields' => [
            'name' => 'Advanced Custom Fields',
            'slug' => 'advanced-custom-fields/acf.php',
            'source' => 'repo',
            'required' => true,
            'version' => '6.0.0',
            'description' => 'Customize WordPress with powerful, professional and intuitive fields.'
        ],
        'wpforms-lite' => [
            'name' => 'WPForms Lite',
            'slug' => 'wpforms-lite/wpforms.php',
            'source' => 'repo',
            'required' => true,
            'version' => '1.8.0',
            'description' => 'Beginner friendly WordPress contact form plugin.'
        ],
        'one-click-demo-import' => [
            'name' => 'One Click Demo Import',
            'slug' => 'one-click-demo-import/one-click-demo-import.php',
            'source' => 'repo',
            'required' => true,
            'version' => '3.0.0',
            'description' => 'Import demo content, widgets and theme settings with one click.'
        ]
    ];
    
    /**
     * Optional recommended plugins
     */
    private $optional_plugins = [
        'custom-post-type-ui' => [
            'name' => 'Custom Post Type UI',
            'slug' => 'custom-post-type-ui/custom-post-type-ui.php',
            'source' => 'repo',
            'required' => false,
            'version' => '1.13.0',
            'description' => 'Admin UI for creating custom post types and custom taxonomies.'
        ],
        'regenerate-thumbnails' => [
            'name' => 'Regenerate Thumbnails',
            'slug' => 'regenerate-thumbnails/regenerate-thumbnails.php',
            'source' => 'repo',
            'required' => false,
            'version' => '3.1.0',
            'description' => 'Regenerate thumbnails for existing images.'
        ],
        'svg-support' => [
            'name' => 'SVG Support',
            'slug' => 'svg-support/svg-support.php',
            'source' => 'repo',
            'required' => false,
            'version' => '2.5.0',
            'description' => 'Allow SVG files to be uploaded to the Media Library.'
        ],
        'wordpress-seo' => [
            'name' => 'Yoast SEO',
            'slug' => 'wordpress-seo/wp-seo.php',
            'source' => 'repo',
            'required' => false,
            'version' => '21.0.0',
            'description' => 'Improve your WordPress SEO: Write better content and have a fully optimized WordPress site.'
        ],
        'disable-comments' => [
            'name' => 'Disable Comments',
            'slug' => 'disable-comments/disable-comments.php',
            'source' => 'repo',
            'required' => false,
            'version' => '2.4.0',
            'description' => 'Allows administrators to globally disable comments on their site.'
        ],
        'wp-mail-smtp' => [
            'name' => 'WP Mail SMTP',
            'slug' => 'wp-mail-smtp/wp_mail_smtp.php',
            'source' => 'repo',
            'required' => false,
            'version' => '3.8.0',
            'description' => 'Reconfigures the wp_mail() function to use SMTP instead of mail().'
        ]
    ];
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('wp_ajax_wp_master_dev_install_plugin', [$this, 'ajax_install_plugin']);
        add_action('wp_ajax_wp_master_dev_activate_plugin', [$this, 'ajax_activate_plugin']);
        add_action('wp_ajax_wp_master_dev_check_plugins', [$this, 'ajax_check_plugins']);
        add_action('wp_ajax_wp_master_dev_setup_theme_options', [$this, 'ajax_setup_theme_options']);
        add_action('wp_ajax_wp_master_dev_import_demo_content', [$this, 'ajax_import_demo_content']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
    }
    
    /**
     * Add admin menu for setup wizard
     */
    public function add_admin_menu() {
        add_theme_page(
            __('Theme Setup Wizard', 'wp-master-dev'),
            __('Setup Wizard', 'wp-master-dev'),
            'manage_options',
            'wp-master-dev-setup-wizard',
            [$this, 'render_setup_wizard']
        );
    }
    
    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'appearance_page_wp-master-dev-setup-wizard') {
            return;
        }
        
        wp_enqueue_script(
            'wp-master-dev-setup-wizard',
            get_template_directory_uri() . '/assets/js/setup-wizard.js',
            ['jquery'],
            WP_MASTER_DEV_VERSION,
            true
        );
        
        wp_enqueue_style(
            'wp-master-dev-setup-wizard',
            get_template_directory_uri() . '/assets/css/setup-wizard.css',
            [],
            WP_MASTER_DEV_VERSION
        );
        
        wp_localize_script('wp-master-dev-setup-wizard', 'wpMasterDevSetup', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_master_dev_setup_nonce'),
            'strings' => [
                'installing' => __('Installing...', 'wp-master-dev'),
                'activating' => __('Activating...', 'wp-master-dev'),
                'installed' => __('Installed', 'wp-master-dev'),
                'activated' => __('Activated', 'wp-master-dev'),
                'error' => __('Error', 'wp-master-dev'),
                'retry' => __('Retry', 'wp-master-dev'),
                'success' => __('Success!', 'wp-master-dev'),
                'importing' => __('Importing demo content...', 'wp-master-dev'),
                'complete' => __('Setup Complete!', 'wp-master-dev')
            ]
        ]);
    }
    
    /**
     * Render the setup wizard interface
     */
    public function render_setup_wizard() {
        ?>
        <div class="wrap wp-master-dev-setup-wizard">
            <h1><?php _e('WordPress Master Developer - Setup Wizard', 'wp-master-dev'); ?></h1>
            
            <div class="setup-wizard-container">
                
                <!-- Step 1: Plugin Installation -->
                <div class="setup-step" id="step-plugins" data-step="1">
                    <div class="step-header">
                        <h2><?php _e('Step 1: Install Required & Optional Plugins', 'wp-master-dev'); ?></h2>
                        <p><?php _e('Install the required plugins for full theme functionality, and optionally install recommended plugins for enhanced features.', 'wp-master-dev'); ?></p>
                    </div>
                    
                    <div class="plugins-section">
                        <h3 class="plugins-section-title required"><?php _e('Required Plugins', 'wp-master-dev'); ?></h3>
                        <p class="plugins-section-description"><?php _e('These plugins are essential for the theme to work properly.', 'wp-master-dev'); ?></p>
                        
                        <div class="plugins-list required-plugins">
                            <?php $this->render_plugins_list($this->required_plugins, true); ?>
                        </div>
                    </div>
                    
                    <div class="plugins-section">
                        <h3 class="plugins-section-title optional"><?php _e('Optional Plugins', 'wp-master-dev'); ?></h3>
                        <p class="plugins-section-description"><?php _e('These plugins are recommended for enhanced functionality but not required.', 'wp-master-dev'); ?></p>
                        
                        <div class="plugins-list optional-plugins">
                            <?php $this->render_plugins_list($this->optional_plugins, false); ?>
                        </div>
                    </div>
                    
                    <div class="step-actions">
                        <button type="button" class="button button-primary" id="install-required-plugins">
                            <?php _e('Install Required Plugins', 'wp-master-dev'); ?>
                        </button>
                        <button type="button" class="button" id="install-selected-optional">
                            <?php _e('Install Selected Optional Plugins', 'wp-master-dev'); ?>
                        </button>
                        <button type="button" class="button button-secondary" id="skip-to-step-2" disabled>
                            <?php _e('Continue to Theme Setup', 'wp-master-dev'); ?>
                        </button>
                    </div>
                </div>
                
                <!-- Step 2: Theme Options -->
                <div class="setup-step" id="step-theme-options" data-step="2" style="display: none;">
                    <div class="step-header">
                        <h2><?php _e('Step 2: Configure Theme Options', 'wp-master-dev'); ?></h2>
                        <p><?php _e('Set up basic theme settings to match the design system. No content will be created yet.', 'wp-master-dev'); ?></p>
                    </div>
                    
                    <div class="theme-options-form">
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e('Site Logo', 'wp-master-dev'); ?></th>
                                <td>
                                    <input type="text" id="site-logo-url" class="regular-text" placeholder="<?php _e('Logo URL (optional)', 'wp-master-dev'); ?>" />
                                    <p class="description"><?php _e('Leave empty to use a generated placeholder logo.', 'wp-master-dev'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Primary Color', 'wp-master-dev'); ?></th>
                                <td>
                                    <input type="color" id="primary-color" value="#2563eb" />
                                    <p class="description"><?php _e('Main brand color for buttons, links, and accents.', 'wp-master-dev'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Secondary Color', 'wp-master-dev'); ?></th>
                                <td>
                                    <input type="color" id="secondary-color" value="#f59e0b" />
                                    <p class="description"><?php _e('Secondary accent color for highlights and CTAs.', 'wp-master-dev'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Container Width', 'wp-master-dev'); ?></th>
                                <td>
                                    <select id="container-width">
                                        <option value="1200">1200px (Default)</option>
                                        <option value="1140">1140px (Bootstrap)</option>
                                        <option value="1320">1320px (Wide)</option>
                                        <option value="100%">100% (Full Width)</option>
                                    </select>
                                    <p class="description"><?php _e('Maximum content width for the site layout.', 'wp-master-dev'); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="step-actions">
                        <button type="button" class="button" id="back-to-step-1">
                            <?php _e('← Back to Plugins', 'wp-master-dev'); ?>
                        </button>
                        <button type="button" class="button button-primary" id="save-theme-options">
                            <?php _e('Save Theme Options', 'wp-master-dev'); ?>
                        </button>
                        <button type="button" class="button button-secondary" id="skip-to-step-3" disabled>
                            <?php _e('Continue to Content Import', 'wp-master-dev'); ?>
                        </button>
                    </div>
                </div>
                
                <!-- Step 3: Content Import -->
                <div class="setup-step" id="step-content-import" data-step="3" style="display: none;">
                    <div class="step-header">
                        <h2><?php _e('Step 3: Import Demo Content (Optional)', 'wp-master-dev'); ?></h2>
                        <p><?php _e('Import demo content to make your site look like the example. This will create pages, menus, forms, and sample content.', 'wp-master-dev'); ?></p>
                    </div>
                    
                    <div class="content-import-options">
                        <div class="import-preview">
                            <h3><?php _e('What will be imported:', 'wp-master-dev'); ?></h3>
                            <ul class="import-checklist">
                                <li><span class="dashicons dashicons-yes"></span> <?php _e('Pages (Home, About, Services, Contact, Legal)', 'wp-master-dev'); ?></li>
                                <li><span class="dashicons dashicons-yes"></span> <?php _e('Navigation Menus (Primary & Footer)', 'wp-master-dev'); ?></li>
                                <li><span class="dashicons dashicons-yes"></span> <?php _e('Elementor Templates & Layouts', 'wp-master-dev'); ?></li>
                                <li><span class="dashicons dashicons-yes"></span> <?php _e('WPForms Contact Forms', 'wp-master-dev'); ?></li>
                                <li><span class="dashicons dashicons-yes"></span> <?php _e('Custom Post Types & Sample Content', 'wp-master-dev'); ?></li>
                                <li><span class="dashicons dashicons-yes"></span> <?php _e('Theme Settings & Customizations', 'wp-master-dev'); ?></li>
                            </ul>
                        </div>
                        
                        <div class="import-warning">
                            <p><strong><?php _e('Important:', 'wp-master-dev'); ?></strong> <?php _e('This will create new content on your site. Existing content will not be affected, but new pages and menus will be added.', 'wp-master-dev'); ?></p>
                        </div>
                    </div>
                    
                    <div class="step-actions">
                        <button type="button" class="button" id="back-to-step-2">
                            <?php _e('← Back to Theme Options', 'wp-master-dev'); ?>
                        </button>
                        <button type="button" class="button button-primary" id="import-demo-content">
                            <?php _e('Import Demo Content', 'wp-master-dev'); ?>
                        </button>
                        <button type="button" class="button button-secondary" id="skip-import">
                            <?php _e('Skip Import (Keep Site Empty)', 'wp-master-dev'); ?>
                        </button>
                    </div>
                </div>
                
                <!-- Step 4: Complete -->
                <div class="setup-step" id="step-complete" data-step="4" style="display: none;">
                    <div class="step-header">
                        <h2><?php _e('Setup Complete!', 'wp-master-dev'); ?></h2>
                        <p><?php _e('Your WordPress Master Developer theme has been successfully configured.', 'wp-master-dev'); ?></p>
                    </div>
                    
                    <div class="completion-actions">
                        <div class="action-card">
                            <h3><?php _e('View Your Site', 'wp-master-dev'); ?></h3>
                            <p><?php _e('See how your site looks with the new theme.', 'wp-master-dev'); ?></p>
                            <a href="<?php echo home_url(); ?>" class="button button-primary" target="_blank">
                                <?php _e('Visit Site', 'wp-master-dev'); ?>
                            </a>
                        </div>
                        
                        <div class="action-card">
                            <h3><?php _e('Edit with Elementor', 'wp-master-dev'); ?></h3>
                            <p><?php _e('Customize your pages with the Elementor page builder.', 'wp-master-dev'); ?></p>
                            <a href="<?php echo admin_url('edit.php?post_type=page'); ?>" class="button">
                                <?php _e('Edit Pages', 'wp-master-dev'); ?>
                            </a>
                        </div>
                        
                        <div class="action-card">
                            <h3><?php _e('Manage Forms', 'wp-master-dev'); ?></h3>
                            <p><?php _e('Configure your contact forms with WPForms.', 'wp-master-dev'); ?></p>
                            <a href="<?php echo admin_url('admin.php?page=wpforms-overview'); ?>" class="button">
                                <?php _e('Manage Forms', 'wp-master-dev'); ?>
                            </a>
                        </div>
                        
                        <div class="action-card">
                            <h3><?php _e('Customize Theme', 'wp-master-dev'); ?></h3>
                            <p><?php _e('Further customize colors, fonts, and layout options.', 'wp-master-dev'); ?></p>
                            <a href="<?php echo admin_url('customize.php'); ?>" class="button">
                                <?php _e('Customize', 'wp-master-dev'); ?>
                            </a>
                        </div>
                    </div>
                    
                    <div class="final-actions">
                        <button type="button" class="button button-secondary" id="restart-wizard">
                            <?php _e('Restart Setup Wizard', 'wp-master-dev'); ?>
                        </button>
                    </div>
                </div>
                
            </div>
            
            <!-- Progress Indicator -->
            <div class="setup-progress">
                <div class="progress-steps">
                    <div class="progress-step active" data-step="1">
                        <span class="step-number">1</span>
                        <span class="step-label"><?php _e('Plugins', 'wp-master-dev'); ?></span>
                    </div>
                    <div class="progress-step" data-step="2">
                        <span class="step-number">2</span>
                        <span class="step-label"><?php _e('Theme Options', 'wp-master-dev'); ?></span>
                    </div>
                    <div class="progress-step" data-step="3">
                        <span class="step-number">3</span>
                        <span class="step-label"><?php _e('Content Import', 'wp-master-dev'); ?></span>
                    </div>
                    <div class="progress-step" data-step="4">
                        <span class="step-number">4</span>
                        <span class="step-label"><?php _e('Complete', 'wp-master-dev'); ?></span>
                    </div>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 25%;"></div>
                </div>
            </div>
            
        </div>
        <?php
    }
    
    /**
     * Render plugins list
     */
    private function render_plugins_list($plugins, $required = true) {
        foreach ($plugins as $slug => $plugin) {
            $status = $this->get_plugin_status($plugin['slug']);
            $status_class = $status['installed'] ? ($status['active'] ? 'active' : 'inactive') : 'not-installed';
            ?>
            <div class="plugin-item <?php echo $status_class; ?>" data-slug="<?php echo esc_attr($slug); ?>" data-plugin-file="<?php echo esc_attr($plugin['slug']); ?>">
                <div class="plugin-info">
                    <div class="plugin-header">
                        <h4 class="plugin-name"><?php echo esc_html($plugin['name']); ?></h4>
                        <div class="plugin-status">
                            <?php if ($status['active']): ?>
                                <span class="status-badge active"><?php _e('Active', 'wp-master-dev'); ?></span>
                            <?php elseif ($status['installed']): ?>
                                <span class="status-badge inactive"><?php _e('Installed', 'wp-master-dev'); ?></span>
                            <?php else: ?>
                                <span class="status-badge not-installed"><?php _e('Not Installed', 'wp-master-dev'); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <p class="plugin-description"><?php echo esc_html($plugin['description']); ?></p>
                    <div class="plugin-meta">
                        <span class="plugin-version"><?php printf(__('Min Version: %s', 'wp-master-dev'), $plugin['version']); ?></span>
                        <?php if ($required): ?>
                            <span class="plugin-required"><?php _e('Required', 'wp-master-dev'); ?></span>
                        <?php else: ?>
                            <label class="plugin-checkbox">
                                <input type="checkbox" name="optional_plugins[]" value="<?php echo esc_attr($slug); ?>" />
                                <?php _e('Install this plugin', 'wp-master-dev'); ?>
                            </label>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="plugin-actions">
                    <?php if (!$status['installed']): ?>
                        <button type="button" class="button install-plugin" data-slug="<?php echo esc_attr($slug); ?>">
                            <?php _e('Install', 'wp-master-dev'); ?>
                        </button>
                    <?php elseif (!$status['active']): ?>
                        <button type="button" class="button activate-plugin" data-plugin-file="<?php echo esc_attr($plugin['slug']); ?>">
                            <?php _e('Activate', 'wp-master-dev'); ?>
                        </button>
                    <?php else: ?>
                        <span class="plugin-active-indicator"><?php _e('✓ Ready', 'wp-master-dev'); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        }
    }
    
    /**
     * Get plugin installation and activation status
     */
    private function get_plugin_status($plugin_file) {
        $installed_plugins = get_plugins();
        $active_plugins = get_option('active_plugins', []);
        
        $installed = isset($installed_plugins[$plugin_file]);
        $active = in_array($plugin_file, $active_plugins);
        
        return [
            'installed' => $installed,
            'active' => $active,
            'version' => $installed ? $installed_plugins[$plugin_file]['Version'] : null
        ];
    }
    
    /**
     * AJAX: Install plugin
     */
    public function ajax_install_plugin() {
        check_ajax_referer('wp_master_dev_setup_nonce', 'nonce');
        
        if (!current_user_can('install_plugins')) {
            wp_die(__('You do not have sufficient permissions to install plugins.', 'wp-master-dev'));
        }
        
        $plugin_slug = sanitize_text_field($_POST['slug']);
        
        // Get plugin info from our arrays
        $plugin_info = null;
        if (isset($this->required_plugins[$plugin_slug])) {
            $plugin_info = $this->required_plugins[$plugin_slug];
        } elseif (isset($this->optional_plugins[$plugin_slug])) {
            $plugin_info = $this->optional_plugins[$plugin_slug];
        }
        
        if (!$plugin_info) {
            wp_send_json_error(['message' => __('Plugin not found.', 'wp-master-dev')]);
        }
        
        // Include required files
        if (!function_exists('plugins_api')) {
            require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        }
        if (!class_exists('WP_Upgrader')) {
            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        }
        
        // Get plugin information
        $api = plugins_api('plugin_information', [
            'slug' => dirname($plugin_info['slug']),
            'fields' => ['sections' => false]
        ]);
        
        if (is_wp_error($api)) {
            wp_send_json_error(['message' => $api->get_error_message()]);
        }
        
        // Install plugin
        $upgrader = new Plugin_Upgrader(new WP_Ajax_Upgrader_Skin());
        $result = $upgrader->install($api->download_link);
        
        if (is_wp_error($result)) {
            wp_send_json_error(['message' => $result->get_error_message()]);
        }
        
        wp_send_json_success(['message' => __('Plugin installed successfully.', 'wp-master-dev')]);
    }
    
    /**
     * AJAX: Activate plugin
     */
    public function ajax_activate_plugin() {
        check_ajax_referer('wp_master_dev_setup_nonce', 'nonce');
        
        if (!current_user_can('activate_plugins')) {
            wp_die(__('You do not have sufficient permissions to activate plugins.', 'wp-master-dev'));
        }
        
        $plugin_file = sanitize_text_field($_POST['plugin_file']);
        
        $result = activate_plugin($plugin_file);
        
        if (is_wp_error($result)) {
            wp_send_json_error(['message' => $result->get_error_message()]);
        }
        
        wp_send_json_success(['message' => __('Plugin activated successfully.', 'wp-master-dev')]);
    }
    
    /**
     * AJAX: Check plugin statuses
     */
    public function ajax_check_plugins() {
        check_ajax_referer('wp_master_dev_setup_nonce', 'nonce');
        
        $all_plugins = array_merge($this->required_plugins, $this->optional_plugins);
        $statuses = [];
        
        foreach ($all_plugins as $slug => $plugin) {
            $statuses[$slug] = $this->get_plugin_status($plugin['slug']);
        }
        
        // Check if all required plugins are active
        $required_ready = true;
        foreach ($this->required_plugins as $slug => $plugin) {
            if (!$statuses[$slug]['active']) {
                $required_ready = false;
                break;
            }
        }
        
        wp_send_json_success([
            'statuses' => $statuses,
            'required_ready' => $required_ready
        ]);
    }
    
    /**
     * AJAX: Setup theme options
     */
    public function ajax_setup_theme_options() {
        check_ajax_referer('wp_master_dev_setup_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to modify theme options.', 'wp-master-dev'));
        }
        
        // Save theme options
        $logo_url = sanitize_url($_POST['logo_url']);
        $primary_color = sanitize_hex_color($_POST['primary_color']);
        $secondary_color = sanitize_hex_color($_POST['secondary_color']);
        $container_width = sanitize_text_field($_POST['container_width']);
        
        // Set theme mods
        if ($logo_url) {
            set_theme_mod('custom_logo_url', $logo_url);
        }
        set_theme_mod('primary_color', $primary_color);
        set_theme_mod('secondary_color', $secondary_color);
        set_theme_mod('container_width', $container_width);
        
        // Configure Elementor settings if active
        if (is_plugin_active('elementor/elementor.php')) {
            update_option('elementor_container_width', $container_width);
            update_option('elementor_cpt_support', ['page', 'post']);
        }
        
        wp_send_json_success(['message' => __('Theme options saved successfully.', 'wp-master-dev')]);
    }
    
    /**
     * AJAX: Import demo content
     */
    public function ajax_import_demo_content() {
        check_ajax_referer('wp_master_dev_setup_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to import content.', 'wp-master-dev'));
        }
        
        // This will trigger the existing demo content import
        // but only when explicitly requested by the user
        if (function_exists('wp_master_dev_import_comprehensive_demo_content')) {
            wp_master_dev_import_comprehensive_demo_content();
        }
        
        // Mark setup as complete
        update_option('wp_master_dev_setup_complete', true);
        update_option('wp_master_dev_demo_imported', true);
        
        wp_send_json_success(['message' => __('Demo content imported successfully.', 'wp-master-dev')]);
    }
}

// Initialize the setup wizard
new WP_Master_Dev_Setup_Wizard();
