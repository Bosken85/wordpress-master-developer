/*!
 * WordPress Master Developer Theme - Admin JavaScript
 * Handles admin dashboard functionality and customizer enhancements
 */

(function($) {
    'use strict';

    /**
     * WordPress Master Developer Admin
     */
    class WPMasterDevAdmin {
        constructor() {
            this.init();
        }

        /**
         * Initialize admin functionality
         */
        init() {
            this.setupCustomizer();
            this.setupMediaUploader();
            this.setupColorPicker();
            this.setupThemeInstaller();
            this.setupFormValidation();
        }

        /**
         * Setup customizer enhancements
         */
        setupCustomizer() {
            // Live preview updates
            if (typeof wp !== 'undefined' && wp.customize) {
                this.setupCustomizerPreviews();
            }

            // Customizer controls
            this.setupCustomizerControls();
        }

        /**
         * Setup customizer live previews
         */
        setupCustomizerPreviews() {
            const { customize } = wp;

            // Hero section updates
            customize('hero_title', (value) => {
                value.bind((newval) => {
                    $('.hero-title').text(newval);
                });
            });

            customize('hero_subtitle', (value) => {
                value.bind((newval) => {
                    $('.hero-subtitle').text(newval);
                });
            });

            customize('hero_description', (value) => {
                value.bind((newval) => {
                    $('.hero-description').text(newval);
                });
            });

            customize('hero_button_text', (value) => {
                value.bind((newval) => {
                    $('.hero-cta').text(newval);
                });
            });

            // Color scheme updates
            customize('primary_color', (value) => {
                value.bind((newval) => {
                    this.updateCSSVariable('--color-primary', newval);
                });
            });

            customize('secondary_color', (value) => {
                value.bind((newval) => {
                    this.updateCSSVariable('--color-secondary', newval);
                });
            });

            // Background image updates
            customize('hero_background_image', (value) => {
                value.bind((newval) => {
                    if (newval) {
                        $('.hero-section').css('background-image', `url(${newval})`);
                    }
                });
            });
        }

        /**
         * Update CSS custom property
         */
        updateCSSVariable(property, value) {
            document.documentElement.style.setProperty(property, value);
        }

        /**
         * Setup customizer controls
         */
        setupCustomizerControls() {
            // Enhanced range controls
            $('.customize-control-range input[type="range"]').on('input', function() {
                const $this = $(this);
                const $output = $this.siblings('.range-value');
                $output.text($this.val());
            });

            // Toggle controls
            $('.customize-control-toggle input[type="checkbox"]').on('change', function() {
                const $this = $(this);
                const $dependent = $(`[data-depends="${$this.attr('id')}"]`);
                
                if ($this.is(':checked')) {
                    $dependent.slideDown();
                } else {
                    $dependent.slideUp();
                }
            });
        }

        /**
         * Setup media uploader
         */
        setupMediaUploader() {
            $('.upload-button').on('click', function(e) {
                e.preventDefault();
                
                const $button = $(this);
                const $input = $button.siblings('input[type="hidden"]');
                const $preview = $button.siblings('.image-preview');
                
                // Create media uploader
                const mediaUploader = wp.media({
                    title: 'Select Image',
                    button: {
                        text: 'Use This Image'
                    },
                    multiple: false
                });

                // Handle selection
                mediaUploader.on('select', function() {
                    const attachment = mediaUploader.state().get('selection').first().toJSON();
                    
                    $input.val(attachment.url);
                    $preview.html(`<img src="${attachment.url}" alt="" style="max-width: 200px; height: auto;">`);
                    $button.text('Change Image');
                });

                mediaUploader.open();
            });

            // Remove image button
            $('.remove-image').on('click', function(e) {
                e.preventDefault();
                
                const $button = $(this);
                const $input = $button.siblings('input[type="hidden"]');
                const $preview = $button.siblings('.image-preview');
                const $uploadBtn = $button.siblings('.upload-button');
                
                $input.val('');
                $preview.empty();
                $uploadBtn.text('Select Image');
            });
        }

        /**
         * Setup color picker
         */
        setupColorPicker() {
            if ($.fn.wpColorPicker) {
                $('.color-picker').wpColorPicker({
                    change: function(event, ui) {
                        const color = ui.color.toString();
                        $(this).val(color).trigger('change');
                    }
                });
            }
        }

        /**
         * Setup theme installer
         */
        setupThemeInstaller() {
            // Demo import button
            $('.demo-import-button').on('click', function(e) {
                e.preventDefault();
                
                const $button = $(this);
                const originalText = $button.text();
                
                $button.text('Importing...').prop('disabled', true);
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'wp_master_dev_import_demo',
                        nonce: wpMasterDevAdmin.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            $button.text('Import Complete!').removeClass('button-primary').addClass('button-secondary');
                            
                            // Show success message
                            $('.demo-import-status').html('<div class="notice notice-success"><p>Demo content imported successfully!</p></div>');
                        } else {
                            $button.text(originalText).prop('disabled', false);
                            $('.demo-import-status').html('<div class="notice notice-error"><p>Import failed. Please try again.</p></div>');
                        }
                    },
                    error: function() {
                        $button.text(originalText).prop('disabled', false);
                        $('.demo-import-status').html('<div class="notice notice-error"><p>Import failed. Please try again.</p></div>');
                    }
                });
            });

            // Setup wizard steps
            $('.setup-wizard .next-step').on('click', function(e) {
                e.preventDefault();
                
                const $current = $('.wizard-step.active');
                const $next = $current.next('.wizard-step');
                
                if ($next.length) {
                    $current.removeClass('active');
                    $next.addClass('active');
                }
            });

            $('.setup-wizard .prev-step').on('click', function(e) {
                e.preventDefault();
                
                const $current = $('.wizard-step.active');
                const $prev = $current.prev('.wizard-step');
                
                if ($prev.length) {
                    $current.removeClass('active');
                    $prev.addClass('active');
                }
            });
        }

        /**
         * Setup form validation
         */
        setupFormValidation() {
            // Theme options form validation
            $('#theme-options-form').on('submit', function(e) {
                let isValid = true;
                
                // Validate required fields
                $(this).find('[required]').each(function() {
                    const $field = $(this);
                    
                    if (!$field.val().trim()) {
                        $field.addClass('error');
                        isValid = false;
                    } else {
                        $field.removeClass('error');
                    }
                });

                // Validate email fields
                $(this).find('input[type="email"]').each(function() {
                    const $field = $(this);
                    const email = $field.val().trim();
                    
                    if (email && !isValidEmail(email)) {
                        $field.addClass('error');
                        isValid = false;
                    } else {
                        $field.removeClass('error');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    $('.form-errors').html('<div class="notice notice-error"><p>Please correct the highlighted fields.</p></div>');
                }
            });

            // Real-time validation
            $('input, textarea, select').on('blur', function() {
                const $field = $(this);
                
                if ($field.attr('required') && !$field.val().trim()) {
                    $field.addClass('error');
                } else {
                    $field.removeClass('error');
                }
            });
        }

        /**
         * Show admin notice
         */
        showNotice(message, type = 'success') {
            const $notice = $(`<div class="notice notice-${type} is-dismissible"><p>${message}</p></div>`);
            $('.wrap h1').after($notice);
            
            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                $notice.fadeOut();
            }, 5000);
        }

        /**
         * AJAX helper
         */
        ajaxRequest(action, data = {}) {
            return $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: action,
                    nonce: wpMasterDevAdmin.nonce,
                    ...data
                }
            });
        }
    }

    /**
     * Utility functions
     */
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * Initialize when document is ready
     */
    $(document).ready(function() {
        new WPMasterDevAdmin();
    });

})(jQuery);
