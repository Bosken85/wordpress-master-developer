/*!
 * WordPress Master Developer Theme - Navigation JavaScript
 * Standalone navigation functionality (compiled separately)
 */

import Navigation from './modules/navigation';

/**
 * Initialize navigation when DOM is ready
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize navigation
    const navigation = new Navigation();
    
    // Make navigation globally available
    window.wpMasterDevNavigation = navigation;
    
    console.log('WordPress Master Developer Navigation initialized');
});
