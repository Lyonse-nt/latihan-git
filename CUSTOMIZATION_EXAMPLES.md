# 🎨 Customization Examples - A4A Website

## Quick Customization Guide

### 1. Mengubah Warna Tema

**File:** `resources/css/app.css`

```css
@theme {
    /* Original Colors */
    --color-primary: #6366F1;    /* Indigo */
    --color-secondary: #8B5CF6;  /* Purple */
    --color-accent: #22D3EE;     /* Cyan */
    
    /* Example: Blue Theme */
    --color-primary: #3B82F6;    /* Blue */
    --color-secondary: #06B6D4;  /* Cyan */
    --color-accent: #10B981;     /* Green */
    
    /* Example: Pink Theme */
    --color-primary: #EC4899;    /* Pink */
    --color-secondary: #F43F5E;  /* Rose */
    --color-accent: #F59E0B;     /* Amber */
}
```

### 2. Mengubah Font

**File:** `resources/css/app.css`

```css
/* Original Fonts */
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap');

/* Example: Change to Inter + Outfit */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap');

@theme {
    --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
}
```

**Update Blade templates:**
```blade
<!-- Change from: -->
<h2 class="font-['Sora']">Title</h2>

<!-- To: -->
<h2 class="font-['Outfit']">Title</h2>
```

### 3. Mengubah Data Member

**File:** `resources/views/components/members.blade.php`

**Option A: Langsung di Blade**
```blade
@php
$members = [
    ['name' => 'John Doe', 'nickname' => 'The Coder', 'role' => 'Full Stack'],
    ['name' => 'Jane Smith', 'nickname' => 'Designer', 'role' => 'UI/UX'],
    // ... 14 members lagi
];
@endphp

@foreach($members as $member)
<div class="member-card" data-name="{{ $member['name'] }}">
    <!-- ... -->
</div>
@endforeach
```

**Option B: Dari Controller (Recommended)**
```php
// routes/web.php
Route::get('/', function () {
    $members = [
        ['name' => 'John', 'nickname' => 'Coder', 'role' => 'Dev'],
        // ...
    ];
    return view('pages.home', compact('members'));
});
```

### 4. Menambah Section Baru

**Step 1: Create Component**

File: `resources/views/components/testimonials.blade.php`
```blade
<section id="testimonials" class="py-24 px-6">
    <div class="container mx-auto max-w-6xl">
        <h2 class="text-5xl font-bold font-['Sora'] text-center mb-16 gradient-text animate-fade-up">
            What People Say
        </h2>
        
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Testimonial cards here -->
        </div>
    </div>
</section>
```

**Step 2: Include in Home**

File: `resources/views/pages/home.blade.php`
```blade
@include('components.testimonials')
```

**Step 3: Add to Navbar**

File: `resources/views/components/navbar.blade.php`
```blade
<a href="#testimonials" class="nav-link">Testimonials</a>
```

### 5. Mengubah Hero Background

**Option A: Gradient**
```blade
<!-- In components/hero.blade.php -->
<div class="absolute inset-0 bg-gradient-to-br from-[#6366F1]/20 via-[#09090B] to-[#EC4899]/20"></div>
```

**Option B: Image + Overlay**
```blade
<div class="absolute inset-0">
    <img src="/images/hero-bg.jpg" class="w-full h-full object-cover opacity-30">
    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#09090B]"></div>
</div>
```

**Option C: Animated Particles** (Requires library)
```html
<div id="particles-js" class="absolute inset-0"></div>
```

### 6. Mengubah Animation Speed

**File:** `resources/css/animations.css`

```css
/* Slower animations */
.animate-fade-up {
    transition: opacity 1s ease-out, transform 1s ease-out; /* from 0.6s */
}

/* Faster animations */
.animate-fade-up {
    transition: opacity 0.3s ease-out, transform 0.3s ease-out;
}

/* Counter animation speed */
```

**File:** `resources/js/counter.js`
```javascript
// Change duration parameter
function animateCounter(element, target, duration = 3000) { // from 2000
    // ...
}
```

### 7. Menambah Social Media Links

**File:** `resources/views/components/footer.blade.php`

```blade
<!-- Add TikTok -->
<a href="#" class="w-10 h-10 bg-[#6366F1]/20 hover:bg-[#6366F1] rounded-full flex items-center justify-center transition-colors">
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
        <!-- TikTok icon path -->
    </svg>
</a>

<!-- Add LinkedIn -->
<a href="#" class="w-10 h-10 bg-[#6366F1]/20 hover:bg-[#6366F1] rounded-full flex items-center justify-center transition-colors">
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
        <!-- LinkedIn icon path -->
    </svg>
</a>
```

### 8. Custom Gallery Categories

**File:** `resources/views/components/memories.blade.php`

```blade
<!-- Add new filter button -->
<button class="filter-btn" data-filter="coding">Coding Session</button>
<button class="filter-btn" data-filter="workshop">Workshops</button>

<!-- Add data-category to images -->
<div class="gallery-item" data-category="coding">
    <img src="..." alt="Coding">
</div>
```

### 9. Mengubah Counter Values

**File:** `resources/views/components/statistics.blade.php`

```blade
<!-- Change target values -->
<span class="counter" data-target="20">0</span> <!-- from 16 -->
<span class="counter" data-target="100">0</span>+ <!-- from 42 -->
<span class="counter" data-target="50">0</span>+ <!-- from 28 -->
<span class="counter" data-target="1000">0</span>+ <!-- from 500 -->
```

### 10. Custom Modal Content

**File:** `resources/js/modal.js`

Update the modal content template:
```javascript
const content = `
    <div class="text-center">
        <img src="${image}" class="w-32 h-32 rounded-full mx-auto mb-6">
        <h3 class="text-3xl font-bold mb-2">${name}</h3>
        <p class="text-accent text-xl mb-2">"${nickname}"</p>
        <p class="text-secondary text-lg mb-6">${role}</p>
        
        <!-- Add custom sections -->
        <div class="mt-8 space-y-4 text-left">
            <div>
                <h4 class="font-bold text-primary mb-2">Skills</h4>
                <div class="flex gap-2 flex-wrap">
                    <span class="px-3 py-1 bg-primary/20 rounded-full text-sm">JavaScript</span>
                    <span class="px-3 py-1 bg-primary/20 rounded-full text-sm">Laravel</span>
                </div>
            </div>
            
            <div>
                <h4 class="font-bold text-primary mb-2">Bio</h4>
                <p class="text-gray-400">${bio}</p>
            </div>
        </div>
    </div>
`;
```

### 11. Menambah Smooth Hover Effects

**File:** `resources/css/animations.css`

```css
/* Glow on hover */
.card-glow:hover {
    box-shadow: 0 0 30px rgba(99, 102, 241, 0.5);
}

/* Rotate on hover */
.card-rotate:hover {
    transform: rotate(2deg) scale(1.05);
}

/* Slide up border */
.slide-border {
    position: relative;
}

.slide-border::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--color-primary);
    transition: width 0.3s;
}

.slide-border:hover::after {
    width: 100%;
}
```

### 12. Custom Loading State

**File:** `resources/js/utils.js`

```javascript
// Add loading spinner
function showLoading() {
    const loader = document.createElement('div');
    loader.id = 'loader';
    loader.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/80';
    loader.innerHTML = `
        <div class="animate-spin rounded-full h-16 w-16 border-4 border-primary border-t-transparent"></div>
    `;
    document.body.appendChild(loader);
}

function hideLoading() {
    document.getElementById('loader')?.remove();
}
```

### 13. Add Page Transitions

**File:** `resources/css/animations.css`

```css
.page-transition {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
```

**Apply to body:**
```blade
<body class="page-transition">
```

### 14. Custom Scroll Progress Bar

**File:** `resources/js/navbar.js`

```javascript
// Add to navbar
const progressBar = document.createElement('div');
progressBar.className = 'fixed top-0 left-0 h-1 bg-primary z-50';
progressBar.id = 'scroll-progress';
document.body.appendChild(progressBar);

window.addEventListener('scroll', () => {
    const height = document.documentElement.scrollHeight - window.innerHeight;
    const scrolled = (window.scrollY / height) * 100;
    progressBar.style.width = scrolled + '%';
});
```

### 15. Add Dark/Light Mode Toggle

**File:** `resources/js/utils.js`

```javascript
const themeToggle = document.getElementById('theme-toggle');

themeToggle?.addEventListener('click', () => {
    document.body.classList.toggle('light-mode');
    localStorage.setItem('theme', 
        document.body.classList.contains('light-mode') ? 'light' : 'dark'
    );
});

// Load saved theme
if (localStorage.getItem('theme') === 'light') {
    document.body.classList.add('light-mode');
}
```

**Add CSS for light mode:**
```css
.light-mode {
    --color-background: #FFFFFF;
    --color-text: #09090B;
    --color-card: #F3F4F6;
}
```

---

## 🎯 Tips for Customization

1. **Test changes in dev environment** before deploying
2. **Keep backup** of original files
3. **Use Git** to track changes
4. **Comment your code** for future reference
5. **Test responsiveness** after changes
6. **Check browser console** for errors
7. **Maintain consistent design language**

---

**Experiment and make it yours!** 🎨
