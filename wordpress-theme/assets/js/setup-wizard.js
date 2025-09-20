/**
 * WordPress Master Developer Theme - Setup Wizard JavaScript
 * 
 * Handles the interactive setup wizard functionality including:
 * - Plugin installation and activation
 * - Step navigation
 * - Progress tracking
 * - AJAX interactions
 * 
 * @package WordPress_Master_Developer
 * @version 1.0.0
 */

(function($) {
    'use strict';

    const SetupWizard = {
        currentStep: 1,
        totalSteps: 4,
        requiredPluginsReady: false,

        /**
         * Initialize the setup wizard
         */
        init: function() {
            this.bindEvents();
            this.checkPluginStatuses();
            this.updateProgress();
        },

        /**
         * Bind event handlers
         */
        bindEvents: function() {
            // Plugin installation buttons
            $(document).on('click', '.install-plugin', this.installPlugin.bind(this));
            $(document).on('click', '.activate-plugin', this.activatePlugin.bind(this));
            
            // Step navigation buttons
            $('#install-required-plugins').on('click', this.installRequiredPlugins.bind(this));
            $('#install-selected-optional').on('click', this.installOptionalPlugins.bind(this));
            $('#skip-to-step-2').on('click', () => this.goToStep(2));
            $('#back-to-step-1').on('click', () => this.goToStep(1));
            $('#save-theme-options').on('click', this.saveThemeOptions.bind(this));
            $('#skip-to-step-3').on('click', () => this.goToStep(3));
            $('#back-to-step-2').on('click', () => this.goToStep(2));
            $('#import-demo-content').on('click', this.importDemoContent.bind(this));
            $('#skip-import').on('click', () => this.goToStep(4));
            $('#restart-wizard').on('click', () => this.goToStep(1));
        },

        /**
         * Navigate to a specific step
         */
        goToStep: function(step) {
            // Hide all steps
            $('.setup-step').hide();
            
            // Show target step
            $(`#step-${this.getStepName(step)}`).show();
            
            // Update progress
            this.currentStep = step;
            this.updateProgress();
            
            // Update step indicators
            $('.progress-step').removeClass('active completed');
            for (let i = 1; i < step; i++) {
                $(`.progress-step[data-step="${i}"]`).addClass('completed');
            }
            $(`.progress-step[data-step="${step}"]`).addClass('active');
        },

        /**
         * Get step name by number
         */
        getStepName: function(step) {
            const stepNames = {
                1: 'plugins',
                2: 'theme-options',
                3: 'content-import',
                4: 'complete'
            };
            return stepNames[step] || 'plugins';
        },

        /**
         * Update progress bar
         */
        updateProgress: function() {
            const percentage = (this.currentStep / this.totalSteps) * 100;
            $('.progress-fill').css('width', percentage + '%');
        },

        /**
         * Check plugin installation and activation statuses
         */
        checkPluginStatuses: function() {
            $.ajax({
                url: wpMasterDevSetup.ajaxurl,
                type: 'POST',
                data: {
                    action: 'wp_master_dev_check_plugins',
                    nonce: wpMasterDevSetup.nonce
                },
                success: (response) => {
                    if (response.success) {
                        this.updatePluginStatuses(response.data.statuses);
                        this.requiredPluginsReady = response.data.required_ready;
                        this.updateNavigationButtons();
                    }
                }
            });
        },

        /**
         * Update plugin status indicators
         */
        updatePluginStatuses: function(statuses) {
            Object.keys(statuses).forEach(slug => {
                const status = statuses[slug];
                const $pluginItem = $(`.plugin-item[data-slug="${slug}"]`);
                
                // Remove all status classes
                $pluginItem.removeClass('not-installed inactive active');
                
                // Add appropriate status class
                if (status.active) {
                    $pluginItem.addClass('active');
                    $pluginItem.find('.status-badge').removeClass('not-installed inactive').addClass('active').text(wpMasterDevSetup.strings.activated);
                    $pluginItem.find('.plugin-actions').html('<span class="plugin-active-indicator">✓ Ready</span>');
                } else if (status.installed) {
                    $pluginItem.addClass('inactive');
                    $pluginItem.find('.status-badge').removeClass('not-installed active').addClass('inactive').text(wpMasterDevSetup.strings.installed);
                    $pluginItem.find('.plugin-actions').html(`<button type="button" class="button activate-plugin" data-plugin-file="${$pluginItem.data('plugin-file')}">Activate</button>`);
                } else {
                    $pluginItem.addClass('not-installed');
                    $pluginItem.find('.status-badge').removeClass('inactive active').addClass('not-installed').text('Not Installed');
                    $pluginItem.find('.plugin-actions').html(`<button type="button" class="button install-plugin" data-slug="${slug}">Install</button>`);
                }
            });
        },

        /**
         * Update navigation button states
         */
        updateNavigationButtons: function() {
            if (this.requiredPluginsReady) {
                $('#skip-to-step-2').prop('disabled', false).removeClass('button-secondary').addClass('button-primary');
                $('#install-required-plugins').prop('disabled', true).text('All Required Plugins Ready');
            } else {
                $('#skip-to-step-2').prop('disabled', true).removeClass('button-primary').addClass('button-secondary');
                $('#install-required-plugins').prop('disabled', false);
            }
        },

        /**
         * Install a single plugin
         */
        installPlugin: function(e) {
            e.preventDefault();
            const $button = $(e.currentTarget);
            const slug = $button.data('slug');
            
            $button.prop('disabled', true).text(wpMasterDevSetup.strings.installing);
            
            $.ajax({
                url: wpMasterDevSetup.ajaxurl,
                type: 'POST',
                data: {
                    action: 'wp_master_dev_install_plugin',
                    slug: slug,
                    nonce: wpMasterDevSetup.nonce
                },
                success: (response) => {
                    if (response.success) {
                        $button.text(wpMasterDevSetup.strings.installed);
                        // Check statuses again to update UI
                        setTimeout(() => this.checkPluginStatuses(), 1000);
                    } else {
                        $button.prop('disabled', false).text(wpMasterDevSetup.strings.retry);
                        this.showError(response.data.message);
                    }
                },
                error: () => {
                    $button.prop('disabled', false).text(wpMasterDevSetup.strings.retry);
                    this.showError('Installation failed. Please try again.');
                }
            });
        },

        /**
         * Activate a single plugin
         */
        activatePlugin: function(e) {
            e.preventDefault();
            const $button = $(e.currentTarget);
            const pluginFile = $button.data('plugin-file');
            
            $button.prop('disabled', true).text(wpMasterDevSetup.strings.activating);
            
            $.ajax({
                url: wpMasterDevSetup.ajaxurl,
                type: 'POST',
                data: {
                    action: 'wp_master_dev_activate_plugin',
                    plugin_file: pluginFile,
                    nonce: wpMasterDevSetup.nonce
                },
                success: (response) => {
                    if (response.success) {
                        $button.text(wpMasterDevSetup.strings.activated);
                        // Check statuses again to update UI
                        setTimeout(() => this.checkPluginStatuses(), 1000);
                    } else {
                        $button.prop('disabled', false).text(wpMasterDevSetup.strings.retry);
                        this.showError(response.data.message);
                    }
                },
                error: () => {
                    $button.prop('disabled', false).text(wpMasterDevSetup.strings.retry);
                    this.showError('Activation failed. Please try again.');
                }
            });
        },

        /**
         * Install all required plugins
         */
        installRequiredPlugins: function(e) {
            e.preventDefault();
            const $requiredPlugins = $('.required-plugins .plugin-item:not(.active)');
            
            if ($requiredPlugins.length === 0) {
                this.goToStep(2);
                return;
            }
            
            let completed = 0;
            const total = $requiredPlugins.length;
            
            $requiredPlugins.each((index, element) => {
                const $plugin = $(element);
                const slug = $plugin.data('slug');
                const $button = $plugin.find('.install-plugin, .activate-plugin');
                
                if ($button.hasClass('install-plugin')) {
                    // Install plugin
                    this.installPluginPromise(slug).then(() => {
                        completed++;
                        if (completed === total) {
                            setTimeout(() => this.checkPluginStatuses(), 2000);
                        }
                    });
                } else if ($button.hasClass('activate-plugin')) {
                    // Activate plugin
                    const pluginFile = $button.data('plugin-file');
                    this.activatePluginPromise(pluginFile).then(() => {
                        completed++;
                        if (completed === total) {
                            setTimeout(() => this.checkPluginStatuses(), 2000);
                        }
                    });
                }
            });
        },

        /**
         * Install selected optional plugins
         */
        installOptionalPlugins: function(e) {
            e.preventDefault();
            const selectedPlugins = $('input[name="optional_plugins[]"]:checked').map(function() {
                return this.value;
            }).get();
            
            if (selectedPlugins.length === 0) {
                this.showError('Please select at least one optional plugin to install.');
                return;
            }
            
            selectedPlugins.forEach(slug => {
                const $plugin = $(`.plugin-item[data-slug="${slug}"]`);
                const $button = $plugin.find('.install-plugin, .activate-plugin');
                
                if ($button.hasClass('install-plugin')) {
                    this.installPluginPromise(slug);
                } else if ($button.hasClass('activate-plugin')) {
                    const pluginFile = $button.data('plugin-file');
                    this.activatePluginPromise(pluginFile);
                }
            });
            
            setTimeout(() => this.checkPluginStatuses(), 3000);
        },

        /**
         * Promise-based plugin installation
         */
        installPluginPromise: function(slug) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: wpMasterDevSetup.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'wp_master_dev_install_plugin',
                        slug: slug,
                        nonce: wpMasterDevSetup.nonce
                    },
                    success: (response) => {
                        if (response.success) {
                            resolve(response);
                        } else {
                            reject(response);
                        }
                    },
                    error: reject
                });
            });
        },

        /**
         * Promise-based plugin activation
         */
        activatePluginPromise: function(pluginFile) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: wpMasterDevSetup.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'wp_master_dev_activate_plugin',
                        plugin_file: pluginFile,
                        nonce: wpMasterDevSetup.nonce
                    },
                    success: (response) => {
                        if (response.success) {
                            resolve(response);
                        } else {
                            reject(response);
                        }
                    },
                    error: reject
                });
            });
        },

        /**
         * Save theme options
         */
        saveThemeOptions: function(e) {
            e.preventDefault();
            const $button = $(e.currentTarget);
            
            const formData = {
                action: 'wp_master_dev_setup_theme_options',
                logo_url: $('#site-logo-url').val(),
                primary_color: $('#primary-color').val(),
                secondary_color: $('#secondary-color').val(),
                container_width: $('#container-width').val(),
                nonce: wpMasterDevSetup.nonce
            };
            
            $button.prop('disabled', true).text('Saving...');
            
            $.ajax({
                url: wpMasterDevSetup.ajaxurl,
                type: 'POST',
                data: formData,
                success: (response) => {
                    if (response.success) {
                        $button.text('Saved!');
                        $('#skip-to-step-3').prop('disabled', false).removeClass('button-secondary').addClass('button-primary');
                        setTimeout(() => {
                            $button.prop('disabled', false).text('Save Theme Options');
                        }, 2000);
                    } else {
                        $button.prop('disabled', false).text('Save Theme Options');
                        this.showError(response.data.message);
                    }
                },
                error: () => {
                    $button.prop('disabled', false).text('Save Theme Options');
                    this.showError('Failed to save theme options. Please try again.');
                }
            });
        },

        /**
         * Import demo content
         */
        importDemoContent: function(e) {
            e.preventDefault();
            const $button = $(e.currentTarget);
            
            $button.prop('disabled', true).text(wpMasterDevSetup.strings.importing);
            
            $.ajax({
                url: wpMasterDevSetup.ajaxurl,
                type: 'POST',
                data: {
                    action: 'wp_master_dev_import_demo_content',
                    nonce: wpMasterDevSetup.nonce
                },
                success: (response) => {
                    if (response.success) {
                        $button.text(wpMasterDevSetup.strings.complete);
                        setTimeout(() => this.goToStep(4), 1000);
                    } else {
                        $button.prop('disabled', false).text('Import Demo Content');
                        this.showError(response.data.message);
                    }
                },
                error: () => {
                    $button.prop('disabled', false).text('Import Demo Content');
                    this.showError('Failed to import demo content. Please try again.');
                }
            });
        },

        /**
         * Show error message
         */
        showError: function(message) {
            // Create or update error notice
            let $notice = $('.setup-wizard-error');
            if ($notice.length === 0) {
                $notice = $('<div class="notice notice-error setup-wizard-error"><p></p></div>');
                $('.setup-wizard-container').prepend($notice);
            }
            
            $notice.find('p').text(message);
            $notice.show();
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                $notice.fadeOut();
            }, 5000);
        },

        /**
         * Show success message
         */
        showSuccess: function(message) {
            // Create or update success notice
            let $notice = $('.setup-wizard-success');
            if ($notice.length === 0) {
                $notice = $('<div class="notice notice-success setup-wizard-success"><p></p></div>');
                $('.setup-wizard-container').prepend($notice);
            }
            
            $notice.find('p').text(message);
            $notice.show();
            
            // Auto-hide after 3 seconds
            setTimeout(() => {
                $notice.fadeOut();
            }, 3000);
        }
    };

    // Initialize when document is ready
    $(document).ready(function() {
        SetupWizard.init();
    });

})(jQuery);
