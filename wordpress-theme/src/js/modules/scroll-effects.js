/*!
 * WordPress Master Developer Theme - Scroll Effects Module
 * Handles scroll-based animations and effects
 */

export default class ScrollEffects {
  constructor() {
    this.elements = [];
    this.isScrolling = false;
    this.lastScrollY = window.scrollY;
    
    this.init();
  }

  /**
   * Initialize scroll effects
   */
  init() {
    this.setupIntersectionObserver();
    this.setupScrollAnimations();
    this.setupParallaxEffects();
    this.setupScrollToTop();
  }

  /**
   * Setup Intersection Observer for fade-in animations
   */
  setupIntersectionObserver() {
    // Check if Intersection Observer is supported
    if (!('IntersectionObserver' in window)) {
      // Fallback: show all elements immediately
      document.querySelectorAll('[data-animate]').forEach(el => {
        el.classList.add('animate-in');
      });
      return;
    }

    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    this.observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          this.animateElement(entry.target);
          this.observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    // Observe elements with animation attributes
    document.querySelectorAll('[data-animate]').forEach(el => {
      el.classList.add('animate-ready');
      this.observer.observe(el);
    });
  }

  /**
   * Animate element when it comes into view
   */
  animateElement(element) {
    const animationType = element.dataset.animate || 'fade-in';
    const delay = element.dataset.delay || 0;

    setTimeout(() => {
      element.classList.add('animate-in');
      element.classList.add(`animate-${animationType}`);
    }, parseInt(delay));
  }

  /**
   * Setup scroll-based animations
   */
  setupScrollAnimations() {
    // Add scroll event listener with throttling
    let ticking = false;
    
    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(() => {
          this.handleScroll();
          ticking = false;
        });
        ticking = true;
      }
    });
  }

  /**
   * Handle scroll events
   */
  handleScroll() {
    const currentScrollY = window.scrollY;
    const scrollDirection = currentScrollY > this.lastScrollY ? 'down' : 'up';
    
    // Update header on scroll
    this.updateHeader(currentScrollY, scrollDirection);
    
    // Update progress indicators
    this.updateProgressIndicators();
    
    // Handle parallax effects
    this.updateParallaxElements(currentScrollY);
    
    this.lastScrollY = currentScrollY;
  }

  /**
   * Update header based on scroll position
   */
  updateHeader(scrollY, direction) {
    const header = document.querySelector('.site-header');
    if (!header) return;

    // Add scrolled class after scrolling past hero
    if (scrollY > 100) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }

    // Hide/show header based on scroll direction (optional)
    if (scrollY > 200) {
      if (direction === 'down') {
        header.classList.add('header-hidden');
      } else {
        header.classList.remove('header-hidden');
      }
    }
  }

  /**
   * Update progress indicators
   */
  updateProgressIndicators() {
    const progressBars = document.querySelectorAll('.scroll-progress');
    
    progressBars.forEach(bar => {
      const windowHeight = window.innerHeight;
      const documentHeight = document.documentElement.scrollHeight;
      const scrollTop = window.scrollY;
      const progress = (scrollTop / (documentHeight - windowHeight)) * 100;
      
      bar.style.width = `${Math.min(progress, 100)}%`;
    });
  }

  /**
   * Setup parallax effects
   */
  setupParallaxEffects() {
    this.parallaxElements = document.querySelectorAll('[data-parallax]');
  }

  /**
   * Update parallax elements
   */
  updateParallaxElements(scrollY) {
    this.parallaxElements.forEach(element => {
      const speed = parseFloat(element.dataset.parallax) || 0.5;
      const yPos = -(scrollY * speed);
      element.style.transform = `translateY(${yPos}px)`;
    });
  }

  /**
   * Setup scroll to top functionality
   */
  setupScrollToTop() {
    // Create scroll to top button if it doesn't exist
    let scrollTopBtn = document.querySelector('.scroll-to-top');
    
    if (!scrollTopBtn) {
      scrollTopBtn = document.createElement('button');
      scrollTopBtn.className = 'scroll-to-top';
      scrollTopBtn.innerHTML = '↑';
      scrollTopBtn.setAttribute('aria-label', 'Scroll to top');
      document.body.appendChild(scrollTopBtn);
    }

    // Show/hide button based on scroll position
    window.addEventListener('scroll', () => {
      if (window.scrollY > 500) {
        scrollTopBtn.classList.add('visible');
      } else {
        scrollTopBtn.classList.remove('visible');
      }
    });

    // Handle click
    scrollTopBtn.addEventListener('click', () => {
      this.scrollToTop();
    });
  }

  /**
   * Smooth scroll to top
   */
  scrollToTop() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }

  /**
   * Smooth scroll to element
   */
  scrollToElement(target, offset = 0) {
    const element = typeof target === 'string' ? document.querySelector(target) : target;
    
    if (element) {
      const elementPosition = element.getBoundingClientRect().top + window.scrollY;
      const offsetPosition = elementPosition - offset;

      window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth'
      });
    }
  }

  /**
   * Setup smooth scrolling for anchor links
   */
  setupSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', (e) => {
        const href = anchor.getAttribute('href');
        
        if (href === '#') return;
        
        const target = document.querySelector(href);
        if (target) {
          e.preventDefault();
          this.scrollToElement(target, 80); // Account for fixed header
        }
      });
    });
  }

  /**
   * Add scroll animations to elements
   */
  addScrollAnimation(selector, animationType = 'fade-in', delay = 0) {
    document.querySelectorAll(selector).forEach((element, index) => {
      element.setAttribute('data-animate', animationType);
      element.setAttribute('data-delay', delay + (index * 100));
      
      if (this.observer) {
        element.classList.add('animate-ready');
        this.observer.observe(element);
      }
    });
  }

  /**
   * Destroy scroll effects (cleanup)
   */
  destroy() {
    if (this.observer) {
      this.observer.disconnect();
    }
    
    // Remove event listeners
    window.removeEventListener('scroll', this.handleScroll);
  }
}
