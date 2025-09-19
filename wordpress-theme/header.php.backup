<?php
/**
 * The header for our theme
 *
 * @package WordPress_Master_Developer
 * @since 1.0.0
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#main"><?php esc_html_e('Skip to content', 'wp-master-dev'); ?></a>

    <header id="masthead" class="site-header">
        <nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary Navigation', 'wp-master-dev'); ?>">
            <div class="nav-container">
                <!-- Logo -->
                <div class="site-branding">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo-text">
                            <h1 class="site-title"><?php bloginfo('name'); ?></h1>
                        </a>
                        <?php
                    }
                    ?>
                </div>

                <!-- Desktop Navigation -->
                <div class="desktop-menu">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'container'      => false,
                        'fallback_cb'    => 'wp_master_dev_fallback_menu',
                    ));
                    ?>
                </div>

                <!-- CTA Button (Desktop) -->
                <div class="desktop-cta">
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn-primary">
                        <?php esc_html_e('Get Started', 'wp-master-dev'); ?>
                    </a>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" aria-controls="mobile-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation menu', 'wp-master-dev'); ?>">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>
        </nav>

        <!-- Full-Screen Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu-overlay" aria-hidden="true">
            <div class="mobile-menu-backdrop"></div>
            <div class="mobile-menu-panel">
                <!-- Mobile Menu Header -->
                <div class="mobile-menu-header">
                    <div class="mobile-logo">
                        <?php
                        if (has_custom_logo()) {
                            the_custom_logo();
                        } else {
                            ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo-text">
                                <span class="site-title"><?php bloginfo('name'); ?></span>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                    <button class="mobile-menu-close" aria-label="<?php esc_attr_e('Close menu', 'wp-master-dev'); ?>">
                        <span class="close-icon">&times;</span>
                    </button>
                </div>

                <!-- Mobile Menu Content -->
                <div class="mobile-menu-content">
                    <nav class="mobile-navigation" role="navigation" aria-label="<?php esc_attr_e('Mobile Navigation', 'wp-master-dev'); ?>">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'mobile-primary-menu',
                            'menu_class'     => 'mobile-nav-menu',
                            'container'      => false,
                            'fallback_cb'    => 'wp_master_dev_fallback_menu',
                        ));
                        ?>
                    </nav>

                    <!-- Mobile CTA -->
                    <div class="mobile-cta">
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn-primary btn-full-width">
                            <?php esc_html_e('Get Started', 'wp-master-dev'); ?>
                        </a>
                    </div>

                    <!-- Mobile Menu Footer -->
                    <div class="mobile-menu-footer">
                        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'wp-master-dev'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="content" class="site-content">

<?php
/**
 * Fallback menu for when no menu is assigned
 */
function wp_master_dev_fallback_menu() {
    $pages = get_pages(array(
        'sort_column' => 'menu_order',
        'parent' => 0,
        'number' => 5
    ));
    
    if ($pages) {
        echo '<ul class="nav-menu fallback-menu">';
        echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'wp-master-dev') . '</a></li>';
        
        foreach ($pages as $page) {
            echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
        }
        
        echo '</ul>';
    }
}
?>
