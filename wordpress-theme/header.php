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
                        'fallback_cb'    => 'wp_master_dev_default_menu',
                        'walker'         => new WP_Master_Dev_Walker_Nav_Menu(),
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
                            'fallback_cb'    => 'wp_master_dev_mobile_default_menu',
                            'walker'         => new WP_Master_Dev_Walker_Mobile_Nav_Menu(),
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

<?php
/**
 * Default menu fallback for desktop navigation
 */
function wp_master_dev_default_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '" class="' . ( is_front_page() ? 'active' : '' ) . '">Home</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/about' ) ) . '" class="' . ( is_page( 'about' ) ? 'active' : '' ) . '">About Us</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/services' ) ) . '" class="' . ( is_page( 'services' ) ? 'active' : '' ) . '">Services</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/contact' ) ) . '" class="' . ( is_page( 'contact' ) ? 'active' : '' ) . '">Contact</a></li>';
    echo '</ul>';
}

/**
 * Default menu fallback for mobile navigation
 */
function wp_master_dev_mobile_default_menu() {
    echo '<div class="mobile-nav-links">';
    echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="' . ( is_front_page() ? 'active' : '' ) . '">Home</a>';
    echo '<a href="' . esc_url( home_url( '/about' ) ) . '" class="' . ( is_page( 'about' ) ? 'active' : '' ) . '">About Us</a>';
    echo '<a href="' . esc_url( home_url( '/services' ) ) . '" class="' . ( is_page( 'services' ) ? 'active' : '' ) . '">Services</a>';
    echo '<a href="' . esc_url( home_url( '/contact' ) ) . '" class="' . ( is_page( 'contact' ) ? 'active' : '' ) . '">Contact</a>';
    echo '</div>';
}

/**
 * Custom Walker for Desktop Navigation Menu
 */
class WP_Master_Dev_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        
        // Add active class for current page
        if ( in_array( 'current-menu-item', $classes ) || in_array( 'current_page_item', $classes ) ) {
            $class_names .= ' active';
        }
        
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $item_output = isset( $args->before ) ? $args->before : '';
        $item_output .= '<a' . $attributes .'>';
        $item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . apply_filters( 'the_title', $item->title, $item->ID ) . ( isset( $args->link_after ) ? $args->link_after : '' );
        $item_output .= '</a>';
        $item_output .= isset( $args->after ) ? $args->after : '';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}

/**
 * Custom Walker for Mobile Navigation Menu
 */
class WP_Master_Dev_Walker_Mobile_Nav_Menu extends Walker_Nav_Menu {
    
    function start_lvl( &$output, $depth = 0, $args = null ) {
        // No sub-menus in mobile for simplicity
    }

    function end_lvl( &$output, $depth = 0, $args = null ) {
        // No sub-menus in mobile for simplicity
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        if ( $depth > 0 ) return; // Only show top-level items in mobile

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        
        // Add active class for current page
        $active_class = '';
        if ( in_array( 'current-menu-item', $classes ) || in_array( 'current_page_item', $classes ) ) {
            $active_class = ' active';
        }

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $output .= '<a' . $attributes . ' class="mobile-nav-link' . $active_class . '">';
        $output .= apply_filters( 'the_title', $item->title, $item->ID );
        $output .= '</a>';
    }

    function end_el( &$output, $item, $depth = 0, $args = null ) {
        // No closing tag needed for mobile links
    }
}
?>
