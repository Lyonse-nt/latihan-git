# 🚀 Quick Start Guide - A4A Website

## Prasyarat

Pastikan Anda memiliki:
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js 18 atau lebih tinggi
- NPM atau Yarn

## Instalasi Cepat

### 1. Clone atau Download Project
```bash
cd path/to/project
```

### 2. Install Dependencies

**Backend (Laravel):**
```bash
composer install
```

**Frontend (Node packages):**
```bash
npm install
```

### 3. Environment Setup

Copy file environment:
```bash
cp .env.example .env
```

Generate application key:
```bash
php artisan key:generate
```

### 4. Jalankan Development Server

**Terminal 1 - Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 - Vite Dev Server:**
```bash
npm run dev
```

### 5. Buka Browser

Akses website di:
```
http://localhost:8000
```

## 🎨 Customization Guide

### Mengubah Data Member

Edit file: `resources/views/components/members.blade.php`

Atau gunakan data dari JSON (untuk integrasi nanti):
`public/data/members.json`

### Mengubah Warna

Edit: `resources/css/app.css`
```css
@theme {
    --color-primary: #6366F1;  /* Ubah warna primary */
    --color-secondary: #8B5CF6; /* Ubah warna secondary */
    --color-accent: #22D3EE;   /* Ubah warna accent */
}
```

### Menambah Section Baru

1. Buat file component baru:
```bash
resources/views/components/section-baru.blade.php
```

2. Include di home page:
```blade
@include('components.section-baru')
```

3. Tambahkan link di navbar

### Mengubah Animasi

Edit: `resources/css/animations.css`

Atau ubah timing di JavaScript files di `resources/js/`

## 📱 Testing Responsive

Gunakan browser DevTools untuk test di berbagai ukuran:
- Mobile: 375px
- Tablet: 768px
- Laptop: 1024px
- Desktop: 1920px

## 🔧 Troubleshooting

### Error: Vite manifest not found
```bash
npm run build
# atau
npm run dev
```

### CSS tidak muncul
```bash
php artisan optimize:clear
npm run build
```

### JavaScript tidak berfungsi
Cek console browser (F12) untuk error messages

### Fonts tidak muncul
Pastikan koneksi internet aktif (Google Fonts)

## 📦 Production Build

Untuk production:

1. Build assets:
```bash
npm run build
```

2. Optimize Laravel:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Set environment:
```env
APP_ENV=production
APP_DEBUG=false
```

## 🔐 Keamanan

Sebelum deploy:
1. Update `.env` dengan kredensial production
2. Set `APP_KEY` yang unique
3. Nonaktifkan debug mode
4. Setup HTTPS
5. Configure CORS jika menggunakan API

## 📚 Struktur File Penting

```
├── resources/
│   ├── css/           # Styling
│   ├── js/            # JavaScript
│   └── views/         # Blade templates
├── routes/
│   └── web.php        # Web routes
├── public/
│   └── data/          # JSON data dummy
├── README.md          # Dokumentasi utama
├── FEATURES.md        # Detail fitur
└── QUICKSTART.md      # Guide ini
```

## 🆘 Bantuan

Jika mengalami masalah:
1. Cek log Laravel: `storage/logs/laravel.log`
2. Cek console browser untuk JavaScript errors
3. Pastikan semua dependencies terinstall
4. Clear cache: `php artisan optimize:clear`

## 🎯 Next Steps

Setelah setup berhasil:
1. ✅ Ganti placeholder data dengan data real
2. ✅ Upload gambar member ke `/public/images`
3. ✅ Customize warna sesuai preferensi
4. ✅ Setup backend API (opsional)
5. ✅ Deploy ke hosting

## 🚀 Deploy

### Vercel (Recommended untuk Laravel)
```bash
npm install -g vercel
vercel
```

### Shared Hosting
1. Upload semua files
2. Point domain ke `/public`
3. Set permissions untuk `/storage` dan `/bootstrap/cache`
4. Run composer install di server

---

**Happy Coding! 🎉**

*Built by Code. Bound by Friendship.*
