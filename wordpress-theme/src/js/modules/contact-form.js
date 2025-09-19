/*!
 * WordPress Master Developer Theme - Contact Form Module
 * Handles contact form functionality and validation
 */

export default class ContactForm {
  constructor() {
    this.form = document.querySelector('#contact-form');
    this.submitButton = document.querySelector('#contact-submit');
    this.messageContainer = document.querySelector('#form-message');
    
    this.init();
  }

  /**
   * Initialize contact form functionality
   */
  init() {
    if (!this.form) return;
    
    this.setupEventListeners();
    this.setupValidation();
  }

  /**
   * Setup event listeners
   */
  setupEventListeners() {
    // Form submission
    this.form.addEventListener('submit', (e) => {
      e.preventDefault();
      this.handleSubmit();
    });

    // Real-time validation
    const inputs = this.form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
      input.addEventListener('blur', () => {
        this.validateField(input);
      });
      
      input.addEventListener('input', () => {
        this.clearFieldError(input);
      });
    });
  }

  /**
   * Setup form validation
   */
  setupValidation() {
    // Add required field indicators
    const requiredFields = this.form.querySelectorAll('[required]');
    requiredFields.forEach(field => {
      const label = this.form.querySelector(`label[for="${field.id}"]`);
      if (label && !label.querySelector('.required-indicator')) {
        label.innerHTML += ' <span class="required-indicator">*</span>';
      }
    });
  }

  /**
   * Handle form submission
   */
  async handleSubmit() {
    // Validate all fields
    if (!this.validateForm()) {
      this.showMessage('Please correct the errors below.', 'error');
      return;
    }

    // Show loading state
    this.setLoadingState(true);

    try {
      // Prepare form data
      const formData = new FormData(this.form);
      formData.append('action', 'wp_master_dev_contact_form');
      formData.append('nonce', wpMasterDev.nonce);

      // Submit form
      const response = await fetch(wpMasterDev.ajaxUrl, {
        method: 'POST',
        body: formData
      });

      const result = await response.json();

      if (result.success) {
        this.showMessage(result.data.message, 'success');
        this.form.reset();
        this.clearAllErrors();
      } else {
        this.showMessage(result.data.message, 'error');
      }
    } catch (error) {
      console.error('Contact form error:', error);
      this.showMessage('An error occurred. Please try again.', 'error');
    } finally {
      this.setLoadingState(false);
    }
  }

  /**
   * Validate entire form
   */
  validateForm() {
    let isValid = true;
    const fields = this.form.querySelectorAll('input, textarea, select');
    
    fields.forEach(field => {
      if (!this.validateField(field)) {
        isValid = false;
      }
    });

    return isValid;
  }

  /**
   * Validate individual field
   */
  validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name;
    let isValid = true;
    let errorMessage = '';

    // Required field validation
    if (field.hasAttribute('required') && !value) {
      errorMessage = 'This field is required.';
      isValid = false;
    }

    // Email validation
    if (fieldName === 'email' && value) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(value)) {
        errorMessage = 'Please enter a valid email address.';
        isValid = false;
      }
    }

    // Phone validation (optional)
    if (fieldName === 'phone' && value) {
      const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
      if (!phoneRegex.test(value.replace(/[\s\-\(\)]/g, ''))) {
        errorMessage = 'Please enter a valid phone number.';
        isValid = false;
      }
    }

    // Name validation
    if (fieldName === 'name' && value) {
      if (value.length < 2) {
        errorMessage = 'Name must be at least 2 characters long.';
        isValid = false;
      }
    }

    // Message validation
    if (fieldName === 'message' && value) {
      if (value.length < 10) {
        errorMessage = 'Message must be at least 10 characters long.';
        isValid = false;
      }
    }

    // Show/hide error
    if (!isValid) {
      this.showFieldError(field, errorMessage);
    } else {
      this.clearFieldError(field);
    }

    return isValid;
  }

  /**
   * Show field error
   */
  showFieldError(field, message) {
    const fieldGroup = field.closest('.form-group') || field.parentElement;
    
    // Remove existing error
    const existingError = fieldGroup.querySelector('.field-error');
    if (existingError) {
      existingError.remove();
    }

    // Add error class
    field.classList.add('error');
    fieldGroup.classList.add('has-error');

    // Add error message
    const errorElement = document.createElement('div');
    errorElement.className = 'field-error';
    errorElement.textContent = message;
    fieldGroup.appendChild(errorElement);
  }

  /**
   * Clear field error
   */
  clearFieldError(field) {
    const fieldGroup = field.closest('.form-group') || field.parentElement;
    
    // Remove error class
    field.classList.remove('error');
    fieldGroup.classList.remove('has-error');

    // Remove error message
    const errorElement = fieldGroup.querySelector('.field-error');
    if (errorElement) {
      errorElement.remove();
    }
  }

  /**
   * Clear all form errors
   */
  clearAllErrors() {
    const fields = this.form.querySelectorAll('input, textarea, select');
    fields.forEach(field => {
      this.clearFieldError(field);
    });
  }

  /**
   * Show form message
   */
  showMessage(message, type = 'info') {
    if (!this.messageContainer) {
      // Create message container if it doesn't exist
      this.messageContainer = document.createElement('div');
      this.messageContainer.id = 'form-message';
      this.form.insertBefore(this.messageContainer, this.form.firstChild);
    }

    this.messageContainer.className = `form-message ${type}`;
    this.messageContainer.textContent = message;
    this.messageContainer.style.display = 'block';

    // Auto-hide success messages
    if (type === 'success') {
      setTimeout(() => {
        this.hideMessage();
      }, 5000);
    }

    // Scroll to message
    this.messageContainer.scrollIntoView({ 
      behavior: 'smooth', 
      block: 'center' 
    });
  }

  /**
   * Hide form message
   */
  hideMessage() {
    if (this.messageContainer) {
      this.messageContainer.style.display = 'none';
    }
  }

  /**
   * Set loading state
   */
  setLoadingState(isLoading) {
    if (this.submitButton) {
      if (isLoading) {
        this.submitButton.disabled = true;
        this.submitButton.textContent = 'Sending...';
        this.submitButton.classList.add('loading');
      } else {
        this.submitButton.disabled = false;
        this.submitButton.textContent = 'Send Message';
        this.submitButton.classList.remove('loading');
      }
    }

    // Disable form during submission
    const fields = this.form.querySelectorAll('input, textarea, select, button');
    fields.forEach(field => {
      field.disabled = isLoading;
    });
  }
}
