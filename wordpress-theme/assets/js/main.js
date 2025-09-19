/**
 * WordPress Master Developer Theme Main JavaScript
 * Core functionality without jQuery or React dependencies
 * Vanilla JavaScript implementation for WordPress theme
 */

(function() {
    'use strict';

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initTheme();
    });

    /**
     * Initialize all theme functionality
     */
    function initTheme() {
        initContactForm();
        initFAQAccordion();
        initSkillBars();
        initFormValidation();
        initNewsletterForm();
        initAnimations();
        initInteractiveElements();
        initWordPressFeatures();
    }

    /**
     * Initialize Contact Form Enhancement
     */
    function initContactForm() {
        const contactForm = document.getElementById('contact-form');
        
        if (!contactForm) return;

        // Pre-fill service field from URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const service = urlParams.get('service');
        
        if (service) {
            const serviceField = document.getElementById('contact-service');
            if (serviceField) {
                serviceField.value = service;
            }
        }
        
        // Form submission handling
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleContactFormSubmission(this);
        });
    }

    /**
     * Handle contact form submission
     */
    function handleContactFormSubmission(form) {
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        const formData = new FormData(form);

        // Validate form
        if (!validateContactForm(form)) {
            return;
        }

        // Show loading state
        submitButton.textContent = 'Sending...';
        submitButton.disabled = true;
        submitButton.classList.add('loading');

        // Prepare data for WordPress AJAX
        const data = {
            action: 'wp_master_dev_contact_form',
            nonce: window.wpMasterDev?.nonce || '',
            name: formData.get('name'),
            email: formData.get('email'),
            phone: formData.get('phone'),
            service: formData.get('service'),
            budget: formData.get('budget'),
            timeline: formData.get('timeline'),
            message: formData.get('message'),
            newsletter: formData.get('newsletter') ? '1' : '0'
        };

        // Submit via fetch API
        fetch(window.wpMasterDev?.ajaxUrl || '/wp-admin/admin-ajax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                showFormMessage(form, 'success', result.data.message || 'Thank you! Your message has been sent successfully.');
                form.reset();
            } else {
                showFormMessage(form, 'error', result.data.message || 'Sorry, there was an error. Please try again.');
            }
        })
        .catch(error => {
            console.error('Form submission error:', error);
            showFormMessage(form, 'error', 'Sorry, there was an error. Please try again.');
        })
        .finally(() => {
            // Restore button state
            submitButton.textContent = originalText;
            submitButton.disabled = false;
            submitButton.classList.remove('loading');
        });
    }

    /**
     * Validate contact form
     */
    function validateContactForm(form) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(function(field) {
            if (!validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    /**
     * Initialize FAQ Accordion
     */
    function initFAQAccordion() {
        const faqItems = document.querySelectorAll('.faq-item');
        
        faqItems.forEach(function(item) {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');
            
            if (question && answer) {
                question.addEventListener('click', function() {
                    const isOpen = item.classList.contains('active');
                    
                    // Close all other FAQ items
                    faqItems.forEach(function(otherItem) {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                            const otherAnswer = otherItem.querySelector('.faq-answer');
                            const otherQuestion = otherItem.querySelector('.faq-question');
                            if (otherAnswer) otherAnswer.style.maxHeight = null;
                            if (otherQuestion) otherQuestion.setAttribute('aria-expanded', 'false');
                        }
                    });
                    
                    // Toggle current item
                    if (isOpen) {
                        item.classList.remove('active');
                        answer.style.maxHeight = null;
                        question.setAttribute('aria-expanded', 'false');
                    } else {
                        item.classList.add('active');
                        answer.style.maxHeight = answer.scrollHeight + 'px';
                        question.setAttribute('aria-expanded', 'true');
                    }
                });

                // Initialize ARIA attributes
                question.setAttribute('aria-expanded', 'false');
                question.setAttribute('role', 'button');
                question.setAttribute('tabindex', '0');
                
                // Handle keyboard navigation
                question.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            }
        });
    }

    /**
     * Initialize Skill Bars Animation
     */
    function initSkillBars() {
        const skillBars = document.querySelectorAll('.skill-bar');
        
        if (skillBars.length === 0) return;

        // Use Intersection Observer for performance
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        animateSkillBar(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            skillBars.forEach(function(bar) {
                observer.observe(bar);
            });
        } else {
            // Fallback for older browsers
            skillBars.forEach(function(bar) {
                animateSkillBar(bar);
            });
        }
    }

    /**
     * Animate individual skill bar
     */
    function animateSkillBar(skillBar) {
        const progressBar = skillBar.querySelector('.skill-progress');
        const percentage = skillBar.getAttribute('data-percentage') || '0';
        
        if (progressBar) {
            progressBar.style.width = '0%';
            
            setTimeout(function() {
                progressBar.style.transition = 'width 2s ease-in-out';
                progressBar.style.width = percentage + '%';
            }, 100);
        }
    }

    /**
     * Initialize Form Validation
     */
    function initFormValidation() {
        const forms = document.querySelectorAll('form');
        
        forms.forEach(function(form) {
            const inputs = form.querySelectorAll('input, select, textarea');
            
            inputs.forEach(function(input) {
                // Real-time validation on blur
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                // Clear errors on input
                input.addEventListener('input', function() {
                    clearFieldError(this);
                });
            });
        });
    }

    /**
     * Validate individual field
     */
    function validateField(field) {
        const value = field.value.trim();
        const fieldType = field.type;
        const fieldName = field.name;
        let isValid = true;
        let errorMessage = '';

        // Required field validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'This field is required.';
        }
        // Email validation
        else if (fieldType === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Please enter a valid email address.';
            }
        }
        // Phone validation
        else if (fieldName === 'phone' && value) {
            const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
            if (!phoneRegex.test(value.replace(/[\s\-\(\)]/g, ''))) {
                isValid = false;
                errorMessage = 'Please enter a valid phone number.';
            }
        }
        // URL validation
        else if (fieldType === 'url' && value) {
            try {
                new URL(value);
            } catch {
                isValid = false;
                errorMessage = 'Please enter a valid URL.';
            }
        }

        if (isValid) {
            clearFieldError(field);
        } else {
            showFieldError(field, errorMessage);
        }

        return isValid;
    }

    /**
     * Show field error
     */
    function showFieldError(field, message) {
        clearFieldError(field);
        
        field.classList.add('error');
        field.setAttribute('aria-invalid', 'true');
        
        const errorElement = document.createElement('div');
        errorElement.className = 'field-error';
        errorElement.textContent = message;
        errorElement.id = field.id + '-error';
        
        field.setAttribute('aria-describedby', errorElement.id);
        field.parentNode.appendChild(errorElement);
    }

    /**
     * Clear field error
     */
    function clearFieldError(field) {
        field.classList.remove('error');
        field.removeAttribute('aria-invalid');
        
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
    }

    /**
     * Show form message
     */
    function showFormMessage(form, type, message) {
        // Remove existing messages
        const existingMessages = form.querySelectorAll('.form-message');
        existingMessages.forEach(msg => msg.remove());

        // Create new message
        const messageElement = document.createElement('div');
        messageElement.className = `form-message ${type}`;
        messageElement.textContent = message;
        messageElement.setAttribute('role', type === 'error' ? 'alert' : 'status');

        // Insert at top of form
        form.insertBefore(messageElement, form.firstChild);

        // Auto-remove success messages
        if (type === 'success') {
            setTimeout(() => {
                if (messageElement.parentNode) {
                    messageElement.remove();
                }
            }, 5000);
        }

        // Scroll to message
        messageElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    /**
     * Initialize Newsletter Form
     */
    function initNewsletterForm() {
        const newsletterForms = document.querySelectorAll('.newsletter-form');
        
        newsletterForms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                handleNewsletterSubmission(this);
            });
        });
    }

    /**
     * Handle newsletter form submission
     */
    function handleNewsletterSubmission(form) {
        const emailInput = form.querySelector('input[type="email"]');
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;

        if (!validateField(emailInput)) {
            return;
        }

        // Show loading state
        submitButton.textContent = 'Subscribing...';
        submitButton.disabled = true;

        // Simulate API call (replace with actual newsletter service)
        setTimeout(function() {
            showFormMessage(form, 'success', 'Thank you for subscribing to our newsletter!');
            form.reset();
            
            // Restore button
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        }, 1000);
    }

    /**
     * Initialize Animations
     */
    function initAnimations() {
        // Fade in animations for elements
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe elements that should animate
            const animateElements = document.querySelectorAll('.animate-on-scroll, .service-card, .portfolio-item, .expertise-item, .post-card');
            animateElements.forEach(function(el) {
                observer.observe(el);
            });
        }

        // Counter animations
        initCounters();
    }

    /**
     * Initialize counter animations
     */
    function initCounters() {
        const counters = document.querySelectorAll('.counter');
        
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        animateCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            counters.forEach(function(counter) {
                observer.observe(counter);
            });
        }
    }

    /**
     * Animate counter
     */
    function animateCounter(counter) {
        const target = parseInt(counter.getAttribute('data-target')) || 0;
        const duration = parseInt(counter.getAttribute('data-duration')) || 2000;
        const increment = target / (duration / 16); // 60fps
        let current = 0;

        const timer = setInterval(function() {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = Math.floor(current);
        }, 16);
    }

    /**
     * Initialize Interactive Elements
     */
    function initInteractiveElements() {
        // Back to top button
        initBackToTop();
        
        // Image lightbox
        initLightbox();
        
        // Tooltips
        initTooltips();
    }

    /**
     * Initialize back to top button
     */
    function initBackToTop() {
        const backToTopButton = document.querySelector('.back-to-top');
        
        if (!backToTopButton) return;

        // Show/hide based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });

        // Smooth scroll to top
        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    /**
     * Initialize lightbox for images
     */
    function initLightbox() {
        const lightboxImages = document.querySelectorAll('.lightbox-image, .gallery img');
        
        lightboxImages.forEach(function(img) {
            img.addEventListener('click', function(e) {
                e.preventDefault();
                openLightbox(this);
            });
        });
    }

    /**
     * Open lightbox
     */
    function openLightbox(img) {
        const lightbox = document.createElement('div');
        lightbox.className = 'lightbox';
        lightbox.innerHTML = `
            <div class="lightbox-overlay">
                <div class="lightbox-content">
                    <button class="lightbox-close" aria-label="Close lightbox">&times;</button>
                    <img src="${img.src}" alt="${img.alt || ''}" loading="lazy">
                    ${img.alt ? `<div class="lightbox-caption">${img.alt}</div>` : ''}
                </div>
            </div>
        `;
        
        document.body.appendChild(lightbox);
        document.body.classList.add('lightbox-open');
        
        // Close functionality
        const closeBtn = lightbox.querySelector('.lightbox-close');
        const overlay = lightbox.querySelector('.lightbox-overlay');
        
        function closeLightbox() {
            lightbox.remove();
            document.body.classList.remove('lightbox-open');
        }
        
        closeBtn.addEventListener('click', closeLightbox);
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) closeLightbox();
        });
        
        document.addEventListener('keydown', function escHandler(e) {
            if (e.key === 'Escape') {
                closeLightbox();
                document.removeEventListener('keydown', escHandler);
            }
        });
    }

    /**
     * Initialize tooltips
     */
    function initTooltips() {
        const tooltipTriggers = document.querySelectorAll('[data-tooltip]');
        
        tooltipTriggers.forEach(function(trigger) {
            let tooltip;
            
            trigger.addEventListener('mouseenter', function() {
                const text = this.getAttribute('data-tooltip');
                tooltip = createTooltip(text);
                document.body.appendChild(tooltip);
                positionTooltip(this, tooltip);
            });
            
            trigger.addEventListener('mouseleave', function() {
                if (tooltip) {
                    tooltip.remove();
                    tooltip = null;
                }
            });
        });
    }

    /**
     * Create tooltip element
     */
    function createTooltip(text) {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = text;
        tooltip.setAttribute('role', 'tooltip');
        return tooltip;
    }

    /**
     * Position tooltip
     */
    function positionTooltip(trigger, tooltip) {
        const triggerRect = trigger.getBoundingClientRect();
        const tooltipRect = tooltip.getBoundingClientRect();
        
        const left = triggerRect.left + (triggerRect.width / 2) - (tooltipRect.width / 2);
        const top = triggerRect.top - tooltipRect.height - 10;
        
        tooltip.style.left = Math.max(10, left) + 'px';
        tooltip.style.top = Math.max(10, top) + 'px';
    }

    /**
     * Initialize WordPress-specific features
     */
    function initWordPressFeatures() {
        // Handle WordPress comment form
        initCommentForm();
        
        // Handle WordPress search
        initSearchEnhancements();
        
        // Handle WordPress galleries
        initGalleryEnhancements();
    }

    /**
     * Initialize comment form enhancements
     */
    function initCommentForm() {
        const commentForm = document.getElementById('commentform');
        if (!commentForm) return;
        
        const inputs = commentForm.querySelectorAll('input[required], textarea[required]');
        inputs.forEach(function(input) {
            input.addEventListener('blur', function() {
                validateField(this);
            });
        });
    }

    /**
     * Initialize search enhancements
     */
    function initSearchEnhancements() {
        const searchInputs = document.querySelectorAll('input[type="search"]');
        
        searchInputs.forEach(function(input) {
            // Add search icon if not present
            if (!input.parentNode.querySelector('.search-icon')) {
                const icon = document.createElement('span');
                icon.className = 'search-icon';
                icon.innerHTML = '🔍';
                input.parentNode.appendChild(icon);
            }
        });
    }

    /**
     * Initialize gallery enhancements
     */
    function initGalleryEnhancements() {
        const galleries = document.querySelectorAll('.wp-block-gallery, .gallery');
        
        galleries.forEach(function(gallery) {
            const images = gallery.querySelectorAll('img');
            images.forEach(function(img) {
                img.classList.add('lightbox-image');
            });
        });
    }

    /**
     * Utility function: Debounce
     */
    function debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction() {
            const context = this;
            const args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Expose theme functions globally
    window.WPMasterDev = window.WPMasterDev || {};
    window.WPMasterDev.theme = {
        showFormMessage: showFormMessage,
        validateField: validateField,
        openLightbox: openLightbox,
        debounce: debounce
    };

})();
