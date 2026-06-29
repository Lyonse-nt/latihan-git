# Development Guide - A4A Website

## 🏗️ Arsitektur Project

### Frontend Architecture
```
Frontend (Blade + Tailwind + JS)
├── Layouts (app.blade.php)
├── Components (modular sections)
├── Pages (home.blade.php)
└── Assets (CSS + JS)
```

### File Organization

**Views:**
- `layouts/` - Template dasar
- `components/` - Section reusable
- `pages/` - Halaman lengkap

**JavaScript:**
- `app.js` - Entry point
- `navbar.js` - Navigation logic
- `modal.js` - Modal functionality
- `gallery.js` - Gallery & lightbox
- `counter.js` - Counter animations
- `reveal.js` - Scroll animations
- `utils.js` - Helper functions
- `api.js` - API utilities (Fetch)

**CSS:**
- `app.css` - Main styles + Tailwind
- `animations.css` - Animation utilities
- `variables.css` - CSS variables

## 🎯 Coding Standards

### Blade Templates

**DO:**
```blade
<!-- Good: Clear component names -->
@include('components.hero')
@include('components.members')

<!-- Good: Use blade directives -->
@foreach($items as $item)
    <div>{{ $item->name }}</div>
@endforeach
```

**DON'T:**
```blade
<!-- Bad: Inline PHP -->
<?php echo $variable; ?>

<!-- Bad: Complex logic in views -->
@php
    $complex = expensive_operation();
@endphp
```

### JavaScript

**DO:**
```javascript
// Good: Modular functions
class Gallery {
    constructor() { }
    open(src) { }
    close() { }
}

// Good: Event delegation
document.addEventListener('DOMContentLoaded', () => {
    init();
});
```

**DON'T:**
```javascript
// Bad: Global pollution
var x = 10;
function doSomething() { }

// Bad: Inline event handlers
<button onclick="doSomething()">
```

### CSS/Tailwind

**DO:**
```html
<!-- Good: Tailwind utilities -->
<div class="glass p-8 rounded-3xl hover-lift">

<!-- Good: Custom animation classes -->
<div class="animate-fade-up animate-scale">
```

**DON'T:**
```html
<!-- Bad: Inline styles -->
<div style="padding: 20px; border-radius: 24px;">

<!-- Bad: Too specific classes -->
<div class="px-8 py-8 pb-10 pt-6 pl-9">
```

## 📝 Component Development

### Creating New Component

1. **Create Blade File:**
```bash
resources/views/components/my-section.blade.php
```

2. **Add Structure:**
```blade
<section id="my-section" class="py-24 px-6">
    <div class="container mx-auto max-w-6xl">
        <h2 class="text-5xl font-bold font-['Sora'] text-center mb-16 gradient-text animate-fade-up">
            Section Title
        </h2>
        
        <!-- Content here -->
    </div>
</section>
```

3. **Include in Home:**
```blade
@include('components.my-section')
```

4. **Add to Navbar:**
```html
<a href="#my-section" class="nav-link">My Section</a>
```

### Component Checklist
- ✅ Responsive design (mobile-first)
- ✅ Animation classes applied
- ✅ Proper spacing (py-24 px-6)
- ✅ Container max-width
- ✅ Accessibility (semantic HTML)
- ✅ Glass effect where appropriate

## 🎨 Animation Guidelines

### Using Scroll Animations

**Apply to elements:**
```html
<div class="animate-fade-up">Content</div>
<div class="animate-fade-in">Content</div>
<div class="animate-scale">Content</div>
```

**Classes are activated by JavaScript when element is visible**

### Custom Animations

Add to `animations.css`:
```css
@keyframes my-animation {
    from { }
    to { }
}

.my-class {
    animation: my-animation 1s ease;
}
```

## 🔌 API Integration (Future)

### Setup for Backend

Current structure ready for API:

```javascript
// In api.js
const members = await api.get('/members');
const quotes = await api.get('/quotes');
```

### Adding API Calls

1. Define endpoint in `api.js`
2. Call from component JavaScript
3. Update DOM with response

Example:
```javascript
// Load members dynamically
async function loadMembers() {
    try {
        const members = await api.get('/api/members');
        renderMembers(members);
    } catch (error) {
        console.error('Failed to load members:', error);
    }
}
```

## 🧪 Testing

### Manual Testing Checklist

**Functionality:**
- [ ] All links work
- [ ] Smooth scroll to sections
- [ ] Modal opens/closes
- [ ] Gallery filter works
- [ ] Lightbox opens
- [ ] Form validation
- [ ] Animations trigger

**Responsive:**
- [ ] Mobile (< 640px)
- [ ] Tablet (640-1024px)
- [ ] Desktop (> 1024px)

**Browsers:**
- [ ] Chrome
- [ ] Firefox
- [ ] Safari
- [ ] Edge

**Performance:**
- [ ] Images lazy load
- [ ] No layout shift
- [ ] Smooth animations
- [ ] Fast page load

## 🐛 Debugging

### Common Issues

**Animations not working:**
```javascript
// Check if reveal.js is loaded
console.log('Reveal loaded');

// Check if elements have animation classes
document.querySelectorAll('.animate-fade-up').forEach(el => {
    console.log(el);
});
```

**Modal not opening:**
```javascript
// Check modal creation
console.log(memberModal);

// Check event listeners
document.querySelectorAll('.member-card').forEach(card => {
    console.log('Card:', card);
});
```

**Styles not applying:**
```bash
# Clear Laravel cache
php artisan optimize:clear

# Rebuild assets
npm run build
```

## 📊 Performance Optimization

### Image Optimization

```html
<!-- Use lazy loading -->
<img class="lazy" data-src="image.jpg" alt="Description">

<!-- Specify dimensions -->
<img width="400" height="300" src="image.jpg">

<!-- Use appropriate formats -->
<!-- WebP for photos, SVG for icons -->
```

### JavaScript Optimization

```javascript
// Debounce scroll events
let timeout;
window.addEventListener('scroll', () => {
    clearTimeout(timeout);
    timeout = setTimeout(handleScroll, 100);
});

// Use Intersection Observer instead of scroll
const observer = new IntersectionObserver(callback);
```

### CSS Optimization

```css
/* Use transform instead of position */
/* Good */
.element { transform: translateY(-10px); }

/* Avoid */
.element { top: -10px; }

/* Minimize repaints */
.element {
    will-change: transform;
    transform: translateZ(0);
}
```

## 🔄 Git Workflow

### Branch Strategy
```bash
main          # Production
develop       # Development
feature/xyz   # New features
fix/xyz       # Bug fixes
```

### Commit Messages
```bash
# Good
git commit -m "Add member modal functionality"
git commit -m "Fix navbar scroll behavior"
git commit -m "Update hero section animations"

# Bad
git commit -m "update"
git commit -m "fix bug"
git commit -m "changes"
```

## 📚 Resources

### Documentation
- [Laravel 12 Docs](https://laravel.com/docs/12.x)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [MDN Web Docs](https://developer.mozilla.org/)

### Design Inspiration
- [Apple](https://apple.com)
- [Linear](https://linear.app)
- [Framer](https://framer.com)

### Tools
- [Unsplash](https://unsplash.com) - Free images
- [Heroicons](https://heroicons.com) - SVG icons
- [Google Fonts](https://fonts.google.com)

---

## 🚀 Deployment Checklist

Before deploying to production:

- [ ] Update `.env` with production values
- [ ] Run `npm run build`
- [ ] Run `php artisan optimize`
- [ ] Test all functionality
- [ ] Check mobile responsiveness
- [ ] Verify all images load
- [ ] Test forms
- [ ] Check console for errors
- [ ] Set `APP_DEBUG=false`
- [ ] Setup HTTPS
- [ ] Configure CDN (optional)

---

**Happy Coding!** 🎉
