// Gallery & Lightbox functionality
class Gallery {
    constructor() {
        this.currentFilter = 'all';
        this.lightbox = null;
        this.createLightbox();
        this.initFilters();
    }
    
    createLightbox() {
        this.lightbox = document.createElement('div');
        this.lightbox.id = 'lightbox';
        this.lightbox.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-black/90 backdrop-blur-sm';
        this.lightbox.innerHTML = `
            <button class="absolute top-8 right-8 text-white hover:text-primary transition-colors z-10" id="close-lightbox">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="lightbox-image" class="max-w-[90%] max-h-[90vh] object-contain rounded-2xl" src="" alt="">
        `;
        document.body.appendChild(this.lightbox);
        
        document.getElementById('close-lightbox').addEventListener('click', () => this.close());
        this.lightbox.addEventListener('click', (e) => {
            if (e.target === this.lightbox) this.close();
        });
    }
    
    open(imageSrc) {
        document.getElementById('lightbox-image').src = imageSrc;
        this.lightbox.classList.remove('hidden');
        this.lightbox.classList.add('flex');
    }
    
    close() {
        this.lightbox.classList.add('hidden');
        this.lightbox.classList.remove('flex');
    }
    
    initFilters() {
        document.addEventListener('DOMContentLoaded', () => {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const galleryItems = document.querySelectorAll('.gallery-item');
            
            filterButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const filter = btn.getAttribute('data-filter');
                    this.currentFilter = filter;
                    
                    // Update active button
                    filterButtons.forEach(b => b.classList.remove('bg-primary', 'text-white'));
                    btn.classList.add('bg-primary', 'text-white');
                    
                    // Filter items
                    galleryItems.forEach(item => {
                        const category = item.getAttribute('data-category');
                        if (filter === 'all' || category === filter) {
                            item.classList.remove('hidden');
                            setTimeout(() => item.classList.add('active'), 10);
                        } else {
                            item.classList.add('hidden');
                        }
                    });
                });
            });
            
            // Gallery item click
            galleryItems.forEach(item => {
                item.addEventListener('click', () => {
                    const img = item.querySelector('img');
                    this.open(img.src);
                });
            });
        });
    }
}

// Initialize gallery
const gallery = new Gallery();

// Lazy loading images
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('img.lazy').forEach(img => {
            imageObserver.observe(img);
        });
    });
}
