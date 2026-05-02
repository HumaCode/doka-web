/* ════════════════════════════════════
   GLOBAL VARIABLES & CONFIG
════════════════════════════════════ */
let editor;
const tags = new Set();
let uploadedPhotos = [];
const MAX_PHOTOS = 20;

/* ════════════════════════════════════
   TAGS INPUT LOGIC
════════════════════════════════════ */
function initTags() {
    const tagInput = document.getElementById('tagInput');
    const tagsWrap = document.getElementById('tagsWrap');

    if (!tagInput || !tagsWrap) return;

    tagInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            const val = tagInput.value.trim().toLowerCase().replace(/[^a-z0-9-]/g, '');
            if (val && !tags.has(val)) {
                tags.add(val);
                renderTags();
            }
            tagInput.value = '';
        }
    });

    // Backspace to delete last tag
    tagInput.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && tagInput.value === '' && tags.size > 0) {
            const lastTag = Array.from(tags).pop();
            tags.delete(lastTag);
            renderTags();
        }
    });
}

function renderTags() {
    const tagInput = document.getElementById('tagInput');
    const tagsWrap = document.getElementById('tagsWrap');
    
    // Clear current tags except input
    const items = tagsWrap.querySelectorAll('.tag-item');
    items.forEach(item => item.remove());

    // Render new tags
    tags.forEach(tag => {
        const span = document.createElement('span');
        span.className = 'tag-item';
        span.innerHTML = `
            ${tag}
            <button type="button" class="tag-remove" onclick="removeTag('${tag}')" aria-label="Hapus tag ${tag}">
                <i class="bi bi-x"></i>
            </button>
        `;
        tagsWrap.insertBefore(span, tagInput);
    });
}

function removeTag(tag) {
    tags.delete(tag);
    renderTags();
}

/* ════════════════════════════════════
   PHOTO UPLOAD LOGIC
════════════════════════════════════ */
function handleFileSelect(e) {
    const files = e.target.files;
    processFiles(files);
}

function handleDocSelect(e) {
    const files = e.target.files;
    const wrap = document.getElementById('docPreview');
    if (!wrap) return;

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const item = document.createElement('div');
        item.style = "display:flex;align-items:center;gap:8px;padding:8px 10px;background:var(--c-surface2);border:1px solid var(--c-border);border-radius:8px;font-size:.75rem;color:var(--c-text-2);animation:fadeUp .3s both;";
        
        let icon = 'bi-file-earmark';
        if (file.name.endsWith('.pdf')) icon = 'bi-file-earmark-pdf-fill';
        else if (file.name.endsWith('.docx') || file.name.endsWith('.doc')) icon = 'bi-file-earmark-word-fill';
        else if (file.name.endsWith('.xlsx') || file.name.endsWith('.xls')) icon = 'bi-file-earmark-excel-fill';
        else if (file.name.endsWith('.pptx')) icon = 'bi-file-earmark-slides-fill';

        item.innerHTML = `
            <i class="bi ${icon}" style="font-size:1rem;color:var(--c-primary);"></i>
            <div style="flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${file.name}</div>
            <button type="button" style="border:none;background:none;color:var(--c-red);cursor:pointer;" onclick="this.parentElement.remove()">
                <i class="bi bi-x-circle-fill"></i>
            </button>
        `;
        wrap.appendChild(item);
    }
}

function processFiles(files) {
    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        // Validation
        if (!file.type.startsWith('image/')) {
            DKA.notify({ type: 'error', title: 'File Ditolak', message: `${file.name} bukan file gambar.` });
            continue;
        }
        if (file.size > 5 * 1024 * 1024) {
            DKA.notify({ type: 'warning', title: 'File Terlalu Besar', message: `${file.name} melebihi 5MB.` });
            continue;
        }
        if (uploadedPhotos.length >= MAX_PHOTOS) {
            DKA.notify({ type: 'warning', title: 'Limit Tercapai', message: `Maksimal ${MAX_PHOTOS} foto per kegiatan.` });
            break;
        }

        const reader = new FileReader();
        reader.onload = (event) => {
            uploadedPhotos.push({
                id: Date.now() + Math.random(),
                src: event.target.result,
                name: file.name,
                size: file.size
            });
            renderPhotoPreviews();
        };
        reader.readAsDataURL(file);
    }
}

function renderPhotoPreviews() {
    const wrap = document.getElementById('photoPreviewWrap');
    if (!wrap) return;
    wrap.innerHTML = '';

    uploadedPhotos.forEach((photo, index) => {
        const item = document.createElement('div');
        item.className = 'photo-item';
        item.innerHTML = `
            <img src="${photo.src}" alt="${photo.name}">
            <div class="photo-item-num">${index + 1}</div>
            ${index === 0 ? '<div class="photo-main-badge">COVER UTAMA</div>' : ''}
            <div class="photo-item-overlay">
                <button type="button" class="photo-item-btn photo-btn-view" onclick="previewImage('${photo.src}')" title="Lihat">
                    <i class="bi bi-eye-fill"></i>
                </button>
                <button type="button" class="photo-item-btn photo-btn-delete" onclick="removePhoto(${photo.id})" title="Hapus">
                    <i class="bi bi-trash3-fill"></i>
                </button>
            </div>
        `;
        wrap.appendChild(item);
    });

    updatePhotoCounter();
}

function removePhoto(id) {
    uploadedPhotos = uploadedPhotos.filter(p => p.id !== id);
    renderPhotoPreviews();
}

function clearPhotos() {
    if (uploadedPhotos.length === 0) return;
    DKA.deleteConfirm({
        title: 'Kosongkan Foto?',
        message: 'Semua foto yang telah dipilih akan dihapus dari daftar.',
        itemName: 'Koleksi Foto'
    }).then(res => {
        if (res) {
            uploadedPhotos = [];
            renderPhotoPreviews();
        }
    });
}

function updatePhotoCounter() {
    const count = uploadedPhotos.length;
    const label = document.getElementById('photoCountLabel');
    const fill = document.getElementById('photoCounterFill');
    const num = document.getElementById('photoCounterNum');

    if (label) label.innerText = `${count} / ${MAX_PHOTOS}`;
    if (fill) {
        const pct = (count / MAX_PHOTOS) * 100;
        fill.style.width = `${pct}%`;
        fill.style.background = pct > 90 ? 'var(--c-red)' : (pct > 70 ? 'var(--c-accent)' : 'linear-gradient(90deg,var(--c-primary),var(--c-secondary))');
    }
    if (num) num.innerText = `${count} / ${MAX_PHOTOS}`;
}

/* ════════════════════════════════════
   UI HELPERS & VALIDATION
════════════════════════════════════ */
function charCount(el, targetId, max) {
    const count = el.value.length;
    const counter = document.getElementById(targetId);
    if (!counter) return;

    counter.innerText = `${count} / ${max}`;
    if (count >= max) {
        counter.classList.add('over');
        counter.classList.remove('warn');
    } else if (count >= max * 0.8) {
        counter.classList.add('warn');
        counter.classList.remove('over');
    } else {
        counter.classList.remove('warn', 'over');
    }
}

function clearErr(groupId) {
    const group = document.getElementById(groupId);
    if (group) group.classList.remove('has-err');
}

function previewImage(src) {
    const overlay = document.getElementById('previewOverlay');
    const img = document.getElementById('previewImg');
    if (!overlay || !img) return;

    img.src = src;
    overlay.classList.add('show');
}

function closePreview() {
    const overlay = document.getElementById('previewOverlay');
    if (overlay) overlay.classList.remove('show');
}

/* ════════════════════════════════════
   FORM ACTIONS
════════════════════════════════════ */
function submitForm(isDraft = false) {
    // Basic Validation
    let hasError = false;

    const judul = document.getElementById('f-judul').value.trim();
    if (!judul) {
        document.getElementById('grp-judul').classList.add('has-err');
        hasError = true;
    }

    const tgl = document.getElementById('f-tanggal').value;
    if (!tgl) {
        document.getElementById('grp-tanggal').classList.add('has-err');
        hasError = true;
    }

    const kat = document.getElementById('f-kategori').value;
    if (!kat) {
        document.getElementById('grp-kategori').classList.add('has-err');
        hasError = true;
    }

    const content = editor ? editor.getData().trim() : '';
    if (!content) {
        document.getElementById('ck-wrap').classList.add('is-invalid');
        document.getElementById('grp-uraian').classList.add('has-err');
        hasError = true;
    } else {
        document.getElementById('ck-wrap').classList.remove('is-invalid');
        document.getElementById('grp-uraian').classList.remove('has-err');
    }

    if (uploadedPhotos.length === 0 && !isDraft) {
        document.getElementById('uploadZone').classList.add('is-invalid');
        DKA.notify({ type: 'error', title: 'Foto Wajib', message: 'Unggah minimal 1 foto untuk publikasi.' });
        hasError = true;
    } else {
        document.getElementById('uploadZone').classList.remove('is-invalid');
    }

    if (hasError) {
        DKA.notify({ type: 'error', title: 'Form Belum Lengkap', message: 'Silakan periksa kembali kolom yang bertanda merah.' });
        // Scroll to first error
        const firstErr = document.querySelector('.has-err');
        if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    // Success State
    const btnSubmit = document.querySelector(isDraft ? '.btn-draft' : '.btn-submit');
    const oldText = btnSubmit.innerHTML;
    btnSubmit.disabled = true;
    btnSubmit.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...`;

    setTimeout(() => {
        DKA.notify({ 
            type: 'success', 
            title: isDraft ? 'Draf Disimpan' : 'Publikasi Berhasil', 
            message: isDraft ? 'Kegiatan berhasil disimpan di folder draf.' : 'Kegiatan telah berhasil dipublikasikan ke publik.'
        });
        
        setTimeout(() => {
            window.location.href = '/kegiatan';
        }, 1500);
    }, 2000);
}

function cancelForm() {
    DKA.deleteConfirm({
        title: 'Batalkan Pengisian?',
        message: 'Data yang telah Anda masukkan tidak akan disimpan.',
        itemName: 'Formulir Kegiatan'
    }).then(res => {
        if (res) window.location.href = '/kegiatan';
    });
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

/* ════════════════════════════════════
   INITIALIZATION
════════════════════════════════════ */
$(document).ready(function() {
    // 1. Tags Init
    initTags();

    // 2. CKEditor Init
    if (document.querySelector('#editor-uraian')) {
        ClassicEditor
            .create(document.querySelector('#editor-uraian'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'insertTable', 'blockQuote', 'undo', 'redo'],
                placeholder: 'Tuliskan detail jalannya kegiatan di sini...'
            })
            .then(newEditor => {
                editor = newEditor;
                editor.model.document.on('change:data', () => {
                    if (editor.getData().trim()) {
                        document.getElementById('ck-wrap').classList.remove('is-invalid');
                        document.getElementById('grp-uraian').classList.remove('has-err');
                    }
                });
            })
            .catch(error => { console.error(error); });
    }

    // 3. Drag & Drop Zone
    const zone = document.getElementById('uploadZone');
    if (zone) {
        zone.addEventListener('dragover', (e) => {
            e.preventDefault();
            zone.classList.add('drag-over');
        });
        zone.addEventListener('dragleave', () => {
            zone.classList.remove('drag-over');
        });
        zone.addEventListener('drop', (e) => {
            e.preventDefault();
            zone.classList.remove('drag-over');
            const files = e.dataTransfer.files;
            processFiles(files);
        });
    }

    // 4. Scroll FAB
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            $('#fabBtn').addClass('visible');
        } else {
            $('#fabBtn').removeClass('visible');
        }
    });

    // 5. Tooltips (if Bootstrap enabled)
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
