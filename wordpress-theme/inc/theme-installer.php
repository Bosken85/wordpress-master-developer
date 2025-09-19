<?php
/**
 * WordPress Master Developer Theme Installer
 * Handles theme activation, demo content import, and initial setup
 *
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme activation setup
 */
function wp_master_dev_theme_activation() {
    // Only flush rewrite rules on activation
    flush_rewrite_rules();
    
    // Set flag to show welcome notice
    set_transient('wp_master_dev_activation_notice', true, 30);
}
add_action('after_switch_theme', 'wp_master_dev_theme_activation');

/**
 * Set default theme options
 */
function wp_master_dev_set_default_options() {
    $defaults = array(
        'wp_master_dev_hero_title' => 'WordPress Master Developer',
        'wp_master_dev_hero_subtitle' => 'Expert AI assistant specializing in custom WordPress theme development from scratch',
        'wp_master_dev_hero_description' => 'Deep expertise in PHP, CSS, HTML, and JavaScript. Creating high-quality, performance-optimized WordPress themes that are fully integrated with WordPress core and built for security, scalability, and upgrade safety.',
        'wp_master_dev_cta_text' => 'Start Your Project',
        'wp_master_dev_contact_email' => 'contact@wpmaster.dev',
        'wp_master_dev_contact_phone' => '+1 (555) 123-4567',
    );
    
    foreach ($defaults as $option => $value) {
        if (!get_option($option)) {
            update_option($option, $value);
        }
    }
    
    // Set customizer defaults
    $customizer_defaults = array(
        'hero_title' => 'WordPress Master Developer',
        'hero_subtitle' => 'Expert AI assistant specializing in custom WordPress theme development from scratch',
        'hero_description' => 'Deep expertise in PHP, CSS, HTML, and JavaScript. Creating high-quality, performance-optimized WordPress themes that are fully integrated with WordPress core and built for security, scalability, and upgrade safety.',
        'hero_button_text' => 'Start Your Project',
        'primary_color' => '#2563eb',
        'accent_color' => '#f59e0b',
        'contact_email' => 'contact@wpmaster.dev',
        'contact_phone' => '+1 (555) 123-4567',
        'footer_copyright' => sprintf('© %s WordPress Master Developer. All rights reserved.', date('Y')),
        'footer_description' => 'Professional WordPress development services with modern design and expert implementation.',
        'google_fonts' => 'Inter:300,400,500,600,700',
        'container_width' => '1200',
        'preload_fonts' => true,
    );
    
    foreach ($customizer_defaults as $setting => $value) {
        if (!get_theme_mod($setting)) {
            set_theme_mod($setting, $value);
        }
    }
}

/**
 * Create default pages
 */
function wp_master_dev_create_default_pages() {
    $pages = array(
        'about' => array(
            'title' => 'About Us',
            'content' => 'Welcome to WordPress Master Developer, where expertise meets innovation in custom WordPress theme development. With deep knowledge of PHP, CSS, HTML, and JavaScript, we create high-quality, performance-optimized WordPress themes that are fully integrated with WordPress core and built for security, scalability, and upgrade safety.',
            'template' => 'page-about.php'
        ),
        'services' => array(
            'title' => 'Services',
            'content' => 'We offer comprehensive WordPress development services tailored to your specific needs and business goals. From custom theme development to performance optimization, our expertise covers all aspects of WordPress development.',
            'template' => 'page-services.php'
        ),
        'contact' => array(
            'title' => 'Contact',
            'content' => 'Ready to start your WordPress project? Get in touch and let\'s discuss how we can help bring your vision to life. We provide free consultations and detailed project proposals.',
            'template' => 'page-contact.php'
        ),
        'privacy-policy' => array(
            'title' => 'Privacy Policy',
            'content' => wp_master_dev_get_privacy_policy_content(),
            'template' => ''
        ),
        'terms-of-service' => array(
            'title' => 'Terms of Service',
            'content' => wp_master_dev_get_terms_content(),
            'template' => ''
        ),
        'cookie-policy' => array(
            'title' => 'Cookie Policy',
            'content' => wp_master_dev_get_cookie_policy_content(),
            'template' => ''
        ),
        'disclaimer' => array(
            'title' => 'Disclaimer',
            'content' => wp_master_dev_get_disclaimer_content(),
            'template' => ''
        )
    );
    
    foreach ($pages as $slug => $page_data) {
        // Check if page already exists
        $existing_page = get_page_by_path($slug);
        
        if (!$existing_page) {
            $page_id = wp_insert_post(array(
                'post_title' => $page_data['title'],
                'post_content' => $page_data['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_name' => $slug,
                'post_author' => 1
            ));
            
            // Set page template if specified
            if (!empty($page_data['template'])) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
        }
    }
    
    // Set front page to static page (optional)
    $front_page = get_page_by_title('Home');
    if ($front_page) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $front_page->ID);
    }
}

/**
 * Setup default menus
 */
function wp_master_dev_setup_menus() {
    // Delete existing menus to avoid duplicates
    $existing_primary = wp_get_nav_menu_object('Primary Menu');
    if ($existing_primary) {
        wp_delete_nav_menu($existing_primary->term_id);
    }
    
    $existing_footer = wp_get_nav_menu_object('Footer Menu');
    if ($existing_footer) {
        wp_delete_nav_menu($existing_footer->term_id);
    }
    
    // Create primary menu
    $primary_menu_id = wp_create_nav_menu('Primary Menu');
    
    if (!is_wp_error($primary_menu_id)) {
        // Add menu items
        $menu_items = array(
            array('title' => 'Home', 'url' => home_url('/'), 'menu_order' => 1),
            array('title' => 'About', 'page' => 'about', 'menu_order' => 2),
            array('title' => 'Services', 'page' => 'services', 'menu_order' => 3),
            array('title' => 'Contact', 'page' => 'contact', 'menu_order' => 4),
        );
        
        foreach ($menu_items as $item) {
            if (isset($item['page'])) {
                $page = get_page_by_path($item['page']);
                if ($page) {
                    wp_update_nav_menu_item($primary_menu_id, 0, array(
                        'menu-item-title' => $item['title'],
                        'menu-item-object' => 'page',
                        'menu-item-object-id' => $page->ID,
                        'menu-item-type' => 'post_type',
                        'menu-item-status' => 'publish',
                        'menu-item-position' => $item['menu_order']
                    ));
                }
            } else {
                wp_update_nav_menu_item($primary_menu_id, 0, array(
                    'menu-item-title' => $item['title'],
                    'menu-item-url' => $item['url'],
                    'menu-item-type' => 'custom',
                    'menu-item-status' => 'publish',
                    'menu-item-position' => $item['menu_order']
                ));
            }
        }
        
        // Assign menu to location
        $locations = get_theme_mod('nav_menu_locations');
        if (!is_array($locations)) {
            $locations = array();
        }
        $locations['primary'] = $primary_menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
    
    // Create footer menu
    $footer_menu_id = wp_create_nav_menu('Footer Menu');
    
    if (!is_wp_error($footer_menu_id)) {
        $footer_items = array(
            array('title' => 'Privacy Policy', 'page' => 'privacy-policy', 'menu_order' => 1),
            array('title' => 'Terms of Service', 'page' => 'terms-of-service', 'menu_order' => 2),
            array('title' => 'Cookie Policy', 'page' => 'cookie-policy', 'menu_order' => 3),
            array('title' => 'Disclaimer', 'page' => 'disclaimer', 'menu_order' => 4),
        );
        
        foreach ($footer_items as $item) {
            $page = get_page_by_path($item['page']);
            if ($page) {
                wp_update_nav_menu_item($footer_menu_id, 0, array(
                    'menu-item-title' => $item['title'],
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $page->ID,
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish',
                    'menu-item-position' => $item['menu_order']
                ));
            }
        }
        
        // Assign footer menu to location
        $locations = get_theme_mod('nav_menu_locations');
        if (!is_array($locations)) {
            $locations = array();
        }
        $locations['footer'] = $footer_menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

/**
 * Create demo content
 */
function wp_master_dev_create_demo_content() {
    // Create demo services
    $services = array(
        array(
            'title' => 'Custom Theme Development',
            'content' => 'Fully custom WordPress themes built from scratch to match your brand and requirements perfectly. We create responsive, SEO-optimized themes that are fast, secure, and easy to maintain.',
            'price' => '$2,500+',
            'icon' => '🎨',
            'featured' => true
        ),
        array(
            'title' => 'Plugin Integration',
            'content' => 'Expert integration of WordPress plugins with custom functionality and seamless user experience. We work with popular plugins like WooCommerce, ACF, and Contact Form 7.',
            'price' => '$500+',
            'icon' => '🔌',
            'featured' => true
        ),
        array(
            'title' => 'Performance Optimization',
            'content' => 'Speed up your WordPress site with advanced optimization techniques and best practices. We analyze, optimize, and monitor your site\'s performance.',
            'price' => '$800+',
            'icon' => '⚡',
            'featured' => true
        ),
        array(
            'title' => 'Maintenance & Support',
            'content' => 'Ongoing WordPress maintenance, updates, and technical support to keep your site running smoothly. Includes security monitoring and regular backups.',
            'price' => '$200/month',
            'icon' => '🛠️',
            'featured' => true
        )
    );
    
    foreach ($services as $service) {
        $post_id = wp_insert_post(array(
            'post_title' => $service['title'],
            'post_content' => $service['content'],
            'post_status' => 'publish',
            'post_type' => 'service',
            'post_author' => 1
        ));
        
        if ($post_id) {
            update_post_meta($post_id, 'service_price', $service['price']);
            update_post_meta($post_id, 'service_icon', $service['icon']);
            update_post_meta($post_id, 'featured_service', $service['featured'] ? '1' : '0');
        }
    }
    
    // Create demo projects
    $projects = array(
        array(
            'title' => 'E-commerce Fashion Store',
            'content' => 'Custom WooCommerce theme for a fashion retailer with advanced product filtering, wishlist functionality, and mobile-optimized checkout process.',
            'client' => 'Fashion Boutique Inc.',
            'url' => 'https://example.com',
            'technologies' => 'WordPress, WooCommerce, Custom PHP, SCSS, JavaScript',
            'featured' => true
        ),
        array(
            'title' => 'Corporate Business Website',
            'content' => 'Professional corporate website with custom post types for team members, case studies, and news. Features advanced contact forms and CRM integration.',
            'client' => 'Business Solutions Ltd.',
            'url' => 'https://example.com',
            'technologies' => 'WordPress, ACF Pro, Custom PHP, Bootstrap, jQuery',
            'featured' => true
        ),
        array(
            'title' => 'Restaurant Chain Website',
            'content' => 'Multi-location restaurant website with online ordering system, menu management, and location finder with Google Maps integration.',
            'client' => 'Gourmet Restaurants',
            'url' => 'https://example.com',
            'technologies' => 'WordPress, Custom PHP, Google Maps API, Online Ordering System',
            'featured' => true
        ),
        array(
            'title' => 'Educational Platform',
            'content' => 'Learning management system built on WordPress with course management, student progress tracking, and payment integration.',
            'client' => 'Online Academy',
            'url' => 'https://example.com',
            'technologies' => 'WordPress, LearnDash, Custom PHP, Stripe API, SCSS',
            'featured' => true
        )
    );
    
    foreach ($projects as $project) {
        $post_id = wp_insert_post(array(
            'post_title' => $project['title'],
            'post_content' => $project['content'],
            'post_status' => 'publish',
            'post_type' => 'project',
            'post_author' => 1
        ));
        
        if ($post_id) {
            update_post_meta($post_id, 'project_client', $project['client']);
            update_post_meta($post_id, 'project_url', $project['url']);
            update_post_meta($post_id, 'project_technologies', $project['technologies']);
            update_post_meta($post_id, 'featured_project', $project['featured'] ? '1' : '0');
        }
    }
    
    // Create demo testimonials
    $testimonials = array(
        array(
            'title' => 'Exceptional WordPress Development',
            'content' => 'The team delivered an outstanding WordPress theme that exceeded our expectations. The attention to detail and performance optimization was remarkable.',
            'client_name' => 'Sarah Johnson',
            'client_position' => 'Marketing Director',
            'client_company' => 'Tech Innovations Inc.',
            'rating' => 5
        ),
        array(
            'title' => 'Professional and Reliable',
            'content' => 'Working with WordPress Master Developer was a pleasure. They understood our requirements perfectly and delivered a high-quality solution on time.',
            'client_name' => 'Michael Chen',
            'client_position' => 'CEO',
            'client_company' => 'Digital Solutions Ltd.',
            'rating' => 5
        ),
        array(
            'title' => 'Outstanding Results',
            'content' => 'Our website performance improved dramatically after the optimization work. The team\'s expertise in WordPress development is truly impressive.',
            'client_name' => 'Emily Rodriguez',
            'client_position' => 'Project Manager',
            'client_company' => 'Creative Agency',
            'rating' => 5
        )
    );
    
    foreach ($testimonials as $testimonial) {
        $post_id = wp_insert_post(array(
            'post_title' => $testimonial['title'],
            'post_content' => $testimonial['content'],
            'post_status' => 'publish',
            'post_type' => 'testimonial',
            'post_author' => 1
        ));
        
        if ($post_id) {
            update_post_meta($post_id, 'client_name', $testimonial['client_name']);
            update_post_meta($post_id, 'client_position', $testimonial['client_position']);
            update_post_meta($post_id, 'client_company', $testimonial['client_company']);
            update_post_meta($post_id, 'testimonial_rating', $testimonial['rating']);
        }
    }
}

/**
 * Show activation notice
 */
function wp_master_dev_activation_notice() {
    if (get_transient('wp_master_dev_activation_notice')) {
        ?>
        <div class="notice notice-success is-dismissible">
            <h3><?php esc_html_e('WordPress Master Developer Theme Activated!', 'wp-master-dev'); ?></h3>
            <p><?php esc_html_e('Thank you for choosing WordPress Master Developer theme. Your theme has been set up with default pages and menus.', 'wp-master-dev'); ?></p>
            <p>
                <a href="<?php echo esc_url(admin_url('customize.php')); ?>" class="button button-primary">
                    <?php esc_html_e('Customize Your Site', 'wp-master-dev'); ?>
                </a>
                <a href="<?php echo esc_url(admin_url('admin.php?page=wp-master-dev-demo-import')); ?>" class="button">
                    <?php esc_html_e('Import Demo Content', 'wp-master-dev'); ?>
                </a>
                <a href="<?php echo esc_url(admin_url('themes.php?page=wp-master-dev-options')); ?>" class="button">
                    <?php esc_html_e('Theme Options', 'wp-master-dev'); ?>
                </a>
            </p>
        </div>
        <?php
        delete_transient('wp_master_dev_activation_notice');
    }
}
add_action('admin_notices', 'wp_master_dev_activation_notice');

/**
 * Add demo import page
 */
function wp_master_dev_demo_import_menu() {
    add_theme_page(
        esc_html__('Demo Import', 'wp-master-dev'),
        esc_html__('Demo Import', 'wp-master-dev'),
        'manage_options',
        'wp-master-dev-demo-import',
        'wp_master_dev_demo_import_page'
    );
}
add_action('admin_menu', 'wp_master_dev_demo_import_menu');

/**
 * Demo import page
 */
function wp_master_dev_demo_import_page() {
    if (isset($_POST['import_demo']) && wp_verify_nonce($_POST['demo_import_nonce'], 'wp_master_dev_demo_import')) {
        wp_master_dev_create_demo_content();
        echo '<div class="notice notice-success"><p>' . esc_html__('Demo content imported successfully!', 'wp-master-dev') . '</p></div>';
    }
    
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Import Demo Content', 'wp-master-dev'); ?></h1>
        <p><?php esc_html_e('Import demo content to see how your theme looks with sample data. This will create sample services, projects, and testimonials.', 'wp-master-dev'); ?></p>
        
        <form method="post" action="">
            <?php wp_nonce_field('wp_master_dev_demo_import', 'demo_import_nonce'); ?>
            <p>
                <input type="submit" name="import_demo" class="button button-primary" value="<?php esc_attr_e('Import Demo Content', 'wp-master-dev'); ?>">
            </p>
        </form>
        
        <h3><?php esc_html_e('What will be imported:', 'wp-master-dev'); ?></h3>
        <ul>
            <li><?php esc_html_e('4 Sample Services with pricing and features', 'wp-master-dev'); ?></li>
            <li><?php esc_html_e('4 Sample Projects with client information', 'wp-master-dev'); ?></li>
            <li><?php esc_html_e('3 Sample Testimonials with ratings', 'wp-master-dev'); ?></li>
        </ul>
        
        <p><strong><?php esc_html_e('Note:', 'wp-master-dev'); ?></strong> <?php esc_html_e('This will not overwrite existing content. You can safely run this multiple times.', 'wp-master-dev'); ?></p>
    </div>
    <?php
}

/**
 * Get privacy policy content
 */
function wp_master_dev_get_privacy_policy_content() {
    return 'This Privacy Policy describes how WordPress Master Developer collects, uses, and protects your personal information when you use our website and services.

**Information We Collect**

We collect information you provide directly to us, such as when you contact us through our contact form, subscribe to our newsletter, or request our services.

**How We Use Your Information**

We use the information we collect to provide, maintain, and improve our services, respond to your inquiries, and send you relevant updates about our services.

**Information Sharing**

We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy.

**Data Security**

We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.

**Contact Us**

If you have any questions about this Privacy Policy, please contact us at contact@wpmaster.dev.';
}

/**
 * Get terms of service content
 */
function wp_master_dev_get_terms_content() {
    return 'These Terms of Service govern your use of our website and services provided by WordPress Master Developer.

**Acceptance of Terms**

By accessing and using our services, you accept and agree to be bound by the terms and provision of this agreement.

**Services**

We provide WordPress development services including custom theme development, plugin integration, performance optimization, and ongoing maintenance.

**Payment Terms**

Payment terms will be specified in individual project agreements. Generally, we require a 50% deposit before starting work and the remainder upon completion.

**Intellectual Property**

Upon full payment, you will own the custom code we create specifically for your project. However, we retain rights to any general techniques, methodologies, or frameworks used.

**Limitation of Liability**

Our liability is limited to the amount paid for our services. We are not liable for any indirect, incidental, or consequential damages.

**Contact Information**

For questions about these terms, please contact us at contact@wpmaster.dev.';
}

/**
 * Get cookie policy content
 */
function wp_master_dev_get_cookie_policy_content() {
    return 'This Cookie Policy explains how WordPress Master Developer uses cookies and similar technologies when you visit our website.

**What Are Cookies**

Cookies are small text files that are stored on your device when you visit a website. They help us provide you with a better browsing experience.

**Types of Cookies We Use**

- **Essential Cookies**: Necessary for the website to function properly
- **Analytics Cookies**: Help us understand how visitors interact with our website
- **Functional Cookies**: Remember your preferences and settings
- **Marketing Cookies**: Used to deliver relevant advertisements

**Managing Cookies**

You can control and manage cookies through your browser settings. However, disabling certain cookies may affect the functionality of our website.

**Third-Party Cookies**

We may use third-party services like Google Analytics that set their own cookies. Please refer to their respective privacy policies for more information.

**Updates to This Policy**

We may update this Cookie Policy from time to time. Any changes will be posted on this page.

**Contact Us**

If you have questions about our use of cookies, please contact us at contact@wpmaster.dev.';
}

/**
 * Get disclaimer content
 */
function wp_master_dev_get_disclaimer_content() {
    return 'The information on this website is provided on an "as is" basis. WordPress Master Developer makes no representations or warranties of any kind, express or implied, about the completeness, accuracy, reliability, suitability, or availability of the information, products, services, or related graphics contained on the website.

**Professional Services**

While we strive to provide high-quality WordPress development services, results may vary based on specific requirements, existing website conditions, and other factors beyond our control.

**Third-Party Links**

Our website may contain links to third-party websites. We have no control over the content and nature of these sites and are not responsible for their content or privacy practices.

**Technical Compatibility**

We make every effort to ensure compatibility across different browsers and devices, but cannot guarantee perfect functionality in all environments.

**Service Availability**

We aim to keep our website and services available at all times, but cannot guarantee uninterrupted access due to maintenance, updates, or technical issues.

**Limitation of Liability**

In no event will WordPress Master Developer be liable for any loss or damage including, without limitation, indirect or consequential loss or damage arising from the use of our website or services.

**Contact Information**

For questions about this disclaimer, please contact us at contact@wpmaster.dev.';
}


/**
 * Create contacts table for form submissions
 */
function wp_master_dev_create_contacts_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'wp_master_dev_contacts';
    
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        email varchar(100) NOT NULL,
        subject tinytext,
        message text NOT NULL,
        submitted_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        status varchar(20) DEFAULT 'new' NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/**
 * Add admin menu for contact submissions
 */
function wp_master_dev_add_admin_menu() {
    add_menu_page(
        'Contact Submissions',
        'Contact Forms',
        'manage_options',
        'wp-master-dev-contacts',
        'wp_master_dev_contacts_page',
        'dashicons-email-alt',
        30
    );
}
add_action('admin_menu', 'wp_master_dev_add_admin_menu');

/**
 * Display contact submissions page
 */
function wp_master_dev_contacts_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'wp_master_dev_contacts';
    
    // Handle status updates
    if (isset($_POST['update_status']) && isset($_POST['contact_id'])) {
        $contact_id = intval($_POST['contact_id']);
        $new_status = sanitize_text_field($_POST['status']);
        
        $wpdb->update(
            $table_name,
            array('status' => $new_status),
            array('id' => $contact_id),
            array('%s'),
            array('%d')
        );
        
        echo '<div class="notice notice-success"><p>Status updated successfully!</p></div>';
    }
    
    // Get all contacts
    $contacts = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submitted_at DESC");
    
    ?>
    <div class="wrap">
        <h1>Contact Form Submissions</h1>
        
        <?php if (empty($contacts)): ?>
            <p>No contact submissions yet.</p>
        <?php else: ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?php echo esc_html($contact->name); ?></td>
                            <td><a href="mailto:<?php echo esc_attr($contact->email); ?>"><?php echo esc_html($contact->email); ?></a></td>
                            <td><?php echo esc_html($contact->subject); ?></td>
                            <td><?php echo esc_html(wp_trim_words($contact->message, 10)); ?></td>
                            <td><?php echo esc_html($contact->submitted_at); ?></td>
                            <td>
                                <span class="status-<?php echo esc_attr($contact->status); ?>">
                                    <?php echo esc_html(ucfirst($contact->status)); ?>
                                </span>
                            </td>
                            <td>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="contact_id" value="<?php echo esc_attr($contact->id); ?>">
                                    <select name="status">
                                        <option value="new" <?php selected($contact->status, 'new'); ?>>New</option>
                                        <option value="read" <?php selected($contact->status, 'read'); ?>>Read</option>
                                        <option value="replied" <?php selected($contact->status, 'replied'); ?>>Replied</option>
                                        <option value="archived" <?php selected($contact->status, 'archived'); ?>>Archived</option>
                                    </select>
                                    <input type="submit" name="update_status" value="Update" class="button button-small">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
    <style>
        .status-new { color: #d63638; font-weight: bold; }
        .status-read { color: #135e96; }
        .status-replied { color: #00a32a; }
        .status-archived { color: #646970; }
    </style>
    <?php
}

/**
 * Enhanced contact form handler with database storage
 */
function wp_master_dev_handle_contact_form_enhanced() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'wp_master_dev_nonce')) {
        wp_die(esc_html__('Security check failed', 'wp-master-dev'));
    }

    // Sanitize form data
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(array('message' => esc_html__('Please fill in all required fields.', 'wp-master-dev')));
    }

    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(array('message' => esc_html__('Please enter a valid email address.', 'wp-master-dev')));
    }

    // Store in database
    global $wpdb;
    $table_name = $wpdb->prefix . 'wp_master_dev_contacts';
    
    $result = $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
            'submitted_at' => current_time('mysql'),
            'status' => 'new'
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s')
    );

    if ($result === false) {
        wp_send_json_error(array('message' => esc_html__('Error saving your message. Please try again.', 'wp-master-dev')));
    }

    // Prepare email
    $to = get_option('admin_email');
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    $email_subject = sprintf(esc_html__('Contact Form: %s', 'wp-master-dev'), $subject);
    $email_message = sprintf(
        '<h3>%s</h3><p><strong>%s:</strong> %s</p><p><strong>%s:</strong> %s</p><p><strong>%s:</strong></p><p>%s</p>',
        esc_html__('New Contact Form Submission', 'wp-master-dev'),
        esc_html__('Name', 'wp-master-dev'),
        esc_html($name),
        esc_html__('Email', 'wp-master-dev'),
        esc_html($email),
        esc_html__('Message', 'wp-master-dev'),
        wp_kses_post(wpautop($message))
    );

    // Send email
    if (wp_mail($to, $email_subject, $email_message, $headers)) {
        wp_send_json_success(array('message' => esc_html__('Thank you! Your message has been sent successfully.', 'wp-master-dev')));
    } else {
        wp_send_json_error(array('message' => esc_html__('Sorry, there was an error sending your message. Please try again.', 'wp-master-dev')));
    }
}
add_action('wp_ajax_wp_master_dev_contact_form', 'wp_master_dev_handle_contact_form_enhanced');
add_action('wp_ajax_nopriv_wp_master_dev_contact_form', 'wp_master_dev_handle_contact_form_enhanced');


/**
 * Add theme setup wizard to admin menu
 */
function wp_master_dev_add_setup_wizard() {
    add_theme_page(
        'Theme Setup Wizard',
        'Setup Wizard',
        'manage_options',
        'wp-master-dev-setup',
        'wp_master_dev_setup_wizard_page'
    );
}
add_action('admin_menu', 'wp_master_dev_add_setup_wizard');

/**
 * Theme setup wizard page
 */
function wp_master_dev_setup_wizard_page() {
    // Handle form submission
    if (isset($_POST['run_setup'])) {
        wp_master_dev_run_complete_setup();
        echo '<div class="notice notice-success"><p><strong>Setup Complete!</strong> Your theme has been configured successfully.</p></div>';
    }
    
    if (isset($_POST['import_demo'])) {
        wp_master_dev_create_demo_content();
        echo '<div class="notice notice-success"><p><strong>Demo Content Imported!</strong> Sample content has been added to your site.</p></div>';
    }
    
    if (isset($_POST['reset_theme'])) {
        wp_master_dev_reset_theme_data();
        echo '<div class="notice notice-success"><p><strong>Theme Reset!</strong> All theme data has been cleared.</p></div>';
    }
    
    ?>
    <div class="wrap">
        <h1>WordPress Master Developer - Setup Wizard</h1>
        
        <div class="setup-wizard-container">
            <div class="setup-section">
                <h2>🚀 Quick Setup</h2>
                <p>Run the complete setup to create all necessary pages, menus, and configure your theme.</p>
                
                <form method="post">
                    <input type="submit" name="run_setup" value="Run Complete Setup" class="button button-primary button-large">
                </form>
                
                <h3>What this includes:</h3>
                <ul>
                    <li>✅ Create essential pages (Home, About, Services, Contact)</li>
                    <li>✅ Create legal pages (Privacy Policy, Terms, etc.)</li>
                    <li>✅ Set up primary navigation menu</li>
                    <li>✅ Set up footer menu</li>
                    <li>✅ Configure theme options</li>
                    <li>✅ Create contact form database table</li>
                </ul>
            </div>
            
            <div class="setup-section">
                <h2>📝 Demo Content</h2>
                <p>Import sample content including services, projects, and testimonials.</p>
                
                <form method="post">
                    <input type="submit" name="import_demo" value="Import Demo Content" class="button button-secondary">
                </form>
                
                <h3>Demo content includes:</h3>
                <ul>
                    <li>Sample services with pricing</li>
                    <li>Portfolio projects</li>
                    <li>Customer testimonials</li>
                    <li>Example blog posts</li>
                </ul>
            </div>
            
            <div class="setup-section">
                <h2>🔄 Reset Theme</h2>
                <p><strong>Warning:</strong> This will remove all theme-related content and settings.</p>
                
                <form method="post" onsubmit="return confirm('Are you sure you want to reset all theme data? This cannot be undone.');">
                    <input type="submit" name="reset_theme" value="Reset Theme Data" class="button button-secondary">
                </form>
            </div>
            
            <div class="setup-section">
                <h2>📚 Next Steps</h2>
                <p>After running the setup, you can:</p>
                <ul>
                    <li>🎨 <a href="<?php echo admin_url('customize.php'); ?>">Customize your theme</a></li>
                    <li>📄 <a href="<?php echo admin_url('edit.php?post_type=page'); ?>">Edit your pages</a></li>
                    <li>🍔 <a href="<?php echo admin_url('nav-menus.php'); ?>">Manage your menus</a></li>
                    <li>📧 <a href="<?php echo admin_url('admin.php?page=wp-master-dev-contacts'); ?>">View contact submissions</a></li>
                    <li>⚙️ <a href="<?php echo admin_url('options-general.php'); ?>">Configure settings</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <style>
        .setup-wizard-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }
        
        .setup-section {
            background: #fff;
            border: 1px solid #ccd0d4;
            border-radius: 4px;
            padding: 20px;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        
        .setup-section h2 {
            margin-top: 0;
            color: #23282d;
        }
        
        .setup-section ul {
            margin: 15px 0;
            padding-left: 20px;
        }
        
        .setup-section li {
            margin-bottom: 5px;
        }
        
        @media (max-width: 782px) {
            .setup-wizard-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <?php
}

/**
 * Run complete theme setup
 */
function wp_master_dev_run_complete_setup() {
    // Create contact submissions table
    wp_master_dev_create_contacts_table();
    
    // Set default theme options
    wp_master_dev_set_default_options();
    
    // Create default pages
    wp_master_dev_create_default_pages();
    
    // Set up menus
    wp_master_dev_setup_menus();
    
    // Flush rewrite rules
    flush_rewrite_rules();
    
    // Update setup completion flag
    update_option('wp_master_dev_setup_complete', true);
}

/**
 * Reset theme data
 */
function wp_master_dev_reset_theme_data() {
    global $wpdb;
    
    // Delete theme pages
    $pages_to_delete = array('about', 'services', 'contact', 'privacy-policy', 'terms-of-service', 'cookie-policy', 'disclaimer');
    
    foreach ($pages_to_delete as $page_slug) {
        $page = get_page_by_path($page_slug);
        if ($page) {
            wp_delete_post($page->ID, true);
        }
    }
    
    // Delete custom post types
    $post_types = array('service', 'project', 'testimonial');
    foreach ($post_types as $post_type) {
        $posts = get_posts(array('post_type' => $post_type, 'numberposts' => -1));
        foreach ($posts as $post) {
            wp_delete_post($post->ID, true);
        }
    }
    
    // Delete menus
    $menus = array('Primary Menu', 'Footer Menu');
    foreach ($menus as $menu_name) {
        $menu = wp_get_nav_menu_object($menu_name);
        if ($menu) {
            wp_delete_nav_menu($menu->term_id);
        }
    }
    
    // Reset theme mods
    remove_theme_mods();
    
    // Delete theme options
    $options_to_delete = array(
        'wp_master_dev_hero_title',
        'wp_master_dev_hero_subtitle',
        'wp_master_dev_hero_description',
        'wp_master_dev_cta_text',
        'wp_master_dev_contact_email',
        'wp_master_dev_contact_phone',
        'wp_master_dev_setup_complete'
    );
    
    foreach ($options_to_delete as $option) {
        delete_option($option);
    }
    
    // Drop contacts table
    $table_name = $wpdb->prefix . 'wp_master_dev_contacts';
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
    
    // Flush rewrite rules
    flush_rewrite_rules();
}

/**
 * Check if setup is complete
 */
function wp_master_dev_is_setup_complete() {
    return get_option('wp_master_dev_setup_complete', false);
}

/**
 * Show setup notice if not complete
 */
function wp_master_dev_setup_notice() {
    if (!wp_master_dev_is_setup_complete() && current_user_can('manage_options')) {
        $setup_url = admin_url('themes.php?page=wp-master-dev-setup');
        ?>
        <div class="notice notice-info is-dismissible">
            <h3><?php esc_html_e('WordPress Master Developer Theme', 'wp-master-dev'); ?></h3>
            <p><?php esc_html_e('Welcome! To get started with your new theme, please run the setup wizard.', 'wp-master-dev'); ?></p>
            <p>
                <a href="<?php echo esc_url($setup_url); ?>" class="button button-primary">
                    <?php esc_html_e('Run Setup Wizard', 'wp-master-dev'); ?>
                </a>
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'wp_master_dev_setup_notice');

/**
 * Add setup wizard link to theme actions
 */
function wp_master_dev_theme_action_links($actions, $theme) {
    if ($theme->get_stylesheet() === get_stylesheet()) {
        $setup_url = admin_url('themes.php?page=wp-master-dev-setup');
        $actions['setup'] = '<a href="' . esc_url($setup_url) . '">Setup Wizard</a>';
    }
    return $actions;
}
add_filter('theme_action_links', 'wp_master_dev_theme_action_links', 10, 2);
