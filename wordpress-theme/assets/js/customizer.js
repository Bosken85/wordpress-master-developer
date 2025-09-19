/*!
 * WordPress Master Developer Theme - Customizer Preview JavaScript
 * Handles live preview updates in the WordPress customizer
 */

(function($) {
    'use strict';

    // Site title and description
    wp.customize('blogname', function(value) {
        value.bind(function(newval) {
            $('.site-title').text(newval);
        });
    });

    wp.customize('blogdescription', function(value) {
        value.bind(function(newval) {
            $('.site-description').text(newval);
        });
    });

    // Hero section updates
    wp.customize('hero_title', function(value) {
        value.bind(function(newval) {
            $('.hero-title').text(newval);
        });
    });

    wp.customize('hero_subtitle', function(value) {
        value.bind(function(newval) {
            $('.hero-subtitle').text(newval);
        });
    });

    wp.customize('hero_description', function(value) {
        value.bind(function(newval) {
            $('.hero-description').text(newval);
        });
    });

    wp.customize('hero_button_text', function(value) {
        value.bind(function(newval) {
            $('.hero-cta').text(newval);
        });
    });

    // Color updates
    wp.customize('primary_color', function(value) {
        value.bind(function(newval) {
            updateCSSVariable('--primary-color', newval);
        });
    });

    wp.customize('accent_color', function(value) {
        value.bind(function(newval) {
            updateCSSVariable('--accent-color', newval);
        });
    });

    // Container width
    wp.customize('container_width', function(value) {
        value.bind(function(newval) {
            updateCSSVariable('--container-width', newval + 'px');
        });
    });

    // Footer updates
    wp.customize('footer_copyright', function(value) {
        value.bind(function(newval) {
            $('.footer-copyright').html(newval);
        });
    });

    wp.customize('footer_description', function(value) {
        value.bind(function(newval) {
            $('.footer-description').text(newval);
        });
    });

    /**
     * Update CSS custom property
     */
    function updateCSSVariable(property, value) {
        document.documentElement.style.setProperty(property, value);
    }

})(jQuery);
