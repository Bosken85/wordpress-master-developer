/*!
 * WordPress Master Developer Theme - Customizer Controls JavaScript
 * Handles customizer control enhancements and interactions
 */

(function($) {
    'use strict';

    wp.customize.bind('ready', function() {
        
        // Enhanced range controls
        $('.customize-control-range input[type="range"]').each(function() {
            const $range = $(this);
            const $output = $('<span class="range-value"></span>');
            
            $range.after($output);
            $output.text($range.val());
            
            $range.on('input', function() {
                $output.text($(this).val());
            });
        });

        // Toggle dependent controls
        $('.customize-control input[type="checkbox"]').each(function() {
            const $checkbox = $(this);
            const controlId = $checkbox.attr('id');
            const $dependents = $('[data-depends="' + controlId + '"]');
            
            function toggleDependents() {
                if ($checkbox.is(':checked')) {
                    $dependents.slideDown(200);
                } else {
                    $dependents.slideUp(200);
                }
            }
            
            // Initial state
            toggleDependents();
            
            // On change
            $checkbox.on('change', toggleDependents);
        });

        // Color picker enhancements
        $('.customize-control-color .wp-color-picker').each(function() {
            const $picker = $(this);
            
            $picker.wpColorPicker({
                change: function(event, ui) {
                    const color = ui.color.toString();
                    $picker.val(color).trigger('change');
                },
                clear: function() {
                    $picker.val('').trigger('change');
                }
            });
        });

        // Image upload preview enhancements
        $('.customize-control-image .thumbnail-image img').on('load', function() {
            $(this).fadeIn(200);
        });

        // Section navigation
        $('.customize-control-nav button').on('click', function(e) {
            e.preventDefault();
            
            const targetSection = $(this).data('section');
            if (targetSection) {
                wp.customize.section(targetSection).focus();
            }
        });

        // Reset to defaults
        $('.customize-control-reset button').on('click', function(e) {
            e.preventDefault();
            
            const $button = $(this);
            const settingId = $button.data('setting');
            
            if (settingId && wp.customize(settingId)) {
                const defaultValue = wp.customize(settingId).get();
                wp.customize(settingId).set(defaultValue);
                
                // Visual feedback
                $button.text('Reset!').prop('disabled', true);
                setTimeout(function() {
                    $button.text('Reset to Default').prop('disabled', false);
                }, 1000);
            }
        });

        // Live preview toggle
        $('.customize-control-preview-toggle input[type="checkbox"]').on('change', function() {
            const isEnabled = $(this).is(':checked');
            
            if (isEnabled) {
                wp.customize.previewer.refresh();
            }
        });

        // Conditional sections
        function handleConditionalSections() {
            // Show/hide sections based on other settings
            wp.customize('boxed_layout', function(value) {
                value.bind(function(newval) {
                    const $boxedSection = wp.customize.section('wp_master_dev_boxed_options');
                    
                    if (newval && $boxedSection) {
                        $boxedSection.activate();
                    } else if ($boxedSection) {
                        $boxedSection.deactivate();
                    }
                });
            });
        }

        // Initialize conditional sections
        handleConditionalSections();

        // Enhanced typography controls
        $('.customize-control-typography select').on('change', function() {
            const $select = $(this);
            const fontFamily = $select.val();
            
            // Update preview
            if (fontFamily && wp.customize.previewer) {
                wp.customize.previewer.send('font-family-change', {
                    family: fontFamily,
                    selector: $select.data('selector') || 'body'
                });
            }
        });

        // Responsive preview helpers
        $('.customize-control-responsive .responsive-switchers button').on('click', function(e) {
            e.preventDefault();
            
            const device = $(this).data('device');
            
            // Switch customizer preview device
            if (wp.customize.previewedDevice) {
                wp.customize.previewedDevice.set(device);
            }
            
            // Update active state
            $(this).addClass('active').siblings().removeClass('active');
        });

        // Import/Export functionality
        $('.customize-control-import-export .import-button').on('click', function(e) {
            e.preventDefault();
            
            const $input = $(this).siblings('input[type="file"]');
            $input.trigger('click');
        });

        $('.customize-control-import-export input[type="file"]').on('change', function() {
            const file = this.files[0];
            
            if (file && file.type === 'application/json') {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    try {
                        const settings = JSON.parse(e.target.result);
                        
                        // Import settings
                        Object.keys(settings).forEach(function(key) {
                            if (wp.customize(key)) {
                                wp.customize(key).set(settings[key]);
                            }
                        });
                        
                        // Show success message
                        $('.customize-control-import-export .import-status')
                            .text('Settings imported successfully!')
                            .addClass('success')
                            .fadeIn();
                            
                    } catch (error) {
                        $('.customize-control-import-export .import-status')
                            .text('Error importing settings.')
                            .addClass('error')
                            .fadeIn();
                    }
                };
                
                reader.readAsText(file);
            }
        });

        $('.customize-control-import-export .export-button').on('click', function(e) {
            e.preventDefault();
            
            const settings = {};
            
            // Collect all theme mod settings
            wp.customize.each(function(setting) {
                if (setting.id.indexOf('wp_master_dev_') === 0) {
                    settings[setting.id] = setting.get();
                }
            });
            
            // Create download
            const dataStr = JSON.stringify(settings, null, 2);
            const dataBlob = new Blob([dataStr], {type: 'application/json'});
            const url = URL.createObjectURL(dataBlob);
            
            const link = document.createElement('a');
            link.href = url;
            link.download = 'wp-master-dev-settings.json';
            link.click();
            
            URL.revokeObjectURL(url);
        });

    });

})(jQuery);
