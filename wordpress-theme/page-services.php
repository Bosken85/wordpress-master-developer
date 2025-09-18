<?php
/**
 * Template Name: Services Page
 * The template for displaying the Services page
 *
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Services Hero Section -->
        <section class="services-hero-section">
            <div class="container">
                <div class="services-hero-content">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php if (has_excerpt()) : ?>
                        <div class="page-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php else : ?>
                        <div class="page-excerpt">
                            <p><?php esc_html_e('Comprehensive WordPress development services tailored to your specific needs and business goals.', 'wp-master-dev'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Services Overview -->
        <section class="services-overview-section">
            <div class="container">
                <div class="content-wrapper">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>

        <!-- Main Services Grid -->
        <section class="main-services-section">
            <div class="container">
                <div class="section-header">
                    <h2><?php echo esc_html(get_post_meta(get_the_ID(), 'main_services_title', true) ?: __('Our Core Services', 'wp-master-dev')); ?></h2>
                    <p><?php echo esc_html(get_post_meta(get_the_ID(), 'main_services_description', true) ?: __('Professional WordPress development services designed to help your business succeed online.', 'wp-master-dev')); ?></p>
                </div>
                
                <div class="services-grid">
                    <?php
                    // Query services from custom post type
                    $services_query = new WP_Query(array(
                        'post_type' => 'service',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                    ));
                    
                    if ($services_query->have_posts()) :
                        while ($services_query->have_posts()) : $services_query->the_post();
                            $service_price = get_post_meta(get_the_ID(), 'service_price', true);
                            $service_features = get_post_meta(get_the_ID(), 'service_features', true);
                            $service_icon = get_post_meta(get_the_ID(), 'service_icon', true);
                    ?>
                        <div class="service-card">
                            <?php if ($service_icon) : ?>
                                <div class="service-icon">
                                    <span><?php echo esc_html($service_icon); ?></span>
                                </div>
                            <?php elseif (has_post_thumbnail()) : ?>
                                <div class="service-image">
                                    <?php the_post_thumbnail('medium'); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="service-content">
                                <h3 class="service-title"><?php the_title(); ?></h3>
                                
                                <div class="service-description">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <?php if ($service_features) : ?>
                                    <ul class="service-features">
                                        <?php foreach ($service_features as $feature) : ?>
                                            <li><?php echo esc_html($feature); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                
                                <?php if ($service_price) : ?>
                                    <div class="service-price">
                                        <span class="price-label"><?php esc_html_e('Starting at', 'wp-master-dev'); ?></span>
                                        <span class="price-amount"><?php echo esc_html($service_price); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="service-actions">
                                    <a href="<?php the_permalink(); ?>" class="btn btn-outline">
                                        <?php esc_html_e('Learn More', 'wp-master-dev'); ?>
                                    </a>
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>?service=<?php echo urlencode(get_the_title()); ?>" class="btn btn-primary">
                                        <?php esc_html_e('Get Quote', 'wp-master-dev'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        // Fallback services if no custom posts exist
                        $default_services = array(
                            array(
                                'title' => __('Custom Theme Development', 'wp-master-dev'),
                                'description' => __('Fully custom WordPress themes built from scratch to match your brand and requirements perfectly.', 'wp-master-dev'),
                                'icon' => '🎨',
                                'price' => '$2,500+',
                                'features' => array(
                                    __('Responsive Design', 'wp-master-dev'),
                                    __('Custom Post Types', 'wp-master-dev'),
                                    __('SEO Optimized', 'wp-master-dev'),
                                    __('Performance Optimized', 'wp-master-dev')
                                )
                            ),
                            array(
                                'title' => __('Plugin Integration', 'wp-master-dev'),
                                'description' => __('Expert integration of WordPress plugins with custom functionality and seamless user experience.', 'wp-master-dev'),
                                'icon' => '🔌',
                                'price' => '$500+',
                                'features' => array(
                                    __('WooCommerce Setup', 'wp-master-dev'),
                                    __('ACF Integration', 'wp-master-dev'),
                                    __('Custom Functionality', 'wp-master-dev'),
                                    __('Testing & QA', 'wp-master-dev')
                                )
                            ),
                            array(
                                'title' => __('Performance Optimization', 'wp-master-dev'),
                                'description' => __('Speed up your WordPress site with advanced optimization techniques and best practices.', 'wp-master-dev'),
                                'icon' => '⚡',
                                'price' => '$800+',
                                'features' => array(
                                    __('Speed Analysis', 'wp-master-dev'),
                                    __('Code Optimization', 'wp-master-dev'),
                                    __('Caching Setup', 'wp-master-dev'),
                                    __('Performance Monitoring', 'wp-master-dev')
                                )
                            ),
                            array(
                                'title' => __('Maintenance & Support', 'wp-master-dev'),
                                'description' => __('Ongoing WordPress maintenance, updates, and technical support to keep your site running smoothly.', 'wp-master-dev'),
                                'icon' => '🛠️',
                                'price' => '$200/month',
                                'features' => array(
                                    __('Regular Updates', 'wp-master-dev'),
                                    __('Security Monitoring', 'wp-master-dev'),
                                    __('Backup Management', 'wp-master-dev'),
                                    __('Priority Support', 'wp-master-dev')
                                )
                            )
                        );
                        
                        foreach ($default_services as $service) : ?>
                            <div class="service-card">
                                <div class="service-icon">
                                    <span><?php echo esc_html($service['icon']); ?></span>
                                </div>
                                
                                <div class="service-content">
                                    <h3 class="service-title"><?php echo esc_html($service['title']); ?></h3>
                                    
                                    <div class="service-description">
                                        <p><?php echo esc_html($service['description']); ?></p>
                                    </div>
                                    
                                    <ul class="service-features">
                                        <?php foreach ($service['features'] as $feature) : ?>
                                            <li><?php echo esc_html($feature); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    
                                    <div class="service-price">
                                        <span class="price-label"><?php esc_html_e('Starting at', 'wp-master-dev'); ?></span>
                                        <span class="price-amount"><?php echo esc_html($service['price']); ?></span>
                                    </div>
                                    
                                    <div class="service-actions">
                                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>?service=<?php echo urlencode($service['title']); ?>" class="btn btn-primary">
                                            <?php esc_html_e('Get Quote', 'wp-master-dev'); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section class="process-section">
            <div class="container">
                <div class="section-header">
                    <h2><?php echo esc_html(get_post_meta(get_the_ID(), 'process_title', true) ?: __('Our Development Process', 'wp-master-dev')); ?></h2>
                    <p><?php echo esc_html(get_post_meta(get_the_ID(), 'process_description', true) ?: __('A proven methodology that ensures quality results and client satisfaction.', 'wp-master-dev')); ?></p>
                </div>
                
                <div class="process-steps">
                    <?php
                    // Get process steps from custom fields or use defaults
                    $process_steps = get_post_meta(get_the_ID(), 'process_steps', true);
                    
                    if (empty($process_steps)) {
                        // Default process steps
                        $process_steps = array(
                            array(
                                'number' => '1',
                                'title' => __('Discovery & Planning', 'wp-master-dev'),
                                'description' => __('We start by understanding your goals, requirements, and target audience to create a comprehensive project plan.', 'wp-master-dev')
                            ),
                            array(
                                'number' => '2',
                                'title' => __('Design & Prototyping', 'wp-master-dev'),
                                'description' => __('Creating wireframes and prototypes to visualize the final product and ensure alignment with your vision.', 'wp-master-dev')
                            ),
                            array(
                                'number' => '3',
                                'title' => __('Development & Testing', 'wp-master-dev'),
                                'description' => __('Building your WordPress solution with clean code, thorough testing, and regular progress updates.', 'wp-master-dev')
                            ),
                            array(
                                'number' => '4',
                                'title' => __('Launch & Support', 'wp-master-dev'),
                                'description' => __('Deploying your site and providing ongoing support to ensure everything runs smoothly.', 'wp-master-dev')
                            )
                        );
                    }
                    
                    foreach ($process_steps as $step) : ?>
                        <div class="process-step">
                            <div class="step-number">
                                <span><?php echo esc_html($step['number']); ?></span>
                            </div>
                            <div class="step-content">
                                <h3 class="step-title"><?php echo esc_html($step['title']); ?></h3>
                                <p class="step-description"><?php echo esc_html($step['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="faq-section">
            <div class="container">
                <div class="section-header">
                    <h2><?php echo esc_html(get_post_meta(get_the_ID(), 'faq_title', true) ?: __('Frequently Asked Questions', 'wp-master-dev')); ?></h2>
                </div>
                
                <div class="faq-list">
                    <?php
                    // Get FAQs from custom fields or use defaults
                    $faqs = get_post_meta(get_the_ID(), 'faq_list', true);
                    
                    if (empty($faqs)) {
                        // Default FAQs
                        $faqs = array(
                            array(
                                'question' => __('How long does a typical WordPress project take?', 'wp-master-dev'),
                                'answer' => __('Project timelines vary based on complexity, but most custom themes take 4-8 weeks from start to finish. We provide detailed timelines during the planning phase.', 'wp-master-dev')
                            ),
                            array(
                                'question' => __('Do you provide ongoing maintenance and support?', 'wp-master-dev'),
                                'answer' => __('Yes, we offer comprehensive maintenance packages including updates, security monitoring, backups, and technical support to keep your site running smoothly.', 'wp-master-dev')
                            ),
                            array(
                                'question' => __('Can you work with existing WordPress sites?', 'wp-master-dev'),
                                'answer' => __('Absolutely! We can enhance existing WordPress sites, optimize performance, add new features, or completely redesign while preserving your content.', 'wp-master-dev')
                            ),
                            array(
                                'question' => __('What is included in your WordPress development service?', 'wp-master-dev'),
                                'answer' => __('Our service includes custom theme development, responsive design, SEO optimization, performance tuning, testing, and documentation. We also provide training on managing your new site.', 'wp-master-dev')
                            )
                        );
                    }
                    
                    foreach ($faqs as $index => $faq) : ?>
                        <div class="faq-item">
                            <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-<?php echo $index; ?>">
                                <span><?php echo esc_html($faq['question']); ?></span>
                                <span class="faq-toggle">+</span>
                            </button>
                            <div id="faq-answer-<?php echo $index; ?>" class="faq-answer" aria-hidden="true">
                                <p><?php echo esc_html($faq['answer']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Services CTA Section -->
        <section class="services-cta-section">
            <div class="container">
                <div class="cta-content">
                    <h2><?php echo esc_html(get_post_meta(get_the_ID(), 'cta_title', true) ?: __('Ready to Start Your Project?', 'wp-master-dev')); ?></h2>
                    <p><?php echo esc_html(get_post_meta(get_the_ID(), 'cta_description', true) ?: __('Let\'s discuss your WordPress needs and create a solution that drives results for your business.', 'wp-master-dev')); ?></p>
                    <div class="cta-actions">
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn-primary btn-large">
                            <?php echo esc_html(get_post_meta(get_the_ID(), 'cta_button_text', true) ?: __('Get Free Quote', 'wp-master-dev')); ?>
                        </a>
                    </div>
                </div>
            </div>
        </section>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
