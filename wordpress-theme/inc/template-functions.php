<?php
/**
 * WordPress Master Developer Theme Template Functions
 *
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle contact form submission
 */
function wp_master_dev_handle_contact_form() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['contact_nonce'], 'wp_master_dev_contact_nonce')) {
        wp_die(esc_html__('Security check failed. Please try again.', 'wp-master-dev'));
    }

    // Sanitize form data
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $phone = sanitize_text_field($_POST['contact_phone']);
    $company = sanitize_text_field($_POST['contact_company']);
    $service = sanitize_text_field($_POST['contact_service']);
    $budget = sanitize_text_field($_POST['contact_budget']);
    $timeline = sanitize_text_field($_POST['contact_timeline']);
    $message = sanitize_textarea_field($_POST['contact_message']);
    $newsletter = isset($_POST['contact_newsletter']) ? 'yes' : 'no';

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        wp_redirect(add_query_arg('contact_error', 'required_fields', wp_get_referer()));
        exit;
    }

    // Validate email
    if (!is_email($email)) {
        wp_redirect(add_query_arg('contact_error', 'invalid_email', wp_get_referer()));
        exit;
    }

    // Prepare email content
    $to = get_option('admin_email');
    $subject = sprintf(esc_html__('[%s] New Contact Form Submission', 'wp-master-dev'), get_bloginfo('name'));
    
    $email_message = sprintf(
        esc_html__("New contact form submission:\n\nName: %s\nEmail: %s\nPhone: %s\nCompany: %s\nService: %s\nBudget: %s\nTimeline: %s\nNewsletter: %s\n\nMessage:\n%s", 'wp-master-dev'),
        $name,
        $email,
        $phone,
        $company,
        $service,
        $budget,
        $timeline,
        $newsletter,
        $message
    );

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );

    // Send email
    $sent = wp_mail($to, $subject, $email_message, $headers);

    // Store submission in database (optional)
    wp_master_dev_store_contact_submission(array(
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'company' => $company,
        'service' => $service,
        'budget' => $budget,
        'timeline' => $timeline,
        'message' => $message,
        'newsletter' => $newsletter,
        'submitted_at' => current_time('mysql')
    ));

    // Redirect with success message
    if ($sent) {
        wp_redirect(add_query_arg('contact_success', '1', wp_get_referer()));
    } else {
        wp_redirect(add_query_arg('contact_error', 'send_failed', wp_get_referer()));
    }
    exit;
}
add_action('admin_post_wp_master_dev_contact_form', 'wp_master_dev_handle_contact_form');
add_action('admin_post_nopriv_wp_master_dev_contact_form', 'wp_master_dev_handle_contact_form');

/**
 * Store contact form submission in database
 */
function wp_master_dev_store_contact_submission($data) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'wp_master_dev_contacts';
    
    $wpdb->insert(
        $table_name,
        $data,
        array(
            '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s'
        )
    );
}

/**
 * Create contact submissions table
 */
// create_contacts_table function is defined in inc/theme-installer.php

/**
 * Display contact form messages
 */
function wp_master_dev_contact_form_messages() {
    if (isset($_GET['contact_success'])) {
        echo '<div class="contact-message success">';
        echo '<p>' . esc_html__('Thank you for your message! We\'ll get back to you within 24 hours.', 'wp-master-dev') . '</p>';
        echo '</div>';
    }
    
    if (isset($_GET['contact_error'])) {
        $error = $_GET['contact_error'];
        $message = '';
        
        switch ($error) {
            case 'required_fields':
                $message = esc_html__('Please fill in all required fields.', 'wp-master-dev');
                break;
            case 'invalid_email':
                $message = esc_html__('Please enter a valid email address.', 'wp-master-dev');
                break;
            case 'send_failed':
                $message = esc_html__('Sorry, there was an error sending your message. Please try again.', 'wp-master-dev');
                break;
            default:
                $message = esc_html__('An error occurred. Please try again.', 'wp-master-dev');
        }
        
        echo '<div class="contact-message error">';
        echo '<p>' . $message . '</p>';
        echo '</div>';
    }
}

/**
 * Get featured services for homepage
 */
function wp_master_dev_get_featured_services($limit = 4) {
    $services = new WP_Query(array(
        'post_type' => 'service',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'featured_service',
                'value' => '1',
                'compare' => '='
            )
        )
    ));
    
    if (!$services->have_posts()) {
        // Fallback to regular services if no featured ones
        $services = new WP_Query(array(
            'post_type' => 'service',
            'posts_per_page' => $limit,
            'post_status' => 'publish',
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ));
    }
    
    return $services;
}

/**
 * Get featured projects for homepage
 */
function wp_master_dev_get_featured_projects($limit = 4) {
    $projects = new WP_Query(array(
        'post_type' => 'project',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'featured_project',
                'value' => '1',
                'compare' => '='
            )
        )
    ));
    
    if (!$projects->have_posts()) {
        // Fallback to regular projects if no featured ones
        $projects = new WP_Query(array(
            'post_type' => 'project',
            'posts_per_page' => $limit,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        ));
    }
    
    return $projects;
}

/**
 * Get testimonials
 */
function wp_master_dev_get_testimonials($limit = 3) {
    return new WP_Query(array(
        'post_type' => 'testimonial',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'orderby' => 'rand'
    ));
}

/**
 * Custom excerpt length
 */
function wp_master_dev_excerpt_length($length) {
    if (is_admin()) {
        return $length;
    }
    
    return 25;
}
add_filter('excerpt_length', 'wp_master_dev_excerpt_length', 999);

/**
 * Custom excerpt more
 */
function wp_master_dev_excerpt_more($more) {
    if (is_admin()) {
        return $more;
    }
    
    return '...';
}
add_filter('excerpt_more', 'wp_master_dev_excerpt_more');

/**
 * Add custom body classes
 */
function wp_master_dev_body_classes($classes) {
    // Add class for boxed layout
    if (get_theme_mod('boxed_layout', false)) {
        $classes[] = 'boxed-layout';
    }
    
    // Add class for front page
    if (is_front_page()) {
        $classes[] = 'front-page';
    }
    
    // Add class for pages with custom templates
    if (is_page_template()) {
        $template = get_page_template_slug();
        $template_name = str_replace('.php', '', basename($template));
        $classes[] = 'page-template-' . $template_name;
    }
    
    return $classes;
}
add_filter('body_class', 'wp_master_dev_body_classes');

/**
 * Add custom post classes
 */
function wp_master_dev_post_classes($classes, $class, $post_id) {
    // Add featured class for featured posts
    if (get_post_meta($post_id, 'featured_post', true)) {
        $classes[] = 'featured-post';
    }
    
    return $classes;
}
add_filter('post_class', 'wp_master_dev_post_classes', 10, 3);

/**
 * Customize WordPress login page
 */
function wp_master_dev_login_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
        ?>
        <style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url(<?php echo esc_url($logo[0]); ?>);
                height: 80px;
                width: 320px;
                background-size: contain;
                background-repeat: no-repeat;
                padding-bottom: 30px;
            }
        </style>
        <?php
    }
}
add_action('login_enqueue_scripts', 'wp_master_dev_login_logo');

/**
 * Change login logo URL
 */
function wp_master_dev_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'wp_master_dev_login_logo_url');

/**
 * Change login logo title
 */
function wp_master_dev_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter('login_headertitle', 'wp_master_dev_login_logo_url_title');

/**
 * Add theme support for Gutenberg
 */
function wp_master_dev_gutenberg_support() {
    // Add support for editor styles
    add_theme_support('editor-styles');
    
    // Enqueue editor styles
    add_editor_style('assets/css/editor-style.css');
    
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add support for wide and full alignment
    add_theme_support('align-wide');
    
    // Add custom color palette
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => esc_html__('Primary Blue', 'wp-master-dev'),
            'slug'  => 'primary-blue',
            'color' => '#2563eb',
        ),
        array(
            'name'  => esc_html__('Accent Orange', 'wp-master-dev'),
            'slug'  => 'accent-orange',
            'color' => '#f59e0b',
        ),
        array(
            'name'  => esc_html__('Dark Gray', 'wp-master-dev'),
            'slug'  => 'dark-gray',
            'color' => '#1f2937',
        ),
        array(
            'name'  => esc_html__('Light Gray', 'wp-master-dev'),
            'slug'  => 'light-gray',
            'color' => '#f3f4f6',
        ),
        array(
            'name'  => esc_html__('White', 'wp-master-dev'),
            'slug'  => 'white',
            'color' => '#ffffff',
        ),
    ));
    
    // Add custom font sizes
    add_theme_support('editor-font-sizes', array(
        array(
            'name' => esc_html__('Small', 'wp-master-dev'),
            'size' => 14,
            'slug' => 'small'
        ),
        array(
            'name' => esc_html__('Regular', 'wp-master-dev'),
            'size' => 16,
            'slug' => 'regular'
        ),
        array(
            'name' => esc_html__('Large', 'wp-master-dev'),
            'size' => 20,
            'slug' => 'large'
        ),
        array(
            'name' => esc_html__('Extra Large', 'wp-master-dev'),
            'size' => 24,
            'slug' => 'extra-large'
        )
    ));
}
add_action('after_setup_theme', 'wp_master_dev_gutenberg_support');

/**
 * Add admin menu for contact submissions
 */
function wp_master_dev_admin_menu() {
    add_menu_page(
        esc_html__('Contact Submissions', 'wp-master-dev'),
        esc_html__('Contact Forms', 'wp-master-dev'),
        'manage_options',
        'wp-master-dev-contacts',
        'wp_master_dev_contacts_page',
        'dashicons-email-alt',
        30
    );
}
add_action('admin_menu', 'wp_master_dev_admin_menu');

/**
 * Display contact submissions page
 */
// contacts_page function is defined in inc/theme-installer.php

/**
 * Add meta boxes for custom fields
 */
function wp_master_dev_add_meta_boxes() {
    // Service meta box
    add_meta_box(
        'service-details',
        esc_html__('Service Details', 'wp-master-dev'),
        'wp_master_dev_service_meta_box',
        'service',
        'normal',
        'high'
    );
    
    // Project meta box
    add_meta_box(
        'project-details',
        esc_html__('Project Details', 'wp-master-dev'),
        'wp_master_dev_project_meta_box',
        'project',
        'normal',
        'high'
    );
    
    // Testimonial meta box
    add_meta_box(
        'testimonial-details',
        esc_html__('Testimonial Details', 'wp-master-dev'),
        'wp_master_dev_testimonial_meta_box',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'wp_master_dev_add_meta_boxes');

/**
 * Service meta box callback
 */
function wp_master_dev_service_meta_box($post) {
    wp_nonce_field('wp_master_dev_service_meta', 'wp_master_dev_service_nonce');
    
    $price = get_post_meta($post->ID, 'service_price', true);
    $icon = get_post_meta($post->ID, 'service_icon', true);
    $featured = get_post_meta($post->ID, 'featured_service', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="service_price"><?php esc_html_e('Price', 'wp-master-dev'); ?></label></th>
            <td><input type="text" id="service_price" name="service_price" value="<?php echo esc_attr($price); ?>" /></td>
        </tr>
        <tr>
            <th><label for="service_icon"><?php esc_html_e('Icon (Emoji)', 'wp-master-dev'); ?></label></th>
            <td><input type="text" id="service_icon" name="service_icon" value="<?php echo esc_attr($icon); ?>" /></td>
        </tr>
        <tr>
            <th><label for="featured_service"><?php esc_html_e('Featured Service', 'wp-master-dev'); ?></label></th>
            <td><input type="checkbox" id="featured_service" name="featured_service" value="1" <?php checked($featured, '1'); ?> /></td>
        </tr>
    </table>
    <?php
}

/**
 * Project meta box callback
 */
function wp_master_dev_project_meta_box($post) {
    wp_nonce_field('wp_master_dev_project_meta', 'wp_master_dev_project_nonce');
    
    $client = get_post_meta($post->ID, 'project_client', true);
    $url = get_post_meta($post->ID, 'project_url', true);
    $technologies = get_post_meta($post->ID, 'project_technologies', true);
    $featured = get_post_meta($post->ID, 'featured_project', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="project_client"><?php esc_html_e('Client', 'wp-master-dev'); ?></label></th>
            <td><input type="text" id="project_client" name="project_client" value="<?php echo esc_attr($client); ?>" /></td>
        </tr>
        <tr>
            <th><label for="project_url"><?php esc_html_e('Project URL', 'wp-master-dev'); ?></label></th>
            <td><input type="url" id="project_url" name="project_url" value="<?php echo esc_attr($url); ?>" /></td>
        </tr>
        <tr>
            <th><label for="project_technologies"><?php esc_html_e('Technologies Used', 'wp-master-dev'); ?></label></th>
            <td><textarea id="project_technologies" name="project_technologies" rows="3"><?php echo esc_textarea($technologies); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="featured_project"><?php esc_html_e('Featured Project', 'wp-master-dev'); ?></label></th>
            <td><input type="checkbox" id="featured_project" name="featured_project" value="1" <?php checked($featured, '1'); ?> /></td>
        </tr>
    </table>
    <?php
}

/**
 * Testimonial meta box callback
 */
function wp_master_dev_testimonial_meta_box($post) {
    wp_nonce_field('wp_master_dev_testimonial_meta', 'wp_master_dev_testimonial_nonce');
    
    $client_name = get_post_meta($post->ID, 'client_name', true);
    $client_position = get_post_meta($post->ID, 'client_position', true);
    $client_company = get_post_meta($post->ID, 'client_company', true);
    $rating = get_post_meta($post->ID, 'testimonial_rating', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="client_name"><?php esc_html_e('Client Name', 'wp-master-dev'); ?></label></th>
            <td><input type="text" id="client_name" name="client_name" value="<?php echo esc_attr($client_name); ?>" /></td>
        </tr>
        <tr>
            <th><label for="client_position"><?php esc_html_e('Client Position', 'wp-master-dev'); ?></label></th>
            <td><input type="text" id="client_position" name="client_position" value="<?php echo esc_attr($client_position); ?>" /></td>
        </tr>
        <tr>
            <th><label for="client_company"><?php esc_html_e('Client Company', 'wp-master-dev'); ?></label></th>
            <td><input type="text" id="client_company" name="client_company" value="<?php echo esc_attr($client_company); ?>" /></td>
        </tr>
        <tr>
            <th><label for="testimonial_rating"><?php esc_html_e('Rating (1-5)', 'wp-master-dev'); ?></label></th>
            <td>
                <select id="testimonial_rating" name="testimonial_rating">
                    <option value=""><?php esc_html_e('Select rating...', 'wp-master-dev'); ?></option>
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>><?php echo $i; ?> <?php echo str_repeat('⭐', $i); ?></option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save meta box data
 */
function wp_master_dev_save_meta_boxes($post_id) {
    // Check if user has permission to edit
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save service meta
    if (isset($_POST['wp_master_dev_service_nonce']) && wp_verify_nonce($_POST['wp_master_dev_service_nonce'], 'wp_master_dev_service_meta')) {
        update_post_meta($post_id, 'service_price', sanitize_text_field($_POST['service_price']));
        update_post_meta($post_id, 'service_icon', sanitize_text_field($_POST['service_icon']));
        update_post_meta($post_id, 'featured_service', isset($_POST['featured_service']) ? '1' : '0');
    }
    
    // Save project meta
    if (isset($_POST['wp_master_dev_project_nonce']) && wp_verify_nonce($_POST['wp_master_dev_project_nonce'], 'wp_master_dev_project_meta')) {
        update_post_meta($post_id, 'project_client', sanitize_text_field($_POST['project_client']));
        update_post_meta($post_id, 'project_url', esc_url_raw($_POST['project_url']));
        update_post_meta($post_id, 'project_technologies', sanitize_textarea_field($_POST['project_technologies']));
        update_post_meta($post_id, 'featured_project', isset($_POST['featured_project']) ? '1' : '0');
    }
    
    // Save testimonial meta
    if (isset($_POST['wp_master_dev_testimonial_nonce']) && wp_verify_nonce($_POST['wp_master_dev_testimonial_nonce'], 'wp_master_dev_testimonial_meta')) {
        update_post_meta($post_id, 'client_name', sanitize_text_field($_POST['client_name']));
        update_post_meta($post_id, 'client_position', sanitize_text_field($_POST['client_position']));
        update_post_meta($post_id, 'client_company', sanitize_text_field($_POST['client_company']));
        update_post_meta($post_id, 'testimonial_rating', absint($_POST['testimonial_rating']));
    }
}
add_action('save_post', 'wp_master_dev_save_meta_boxes');
