<?php
/**
 * WordPress Master Developer Theme Demo Content
 * Handles full demo content import to replicate SPA example
 *
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Import full demo content to replicate SPA example
 */
function wp_master_dev_import_full_demo_content() {
    // Update homepage content
    wp_master_dev_update_homepage_content();
    
    // Update About page content
    wp_master_dev_update_about_page_content();
    
    // Update Services page content
    wp_master_dev_update_services_page_content();
    
    // Update Contact page content
    wp_master_dev_update_contact_page_content();
    
    // Create demo services
    wp_master_dev_create_demo_services();
    
    // Create demo projects
    wp_master_dev_create_demo_projects();
    
    // Create demo testimonials
    wp_master_dev_create_demo_testimonials();
    
    // Update theme options with SPA-like content
    wp_master_dev_update_theme_options_for_demo();
}

/**
 * Update homepage content to match SPA example
 */
function wp_master_dev_update_homepage_content() {
    $homepage = get_page_by_path('home');
    if (!$homepage) {
        // Create homepage if it doesn't exist
        $homepage_id = wp_insert_post(array(
            'post_title' => 'Home',
            'post_content' => wp_master_dev_get_homepage_content(),
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_name' => 'home'
        ));
        
        // Set as front page
        update_option('show_on_front', 'page');
        update_option('page_on_front', $homepage_id);
    } else {
        // Update existing homepage
        wp_update_post(array(
            'ID' => $homepage->ID,
            'post_content' => wp_master_dev_get_homepage_content()
        ));
    }
}

/**
 * Get rich homepage content
 */
function wp_master_dev_get_homepage_content() {
    return '
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">WordPress Master Developer</h1>
                <p class="hero-subtitle">Expert AI assistant specializing in custom WordPress theme development from scratch</p>
                <p class="hero-description">Deep expertise in PHP, CSS, HTML, and JavaScript. Creating high-quality, performance-optimized WordPress themes that are fully integrated with WordPress core and built for security, scalability, and upgrade safety.</p>
                <div class="hero-buttons">
                    <a href="/contact" class="btn btn-primary btn-lg">Start Your Project</a>
                    <a href="/services" class="btn btn-outline-primary btn-lg">View Services</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&h=600&fit=crop&crop=center" alt="WordPress Development" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="features-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-code fa-3x text-primary"></i>
                    </div>
                    <h3>Custom Development</h3>
                    <p>Tailored WordPress themes built from scratch to match your exact requirements and brand identity.</p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-rocket fa-3x text-primary"></i>
                    </div>
                    <h3>Performance Optimized</h3>
                    <p>Lightning-fast themes optimized for speed, SEO, and user experience across all devices.</p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt fa-3x text-primary"></i>
                    </div>
                    <h3>Secure & Scalable</h3>
                    <p>Built with WordPress best practices, security standards, and scalability in mind.</p>
                </div>
            </div>
        </div>
    </div>
</div>';
}

/**
 * Update About page content
 */
function wp_master_dev_update_about_page_content() {
    $about_page = get_page_by_path('about');
    if ($about_page) {
        wp_update_post(array(
            'ID' => $about_page->ID,
            'post_content' => wp_master_dev_get_about_content()
        ));
    }
}

/**
 * Get rich about page content
 */
function wp_master_dev_get_about_content() {
    return '
<div class="about-hero py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1>About WordPress Master Developer</h1>
                <p class="lead">Passionate about creating exceptional WordPress experiences through expert development and innovative solutions.</p>
            </div>
        </div>
    </div>
</div>

<div class="skills-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2>Skills & Expertise</h2>
                <div class="skill-item mb-3">
                    <div class="d-flex justify-content-between">
                        <span>WordPress Development</span>
                        <span>95%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: 95%"></div>
                    </div>
                </div>
                <div class="skill-item mb-3">
                    <div class="d-flex justify-content-between">
                        <span>PHP Programming</span>
                        <span>90%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: 90%"></div>
                    </div>
                </div>
                <div class="skill-item mb-3">
                    <div class="d-flex justify-content-between">
                        <span>JavaScript & jQuery</span>
                        <span>85%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: 85%"></div>
                    </div>
                </div>
                <div class="skill-item mb-3">
                    <div class="d-flex justify-content-between">
                        <span>CSS & SCSS</span>
                        <span>92%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: 92%"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h2>Experience</h2>
                <div class="experience-item mb-4">
                    <h4>Senior WordPress Developer</h4>
                    <p class="text-muted">2020 - Present</p>
                    <p>Leading custom WordPress theme development projects for enterprise clients, focusing on performance optimization and scalability.</p>
                </div>
                <div class="experience-item mb-4">
                    <h4>Full Stack Developer</h4>
                    <p class="text-muted">2018 - 2020</p>
                    <p>Developed custom web applications and WordPress solutions for various industries including e-commerce and education.</p>
                </div>
                <div class="experience-item mb-4">
                    <h4>Frontend Developer</h4>
                    <p class="text-muted">2016 - 2018</p>
                    <p>Specialized in responsive web design and user interface development using modern CSS frameworks and JavaScript.</p>
                </div>
            </div>
        </div>
    </div>
</div>';
}

/**
 * Update Services page content
 */
function wp_master_dev_update_services_page_content() {
    $services_page = get_page_by_path('services');
    if ($services_page) {
        wp_update_post(array(
            'ID' => $services_page->ID,
            'post_content' => wp_master_dev_get_services_content()
        ));
    }
}

/**
 * Get rich services page content
 */
function wp_master_dev_get_services_content() {
    return '
<div class="services-hero py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1>Our Services</h1>
                <p class="lead">Comprehensive WordPress development services tailored to your business needs.</p>
            </div>
        </div>
    </div>
</div>

<div class="services-grid py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="service-card h-100">
                    <div class="service-icon">
                        <i class="fas fa-paint-brush fa-3x text-primary"></i>
                    </div>
                    <h3>Custom Theme Development</h3>
                    <p>Bespoke WordPress themes designed and developed from scratch to match your brand and requirements.</p>
                    <div class="service-price">Starting at $2,500</div>
                    <a href="/contact" class="btn btn-primary">Get Quote</a>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="service-card h-100">
                    <div class="service-icon">
                        <i class="fas fa-plug fa-3x text-primary"></i>
                    </div>
                    <h3>Plugin Development</h3>
                    <p>Custom WordPress plugins to extend functionality and integrate with third-party services.</p>
                    <div class="service-price">Starting at $1,500</div>
                    <a href="/contact" class="btn btn-primary">Get Quote</a>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="service-card h-100">
                    <div class="service-icon">
                        <i class="fas fa-tachometer-alt fa-3x text-primary"></i>
                    </div>
                    <h3>Performance Optimization</h3>
                    <p>Speed up your WordPress site with advanced optimization techniques and caching strategies.</p>
                    <div class="service-price">Starting at $800</div>
                    <a href="/contact" class="btn btn-primary">Get Quote</a>
                </div>
            </div>
        </div>
    </div>
</div>';
}

/**
 * Update Contact page content
 */
function wp_master_dev_update_contact_page_content() {
    $contact_page = get_page_by_path('contact');
    if ($contact_page) {
        wp_update_post(array(
            'ID' => $contact_page->ID,
            'post_content' => wp_master_dev_get_contact_content()
        ));
    }
}

/**
 * Get rich contact page content
 */
function wp_master_dev_get_contact_content() {
    return '
<div class="contact-hero py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1>Get In Touch</h1>
                <p class="lead">Ready to start your WordPress project? Let\'s discuss how we can help bring your vision to life.</p>
            </div>
        </div>
    </div>
</div>

<div class="contact-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Contact form will be automatically inserted here by the page template -->
            </div>
            <div class="col-lg-4">
                <div class="contact-info">
                    <h3>Contact Information</h3>
                    <div class="contact-item mb-3">
                        <i class="fas fa-envelope text-primary"></i>
                        <span>contact@wpmaster.dev</span>
                    </div>
                    <div class="contact-item mb-3">
                        <i class="fas fa-phone text-primary"></i>
                        <span>+1 (555) 123-4567</span>
                    </div>
                    <div class="contact-item mb-3">
                        <i class="fas fa-clock text-primary"></i>
                        <span>Mon-Fri: 9AM-6PM EST</span>
                    </div>
                </div>
                
                <div class="contact-faq mt-4">
                    <h4>Frequently Asked Questions</h4>
                    <div class="faq-item mb-3">
                        <strong>How long does a custom theme take?</strong>
                        <p>Typically 2-4 weeks depending on complexity and requirements.</p>
                    </div>
                    <div class="faq-item mb-3">
                        <strong>Do you provide ongoing support?</strong>
                        <p>Yes, we offer maintenance packages and ongoing support options.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
}

/**
 * Update theme options for demo
 */
function wp_master_dev_update_theme_options_for_demo() {
    $demo_options = array(
        'wp_master_dev_hero_title' => 'WordPress Master Developer',
        'wp_master_dev_hero_subtitle' => 'Expert AI assistant specializing in custom WordPress theme development from scratch',
        'wp_master_dev_hero_description' => 'Deep expertise in PHP, CSS, HTML, and JavaScript. Creating high-quality, performance-optimized WordPress themes that are fully integrated with WordPress core and built for security, scalability, and upgrade safety.',
        'wp_master_dev_cta_text' => 'Start Your Project',
        'wp_master_dev_contact_email' => 'contact@wpmaster.dev',
        'wp_master_dev_contact_phone' => '+1 (555) 123-4567',
    );
    
    foreach ($demo_options as $option => $value) {
        update_option($option, $value);
    }
}
