/*!
 * WordPress Master Developer Theme - Main JavaScript
 * Modular JavaScript with Bootstrap integration
 */

// Import Bootstrap JavaScript (only what we need)
import { Modal, Dropdown, Collapse, Tooltip, Popover } from 'bootstrap';

// Import custom modules
import Navigation from './modules/navigation';
import ContactForm from './modules/contact-form';
import ScrollEffects from './modules/scroll-effects';
import LazyLoading from './modules/lazy-loading';

/**
 * WordPress Master Developer Theme JavaScript
 */
class WPMasterDevTheme {
  constructor() {
    this.init();
  }

  /**
   * Initialize theme functionality
   */
  init() {
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => this.onDOMReady());
    } else {
      this.onDOMReady();
    }
  }

  /**
   * DOM Ready handler
   */
  onDOMReady() {
    console.log('WordPress Master Developer Theme initialized');
    
    // Initialize modules
    this.initializeModules();
    
    // Initialize Bootstrap components
    this.initializeBootstrap();
    
    // Setup event listeners
    this.setupEventListeners();
  }

  /**
   * Initialize custom modules
   */
  initializeModules() {
    // Initialize navigation (TrueHorizon.ai style)
    this.navigation = new Navigation();
    
    // Initialize contact form
    this.contactForm = new ContactForm();
    
    // Initialize scroll effects
    this.scrollEffects = new ScrollEffects();
    
    // Initialize lazy loading
    this.lazyLoading = new LazyLoading();
  }

  /**
   * Initialize Bootstrap components
   */
  initializeBootstrap() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
      return new Popover(popoverTriggerEl);
    });

    // Initialize modals
    const modalElements = document.querySelectorAll('.modal');
    modalElements.forEach(modalEl => {
      new Modal(modalEl);
    });

    // Initialize dropdowns
    const dropdownElements = document.querySelectorAll('.dropdown-toggle');
    dropdownElements.forEach(dropdownEl => {
      new Dropdown(dropdownEl);
    });
  }

  /**
   * Setup global event listeners
   */
  setupEventListeners() {
    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        this.handleResize();
      }, 250);
    });

    // Handle scroll events (throttled)
    let scrollTimer;
    window.addEventListener('scroll', () => {
      if (!scrollTimer) {
        scrollTimer = setTimeout(() => {
          this.handleScroll();
          scrollTimer = null;
        }, 16); // ~60fps
      }
    });

    // Handle page visibility changes
    document.addEventListener('visibilitychange', () => {
      this.handleVisibilityChange();
    });
  }

  /**
   * Handle window resize
   */
  handleResize() {
    // Close mobile menu on resize to desktop
    if (window.innerWidth >= 768) {
      this.navigation.closeMobileMenu();
    }
    
    // Trigger resize event for modules
    document.dispatchEvent(new CustomEvent('themeResize'));
  }

  /**
   * Handle scroll events
   */
  handleScroll() {
    // Trigger scroll event for modules
    document.dispatchEvent(new CustomEvent('themeScroll', {
      detail: {
        scrollY: window.scrollY,
        scrollDirection: this.getScrollDirection()
      }
    }));
  }

  /**
   * Handle page visibility changes
   */
  handleVisibilityChange() {
    if (document.hidden) {
      // Page is hidden - pause animations, etc.
      document.body.classList.add('page-hidden');
    } else {
      // Page is visible - resume animations, etc.
      document.body.classList.remove('page-hidden');
    }
  }

  /**
   * Get scroll direction
   */
  getScrollDirection() {
    const currentScrollY = window.scrollY;
    const direction = currentScrollY > (this.lastScrollY || 0) ? 'down' : 'up';
    this.lastScrollY = currentScrollY;
    return direction;
  }

  /**
   * Utility: Debounce function
   */
  static debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        timeout = null;
        if (!immediate) func(...args);
      };
      const callNow = immediate && !timeout;
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
      if (callNow) func(...args);
    };
  }

  /**
   * Utility: Throttle function
   */
  static throttle(func, limit) {
    let inThrottle;
    return function(...args) {
      if (!inThrottle) {
        func.apply(this, args);
        inThrottle = true;
        setTimeout(() => inThrottle = false, limit);
      }
    };
  }
}

// Initialize theme when script loads
new WPMasterDevTheme();

// Export for use in other modules
export default WPMasterDevTheme;
