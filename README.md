# A4A - Antek Antek Akey Website

Website komunitas kelas modern yang dibangun dengan Laravel 12, Tailwind CSS, dan Native JavaScript.

## 🚀 Tech Stack

- **Laravel 12** - Backend Framework
- **Tailwind CSS 4.0** - Styling
- **Native JavaScript** - Interactivity & Animations
- **Vite** - Build Tool
- **Blade Template** - View Engine

## ✨ Features

- **Modern Dark Mode Design** - Premium UI/UX dengan style guide terinspirasi dari Apple, Linear, Framer
- **Smooth Animations** - Fade up, scale, counter animations, scroll reveal
- **Interactive Components** - Modal, lightbox, auto slider, smooth scroll
- **Responsive Layout** - Mobile-first design yang responsive di semua device
- **Glassmorphism Effects** - Modern glass effect dengan backdrop blur
- **Performance Optimized** - Lazy loading, Intersection Observer API

## 🎨 Style Guide

### Colors
- Background: `#09090B`
- Primary: `#6366F1`
- Secondary: `#8B5CF6`
- Accent: `#22D3EE`
- Card: `#18181B`

### Typography
- Heading: **Sora**
- Body: **Poppins**

## 📦 Installation

1. Clone repository
2. Install dependencies

```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Run development server
```bash
npm run dev
php artisan serve
```

5. Open browser
```
http://localhost:8000
```

## 📁 Project Structure

```
resources/
├── css/
│   ├── app.css              # Main CSS with Tailwind config
│   ├── animations.css       # Animation utilities
│   └── variables.css        # CSS variables
├── js/
│   ├── app.js              # Main JavaScript entry
│   ├── navbar.js           # Navbar functionality
│   ├── counter.js          # Counter animations
│   ├── reveal.js           # Scroll reveal animations
│   ├── modal.js            # Modal functionality
│   ├── gallery.js          # Gallery & lightbox
│   ├── api.js              # Fetch API utilities
│   └── utils.js            # Helper functions
└── views/
    ├── layouts/
    │   └── app.blade.php   # Main layout
    ├── components/
    │   ├── navbar.blade.php
    │   ├── footer.blade.php
    │   ├── hero.blade.php
    │   ├── about.blade.php
    │   ├── statistics.blade.php
    │   ├── members.blade.php
    │   ├── memories.blade.php
    │   ├── timeline.blade.php
    │   ├── hall-of-fame.blade.php
    │   ├── quotes.blade.php
    │   └── guestbook.blade.php
    └── pages/
        └── home.blade.php
```

## 🎯 Sections

1. **Hero** - Full screen hero dengan gradient background
2. **About** - Penjelasan komunitas dengan layout dua kolom
3. **Statistics** - Counter animation untuk statistik
4. **Meet The Squad** - Grid 16 member cards dengan modal
5. **Memories** - Masonry gallery dengan filter dan lightbox
6. **Timeline** - Timeline vertikal dengan scroll animations
7. **Hall of Fame** - Awards dan achievement
8. **Quotes** - Auto slider quotes
9. **Guestbook** - Form modern untuk pesan
10. **Footer** - Informasi kontak dan social media

## 🔮 Future Development

- Backend API integration untuk data dinamis
- Member detail pages
- Admin panel untuk manage content
- Gallery upload functionality
- Guestbook dengan database
- Authentication system

## 👥 Team

Dibuat dengan ❤️ oleh **A4A Team** (Antek Antek Akey)

---

**Built by Code. Bound by Friendship.**
