<?php
/**
 * Template Name: About Page
 * The template for displaying the About page
 *
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- About Hero Section -->
        <section class="about-hero-section">
            <div class="container">
                <div class="about-hero-content">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php if (has_excerpt()) : ?>
                        <div class="page-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- About Content Section -->
        <section class="about-content-section">
            <div class="container">
                <div class="about-grid">
                    <div class="about-text">
                        <div class="content-wrapper">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="about-image">
                            <?php the_post_thumbnail('large', array('class' => 'about-featured-image')); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Skills & Expertise Section -->
        <section class="skills-section">
            <div class="container">
                <div class="section-header">
                    <h2><?php echo esc_html(get_post_meta(get_the_ID(), 'skills_section_title', true) ?: __('Skills & Expertise', 'wp-master-dev')); ?></h2>
                    <p><?php echo esc_html(get_post_meta(get_the_ID(), 'skills_section_description', true) ?: __('Comprehensive WordPress development skills with years of experience.', 'wp-master-dev')); ?></p>
                </div>
                
                <div class="skills-grid">
                    <?php
                    // Get skills from custom fields or use defaults
                    $skills = get_post_meta(get_the_ID(), 'skills_list', true);
                    
                    if (empty($skills)) {
                        // Default skills
                        $skills = array(
                            array(
                                'title' => __('PHP Development', 'wp-master-dev'),
                                'description' => __('Expert-level PHP programming for WordPress themes and plugins.', 'wp-master-dev'),
                                'percentage' => '95'
                            ),
                            array(
                                'title' => __('WordPress Core', 'wp-master-dev'),
                                'description' => __('Deep understanding of WordPress architecture and best practices.', 'wp-master-dev'),
                                'percentage' => '98'
                            ),
                            array(
                                'title' => __('Frontend Development', 'wp-master-dev'),
                                'description' => __('Modern HTML5, CSS3, and JavaScript for responsive designs.', 'wp-master-dev'),
                                'percentage' => '90'
                            ),
                            array(
                                'title' => __('Performance Optimization', 'wp-master-dev'),
                                'description' => __('Speed optimization and performance tuning for WordPress sites.', 'wp-master-dev'),
                                'percentage' => '88'
                            )
                        );
                    }
                    
                    foreach ($skills as $skill) : ?>
                        <div class="skill-item">
                            <div class="skill-content">
                                <h3 class="skill-title"><?php echo esc_html($skill['title']); ?></h3>
                                <p class="skill-description"><?php echo esc_html($skill['description']); ?></p>
                                <?php if (!empty($skill['percentage'])) : ?>
                                    <div class="skill-progress">
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: <?php echo esc_attr($skill['percentage']); ?>%"></div>
                                        </div>
                                        <span class="progress-percentage"><?php echo esc_html($skill['percentage']); ?>%</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Experience Section -->
        <section class="experience-section">
            <div class="container">
                <div class="section-header">
                    <h2><?php echo esc_html(get_post_meta(get_the_ID(), 'experience_section_title', true) ?: __('Professional Experience', 'wp-master-dev')); ?></h2>
                </div>
                
                <div class="experience-timeline">
                    <?php
                    // Get experience from custom fields or use defaults
                    $experiences = get_post_meta(get_the_ID(), 'experience_list', true);
                    
                    if (empty($experiences)) {
                        // Default experience
                        $experiences = array(
                            array(
                                'year' => '2020 - Present',
                                'title' => __('Senior WordPress Developer', 'wp-master-dev'),
                                'company' => __('Freelance', 'wp-master-dev'),
                                'description' => __('Specialized in custom WordPress theme development, performance optimization, and complex plugin integrations for enterprise clients.', 'wp-master-dev')
                            ),
                            array(
                                'year' => '2018 - 2020',
                                'title' => __('WordPress Developer', 'wp-master-dev'),
                                'company' => __('Digital Agency', 'wp-master-dev'),
                                'description' => __('Developed custom WordPress solutions for various clients, focusing on responsive design and user experience optimization.', 'wp-master-dev')
                            ),
                            array(
                                'year' => '2016 - 2018',
                                'title' => __('Frontend Developer', 'wp-master-dev'),
                                'company' => __('Web Studio', 'wp-master-dev'),
                                'description' => __('Created modern, responsive websites using HTML5, CSS3, and JavaScript, with a focus on WordPress integration.', 'wp-master-dev')
                            )
                        );
                    }
                    
                    foreach ($experiences as $experience) : ?>
                        <div class="experience-item">
                            <div class="experience-year">
                                <span><?php echo esc_html($experience['year']); ?></span>
                            </div>
                            <div class="experience-content">
                                <h3 class="experience-title"><?php echo esc_html($experience['title']); ?></h3>
                                <h4 class="experience-company"><?php echo esc_html($experience['company']); ?></h4>
                                <p class="experience-description"><?php echo esc_html($experience['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Values Section -->
        <section class="values-section">
            <div class="container">
                <div class="section-header">
                    <h2><?php echo esc_html(get_post_meta(get_the_ID(), 'values_section_title', true) ?: __('Core Values', 'wp-master-dev')); ?></h2>
                    <p><?php echo esc_html(get_post_meta(get_the_ID(), 'values_section_description', true) ?: __('The principles that guide every project and client relationship.', 'wp-master-dev')); ?></p>
                </div>
                
                <div class="values-grid">
                    <?php
                    // Get values from custom fields or use defaults
                    $values = get_post_meta(get_the_ID(), 'values_list', true);
                    
                    if (empty($values)) {
                        // Default values
                        $values = array(
                            array(
                                'title' => __('Quality First', 'wp-master-dev'),
                                'description' => __('Every line of code is written with precision and attention to detail, ensuring robust and maintainable solutions.', 'wp-master-dev'),
                                'icon' => '⭐'
                            ),
                            array(
                                'title' => __('Client Success', 'wp-master-dev'),
                                'description' => __('Your success is my success. I work closely with clients to understand their goals and exceed expectations.', 'wp-master-dev'),
                                'icon' => '🎯'
                            ),
                            array(
                                'title' => __('Continuous Learning', 'wp-master-dev'),
                                'description' => __('Staying current with the latest WordPress developments and web technologies to provide cutting-edge solutions.', 'wp-master-dev'),
                                'icon' => '📚'
                            ),
                            array(
                                'title' => __('Transparent Communication', 'wp-master-dev'),
                                'description' => __('Clear, honest communication throughout every project phase, keeping clients informed and involved.', 'wp-master-dev'),
                                'icon' => '💬'
                            )
                        );
                    }
                    
                    foreach ($values as $value) : ?>
                        <div class="value-item">
                            <?php if (!empty($value['icon'])) : ?>
                                <div class="value-icon">
                                    <span><?php echo esc_html($value['icon']); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="value-content">
                                <h3 class="value-title"><?php echo esc_html($value['title']); ?></h3>
                                <p class="value-description"><?php echo esc_html($value['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="about-cta-section">
            <div class="container">
                <div class="cta-content">
                    <h2><?php echo esc_html(get_post_meta(get_the_ID(), 'cta_title', true) ?: __('Ready to Work Together?', 'wp-master-dev')); ?></h2>
                    <p><?php echo esc_html(get_post_meta(get_the_ID(), 'cta_description', true) ?: __('Let\'s discuss your WordPress project and create something amazing together.', 'wp-master-dev')); ?></p>
                    <div class="cta-actions">
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn-primary btn-large">
                            <?php echo esc_html(get_post_meta(get_the_ID(), 'cta_button_text', true) ?: __('Get In Touch', 'wp-master-dev')); ?>
                        </a>
                    </div>
                </div>
            </div>
        </section>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
