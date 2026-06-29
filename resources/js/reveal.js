// Scroll Reveal Animation
const revealOptions = {
    threshold: 0.15,
    rootMargin: '0px'
};

const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('active');
        }
    });
}, revealOptions);

document.addEventListener('DOMContentLoaded', () => {
    // Observe all elements with animation classes
    document.querySelectorAll('.animate-fade-up, .animate-fade-in, .animate-scale').forEach(el => {
        revealObserver.observe(el);
    });
});

// Typing Effect
function typeText(element, text, speed = 100) {
    let i = 0;
    element.textContent = '';
    
    const typing = setInterval(() => {
        if (i < text.length) {
            element.textContent += text.charAt(i);
            i++;
        } else {
            clearInterval(typing);
        }
    }, speed);
}

// Export for use in other modules
window.typeText = typeText;
