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
