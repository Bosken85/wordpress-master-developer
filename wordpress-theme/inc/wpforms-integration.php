<?php
/**
 * WordPress Master Developer Theme - WPForms Integration
 * 
 * Enhanced WPForms integration:
 * - Custom form styling
 * - Theme-specific form templates
 * - Advanced form features
 * - Contact form management
 * 
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * WPForms Integration Class
 */
class WP_Master_Dev_WPForms_Integration {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
        add_filter('wpforms_frontend_form_data', array($this, 'customize_form_data'));
        add_action('wpforms_process_complete', array($this, 'handle_form_submission'), 10, 4);
        add_filter('wpforms_field_properties', array($this, 'customize_field_properties'), 10, 3);
    }
    
    /**
     * Initialize WPForms integration
     */
    public function init() {
        if (class_exists('WPForms')) {
            // Add theme support for WPForms
            add_theme_support('wpforms');
            
            // Create default contact form if it doesn't exist
            add_action('after_switch_theme', array($this, 'create_default_contact_form'));
            
            // Add custom form templates
            add_filter('wpforms_templates', array($this, 'add_custom_templates'));
            
            // Customize form output
            add_filter('wpforms_frontend_output', array($this, 'customize_form_output'), 10, 5);
        } else {
            // Show admin notice if WPForms is not active
            add_action('admin_notices', array($this, 'wpforms_admin_notice'));
        }
    }
    
    /**
     * Enqueue WPForms custom styles
     */
    public function enqueue_styles() {
        if (class_exists('WPForms')) {
            wp_enqueue_style(
                'wp-master-dev-wpforms',
                get_template_directory_uri() . '/assets/css/wpforms-custom.css',
                array('wpforms-full'),
                WP_MASTER_DEV_VERSION
            );
        }
    }
    
    /**
     * Create default contact form
     */
    public function create_default_contact_form() {
        if (!class_exists('WPForms_Form_Handler')) {
            return;
        }
        
        // Check if contact form already exists
        $existing_forms = wpforms()->form->get('', array(
            'meta_key' => '_wp_master_dev_contact_form',
            'meta_value' => '1'
        ));
        
        if (!empty($existing_forms)) {
            return; // Form already exists
        }
        
        // Create contact form
        $form_data = array(
            'post_title' => 'Contact Form - WordPress Master Developer',
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'wpforms'
        );
        
        $form_id = wp_insert_post($form_data);
        
        if ($form_id) {
            // Add form fields configuration
            $form_config = array(
                'fields' => array(
                    '0' => array(
                        'id' => '0',
                        'type' => 'name',
                        'label' => 'Full Name',
                        'required' => '1',
                        'size' => 'large',
                        'placeholder' => 'Enter your full name',
                        'css' => 'wp-master-field-name'
                    ),
                    '1' => array(
                        'id' => '1',
                        'type' => 'email',
                        'label' => 'Email Address',
                        'required' => '1',
                        'size' => 'large',
                        'placeholder' => 'Enter your email address',
                        'css' => 'wp-master-field-email'
                    ),
                    '2' => array(
                        'id' => '2',
                        'type' => 'phone',
                        'label' => 'Phone Number',
                        'required' => '0',
                        'size' => 'large',
                        'placeholder' => 'Enter your phone number',
                        'css' => 'wp-master-field-phone'
                    ),
                    '3' => array(
                        'id' => '3',
                        'type' => 'text',
                        'label' => 'Company/Organization',
                        'required' => '0',
                        'size' => 'large',
                        'placeholder' => 'Enter your company name',
                        'css' => 'wp-master-field-company'
                    ),
                    '4' => array(
                        'id' => '4',
                        'type' => 'select',
                        'label' => 'Service Interested In',
                        'required' => '0',
                        'size' => 'large',
                        'choices' => array(
                            '1' => array(
                                'label' => 'Custom WordPress Development',
                                'value' => 'Custom WordPress Development'
                            ),
                            '2' => array(
                                'label' => 'WordPress Theme Development',
                                'value' => 'WordPress Theme Development'
                            ),
                            '3' => array(
                                'label' => 'Plugin Development',
                                'value' => 'Plugin Development'
                            ),
                            '4' => array(
                                'label' => 'Website Maintenance',
                                'value' => 'Website Maintenance'
                            ),
                            '5' => array(
                                'label' => 'Performance Optimization',
                                'value' => 'Performance Optimization'
                            ),
                            '6' => array(
                                'label' => 'Other',
                                'value' => 'Other'
                            )
                        ),
                        'css' => 'wp-master-field-service'
                    ),
                    '5' => array(
                        'id' => '5',
                        'type' => 'select',
                        'label' => 'Project Budget',
                        'required' => '0',
                        'size' => 'large',
                        'choices' => array(
                            '1' => array(
                                'label' => 'Under $5,000',
                                'value' => 'Under $5,000'
                            ),
                            '2' => array(
                                'label' => '$5,000 - $10,000',
                                'value' => '$5,000 - $10,000'
                            ),
                            '3' => array(
                                'label' => '$10,000 - $25,000',
                                'value' => '$10,000 - $25,000'
                            ),
                            '4' => array(
                                'label' => '$25,000 - $50,000',
                                'value' => '$25,000 - $50,000'
                            ),
                            '5' => array(
                                'label' => 'Over $50,000',
                                'value' => 'Over $50,000'
                            )
                        ),
                        'css' => 'wp-master-field-budget'
                    ),
                    '6' => array(
                        'id' => '6',
                        'type' => 'select',
                        'label' => 'Project Timeline',
                        'required' => '0',
                        'size' => 'large',
                        'choices' => array(
                            '1' => array(
                                'label' => 'ASAP',
                                'value' => 'ASAP'
                            ),
                            '2' => array(
                                'label' => 'Within 1 month',
                                'value' => 'Within 1 month'
                            ),
                            '3' => array(
                                'label' => '1-3 months',
                                'value' => '1-3 months'
                            ),
                            '4' => array(
                                'label' => '3-6 months',
                                'value' => '3-6 months'
                            ),
                            '5' => array(
                                'label' => 'No specific timeline',
                                'value' => 'No specific timeline'
                            )
                        ),
                        'css' => 'wp-master-field-timeline'
                    ),
                    '7' => array(
                        'id' => '7',
                        'type' => 'textarea',
                        'label' => 'Project Details',
                        'required' => '1',
                        'size' => 'large',
                        'placeholder' => 'Please describe your project requirements, goals, and any specific features you need.',
                        'css' => 'wp-master-field-details'
                    ),
                    '8' => array(
                        'id' => '8',
                        'type' => 'checkbox',
                        'label' => 'Newsletter Subscription',
                        'required' => '0',
                        'choices' => array(
                            '1' => array(
                                'label' => 'Subscribe to our newsletter for WordPress tips and updates',
                                'value' => 'Yes'
                            )
                        ),
                        'css' => 'wp-master-field-newsletter'
                    )
                ),
                'settings' => array(
                    'form_title' => 'Contact Form',
                    'form_desc' => 'Get in touch with us for your WordPress development needs.',
                    'submit_text' => 'Send Message',
                    'submit_text_processing' => 'Sending...',
                    'honeypot' => '1',
                    'confirmation_type' => 'message',
                    'confirmation_message' => '<p>Thank you for your message! We\'ll get back to you within 24 hours.</p>',
                    'notification_enable' => '1',
                    'notifications' => array(
                        '1' => array(
                            'notification_name' => 'Default Notification',
                            'email' => '{admin_email}',
                            'subject' => 'New Contact Form Submission',
                            'sender_name' => 'WordPress Master Developer',
                            'sender_address' => '{admin_email}',
                            'replyto' => '{field_id="1"}',
                            'message' => "New contact form submission:\n\nName: {field_id=\"0\"}\nEmail: {field_id=\"1\"}\nPhone: {field_id=\"2\"}\nCompany: {field_id=\"3\"}\nService: {field_id=\"4\"}\nBudget: {field_id=\"5\"}\nTimeline: {field_id=\"6\"}\n\nProject Details:\n{field_id=\"7\"}\n\nNewsletter: {field_id=\"8\"}"
                        )
                    )
                ),
                'meta' => array(
                    'template' => 'wp_master_dev_contact'
                )
            );
            
            // Save form configuration
            update_post_meta($form_id, 'wpforms_form_data', wp_json_encode($form_config));
            update_post_meta($form_id, '_wp_master_dev_contact_form', '1');
            
            // Save form ID in theme options
            set_theme_mod('wp_master_dev_contact_form_id', $form_id);
        }
    }
    
    /**
     * Add custom form templates
     */
    public function add_custom_templates($templates) {
        $templates['wp_master_dev_contact'] = array(
            'name' => 'WP Master Developer Contact',
            'slug' => 'wp_master_dev_contact',
            'description' => 'Professional contact form with all necessary fields for WordPress development inquiries.',
            'includes' => 'name, email, phone, company, service, budget, timeline, message, newsletter',
            'icon' => 'fa-envelope',
            'modal' => 'contact',
            'core' => true,
            'data' => array(
                // Form data would go here - same as above
            )
        );
        
        return $templates;
    }
    
    /**
     * Customize form data
     */
    public function customize_form_data($form_data) {
        // Add theme-specific classes and attributes
        if (isset($form_data['settings']['form_class'])) {
            $form_data['settings']['form_class'] .= ' wp-master-dev-form';
        } else {
            $form_data['settings']['form_class'] = 'wp-master-dev-form';
        }
        
        return $form_data;
    }
    
    /**
     * Customize field properties
     */
    public function customize_field_properties($properties, $field, $form_data) {
        // Add theme-specific field classes
        if (isset($field['css'])) {
            $properties['inputs']['primary']['class'][] = $field['css'];
        }
        
        // Add Bootstrap classes
        $properties['inputs']['primary']['class'][] = 'form-control';
        
        // Add custom attributes for enhanced styling
        if ($field['type'] === 'textarea') {
            $properties['inputs']['primary']['attr']['rows'] = '5';
        }
        
        return $properties;
    }
    
    /**
     * Handle form submission
     */
    public function handle_form_submission($fields, $entry, $form_data, $entry_id) {
        // Check if this is our contact form
        $contact_form_id = get_theme_mod('wp_master_dev_contact_form_id');
        
        if ($form_data['id'] == $contact_form_id) {
            // Store submission in custom table for admin management
            $this->store_contact_submission($fields, $entry_id);
            
            // Trigger custom actions
            do_action('wp_master_dev_contact_form_submitted', $fields, $entry, $form_data, $entry_id);
        }
    }
    
    /**
     * Store contact submission in custom table
     */
    private function store_contact_submission($fields, $entry_id) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'wp_master_dev_contacts';
        
        // Extract field values
        $name = isset($fields[0]['value']) ? sanitize_text_field($fields[0]['value']) : '';
        $email = isset($fields[1]['value']) ? sanitize_email($fields[1]['value']) : '';
        $phone = isset($fields[2]['value']) ? sanitize_text_field($fields[2]['value']) : '';
        $company = isset($fields[3]['value']) ? sanitize_text_field($fields[3]['value']) : '';
        $service = isset($fields[4]['value']) ? sanitize_text_field($fields[4]['value']) : '';
        $budget = isset($fields[5]['value']) ? sanitize_text_field($fields[5]['value']) : '';
        $timeline = isset($fields[6]['value']) ? sanitize_text_field($fields[6]['value']) : '';
        $message = isset($fields[7]['value']) ? sanitize_textarea_field($fields[7]['value']) : '';
        $newsletter = isset($fields[8]['value']) ? 1 : 0;
        
        // Insert into custom table
        $wpdb->insert(
            $table_name,
            array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'company' => $company,
                'service' => $service,
                'budget' => $budget,
                'timeline' => $timeline,
                'message' => $message,
                'newsletter' => $newsletter,
                'wpforms_entry_id' => $entry_id,
                'submitted_at' => current_time('mysql'),
                'status' => 'new'
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s')
        );
    }
    
    /**
     * Customize form output
     */
    public function customize_form_output($output, $form, $title, $description, $errors) {
        // Add custom wrapper for theme styling
        $custom_output = '<div class="wp-master-dev-form-wrapper">';
        
        if ($title && !empty($form['settings']['form_title'])) {
            $custom_output .= '<div class="wpforms-head-container">';
            $custom_output .= '<h3 class="wpforms-form-title">' . esc_html($form['settings']['form_title']) . '</h3>';
            if ($description && !empty($form['settings']['form_desc'])) {
                $custom_output .= '<div class="wpforms-form-description">' . wp_kses_post($form['settings']['form_desc']) . '</div>';
            }
            $custom_output .= '</div>';
        }
        
        $custom_output .= $output;
        $custom_output .= '</div>';
        
        return $custom_output;
    }
    
    /**
     * Show admin notice if WPForms is not active
     */
    public function wpforms_admin_notice() {
        if (!class_exists('WPForms') && current_user_can('activate_plugins')) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p>
                    <strong><?php esc_html_e('WordPress Master Developer Theme', 'wp-master-dev'); ?></strong>
                    <?php esc_html_e('includes enhanced WPForms integration. Please install and activate WPForms for the best contact form experience.', 'wp-master-dev'); ?>
                    <a href="<?php echo esc_url(admin_url('plugin-install.php?s=wpforms&tab=search&type=term')); ?>" class="button button-primary">
                        <?php esc_html_e('Install WPForms', 'wp-master-dev'); ?>
                    </a>
                </p>
            </div>
            <?php
        }
    }
}

/**
 * Initialize WPForms integration
 */
function wp_master_dev_init_wpforms_integration() {
    new WP_Master_Dev_WPForms_Integration();
}
add_action('init', 'wp_master_dev_init_wpforms_integration');

/**
 * Get contact form shortcode
 */
function wp_master_dev_get_contact_form_shortcode() {
    $form_id = get_theme_mod('wp_master_dev_contact_form_id');
    
    if ($form_id && class_exists('WPForms')) {
        return '[wpforms id="' . $form_id . '"]';
    }
    
    return '';
}

/**
 * Display contact form
 */
function wp_master_dev_display_contact_form() {
    $shortcode = wp_master_dev_get_contact_form_shortcode();
    
    if ($shortcode) {
        echo do_shortcode($shortcode);
    } else {
        // Fallback to theme's built-in contact form
        get_template_part('template-parts/contact-form-fallback');
    }
}
