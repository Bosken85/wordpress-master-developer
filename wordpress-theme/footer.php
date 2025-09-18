<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="footer-content">
            <div class="container">
                <div class="footer-widgets">
                    <div class="footer-widget-area">
                        <div class="footer-column">
                            <div class="footer-branding">
                                <?php
                                if (has_custom_logo()) {
                                    the_custom_logo();
                                } else {
                                    ?>
                                    <h3 class="footer-site-title"><?php bloginfo('name'); ?></h3>
                                    <?php
                                }
                                ?>
                                <p class="footer-description">
                                    <?php 
                                    $description = get_bloginfo('description');
                                    if ($description) {
                                        echo esc_html($description);
                                    } else {
                                        esc_html_e('Professional WordPress development services with modern design and expert implementation.', 'wp-master-dev');
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>

                        <div class="footer-column">
                            <h4 class="footer-widget-title"><?php esc_html_e('Quick Links', 'wp-master-dev'); ?></h4>
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer',
                                'menu_class'     => 'footer-menu',
                                'container'      => false,
                                'depth'          => 1,
                                'fallback_cb'    => 'wp_master_dev_footer_fallback_menu',
                            ));
                            ?>
                        </div>

                        <div class="footer-column">
                            <h4 class="footer-widget-title"><?php esc_html_e('Services', 'wp-master-dev'); ?></h4>
                            <ul class="footer-services-menu">
                                <?php
                                $services = get_posts(array(
                                    'post_type' => 'service',
                                    'numberposts' => 5,
                                    'post_status' => 'publish'
                                ));
                                
                                if ($services) {
                                    foreach ($services as $service) {
                                        echo '<li><a href="' . esc_url(get_permalink($service->ID)) . '">' . esc_html($service->post_title) . '</a></li>';
                                    }
                                } else {
                                    // Fallback services
                                    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('services'))) . '">' . esc_html__('Custom Theme Development', 'wp-master-dev') . '</a></li>';
                                    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('services'))) . '">' . esc_html__('Plugin Integration', 'wp-master-dev') . '</a></li>';
                                    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('services'))) . '">' . esc_html__('Performance Optimization', 'wp-master-dev') . '</a></li>';
                                    echo '<li><a href="' . esc_url(get_permalink(get_page_by_path('services'))) . '">' . esc_html__('Maintenance & Support', 'wp-master-dev') . '</a></li>';
                                }
                                ?>
                            </ul>
                        </div>

                        <div class="footer-column">
                            <h4 class="footer-widget-title"><?php esc_html_e('Contact Info', 'wp-master-dev'); ?></h4>
                            <div class="footer-contact">
                                <?php
                                $contact_email = get_option('wp_master_dev_contact_email', 'contact@wpmaster.dev');
                                $contact_phone = get_option('wp_master_dev_contact_phone', '+1 (555) 123-4567');
                                ?>
                                <p class="contact-item">
                                    <span class="contact-label"><?php esc_html_e('Email:', 'wp-master-dev'); ?></span>
                                    <a href="mailto:<?php echo esc_attr($contact_email); ?>"><?php echo esc_html($contact_email); ?></a>
                                </p>
                                <p class="contact-item">
                                    <span class="contact-label"><?php esc_html_e('Phone:', 'wp-master-dev'); ?></span>
                                    <a href="tel:<?php echo esc_attr(str_replace(array(' ', '(', ')', '-'), '', $contact_phone)); ?>"><?php echo esc_html($contact_phone); ?></a>
                                </p>
                                <div class="footer-cta">
                                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn-outline btn-small">
                                        <?php esc_html_e('Get Quote', 'wp-master-dev'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'wp-master-dev'); ?></p>
                        <p class="built-with">
                            <?php esc_html_e('Built with', 'wp-master-dev'); ?> <span class="heart">❤️</span> <?php esc_html_e('using WordPress expertise', 'wp-master-dev'); ?>
                        </p>
                    </div>
                    
                    <div class="footer-legal">
                        <ul class="legal-menu">
                            <?php
                            $legal_pages = array(
                                'privacy-policy' => __('Privacy Policy', 'wp-master-dev'),
                                'terms-of-service' => __('Terms of Service', 'wp-master-dev'),
                                'cookie-policy' => __('Cookie Policy', 'wp-master-dev'),
                                'disclaimer' => __('Disclaimer', 'wp-master-dev'),
                            );
                            
                            foreach ($legal_pages as $slug => $title) {
                                $page = get_page_by_path($slug);
                                if ($page) {
                                    echo '<li><a href="' . esc_url(get_permalink($page)) . '">' . esc_html($title) . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="back-to-top" aria-label="<?php esc_attr_e('Back to top', 'wp-master-dev'); ?>">
        <span class="back-to-top-icon">↑</span>
    </button>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

<?php
/**
 * Fallback footer menu
 */
function wp_master_dev_footer_fallback_menu() {
    $pages = get_pages(array(
        'sort_column' => 'menu_order',
        'parent' => 0,
        'number' => 4
    ));
    
    if ($pages) {
        echo '<ul class="footer-menu fallback-menu">';
        echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'wp-master-dev') . '</a></li>';
        
        foreach ($pages as $page) {
            echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
        }
        
        echo '</ul>';
    }
}
?>
