/**
 * WordPress Master Developer Theme Main JavaScript
 * Additional functionality and interactions
 */

(function($) {
    'use strict';

    // Wait for DOM to be ready
    $(document).ready(function() {
        initContactForm();
        initFAQAccordion();
        initSkillBars();
        initSmoothScrolling();
        initFormValidation();
        initNewsletterForm();
    });

    /**
     * Initialize Contact Form Enhancement
     */
    function initContactForm() {
        const contactForm = $('#contact-form');
        
        if (contactForm.length) {
            // Pre-fill service field from URL parameter
            const urlParams = new URLSearchParams(window.location.search);
            const service = urlParams.get('service');
            
            if (service) {
                $('#contact-service').val(service);
            }
            
            // Form submission handling
            contactForm.on('submit', function(e) {
                const submitButton = $(this).find('button[type="submit"]');
                const originalText = submitButton.text();
                
                // Show loading state
                submitButton.text('Sending...').prop('disabled', true);
                
                // Reset after 3 seconds if form doesn't redirect
                setTimeout(function() {
                    submitButton.text(originalText).prop('disabled', false);
                }, 3000);
            });
        }
    }

    /**
     * Initialize FAQ Accordion
     */
    function initFAQAccordion() {
        $('.faq-question').on('click', function() {
            const faqItem = $(this).closest('.faq-item');
            const faqAnswer = faqItem.find('.faq-answer');
            const toggle = $(this).find('.faq-toggle');
            const isExpanded = $(this).attr('aria-expanded') === 'true';
            
            // Close all other FAQ items
            $('.faq-item').not(faqItem).each(function() {
                $(this).find('.faq-answer').slideUp(300);
                $(this).find('.faq-question').attr('aria-expanded', 'false');
                $(this).find('.faq-answer').attr('aria-hidden', 'true');
                $(this).find('.faq-toggle').text('+');
            });
            
            // Toggle current item
            if (isExpanded) {
                faqAnswer.slideUp(300);
                $(this).attr('aria-expanded', 'false');
                faqAnswer.attr('aria-hidden', 'true');
                toggle.text('+');
            } else {
                faqAnswer.slideDown(300);
                $(this).attr('aria-expanded', 'true');
                faqAnswer.attr('aria-hidden', 'false');
                toggle.text('−');
            }
        });
    }

    /**
     * Initialize Skill Progress Bars
     */
    function initSkillBars() {
        const skillBars = $('.progress-fill');
        
        if (skillBars.length) {
            // Animate skill bars when they come into view
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const progressBar = $(entry.target);
                        const targetWidth = progressBar.css('width');
                        
                        // Reset width and animate
                        progressBar.css('width', '0%');
                        progressBar.animate({
                            width: targetWidth
                        }, 1500, 'easeOutCubic');
                        
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });
            
            skillBars.each(function() {
                observer.observe(this);
            });
        }
    }

    /**
     * Initialize Smooth Scrolling for Internal Links
     */
    function initSmoothScrolling() {
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            const target = $(this.hash);
            
            if (target.length) {
                e.preventDefault();
                
                const headerHeight = $('.site-header').outerHeight() || 0;
                const targetPosition = target.offset().top - headerHeight - 20;
                
                $('html, body').animate({
                    scrollTop: targetPosition
                }, 800, 'easeInOutCubic');
            }
        });
    }

    /**
     * Initialize Form Validation
     */
    function initFormValidation() {
        // Real-time email validation
        $('input[type="email"]').on('blur', function() {
            const email = $(this).val();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                $(this).addClass('error');
                showFieldError($(this), 'Please enter a valid email address');
            } else {
                $(this).removeClass('error');
                hideFieldError($(this));
            }
        });
        
        // Phone number formatting
        $('input[type="tel"]').on('input', function() {
            let value = $(this).val().replace(/\D/g, '');
            
            if (value.length >= 6) {
                value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
            } else if (value.length >= 3) {
                value = value.replace(/(\d{3})(\d{0,3})/, '($1) $2');
            }
            
            $(this).val(value);
        });
        
        // Required field validation
        $('input[required], textarea[required], select[required]').on('blur', function() {
            if (!$(this).val().trim()) {
                $(this).addClass('error');
                showFieldError($(this), 'This field is required');
            } else {
                $(this).removeClass('error');
                hideFieldError($(this));
            }
        });
    }

    /**
     * Show field error message
     */
    function showFieldError(field, message) {
        hideFieldError(field);
        
        const errorElement = $('<span class="field-error">' + message + '</span>');
        field.after(errorElement);
    }

    /**
     * Hide field error message
     */
    function hideFieldError(field) {
        field.siblings('.field-error').remove();
    }

    /**
     * Initialize Newsletter Form
     */
    function initNewsletterForm() {
        $('.newsletter-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const email = form.find('input[type="email"]').val();
            const submitButton = form.find('button[type="submit"]');
            const originalText = submitButton.text();
            
            if (!email) {
                showFormMessage(form, 'Please enter your email address', 'error');
                return;
            }
            
            // Show loading state
            submitButton.text('Subscribing...').prop('disabled', true);
            
            // Simulate newsletter subscription (replace with actual implementation)
            setTimeout(function() {
                showFormMessage(form, 'Thank you for subscribing!', 'success');
                form[0].reset();
                submitButton.text(originalText).prop('disabled', false);
            }, 1500);
        });
    }

    /**
     * Show form message
     */
    function showFormMessage(form, message, type) {
        const messageElement = $('<div class="form-message ' + type + '">' + message + '</div>');
        
        form.find('.form-message').remove();
        form.prepend(messageElement);
        
        setTimeout(function() {
            messageElement.fadeOut(function() {
                $(this).remove();
            });
        }, 5000);
    }

    /**
     * Initialize Lazy Loading for Images
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(function(img) {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Initialize Parallax Effects
     */
    function initParallax() {
        const parallaxElements = $('.parallax');
        
        if (parallaxElements.length) {
            $(window).on('scroll', function() {
                const scrollTop = $(window).scrollTop();
                
                parallaxElements.each(function() {
                    const element = $(this);
                    const speed = element.data('speed') || 0.5;
                    const yPos = -(scrollTop * speed);
                    
                    element.css('transform', 'translateY(' + yPos + 'px)');
                });
            });
        }
    }

    /**
     * Initialize Scroll Animations
     */
    function initScrollAnimations() {
        const animatedElements = $('.animate-on-scroll');
        
        if (animatedElements.length && 'IntersectionObserver' in window) {
            const animationObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        animationObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });
            
            animatedElements.each(function() {
                animationObserver.observe(this);
            });
        }
    }

    /**
     * Initialize Cookie Notice
     */
    function initCookieNotice() {
        const cookieNotice = $('.cookie-notice');
        const cookieAccepted = localStorage.getItem('wp_master_dev_cookies_accepted');
        
        if (cookieNotice.length && !cookieAccepted) {
            cookieNotice.fadeIn();
            
            $('.cookie-accept').on('click', function() {
                localStorage.setItem('wp_master_dev_cookies_accepted', 'true');
                cookieNotice.fadeOut();
            });
        }
    }

    /**
     * Initialize Search Functionality
     */
    function initSearch() {
        const searchToggle = $('.search-toggle');
        const searchForm = $('.search-form');
        const searchInput = searchForm.find('input[type="search"]');
        
        searchToggle.on('click', function(e) {
            e.preventDefault();
            searchForm.toggleClass('active');
            
            if (searchForm.hasClass('active')) {
                searchInput.focus();
            }
        });
        
        // Close search on escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && searchForm.hasClass('active')) {
                searchForm.removeClass('active');
            }
        });
        
        // Close search when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-form, .search-toggle').length) {
                searchForm.removeClass('active');
            }
        });
    }

    /**
     * Initialize all functionality
     */
    function init() {
        initContactForm();
        initFAQAccordion();
        initSkillBars();
        initSmoothScrolling();
        initFormValidation();
        initNewsletterForm();
        initLazyLoading();
        initParallax();
        initScrollAnimations();
        initCookieNotice();
        initSearch();
    }

    // Custom easing functions
    $.easing.easeInOutCubic = function(x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
        return c / 2 * ((t -= 2) * t * t + 2) + b;
    };

    $.easing.easeOutCubic = function(x, t, b, c, d) {
        return c * ((t = t / d - 1) * t * t + 1) + b;
    };

    // Initialize everything when document is ready
    init();

    // Re-initialize on window resize (debounced)
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // Re-initialize responsive elements
            initParallax();
        }, 250);
    });

})(jQuery);
