<?php
/**
 * The main template file
 *
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <?php if (is_home() && is_front_page()) : ?>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-background">
                <?php 
                $hero_bg = get_theme_mod('hero_background_image');
                if ($hero_bg) : ?>
                    <img src="<?php echo esc_url($hero_bg); ?>" alt="<?php esc_attr_e('Hero Background', 'wp-master-dev'); ?>" class="hero-bg-image">
                <?php endif; ?>
            </div>
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">
                        <?php echo esc_html(get_option('wp_master_dev_hero_title', 'WordPress Master Developer')); ?>
                    </h1>
                    <p class="hero-subtitle">
                        <?php echo esc_html(get_option('wp_master_dev_hero_subtitle', 'Expert AI assistant specializing in custom WordPress theme development from scratch')); ?>
                    </p>
                    <div class="hero-description">
                        <p><?php echo esc_html(get_option('wp_master_dev_hero_description', 'Deep expertise in PHP, CSS, HTML, and JavaScript. Creating high-quality, performance-optimized WordPress themes that are fully integrated with WordPress core and built for security, scalability, and upgrade safety.')); ?></p>
                    </div>
                    <div class="hero-actions">
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn-primary">
                            <?php echo esc_html(get_option('wp_master_dev_cta_text', 'Start Your Project')); ?>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="about-section">
            <div class="container">
                <div class="section-header">
                    <h2><?php esc_html_e('Your WordPress Development Expert', 'wp-master-dev'); ?></h2>
                </div>
                <div class="about-content">
                    <?php
                    $about_page = get_page_by_path('about');
                    if ($about_page) {
                        echo wp_kses_post(wp_trim_words($about_page->post_content, 50));
                        echo '<p><a href="' . esc_url(get_permalink($about_page)) . '" class="read-more">' . esc_html__('Learn More About Us', 'wp-master-dev') . '</a></p>';
                    }
                    ?>
                </div>
                <div class="expertise-grid">
                    <div class="expertise-item">
                        <h3><?php esc_html_e('Custom WordPress theme development from scratch', 'wp-master-dev'); ?></h3>
                    </div>
                    <div class="expertise-item">
                        <h3><?php esc_html_e('Popular plugins integration (WooCommerce, ACF, Contact Form 7)', 'wp-master-dev'); ?></h3>
                    </div>
                    <div class="expertise-item">
                        <h3><?php esc_html_e('Major theme builders compatibility (Elementor, Divi, Beaver Builder)', 'wp-master-dev'); ?></h3>
                    </div>
                    <div class="expertise-item">
                        <h3><?php esc_html_e('WordPress template hierarchy mastery', 'wp-master-dev'); ?></h3>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services-section">
            <div class="container">
                <div class="section-header">
                    <h2><?php esc_html_e('Comprehensive WordPress Development Services', 'wp-master-dev'); ?></h2>
                    <p><?php esc_html_e('From custom theme development to performance optimization, I provide end-to-end WordPress solutions that exceed expectations.', 'wp-master-dev'); ?></p>
                </div>
                <div class="services-grid">
                    <?php
                    $services = new WP_Query(array(
                        'post_type' => 'service',
                        'posts_per_page' => 4,
                        'post_status' => 'publish'
                    ));
                    
                    if ($services->have_posts()) :
                        while ($services->have_posts()) : $services->the_post();
                    ?>
                        <div class="service-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="service-icon">
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                </div>
                            <?php endif; ?>
                            <h3><?php the_title(); ?></h3>
                            <p><?php echo wp_kses_post(wp_trim_words(get_the_content(), 20)); ?></p>
                        </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
                <div class="section-footer">
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('services'))); ?>" class="btn btn-outline">
                        <?php esc_html_e('View All Services', 'wp-master-dev'); ?>
                    </a>
                </div>
            </div>
        </section>

        <!-- Portfolio Section -->
        <section class="portfolio-section">
            <div class="container">
                <div class="section-header">
                    <h2><?php esc_html_e('Featured WordPress Projects', 'wp-master-dev'); ?></h2>
                    <p><?php esc_html_e('Showcasing excellence in WordPress theme development across various industries and use cases.', 'wp-master-dev'); ?></p>
                </div>
                <div class="portfolio-grid">
                    <?php
                    $projects = new WP_Query(array(
                        'post_type' => 'project',
                        'posts_per_page' => 4,
                        'post_status' => 'publish'
                    ));
                    
                    if ($projects->have_posts()) :
                        while ($projects->have_posts()) : $projects->the_post();
                    ?>
                        <div class="portfolio-item">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="portfolio-image">
                                    <?php the_post_thumbnail('medium'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="portfolio-content">
                                <h3><?php the_title(); ?></h3>
                                <p><?php echo wp_kses_post(wp_trim_words(get_the_content(), 15)); ?></p>
                                <a href="<?php the_permalink(); ?>" class="portfolio-link">
                                    <?php esc_html_e('View Project', 'wp-master-dev'); ?>
                                </a>
                            </div>
                        </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-content">
                    <h2><?php esc_html_e('Ready to Build Your WordPress Theme?', 'wp-master-dev'); ?></h2>
                    <p><?php esc_html_e('Let\'s discuss your project requirements and create a custom WordPress solution that exceeds your expectations.', 'wp-master-dev'); ?></p>
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn-primary btn-large">
                        <?php echo esc_html(get_option('wp_master_dev_cta_text', 'Start Your Project')); ?>
                    </a>
                </div>
            </div>
        </section>

    <?php else : ?>
        <!-- Blog/Archive Content -->
        <div class="container">
            <div class="content-area">
                <?php if (have_posts()) : ?>
                    <header class="page-header">
                        <?php
                        the_archive_title('<h1 class="page-title">', '</h1>');
                        the_archive_description('<div class="archive-description">', '</div>');
                        ?>
                    </header>

                    <div class="posts-grid">
                        <?php while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="post-content">
                                    <header class="entry-header">
                                        <h2 class="entry-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        <div class="entry-meta">
                                            <span class="post-date"><?php echo get_the_date(); ?></span>
                                            <span class="post-author"><?php esc_html_e('by', 'wp-master-dev'); ?> <?php the_author(); ?></span>
                                        </div>
                                    </header>
                                    
                                    <div class="entry-summary">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    
                                    <footer class="entry-footer">
                                        <a href="<?php the_permalink(); ?>" class="read-more">
                                            <?php esc_html_e('Read More', 'wp-master-dev'); ?>
                                        </a>
                                    </footer>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>

                    <?php
                    the_posts_navigation(array(
                        'prev_text' => esc_html__('Older posts', 'wp-master-dev'),
                        'next_text' => esc_html__('Newer posts', 'wp-master-dev'),
                    ));
                    ?>

                <?php else : ?>
                    <section class="no-results not-found">
                        <header class="page-header">
                            <h1 class="page-title"><?php esc_html_e('Nothing here', 'wp-master-dev'); ?></h1>
                        </header>
                        <div class="page-content">
                            <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'wp-master-dev'); ?></p>
                            <?php get_search_form(); ?>
                        </div>
                    </section>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
