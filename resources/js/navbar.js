// Navbar functionality
let lastScroll = 0;

window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    const currentScroll = window.pageYOffset;
    
    if (currentScroll > 50) {
        navbar.style.background = 'rgba(24, 24, 27, 0.85)';
        navbar.style.backdropFilter = 'blur(20px)';
        navbar.style.borderBottom = '1px solid rgba(255, 255, 255, 0.15)';
    } else {
        navbar.style.background = 'transparent';
        navbar.style.backdropFilter = 'none';
        navbar.style.borderBottom = 'none';
    }
    
    lastScroll = currentScroll;
});

// Active link indicator
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.nav-link');

window.addEventListener('scroll', () => {
    let current = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (pageYOffset >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('text-primary', 'border-b-2', 'border-primary');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('text-primary', 'border-b-2', 'border-primary');
        }
    });
});

// Mobile menu toggle
const mobileMenuBtn = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');

if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
}
