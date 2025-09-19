/**
 * WordPress Master Developer Theme Navigation
 * Vanilla JavaScript for navigation functionality without React dependencies
 * Optimized for performance and accessibility
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        initNavigation();
    });

    /**
     * Initialize all navigation functionality
     */
    function initNavigation() {
        initMobileMenu();
        initHeaderScroll();
        initSmoothScrolling();
        initAccessibility();
        initPerformanceOptimizations();
    }

    /**
     * Initialize Mobile Menu Functionality
     * Full-screen slide-in menu from right (TrueHorizon.ai style)
     */
    function initMobileMenu() {
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const mobileMenu = document.querySelector('.mobile-menu');
        const mobileOverlay = document.querySelector('.mobile-menu-overlay');
        const mobileClose = document.querySelector('.mobile-menu-close');
        const mobileLinks = document.querySelectorAll('.mobile-nav-menu a');
        const body = document.body;

        if (!mobileToggle || !mobileMenu || !mobileOverlay) {
            return;
        }

        // Toggle mobile menu
        function toggleMobileMenu() {
            const isActive = mobileMenu.classList.contains('active');
            
            if (isActive) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        }

        // Open mobile menu with full-screen slide-in effect
        function openMobileMenu() {
            // Add active classes for animation
            mobileToggle.classList.add('active');
            mobileMenu.classList.add('active');
            mobileOverlay.classList.add('active');
            body.classList.add('mobile-menu-open');
            
            // Update ARIA attributes
            mobileToggle.setAttribute('aria-expanded', 'true');
            mobileMenu.setAttribute('aria-hidden', 'false');
            
            // Prevent body scroll
            body.style.overflow = 'hidden';
            
            // Focus management for accessibility
            setTimeout(function() {
                const firstFocusable = mobileMenu.querySelector('a, button');
                if (firstFocusable) {
                    firstFocusable.focus();
                }
            }, 300); // Wait for animation to complete
        }

        // Close mobile menu
        function closeMobileMenu() {
            // Remove active classes
            mobileToggle.classList.remove('active');
            mobileMenu.classList.remove('active');
            mobileOverlay.classList.remove('active');
            body.classList.remove('mobile-menu-open');
            
            // Update ARIA attributes
            mobileToggle.setAttribute('aria-expanded', 'false');
            mobileMenu.setAttribute('aria-hidden', 'true');
            
            // Restore body scroll
            body.style.overflow = '';
            
            // Return focus to toggle button
            mobileToggle.focus();
        }

        // Event listeners
        mobileToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMobileMenu();
        });

        if (mobileClose) {
            mobileClose.addEventListener('click', function(e) {
                e.preventDefault();
                closeMobileMenu();
            });
        }

        // Close menu when clicking overlay background
        mobileOverlay.addEventListener('click', function(e) {
            if (e.target === mobileOverlay) {
                closeMobileMenu();
            }
        });

        // Close menu when clicking navigation links
        mobileLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                // Small delay to allow navigation to start
                setTimeout(closeMobileMenu, 150);
            });
        });

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
                closeMobileMenu();
            }
        });

        // Handle window resize - close menu if switching to desktop
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth > 768 && mobileMenu.classList.contains('active')) {
                    closeMobileMenu();
                }
            }, 250);
        });

        // Trap focus within mobile menu when open
        trapFocus(mobileMenu);
    }

    /**
     * Initialize Header Scroll Effects
     */
    function initHeaderScroll() {
        const header = document.querySelector('.site-header');
        
        if (!header) {
            return;
        }

        let lastScrollTop = 0;
        let ticking = false;

        function updateHeader() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Add scrolled class for styling
            if (scrollTop > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            lastScrollTop = scrollTop;
            ticking = false;
        }

        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(updateHeader);
                ticking = true;
            }
        }

        // Use passive listener for better performance
        window.addEventListener('scroll', requestTick, { passive: true });
    }

    /**
     * Initialize Smooth Scrolling for Anchor Links
     */
    function initSmoothScrolling() {
        const anchorLinks = document.querySelectorAll('a[href*="#"]');
        
        anchorLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                // Skip if it's just "#" or external link
                if (href === '#' || href.indexOf('http') === 0) {
                    return;
                }
                
                const hashIndex = href.indexOf('#');
                if (hashIndex === -1) return;
                
                const hash = href.substring(hashIndex);
                const target = document.querySelector(hash);
                
                if (target) {
                    e.preventDefault();
                    smoothScrollTo(target);
                }
            });
        });

        // Handle skip link
        const skipLink = document.querySelector('.skip-link');
        if (skipLink) {
            skipLink.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.focus();
                    smoothScrollTo(target);
                }
            });
        }
    }

    /**
     * Smooth scroll to element with header offset
     */
    function smoothScrollTo(target) {
        if (!target) return;

        const header = document.querySelector('.site-header');
        const headerHeight = header ? header.offsetHeight : 0;
        const targetPosition = target.offsetTop - headerHeight - 20;

        window.scrollTo({
            top: Math.max(0, targetPosition),
            behavior: 'smooth'
        });
    }

    /**
     * Initialize Accessibility Features
     */
    function initAccessibility() {
        // Enhance keyboard navigation for main menu
        const menuItems = document.querySelectorAll('.nav-menu li');
        menuItems.forEach(function(item) {
            const link = item.querySelector('a');
            const submenu = item.querySelector('.sub-menu');
            
            if (link && submenu) {
                // Handle keyboard navigation for dropdowns
                link.addEventListener('keydown', function(e) {
                    switch(e.key) {
                        case 'ArrowDown':
                            e.preventDefault();
                            const firstSubmenuItem = submenu.querySelector('a');
                            if (firstSubmenuItem) {
                                firstSubmenuItem.focus();
                            }
                            break;
                        case 'Escape':
                            this.focus();
                            break;
                    }
                });

                // Mouse events for dropdown
                item.addEventListener('mouseenter', function() {
                    this.classList.add('hover');
                });

                item.addEventListener('mouseleave', function() {
                    this.classList.remove('hover');
                });
            }
        });

        // Enhance form accessibility
        enhanceFormAccessibility();
    }

    /**
     * Enhance form accessibility
     */
    function enhanceFormAccessibility() {
        const forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(function(input) {
                // Add proper ARIA attributes
                if (input.hasAttribute('required')) {
                    input.setAttribute('aria-required', 'true');
                }

                // Handle validation states
                input.addEventListener('invalid', function() {
                    this.setAttribute('aria-invalid', 'true');
                });

                input.addEventListener('input', function() {
                    if (this.validity.valid) {
                        this.removeAttribute('aria-invalid');
                    }
                });
            });
        });
    }

    /**
     * Trap focus within an element (for modal-like behavior)
     */
    function trapFocus(element) {
        const focusableElements = element.querySelectorAll(
            'a[href], button:not([disabled]), textarea:not([disabled]), input[type="text"]:not([disabled]), input[type="radio"]:not([disabled]), input[type="checkbox"]:not([disabled]), select:not([disabled])'
        );
        
        if (focusableElements.length === 0) return;

        const firstFocusableElement = focusableElements[0];
        const lastFocusableElement = focusableElements[focusableElements.length - 1];

        element.addEventListener('keydown', function(e) {
            if (e.key !== 'Tab') return;

            if (e.shiftKey) {
                // Shift + Tab (backwards)
                if (document.activeElement === firstFocusableElement) {
                    lastFocusableElement.focus();
                    e.preventDefault();
                }
            } else {
                // Tab (forwards)
                if (document.activeElement === lastFocusableElement) {
                    firstFocusableElement.focus();
                    e.preventDefault();
                }
            }
        });
    }

    /**
     * Initialize Performance Optimizations
     */
    function initPerformanceOptimizations() {
        // Lazy load images if not natively supported
        if (!('loading' in HTMLImageElement.prototype)) {
            lazyLoadImages();
        }

        // Preload critical resources
        preloadCriticalResources();
    }

    /**
     * Lazy load images for older browsers
     */
    function lazyLoadImages() {
        const images = document.querySelectorAll('img[data-src]');
        
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

            images.forEach(function(img) {
                imageObserver.observe(img);
            });
        } else {
            // Fallback for older browsers
            images.forEach(function(img) {
                img.src = img.dataset.src;
                img.classList.remove('lazy');
            });
        }
    }

    /**
     * Preload critical resources
     */
    function preloadCriticalResources() {
        // Preload fonts
        const fontLinks = [
            'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap'
        ];

        fontLinks.forEach(function(href) {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.as = 'style';
            link.href = href;
            document.head.appendChild(link);
        });
    }

    /**
     * Utility Functions
     */
    
    // Debounce function for performance
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

    // Throttle function for performance
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    // Check if element is in viewport
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Expose utility functions globally for other scripts
    window.WPMasterDev = window.WPMasterDev || {};
    window.WPMasterDev.navigation = {
        smoothScrollTo: smoothScrollTo,
        debounce: debounce,
        throttle: throttle,
        isInViewport: isInViewport,
        trapFocus: trapFocus
    };

    // Initialize everything when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNavigation);
    } else {
        initNavigation();
    }

})();
