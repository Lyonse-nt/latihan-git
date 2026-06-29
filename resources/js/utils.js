// Utility functions

// Button ripple effect
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-ripple').forEach(button => {
        button.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const ripple = document.createElement('span');
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple-effect');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});

// Auto slider for quotes
let currentQuote = 0;
const quotes = document.querySelectorAll('.quote-item');

function showNextQuote() {
    if (quotes.length === 0) return;
    
    quotes[currentQuote].classList.remove('active');
    quotes[currentQuote].classList.add('hidden');
    
    currentQuote = (currentQuote + 1) % quotes.length;
    
    quotes[currentQuote].classList.remove('hidden');
    setTimeout(() => {
        quotes[currentQuote].classList.add('active');
    }, 10);
}

// Start auto slider
if (quotes.length > 0) {
    setInterval(showNextQuote, 5000);
}

// Scroll indicator
const scrollIndicator = document.getElementById('scroll-indicator');
if (scrollIndicator) {
    scrollIndicator.addEventListener('click', () => {
        document.querySelector('#about').scrollIntoView({ behavior: 'smooth' });
    });
}

// Form validation (for guestbook)
const guestbookForm = document.getElementById('guestbook-form');
if (guestbookForm) {
    guestbookForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const name = document.getElementById('guest-name').value;
        const message = document.getElementById('guest-message').value;
        
        if (name && message) {
            // Show success message
            const successMsg = document.createElement('div');
            successMsg.className = 'bg-primary/20 border border-primary text-white p-4 rounded-xl mt-4 animate-fade-in';
            successMsg.textContent = 'Terima kasih atas pesan Anda! 🎉';
            guestbookForm.appendChild(successMsg);
            
            // Clear form
            guestbookForm.reset();
            
            // Remove success message after 3s
            setTimeout(() => {
                successMsg.remove();
            }, 3000);
        }
    });
}
