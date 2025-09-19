/*!
 * WordPress Master Developer Theme - Lazy Loading Module
 * Handles lazy loading of images and other content
 */

export default class LazyLoading {
  constructor() {
    this.imageObserver = null;
    this.contentObserver = null;
    
    this.init();
  }

  /**
   * Initialize lazy loading
   */
  init() {
    this.setupImageLazyLoading();
    this.setupContentLazyLoading();
    this.setupVideoLazyLoading();
  }

  /**
   * Setup image lazy loading
   */
  setupImageLazyLoading() {
    // Check for Intersection Observer support
    if (!('IntersectionObserver' in window)) {
      // Fallback: load all images immediately
      this.loadAllImages();
      return;
    }

    const imageObserverOptions = {
      threshold: 0.1,
      rootMargin: '50px 0px'
    };

    this.imageObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          this.loadImage(entry.target);
          this.imageObserver.unobserve(entry.target);
        }
      });
    }, imageObserverOptions);

    // Observe images with data-src attribute
    this.observeImages();
  }

  /**
   * Observe images for lazy loading
   */
  observeImages() {
    const lazyImages = document.querySelectorAll('img[data-src], img[loading="lazy"]');
    
    lazyImages.forEach(img => {
      // Add loading class
      img.classList.add('lazy-loading');
      
      // Observe the image
      this.imageObserver.observe(img);
    });
  }

  /**
   * Load individual image
   */
  loadImage(img) {
    // Handle data-src attribute
    if (img.dataset.src) {
      img.src = img.dataset.src;
      img.removeAttribute('data-src');
    }

    // Handle data-srcset attribute
    if (img.dataset.srcset) {
      img.srcset = img.dataset.srcset;
      img.removeAttribute('data-srcset');
    }

    // Handle data-sizes attribute
    if (img.dataset.sizes) {
      img.sizes = img.dataset.sizes;
      img.removeAttribute('data-sizes');
    }

    // Add loaded class when image loads
    img.addEventListener('load', () => {
      img.classList.remove('lazy-loading');
      img.classList.add('lazy-loaded');
    });

    // Handle load errors
    img.addEventListener('error', () => {
      img.classList.remove('lazy-loading');
      img.classList.add('lazy-error');
      console.warn('Failed to load image:', img.src);
    });
  }

  /**
   * Fallback: load all images immediately
   */
  loadAllImages() {
    const lazyImages = document.querySelectorAll('img[data-src]');
    
    lazyImages.forEach(img => {
      this.loadImage(img);
    });
  }

  /**
   * Setup content lazy loading
   */
  setupContentLazyLoading() {
    if (!('IntersectionObserver' in window)) {
      this.loadAllContent();
      return;
    }

    const contentObserverOptions = {
      threshold: 0.1,
      rootMargin: '100px 0px'
    };

    this.contentObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          this.loadContent(entry.target);
          this.contentObserver.unobserve(entry.target);
        }
      });
    }, contentObserverOptions);

    // Observe content with data-lazy-content attribute
    document.querySelectorAll('[data-lazy-content]').forEach(element => {
      element.classList.add('content-loading');
      this.contentObserver.observe(element);
    });
  }

  /**
   * Load lazy content
   */
  loadContent(element) {
    const contentUrl = element.dataset.lazyContent;
    
    if (contentUrl) {
      fetch(contentUrl)
        .then(response => response.text())
        .then(html => {
          element.innerHTML = html;
          element.classList.remove('content-loading');
          element.classList.add('content-loaded');
          
          // Re-observe any new lazy images in the loaded content
          this.observeImages();
        })
        .catch(error => {
          console.error('Failed to load content:', error);
          element.classList.remove('content-loading');
          element.classList.add('content-error');
        });
    }
  }

  /**
   * Fallback: load all content immediately
   */
  loadAllContent() {
    document.querySelectorAll('[data-lazy-content]').forEach(element => {
      this.loadContent(element);
    });
  }

  /**
   * Setup video lazy loading
   */
  setupVideoLazyLoading() {
    const lazyVideos = document.querySelectorAll('video[data-src]');
    
    if (!('IntersectionObserver' in window)) {
      lazyVideos.forEach(video => this.loadVideo(video));
      return;
    }

    const videoObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          this.loadVideo(entry.target);
          videoObserver.unobserve(entry.target);
        }
      });
    });

    lazyVideos.forEach(video => {
      videoObserver.observe(video);
    });
  }

  /**
   * Load individual video
   */
  loadVideo(video) {
    if (video.dataset.src) {
      video.src = video.dataset.src;
      video.removeAttribute('data-src');
      video.load();
    }

    // Handle multiple sources
    const sources = video.querySelectorAll('source[data-src]');
    sources.forEach(source => {
      if (source.dataset.src) {
        source.src = source.dataset.src;
        source.removeAttribute('data-src');
      }
    });

    if (sources.length > 0) {
      video.load();
    }
  }

  /**
   * Add lazy loading to dynamically added images
   */
  addLazyImages(container = document) {
    const newImages = container.querySelectorAll('img[data-src]:not(.lazy-loading):not(.lazy-loaded)');
    
    newImages.forEach(img => {
      img.classList.add('lazy-loading');
      if (this.imageObserver) {
        this.imageObserver.observe(img);
      } else {
        this.loadImage(img);
      }
    });
  }

  /**
   * Force load all remaining lazy content
   */
  loadAll() {
    // Load all remaining images
    document.querySelectorAll('img[data-src]').forEach(img => {
      this.loadImage(img);
    });

    // Load all remaining content
    document.querySelectorAll('[data-lazy-content]').forEach(element => {
      this.loadContent(element);
    });

    // Load all remaining videos
    document.querySelectorAll('video[data-src]').forEach(video => {
      this.loadVideo(video);
    });
  }

  /**
   * Create placeholder for lazy images
   */
  createImagePlaceholder(width, height, backgroundColor = '#f0f0f0') {
    const canvas = document.createElement('canvas');
    canvas.width = width;
    canvas.height = height;
    
    const ctx = canvas.getContext('2d');
    ctx.fillStyle = backgroundColor;
    ctx.fillRect(0, 0, width, height);
    
    return canvas.toDataURL();
  }

  /**
   * Setup responsive images with lazy loading
   */
  setupResponsiveImages() {
    document.querySelectorAll('img[data-srcset]').forEach(img => {
      // Create placeholder based on image dimensions
      if (img.dataset.width && img.dataset.height) {
        const placeholder = this.createImagePlaceholder(
          parseInt(img.dataset.width),
          parseInt(img.dataset.height)
        );
        img.src = placeholder;
      }

      // Add to lazy loading
      img.classList.add('lazy-loading');
      if (this.imageObserver) {
        this.imageObserver.observe(img);
      }
    });
  }

  /**
   * Destroy lazy loading (cleanup)
   */
  destroy() {
    if (this.imageObserver) {
      this.imageObserver.disconnect();
    }
    
    if (this.contentObserver) {
      this.contentObserver.disconnect();
    }
  }
}
