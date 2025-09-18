<?php
/**
 * Template Name: Contact Page
 * The template for displaying the Contact page
 *
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Contact Hero Section -->
        <section class="contact-hero-section">
            <div class="container">
                <div class="contact-hero-content">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php if (has_excerpt()) : ?>
                        <div class="page-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php else : ?>
                        <div class="page-excerpt">
                            <p><?php esc_html_e('Ready to start your WordPress project? Get in touch and let\'s discuss how we can help bring your vision to life.', 'wp-master-dev'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Contact Content -->
        <section class="contact-content-section">
            <div class="container">
                <div class="contact-grid">
                    
                    <!-- Contact Form -->
                    <div class="contact-form-wrapper">
                        <div class="form-header">
                            <h2><?php echo esc_html(get_post_meta(get_the_ID(), 'form_title', true) ?: __('Send us a Message', 'wp-master-dev')); ?></h2>
                            <p><?php echo esc_html(get_post_meta(get_the_ID(), 'form_description', true) ?: __('Fill out the form below and we\'ll get back to you within 24 hours.', 'wp-master-dev')); ?></p>
                        </div>
                        
                        <form id="contact-form" class="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                            <input type="hidden" name="action" value="wp_master_dev_contact_form">
                            <?php wp_nonce_field('wp_master_dev_contact_nonce', 'contact_nonce'); ?>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contact-name"><?php esc_html_e('Full Name', 'wp-master-dev'); ?> <span class="required">*</span></label>
                                    <input type="text" id="contact-name" name="contact_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="contact-email"><?php esc_html_e('Email Address', 'wp-master-dev'); ?> <span class="required">*</span></label>
                                    <input type="email" id="contact-email" name="contact_email" required>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contact-phone"><?php esc_html_e('Phone Number', 'wp-master-dev'); ?></label>
                                    <input type="tel" id="contact-phone" name="contact_phone">
                                </div>
                                <div class="form-group">
                                    <label for="contact-company"><?php esc_html_e('Company/Organization', 'wp-master-dev'); ?></label>
                                    <input type="text" id="contact-company" name="contact_company">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-service"><?php esc_html_e('Service Interested In', 'wp-master-dev'); ?></label>
                                <select id="contact-service" name="contact_service">
                                    <option value=""><?php esc_html_e('Select a service...', 'wp-master-dev'); ?></option>
                                    <option value="custom-theme"><?php esc_html_e('Custom Theme Development', 'wp-master-dev'); ?></option>
                                    <option value="plugin-integration"><?php esc_html_e('Plugin Integration', 'wp-master-dev'); ?></option>
                                    <option value="performance-optimization"><?php esc_html_e('Performance Optimization', 'wp-master-dev'); ?></option>
                                    <option value="maintenance-support"><?php esc_html_e('Maintenance & Support', 'wp-master-dev'); ?></option>
                                    <option value="consultation"><?php esc_html_e('Consultation', 'wp-master-dev'); ?></option>
                                    <option value="other"><?php esc_html_e('Other', 'wp-master-dev'); ?></option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-budget"><?php esc_html_e('Project Budget', 'wp-master-dev'); ?></label>
                                <select id="contact-budget" name="contact_budget">
                                    <option value=""><?php esc_html_e('Select budget range...', 'wp-master-dev'); ?></option>
                                    <option value="under-1000"><?php esc_html_e('Under $1,000', 'wp-master-dev'); ?></option>
                                    <option value="1000-2500"><?php esc_html_e('$1,000 - $2,500', 'wp-master-dev'); ?></option>
                                    <option value="2500-5000"><?php esc_html_e('$2,500 - $5,000', 'wp-master-dev'); ?></option>
                                    <option value="5000-10000"><?php esc_html_e('$5,000 - $10,000', 'wp-master-dev'); ?></option>
                                    <option value="over-10000"><?php esc_html_e('Over $10,000', 'wp-master-dev'); ?></option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-timeline"><?php esc_html_e('Project Timeline', 'wp-master-dev'); ?></label>
                                <select id="contact-timeline" name="contact_timeline">
                                    <option value=""><?php esc_html_e('Select timeline...', 'wp-master-dev'); ?></option>
                                    <option value="asap"><?php esc_html_e('ASAP', 'wp-master-dev'); ?></option>
                                    <option value="1-month"><?php esc_html_e('Within 1 month', 'wp-master-dev'); ?></option>
                                    <option value="2-3-months"><?php esc_html_e('2-3 months', 'wp-master-dev'); ?></option>
                                    <option value="3-6-months"><?php esc_html_e('3-6 months', 'wp-master-dev'); ?></option>
                                    <option value="flexible"><?php esc_html_e('Flexible', 'wp-master-dev'); ?></option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-message"><?php esc_html_e('Project Details', 'wp-master-dev'); ?> <span class="required">*</span></label>
                                <textarea id="contact-message" name="contact_message" rows="6" placeholder="<?php esc_attr_e('Please describe your project requirements, goals, and any specific features you need...', 'wp-master-dev'); ?>" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="contact_newsletter" value="yes">
                                    <span class="checkmark"></span>
                                    <?php esc_html_e('Subscribe to our newsletter for WordPress tips and updates', 'wp-master-dev'); ?>
                                </label>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary btn-large">
                                    <?php esc_html_e('Send Message', 'wp-master-dev'); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="contact-info-wrapper">
                        <div class="contact-info">
                            <h3><?php esc_html_e('Get in Touch', 'wp-master-dev'); ?></h3>
                            <p><?php esc_html_e('Prefer to reach out directly? Here are the best ways to contact us.', 'wp-master-dev'); ?></p>
                            
                            <div class="contact-methods">
                                <?php
                                $contact_email = get_option('wp_master_dev_contact_email', 'contact@wpmaster.dev');
                                $contact_phone = get_option('wp_master_dev_contact_phone', '+1 (555) 123-4567');
                                ?>
                                
                                <div class="contact-method">
                                    <div class="method-icon">
                                        <span>📧</span>
                                    </div>
                                    <div class="method-content">
                                        <h4><?php esc_html_e('Email', 'wp-master-dev'); ?></h4>
                                        <p><a href="mailto:<?php echo esc_attr($contact_email); ?>"><?php echo esc_html($contact_email); ?></a></p>
                                        <small><?php esc_html_e('We respond within 24 hours', 'wp-master-dev'); ?></small>
                                    </div>
                                </div>
                                
                                <div class="contact-method">
                                    <div class="method-icon">
                                        <span>📞</span>
                                    </div>
                                    <div class="method-content">
                                        <h4><?php esc_html_e('Phone', 'wp-master-dev'); ?></h4>
                                        <p><a href="tel:<?php echo esc_attr(str_replace(array(' ', '(', ')', '-'), '', $contact_phone)); ?>"><?php echo esc_html($contact_phone); ?></a></p>
                                        <small><?php esc_html_e('Mon-Fri, 9AM-6PM EST', 'wp-master-dev'); ?></small>
                                    </div>
                                </div>
                                
                                <div class="contact-method">
                                    <div class="method-icon">
                                        <span>💬</span>
                                    </div>
                                    <div class="method-content">
                                        <h4><?php esc_html_e('Live Chat', 'wp-master-dev'); ?></h4>
                                        <p><?php esc_html_e('Available on our website', 'wp-master-dev'); ?></p>
                                        <small><?php esc_html_e('Instant responses during business hours', 'wp-master-dev'); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Response Time -->
                        <div class="response-info">
                            <h4><?php esc_html_e('What to Expect', 'wp-master-dev'); ?></h4>
                            <ul class="response-list">
                                <li><?php esc_html_e('Initial response within 24 hours', 'wp-master-dev'); ?></li>
                                <li><?php esc_html_e('Free consultation and project estimate', 'wp-master-dev'); ?></li>
                                <li><?php esc_html_e('Detailed project proposal within 48 hours', 'wp-master-dev'); ?></li>
                                <li><?php esc_html_e('No obligation - just honest advice', 'wp-master-dev'); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Content -->
                <?php if (get_the_content()) : ?>
                    <div class="contact-additional-content">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="contact-faq-section">
            <div class="container">
                <div class="section-header">
                    <h2><?php esc_html_e('Common Questions', 'wp-master-dev'); ?></h2>
                    <p><?php esc_html_e('Quick answers to questions you might have before reaching out.', 'wp-master-dev'); ?></p>
                </div>
                
                <div class="faq-grid">
                    <?php
                    // Contact page specific FAQs
                    $contact_faqs = array(
                        array(
                            'question' => __('How quickly can you start my project?', 'wp-master-dev'),
                            'answer' => __('Most projects can begin within 1-2 weeks of contract signing, depending on our current workload and project complexity.', 'wp-master-dev')
                        ),
                        array(
                            'question' => __('Do you offer free consultations?', 'wp-master-dev'),
                            'answer' => __('Yes! We provide free initial consultations to discuss your project needs and provide honest recommendations.', 'wp-master-dev')
                        ),
                        array(
                            'question' => __('What information should I include in my message?', 'wp-master-dev'),
                            'answer' => __('Please include your project goals, timeline, budget range, and any specific features or requirements you have in mind.', 'wp-master-dev')
                        ),
                        array(
                            'question' => __('Do you work with clients internationally?', 'wp-master-dev'),
                            'answer' => __('Absolutely! We work with clients worldwide and are experienced in remote collaboration across different time zones.', 'wp-master-dev')
                        )
                    );
                    
                    foreach ($contact_faqs as $index => $faq) : ?>
                        <div class="faq-item">
                            <h4 class="faq-question"><?php echo esc_html($faq['question']); ?></h4>
                            <p class="faq-answer"><?php echo esc_html($faq['answer']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
