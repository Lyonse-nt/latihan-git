import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

const indonesian = {
    months: {
        shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
    },
    weekdays: {
        shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
        longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
    }
};

document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('date_of_birth');
    if (!el) return;

    flatpickr(el, {
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'j F Y',
        locale: indonesian,
        maxDate: 'today',
        allowInput: false,
        disableMobile: true,
    });

    // Style the altInput to match dark theme
    setTimeout(() => {
        const altInput = el.nextElementSibling;
        if (altInput && altInput.classList.contains('flatpickr-input')) {
            altInput.classList.add(
                'w-full', 'bg-slate-950', 'border', 'border-slate-800',
                'rounded-xl', 'px-4', 'py-2.5', 'text-sm', 'text-slate-200',
                'focus:outline-none', 'focus:border-indigo-500', 'transition-colors'
            );
            altInput.style.setProperty('cursor', 'pointer', 'important');
        }
    }, 100);
});
