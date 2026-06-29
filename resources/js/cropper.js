import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.min.css';

/**
 * Image Cropper Modal System
 * Usage: attach data-cropper="true" and data-target="inputName" to file input
 */

let cropperInstance = null;
let currentFileInput = null;
let currentHiddenInput = null;
let currentPreviewEl = null;
let currentRotation = 0;

const RATIOS = {
    'Bebas': NaN,
    '3:4':   3 / 4,
    '9:16':  9 / 16,
    '16:9':  16 / 9,
    '1:1':   1,
    '4:3':   4 / 3,
};

function createModal() {
    if (document.getElementById('cropper-modal')) return;

    const modal = document.createElement('div');
    modal.id = 'cropper-modal';
    modal.className = 'fixed inset-0 z-[999] flex items-center justify-center bg-black/80 backdrop-blur-sm hidden';
    modal.innerHTML = `
        <div class="relative w-full max-w-2xl mx-4 rounded-2xl overflow-hidden shadow-2xl"
             style="background: rgb(15, 23, 42); border: 1px solid rgba(99,102,241,0.3);">
            
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b" style="border-color: rgba(51,65,85,0.8);">
                <div>
                    <h3 class="text-white font-bold text-lg flex items-center gap-2">
                        <span style="color:#f43f5e;">✕</span> Atur &amp; Crop Foto
                    </h3>
                    <p class="text-xs mt-0.5" style="color: rgb(148,163,184);">Pilih rasio, geser, zoom, lalu klik "Pakai Foto Ini"</p>
                </div>
                <button id="cropper-close" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-700 transition-colors text-lg font-bold">✕</button>
            </div>

            <!-- Ratio Buttons -->
            <div class="flex items-center gap-2 px-6 py-3 border-b" style="border-color: rgba(51,65,85,0.8);">
                <span class="text-xs font-bold uppercase tracking-widest mr-2" style="color: rgb(148,163,184);">Rasio:</span>
                <div class="flex gap-2 flex-wrap" id="ratio-buttons">
                    ${Object.keys(RATIOS).map((r, i) => `
                        <button data-ratio="${r}"
                            class="ratio-btn px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 ${i === 0 ? 'active-ratio' : ''}"
                            style="${i === 0
                                ? 'background: rgb(99,102,241); color: white;'
                                : 'background: rgba(51,65,85,0.6); color: rgb(203,213,225);'}">
                            ${r}
                        </button>
                    `).join('')}
                </div>
            </div>

            <!-- Canvas Area -->
            <div class="relative flex items-center justify-center overflow-hidden" style="background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22><rect width=%228%22 height=%228%22 fill=%22%23374151%22/><rect x=%228%22 y=%228%22 width=%228%22 height=%228%22 fill=%22%23374151%22/><rect x=%228%22 width=%228%22 height=%228%22 fill=%22%234B5563%22/><rect y=%228%22 width=%228%22 height=%228%22 fill=%22%234B5563%22/></svg>'); height: 380px;">
                <img id="cropper-image" src="" alt="Preview" style="max-width:100%; max-height:100%; display:block;">
            </div>

            <!-- Controls -->
            <div class="flex items-center justify-center gap-4 px-6 py-3 border-t" style="border-color: rgba(51,65,85,0.8);">
                <span class="text-xs font-bold uppercase tracking-widest" style="color: rgb(148,163,184);">Zoom:</span>
                <button id="crop-zoom-out" class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-lg transition-colors hover:bg-slate-700" style="background: rgba(51,65,85,0.6);">−</button>
                <button id="crop-zoom-in"  class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-lg transition-colors hover:bg-slate-700" style="background: rgba(51,65,85,0.6);">+</button>
                <button id="crop-rotate"   class="px-4 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-colors hover:bg-slate-700" style="background: rgba(51,65,85,0.6); color: rgb(203,213,225);">↻ Putar</button>
                <button id="crop-reset"    class="px-4 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-colors hover:bg-slate-700" style="background: rgba(51,65,85,0.6); color: rgb(203,213,225);">↺ Reset</button>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between px-6 py-4 border-t" style="border-color: rgba(51,65,85,0.8);">
                <button id="cropper-cancel" class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors hover:bg-slate-700" style="background: rgba(51,65,85,0.6); color: rgb(203,213,225);">Batal</button>
                <button id="cropper-apply"  class="px-6 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:opacity-90 flex items-center gap-2" style="background: linear-gradient(135deg, rgb(99,102,241), rgb(139,92,246));">✓ Pakai Foto Ini</button>
            </div>
        </div>
    `;

    document.body.appendChild(modal);
    bindModalEvents(modal);
}

function bindModalEvents(modal) {
    // Close buttons
    document.getElementById('cropper-close').addEventListener('click', closeModal);
    document.getElementById('cropper-cancel').addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });

    // Ratio buttons
    document.getElementById('ratio-buttons').addEventListener('click', e => {
        const btn = e.target.closest('.ratio-btn');
        if (!btn || !cropperInstance) return;

        document.querySelectorAll('.ratio-btn').forEach(b => {
            b.style.background = 'rgba(51,65,85,0.6)';
            b.style.color = 'rgb(203,213,225)';
        });
        btn.style.background = 'rgb(99,102,241)';
        btn.style.color = 'white';

        const ratio = RATIOS[btn.dataset.ratio];
        cropperInstance.setAspectRatio(ratio);
    });

    // Zoom
    document.getElementById('crop-zoom-in').addEventListener('click',  () => cropperInstance?.zoom(0.1));
    document.getElementById('crop-zoom-out').addEventListener('click', () => cropperInstance?.zoom(-0.1));

    // Rotate
    document.getElementById('crop-rotate').addEventListener('click', () => {
        currentRotation = (currentRotation + 90) % 360;
        cropperInstance?.rotateTo(currentRotation);
    });

    // Reset
    document.getElementById('crop-reset').addEventListener('click', () => {
        currentRotation = 0;
        cropperInstance?.reset();
        // Reset ratio buttons to "Bebas"
        document.querySelectorAll('.ratio-btn').forEach((b, i) => {
            b.style.background = i === 0 ? 'rgb(99,102,241)' : 'rgba(51,65,85,0.6)';
            b.style.color      = i === 0 ? 'white' : 'rgb(203,213,225)';
        });
        cropperInstance?.setAspectRatio(NaN);
    });

    // Apply
    document.getElementById('cropper-apply').addEventListener('click', () => {
        if (!cropperInstance || !currentHiddenInput) return;

        const canvas = cropperInstance.getCroppedCanvas({ maxWidth: 2048, maxHeight: 2048 });
        canvas.toBlob(blob => {
            // Put base64 into hidden input
            const reader = new FileReader();
            reader.onloadend = () => {
                currentHiddenInput.value = reader.result;

                // Show preview if element exists
                if (currentPreviewEl) {
                    currentPreviewEl.src = reader.result;
                    currentPreviewEl.classList.remove('hidden');
                }

                // Update label text
                const label = currentFileInput?.closest('.space-y-2')?.querySelector('.file-chosen-label');
                if (label) label.textContent = 'Foto sudah dipilih ✓';

                closeModal();
            };
            reader.readAsDataURL(blob);
        }, 'image/jpeg', 0.92);
    });
}

function openModal(file, hiddenInput, previewEl, fileInput) {
    currentHiddenInput = hiddenInput;
    currentPreviewEl   = previewEl;
    currentFileInput   = fileInput;
    currentRotation    = 0;

    const reader = new FileReader();
    reader.onload = e => {
        const modal = document.getElementById('cropper-modal');
        const img   = document.getElementById('cropper-image');

        img.src = e.target.result;
        modal.classList.remove('hidden');

        // Reset ratio buttons
        document.querySelectorAll('.ratio-btn').forEach((b, i) => {
            b.style.background = i === 0 ? 'rgb(99,102,241)' : 'rgba(51,65,85,0.6)';
            b.style.color      = i === 0 ? 'white' : 'rgb(203,213,225)';
        });

        // Destroy old instance
        if (cropperInstance) { cropperInstance.destroy(); cropperInstance = null; }

        img.onload = () => {
            cropperInstance = new Cropper(img, {
                viewMode: 1,
                dragMode: 'move',
                aspectRatio: NaN,
                autoCropArea: 0.85,
                restore: false,
                guides: true,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                background: false,
            });
        };
    };
    reader.readAsDataURL(file);
}

function closeModal() {
    const modal = document.getElementById('cropper-modal');
    modal?.classList.add('hidden');
    if (cropperInstance) { cropperInstance.destroy(); cropperInstance = null; }
    // Reset file input so user can re-select same file
    if (currentFileInput) currentFileInput.value = '';
}

// Bootstrap all file inputs with data-cropper attribute
function initCropperInputs() {
    document.querySelectorAll('input[type="file"][data-cropper]').forEach(input => {
        // Create hidden input to hold base64
        const hiddenId = `${input.id}_cropped`;
        let hidden = document.getElementById(hiddenId);
        if (!hidden) {
            hidden = document.createElement('input');
            hidden.type  = 'hidden';
            hidden.name  = input.name;
            hidden.id    = hiddenId;
            input.parentNode.insertBefore(hidden, input.nextSibling);
            // Remove name from file input so hidden takes over
            input.removeAttribute('name');
        }

        // Find preview img if present
        const previewEl = document.getElementById(input.dataset.preview || `${input.id}_preview`);

        input.addEventListener('change', e => {
            const file = e.target.files[0];
            if (!file) return;
            openModal(file, hidden, previewEl, input);
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    createModal();
    initCropperInputs();
});
