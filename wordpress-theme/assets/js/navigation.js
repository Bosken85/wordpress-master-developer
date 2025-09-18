/**
 * WordPress Master Developer Theme Navigation JavaScript
 * Handles mobile menu functionality and navigation interactions
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        initMobileMenu();
        initBackToTop();
        initSmoothScrolling();
        initHeaderScroll();
    });

    /**
     * Initialize Mobile Menu Functionality
     */
    function initMobileMenu() {
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const mobileOverlay = document.querySelector('.mobile-menu-overlay');
        const mobileClose = document.querySelector('.mobile-menu-close');
        const mobileBackdrop = document.querySelector('.mobile-menu-backdrop');
        const mobileLinks = document.querySelectorAll('.mobile-nav-menu a');

        if (!mobileToggle || !mobileOverlay) {
            return;
        }

        // Open mobile menu
        mobileToggle.addEventListener('click', function(e) {
            e.preventDefault();
            openMobileMenu();
        });

        // Close mobile menu
        if (mobileClose) {
            mobileClose.addEventListener('click', function(e) {
                e.preventDefault();
                closeMobileMenu();
            });
        }

        // Close on backdrop click
        if (mobileBackdrop) {
            mobileBackdrop.addEventListener('click', function(e) {
                e.preventDefault();
                closeMobileMenu();
            });
        }

        // Close on link click
        mobileLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                closeMobileMenu();
            });
        });

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileOverlay.classList.contains('active')) {
                closeMobileMenu();
            }
        });

        function openMobileMenu() {
            mobileOverlay.classList.add('active');
            mobileToggle.classList.add('active');
            mobileOverlay.setAttribute('aria-hidden', 'false');
            mobileToggle.setAttribute('aria-expanded', 'true');
            
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
            
            // Focus management
            const firstFocusable = mobileOverlay.querySelector('a, button');
            if (firstFocusable) {
                firstFocusable.focus();
            }
        }

        function closeMobileMenu() {
            mobileOverlay.classList.remove('active');
            mobileToggle.classList.remove('active');
            mobileOverlay.setAttribute('aria-hidden', 'true');
            mobileToggle.setAttribute('aria-expanded', 'false');
            
            // Restore body scroll
            document.body.style.overflow = '';
            
            // Return focus to toggle button
            mobileToggle.focus();
        }
    }

    /**
     * Initialize Back to Top Button
     */
    function initBackToTop() {
        const backToTopButton = document.getElementById('back-to-top');
        
        if (!backToTopButton) {
            return;
        }

        // Show/hide button based on scroll position
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
     * Initialize Smooth Scrolling for Anchor Links
     */
    function initSmoothScrolling() {
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        
        anchorLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                // Skip if it's just "#"
                if (href === '#') {
                    return;
                }
                
                const target = document.querySelector(href);
                
                if (target) {
                    e.preventDefault();
                    
                    const headerHeight = document.querySelector('.site-header').offsetHeight;
                    const targetPosition = target.offsetTop - headerHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
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
            
            // Add scrolled class when scrolled down
            if (scrollTop > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            lastScrollTop = scrollTop;
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(updateHeader);
                ticking = true;
            }
        });
    }

    /**
     * Initialize Dropdown Menus (if any)
     */
    function initDropdownMenus() {
        const dropdownToggles = document.querySelectorAll('.menu-item-has-children > a');
        
        dropdownToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                const parentItem = this.parentNode;
                const submenu = parentItem.querySelector('.sub-menu');
                
                if (submenu) {
                    e.preventDefault();
                    
                    // Toggle submenu
                    if (submenu.style.display === 'block') {
                        submenu.style.display = 'none';
                        this.setAttribute('aria-expanded', 'false');
                    } else {
                        // Close other open submenus
                        document.querySelectorAll('.sub-menu').forEach(function(menu) {
                            menu.style.display = 'none';
                        });
                        document.querySelectorAll('.menu-item-has-children > a').forEach(function(link) {
                            link.setAttribute('aria-expanded', 'false');
                        });
                        
                        // Open this submenu
                        submenu.style.display = 'block';
                        this.setAttribute('aria-expanded', 'true');
                    }
                }
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.menu-item-has-children')) {
                document.querySelectorAll('.sub-menu').forEach(function(menu) {
                    menu.style.display = 'none';
                });
                document.querySelectorAll('.menu-item-has-children > a').forEach(function(link) {
                    link.setAttribute('aria-expanded', 'false');
                });
            }
        });
    }

    /**
     * Initialize Search Toggle (if search is in header)
     */
    function initSearchToggle() {
        const searchToggle = document.querySelector('.search-toggle');
        const searchForm = document.querySelector('.header-search-form');
        
        if (searchToggle && searchForm) {
            searchToggle.addEventListener('click', function(e) {
                e.preventDefault();
                searchForm.classList.toggle('active');
                
                if (searchForm.classList.contains('active')) {
                    const searchInput = searchForm.querySelector('input[type="search"]');
                    if (searchInput) {
                        searchInput.focus();
                    }
                }
            });
            
            // Close search on escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && searchForm.classList.contains('active')) {
                    searchForm.classList.remove('active');
                    searchToggle.focus();
                }
            });
        }
    }

    /**
     * Utility function to debounce events
     */
    function debounce(func, wait, immediate) {
        let timeout;
        return function() {
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

    /**
     * Initialize all navigation features
     */
    function init() {
        initMobileMenu();
        initBackToTop();
        initSmoothScrolling();
        initHeaderScroll();
        initDropdownMenus();
        initSearchToggle();
    }

    // Export for potential external use
    window.wpMasterDevNavigation = {
        init: init,
        initMobileMenu: initMobileMenu,
        initBackToTop: initBackToTop,
        initSmoothScrolling: initSmoothScrolling,
        initHeaderScroll: initHeaderScroll
    };

})();
