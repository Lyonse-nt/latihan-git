// Import all modules
import './navbar.js';
import './counter.js';
import './reveal.js';
import './modal.js';
import './gallery.js';
import './utils.js';

// Initialize app
document.addEventListener('DOMContentLoaded', () => {
    console.log('A4A Website Loaded Successfully! 🚀');
    
    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
