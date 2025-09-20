<?php
/**
 * The template for displaying all pages
 *
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>
                
                <?php if (!is_front_page()) : ?>
                    <header class="page-header py-4">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                        <?php if (has_excerpt()) : ?>
                            <div class="page-excerpt lead">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                    </header>
                <?php endif; ?>

                <div class="page-content-wrapper">
                    <div class="row">
                        <div class="col-lg-8">
                            <?php
                            the_content();
                            
                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'wp-master-dev'),
                                'after'  => '</div>',
                            ));
                            
                            // Auto-insert contact form on contact page
                            if (is_page('contact') || is_page('contact-us')) {
                                echo '<div class="contact-form-section mt-4">';
                                wp_master_dev_display_contact_form();
                                echo '</div>';
                            }
                            ?>
                        </div>
                        
                        <?php if (is_page('contact') || is_page('contact-us')) : ?>
                        <div class="col-lg-4">
                            <div class="contact-info bg-light p-4 rounded">
                                <h3><?php esc_html_e('Contact Information', 'wp-master-dev'); ?></h3>
                                <div class="contact-item mb-3">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <span><?php echo esc_html(get_option('wp_master_dev_contact_email', 'contact@example.com')); ?></span>
                                </div>
                                <div class="contact-item mb-3">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <span><?php echo esc_html(get_option('wp_master_dev_contact_phone', '+1 (555) 123-4567')); ?></span>
                                </div>
                                <div class="contact-item mb-3">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    <span><?php esc_html_e('Mon-Fri: 9AM-6PM EST', 'wp-master-dev'); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php else : ?>
                        <div class="col-lg-4">
                            <?php if (is_active_sidebar('sidebar-1')) : ?>
                                <aside class="page-sidebar">
                                    <?php dynamic_sidebar('sidebar-1'); ?>
                                </aside>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (comments_open() || get_comments_number()) : ?>
                    <div class="page-comments mt-5">
                        <?php comments_template(); ?>
                    </div>
                <?php endif; ?>

            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
