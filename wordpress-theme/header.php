<?php
/**
 * The header for WordPress Master Developer theme
 * Displays all of the <head> section and everything up until <div id="content">
 * Includes all assets from React theme for identical appearance
 *
 * @package WordPress_Master_Developer
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Favicon from React theme -->
    <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.ico">
    
    <!-- Preload critical fonts -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"></noscript>
    
    <!-- Preload hero background image for performance -->
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/images/hero-bg.png" as="image">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'wp-master-dev' ); ?></a>

    <!-- TrueHorizon.ai Style Navigation Header -->
    <header id="masthead" class="site-header">
        <div class="nav-container">
            <!-- Logo - Left Side (Using React theme logo) -->
            <div class="site-branding">
                <?php
                $custom_logo_id = get_theme_mod( 'custom_logo' );
                if ( $custom_logo_id ) {
                    $logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
                    $logo_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
                } else {
                    // Use React theme logo as fallback
                    $logo_url = get_template_directory_uri() . '/assets/images/logo.png';
                    $logo_alt = get_bloginfo( 'name' ) . ' - WordPress Master Developer';
                }
                ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <img src="<?php echo esc_url( $logo_url ); ?>" 
                         alt="<?php echo esc_attr( $logo_alt ); ?>" 
                         class="site-logo"
                         loading="eager"
                         width="80"
                         height="80">
                </a>
            </div>

            <!-- Desktop Navigation - Center/Right -->
            <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'wp-master-dev' ); ?>">
                <?php
                wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'menu_class'     => 'nav-menu',
                            'container'      => false,
                            'walker'         => new WP_Master_Dev_Walker_Nav_Menu(),
                            'fallback_cb'    => false,
                        )
                    );
                ?>
            </nav>

            <!-- CTA Button - Right Side (Desktop) -->
            <div class="nav-cta">
                <?php
                $contact_page = get_page_by_path( 'contact' );
                $contact_url = $contact_page ? get_permalink( $contact_page ) : home_url( '/contact' );
                ?>
                <a href="<?php echo esc_url( $contact_url ); ?>" class="cta-button">
                    <?php echo esc_html( get_theme_mod( 'header_cta_text', 'Get Started' ) ); ?>
                </a>
            </div>

            <!-- Mobile menu button -->
            <button class="mobile-menu-toggle" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'wp-master-dev' ); ?>">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <!-- Full-Screen Mobile Menu Overlay (TrueHorizon.ai Style) -->
    <div class="mobile-menu-overlay" aria-hidden="true">
        <!-- Background Overlay -->
        <div class="mobile-menu-backdrop"></div>
        
        <!-- Full-Screen Menu Panel - Slides in from Right -->
        <div class="mobile-menu">
            <!-- Menu Header -->
            <div class="mobile-menu-header">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <img src="<?php echo esc_url( $logo_url ); ?>" 
                         alt="<?php echo esc_attr( $logo_alt ); ?>" 
                         class="site-logo"
                         loading="lazy"
                         width="60"
                         height="60">
                </a>
                <button class="mobile-menu-close" aria-label="<?php esc_attr_e( 'Close menu', 'wp-master-dev' ); ?>">
                    &times;
                </button>
            </div>

            <!-- Menu Content -->
            <div class="mobile-menu-content">
                <!-- Navigation Links -->
                <nav class="mobile-nav-menu" aria-label="<?php esc_attr_e( 'Mobile menu', 'wp-master-dev' ); ?>">
                    <?php
                    wp_nav_menu(
                            array(
                                'theme_location' => 'primary',
                                'menu_id'        => 'mobile-primary-menu',
                                'menu_class'     => 'mobile-nav-links',
                                'container'      => false,
                                'walker'         => new WP_Master_Dev_Walker_Mobile_Nav_Menu(),
                                'fallback_cb'    => false,
                            )
                        );
                    ?>
                    
                    <!-- Mobile CTA Button -->
                    <a href="<?php echo esc_url( $contact_url ); ?>" class="cta-button">
                        <?php echo esc_html( get_theme_mod( 'header_cta_text', 'Get Started' ) ); ?>
                    </a>
                </nav>

                <!-- Additional Menu Footer -->
                <div class="mobile-menu-footer">
                    <p class="copyright">
                        &copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Spacer to prevent content from hiding behind fixed nav -->
    <div class="header-spacer"></div>

    <div id="content" class="site-content">
