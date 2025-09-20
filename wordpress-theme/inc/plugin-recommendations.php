<?php
/**
 * WordPress Master Developer Theme Plugin Recommendations
 * Handles recommended plugin installation and management
 *
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get list of recommended plugins
 */
function wp_master_dev_get_recommended_plugins() {
    return array(
        'elementor' => array(
            'name' => 'Elementor Page Builder',
            'slug' => 'elementor',
            'description' => 'Drag & drop page builder for creating custom layouts',
            'required' => false,
            'recommended' => true
        ),
        'contact-form-7' => array(
            'name' => 'Contact Form 7',
            'slug' => 'contact-form-7',
            'description' => 'Advanced contact form management',
            'required' => false,
            'recommended' => true
        ),
        'yoast-seo' => array(
            'name' => 'Yoast SEO',
            'slug' => 'wordpress-seo',
            'description' => 'SEO optimization and content analysis',
            'required' => false,
            'recommended' => true
        ),
        'wp-super-cache' => array(
            'name' => 'WP Super Cache',
            'slug' => 'wp-super-cache',
            'description' => 'Caching plugin for improved performance',
            'required' => false,
            'recommended' => true
        ),
        'wordfence' => array(
            'name' => 'Wordfence Security',
            'slug' => 'wordfence',
            'description' => 'Security plugin for malware scanning and firewall',
            'required' => false,
            'recommended' => true
        ),
        'updraftplus' => array(
            'name' => 'UpdraftPlus Backup',
            'slug' => 'updraftplus',
            'description' => 'Backup and restoration plugin',
            'required' => false,
            'recommended' => true
        ),
        'wp-optimize' => array(
            'name' => 'WP-Optimize',
            'slug' => 'wp-optimize',
            'description' => 'Database optimization and cleanup',
            'required' => false,
            'recommended' => false
        ),
        'smush' => array(
            'name' => 'Smush Image Optimization',
            'slug' => 'wp-smushit',
            'description' => 'Image compression and optimization',
            'required' => false,
            'recommended' => false
        )
    );
}

/**
 * Display plugin recommendations in the setup wizard
 */
function wp_master_dev_display_plugin_recommendations() {
    $plugins = wp_master_dev_get_recommended_plugins();
    
    echo '<div class="plugin-recommendations">';
    echo '<h3>Select plugins to install:</h3>';
    
    foreach ($plugins as $slug => $plugin) {
        $is_installed = wp_master_dev_is_plugin_installed($plugin['slug']);
        $is_active = is_plugin_active($plugin['slug'] . '/' . $plugin['slug'] . '.php');
        
        $status_class = '';
        $status_text = '';
        $checkbox_disabled = '';
        
        if ($is_active) {
            $status_class = 'plugin-active';
            $status_text = ' (Active)';
            $checkbox_disabled = 'disabled';
        } elseif ($is_installed) {
            $status_class = 'plugin-installed';
            $status_text = ' (Installed)';
        }
        
        $checked = $plugin['recommended'] && !$is_installed ? 'checked' : '';
        
        echo '<div class="plugin-item ' . $status_class . '">';
        echo '<label>';
        echo '<input type="checkbox" name="selected_plugins[]" value="' . esc_attr($slug) . '" ' . $checked . ' ' . $checkbox_disabled . '>';
        echo '<strong>' . esc_html($plugin['name']) . '</strong>' . $status_text;
        echo '<br><small>' . esc_html($plugin['description']) . '</small>';
        echo '</label>';
        echo '</div>';
    }
    
    echo '</div>';
    
    // Add some CSS for better styling
    echo '<style>
        .plugin-recommendations { margin: 15px 0; }
        .plugin-item { 
            margin: 10px 0; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            background: #f9f9f9;
        }
        .plugin-item.plugin-active { 
            background: #d4edda; 
            border-color: #c3e6cb; 
        }
        .plugin-item.plugin-installed { 
            background: #fff3cd; 
            border-color: #ffeaa7; 
        }
        .plugin-item label { 
            display: block; 
            cursor: pointer; 
        }
        .plugin-item input[type="checkbox"] { 
            margin-right: 8px; 
        }
    </style>';
}

/**
 * Check if a plugin is installed
 */
function wp_master_dev_is_plugin_installed($plugin_slug) {
    $plugins = get_plugins();
    
    foreach ($plugins as $plugin_file => $plugin_data) {
        if (strpos($plugin_file, $plugin_slug . '/') === 0) {
            return true;
        }
    }
    
    return false;
}

/**
 * Install and activate recommended plugins
 */
function wp_master_dev_install_recommended_plugins($selected_plugins) {
    if (empty($selected_plugins) || !is_array($selected_plugins)) {
        return;
    }
    
    $recommended_plugins = wp_master_dev_get_recommended_plugins();
    
    // Include necessary WordPress functions
    if (!function_exists('plugins_api')) {
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
    }
    if (!function_exists('download_url')) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }
    if (!class_exists('WP_Upgrader')) {
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    }
    
    foreach ($selected_plugins as $plugin_key) {
        if (!isset($recommended_plugins[$plugin_key])) {
            continue;
        }
        
        $plugin = $recommended_plugins[$plugin_key];
        $plugin_slug = $plugin['slug'];
        
        // Check if already installed
        if (wp_master_dev_is_plugin_installed($plugin_slug)) {
            // Just activate if installed but not active
            $plugin_file = wp_master_dev_get_plugin_file($plugin_slug);
            if ($plugin_file && !is_plugin_active($plugin_file)) {
                activate_plugin($plugin_file);
            }
            continue;
        }
        
        // Install the plugin
        $api = plugins_api('plugin_information', array(
            'slug' => $plugin_slug,
            'fields' => array(
                'short_description' => false,
                'sections' => false,
                'requires' => false,
                'rating' => false,
                'ratings' => false,
                'downloaded' => false,
                'last_updated' => false,
                'added' => false,
                'tags' => false,
                'compatibility' => false,
                'homepage' => false,
                'donate_link' => false,
            ),
        ));
        
        if (is_wp_error($api)) {
            continue;
        }
        
        // Use the Plugin_Upgrader to install
        $upgrader = new Plugin_Upgrader(new WP_Ajax_Upgrader_Skin());
        $install_result = $upgrader->install($api->download_link);
        
        if ($install_result === true) {
            // Activate the plugin after installation
            $plugin_file = wp_master_dev_get_plugin_file($plugin_slug);
            if ($plugin_file) {
                activate_plugin($plugin_file);
            }
        }
    }
}

/**
 * Get the main plugin file for a plugin slug
 */
function wp_master_dev_get_plugin_file($plugin_slug) {
    $plugins = get_plugins();
    
    foreach ($plugins as $plugin_file => $plugin_data) {
        if (strpos($plugin_file, $plugin_slug . '/') === 0) {
            return $plugin_file;
        }
    }
    
    return false;
}
