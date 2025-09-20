/*!
 * WordPress Master Developer Theme - Custom JavaScript
 * Version: 1.0.0
 * Requires Bootstrap 5.3.2 from CDN
 */

(function($) {
    'use strict';

    // Theme object
    const WPMasterDev = {
        
        // Initialize theme
        init: function() {
            this.mobileNavigation();
            this.smoothScrolling();
            this.contactForm();
            this.skillBars();
            this.lazyLoading();
        },

        // Mobile navigation toggle
        mobileNavigation: function() {
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');
            
            if (navbarToggler && navbarCollapse) {
                navbarToggler.addEventListener('click', function() {
                    navbarCollapse.classList.toggle('show');
                });

                // Close mobile menu when clicking on a link
                const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
                navLinks.forEach(function(link) {
                    link.addEventListener('click', function() {
                        if (window.innerWidth < 992) {
                            navbarCollapse.classList.remove('show');
                        }
                    });
                });

                // Close mobile menu when clicking outside
                document.addEventListener('click', function(e) {
                    if (!navbarToggler.contains(e.target) && !navbarCollapse.contains(e.target)) {
                        navbarCollapse.classList.remove('show');
                    }
                });
            }
        },

        // Smooth scrolling for anchor links
        smoothScrolling: function() {
            const links = document.querySelectorAll('a[href^="#"]');
            
            links.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    
                    if (href === '#') return;
                    
                    const target = document.querySelector(href);
                    
                    if (target) {
                        e.preventDefault();
                        
                        const offsetTop = target.offsetTop - 80; // Account for fixed header
                        
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        },

        // Contact form handling
        contactForm: function() {
            const contactForm = document.querySelector('#contact-form');
            
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton.textContent;
                    
                    // Show loading state
                    submitButton.textContent = 'Sending...';
                    submitButton.disabled = true;
                    
                    // Send form data via AJAX
                    fetch(wpMasterDev.ajaxUrl, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.reset();
                            WPMasterDev.showMessage('Thank you! Your message has been sent successfully.', 'success');
                        } else {
                            WPMasterDev.showMessage(data.data.message || 'An error occurred. Please try again.', 'error');
                        }
                    })
                    .catch(error => {
                        WPMasterDev.showMessage('An error occurred. Please try again.', 'error');
                    })
                    .finally(() => {
                        submitButton.textContent = originalText;
                        submitButton.disabled = false;
                    });
                });
            }
        },

        // Animate skill bars when they come into view
        skillBars: function() {
            const skillBars = document.querySelectorAll('.progress-bar');
            
            if (skillBars.length > 0) {
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            const progressBar = entry.target;
                            const width = progressBar.style.width;
                            
                            progressBar.style.width = '0%';
                            
                            setTimeout(function() {
                                progressBar.style.width = width;
                            }, 100);
                            
                            observer.unobserve(progressBar);
                        }
                    });
                }, {
                    threshold: 0.5
                });
                
                skillBars.forEach(function(bar) {
                    observer.observe(bar);
                });
            }
        },

        // Lazy loading for images
        lazyLoading: function() {
            const images = document.querySelectorAll('img[data-src]');
            
            if (images.length > 0) {
                const imageObserver = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    });
                });
                
                images.forEach(function(img) {
                    imageObserver.observe(img);
                });
            }
        },

        // Show message to user
        showMessage: function(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            const container = document.querySelector('.contact-form') || document.querySelector('.container');
            
            if (container) {
                container.insertAdjacentHTML('afterbegin', alertHtml);
                
                // Auto-dismiss after 5 seconds
                setTimeout(function() {
                    const alert = container.querySelector('.alert');
                    if (alert) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000);
            }
        },

        // Utility function to debounce events
        debounce: function(func, wait, immediate) {
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
    };

    // Initialize theme when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        WPMasterDev.init();
    });

    // Handle window resize events
    window.addEventListener('resize', WPMasterDev.debounce(function() {
        // Close mobile menu on resize to desktop
        if (window.innerWidth >= 992) {
            const navbarCollapse = document.querySelector('.navbar-collapse');
            if (navbarCollapse) {
                navbarCollapse.classList.remove('show');
            }
        }
    }, 250));

    // Make WPMasterDev available globally
    window.WPMasterDev = WPMasterDev;

})(jQuery);
