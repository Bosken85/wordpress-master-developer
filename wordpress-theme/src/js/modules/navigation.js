/*!
 * WordPress Master Developer Theme - Navigation Module
 * TrueHorizon.ai inspired navigation functionality
 */

export default class Navigation {
  constructor() {
    this.mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    this.mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
    this.mobileMenuClose = document.querySelector('.mobile-menu-close');
    this.mobileMenuBackdrop = document.querySelector('.mobile-menu-backdrop');
    this.mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
    
    this.isMenuOpen = false;
    
    this.init();
  }

  /**
   * Initialize navigation functionality
   */
  init() {
    this.setupEventListeners();
    this.setupKeyboardNavigation();
    this.updateActiveStates();
  }

  /**
   * Setup event listeners
   */
  setupEventListeners() {
    // Mobile menu toggle
    if (this.mobileMenuToggle) {
      this.mobileMenuToggle.addEventListener('click', (e) => {
        e.preventDefault();
        this.toggleMobileMenu();
      });
    }

    // Mobile menu close button
    if (this.mobileMenuClose) {
      this.mobileMenuClose.addEventListener('click', (e) => {
        e.preventDefault();
        this.closeMobileMenu();
      });
    }

    // Close menu when clicking backdrop
    if (this.mobileMenuBackdrop) {
      this.mobileMenuBackdrop.addEventListener('click', () => {
        this.closeMobileMenu();
      });
    }

    // Close menu when clicking nav links
    this.mobileNavLinks.forEach(link => {
      link.addEventListener('click', () => {
        // Small delay to allow navigation to start
        setTimeout(() => {
          this.closeMobileMenu();
        }, 150);
      });
    });

    // Handle escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.isMenuOpen) {
        this.closeMobileMenu();
      }
    });

    // Handle window resize
    window.addEventListener('resize', () => {
      if (window.innerWidth >= 768 && this.isMenuOpen) {
        this.closeMobileMenu();
      }
    });

    // Handle scroll for header effects
    let lastScrollY = window.scrollY;
    window.addEventListener('scroll', () => {
      this.handleHeaderScroll(lastScrollY);
      lastScrollY = window.scrollY;
    });
  }

  /**
   * Setup keyboard navigation
   */
  setupKeyboardNavigation() {
    // Focus management for mobile menu
    if (this.mobileMenuToggle) {
      this.mobileMenuToggle.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          this.toggleMobileMenu();
        }
      });
    }

    // Tab trapping in mobile menu
    if (this.mobileMenuOverlay) {
      this.mobileMenuOverlay.addEventListener('keydown', (e) => {
        if (e.key === 'Tab') {
          this.handleTabTrapping(e);
        }
      });
    }
  }

  /**
   * Toggle mobile menu
   */
  toggleMobileMenu() {
    if (this.isMenuOpen) {
      this.closeMobileMenu();
    } else {
      this.openMobileMenu();
    }
  }

  /**
   * Open mobile menu
   */
  openMobileMenu() {
    this.isMenuOpen = true;
    
    // Update ARIA attributes
    this.mobileMenuToggle.setAttribute('aria-expanded', 'true');
    this.mobileMenuOverlay.setAttribute('aria-hidden', 'false');
    
    // Add classes for animation
    this.mobileMenuOverlay.classList.add('active');
    document.body.classList.add('mobile-menu-open');
    
    // Focus management
    setTimeout(() => {
      const firstFocusableElement = this.mobileMenuOverlay.querySelector('a, button, [tabindex]:not([tabindex="-1"])');
      if (firstFocusableElement) {
        firstFocusableElement.focus();
      }
    }, 300); // Wait for animation to complete
    
    // Announce to screen readers
    this.announceToScreenReader('Menu opened');
  }

  /**
   * Close mobile menu
   */
  closeMobileMenu() {
    this.isMenuOpen = false;
    
    // Update ARIA attributes
    this.mobileMenuToggle.setAttribute('aria-expanded', 'false');
    this.mobileMenuOverlay.setAttribute('aria-hidden', 'true');
    
    // Remove classes for animation
    this.mobileMenuOverlay.classList.remove('active');
    document.body.classList.remove('mobile-menu-open');
    
    // Return focus to toggle button
    this.mobileMenuToggle.focus();
    
    // Announce to screen readers
    this.announceToScreenReader('Menu closed');
  }

  /**
   * Handle header scroll effects
   */
  handleHeaderScroll(lastScrollY) {
    const currentScrollY = window.scrollY;
    const header = document.querySelector('.site-header');
    
    if (!header) return;
    
    // Add/remove scrolled class
    if (currentScrollY > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
    
    // Hide/show header on scroll (optional)
    if (currentScrollY > lastScrollY && currentScrollY > 100) {
      // Scrolling down
      header.classList.add('header-hidden');
    } else {
      // Scrolling up
      header.classList.remove('header-hidden');
    }
  }

  /**
   * Update active navigation states
   */
  updateActiveStates() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-menu a, .mobile-nav-link');
    
    navLinks.forEach(link => {
      const linkPath = new URL(link.href).pathname;
      
      if (linkPath === currentPath || 
          (currentPath === '/' && link.textContent.trim() === 'Home') ||
          (currentPath.includes(linkPath) && linkPath !== '/')) {
        link.classList.add('active');
      } else {
        link.classList.remove('active');
      }
    });
  }

  /**
   * Handle tab trapping in mobile menu
   */
  handleTabTrapping(e) {
    const focusableElements = this.mobileMenuOverlay.querySelectorAll(
      'a, button, [tabindex]:not([tabindex="-1"])'
    );
    
    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];
    
    if (e.shiftKey) {
      // Shift + Tab
      if (document.activeElement === firstElement) {
        e.preventDefault();
        lastElement.focus();
      }
    } else {
      // Tab
      if (document.activeElement === lastElement) {
        e.preventDefault();
        firstElement.focus();
      }
    }
  }

  /**
   * Announce to screen readers
   */
  announceToScreenReader(message) {
    const announcement = document.createElement('div');
    announcement.setAttribute('aria-live', 'polite');
    announcement.setAttribute('aria-atomic', 'true');
    announcement.className = 'sr-only';
    announcement.textContent = message;
    
    document.body.appendChild(announcement);
    
    setTimeout(() => {
      document.body.removeChild(announcement);
    }, 1000);
  }

  /**
   * Public method to close menu (for external use)
   */
  close() {
    this.closeMobileMenu();
  }

  /**
   * Public method to check if menu is open
   */
  isOpen() {
    return this.isMenuOpen;
  }
}
