/**
 * ═══════════════════════════════════════
 * KEGIATAN FORM JS (ADD/EDIT)
 * ═══════════════════════════════════════
 */

let editor;
const tags = new Set();
let uploadedPhotos = [];
let uploadedDocs = []; // Tracks selected document files
const MAX_PHOTOS = 20;

$(document).ready(function() {
    // 1. Initialize Flatpickr (Time)
    if ($('#f-waktu').length) {
        flatpickr("#f-waktu", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            allowInput: true,
            disableMobile: "true"
        });
    }

    // 2. Initialize Select2 (Kategori & Unit Kerja)
    if ($('#f-kategori').length) {
        $('#f-kategori').select2({
            placeholder: '-- Pilih Kategori --',
            allowClear: true,
            width: '100%'
        }).on('change', function() {
            $('#grp-kategori').removeClass('has-err');
        });
    }
    if ($('#f-unit').length) {
        $('#f-unit').select2({
            placeholder: '-- Pilih Unit --',
            allowClear: true,
            width: '100%'
        });
    }

    // 3. Initialize CKEditor 5
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
                        $('#ck-wrap').removeClass('is-invalid');
                        $('#grp-uraian').removeClass('has-err');
                    }
                });
            })
            .catch(error => console.error(error));
    }

    // 3. Initialize Tags
    initTags();

    // 4. Drag & Drop Zone
    const zone = document.getElementById('uploadZone');
    if (zone) {
        zone.addEventListener('dragover', (e) => { e.preventDefault(); zone.classList.add('drag-over'); });
        zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
        zone.addEventListener('drop', (e) => {
            e.preventDefault();
            zone.classList.remove('drag-over');
            processFiles(e.dataTransfer.files);
        });
    }

    // 5. Scroll FAB
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) $('#fabBtn').addClass('visible');
        else $('#fabBtn').removeClass('visible');
    });

    // 6. Handle Edit Mode Initialization
    if ($('#mainForm').data('mode') === 'edit') {
        initEditMode();
    }
});

/* ════════════════════════════════════
   EDIT MODE LOGIC
════════════════════════════════════ */
let deletedMediaIds = [];

function initEditMode() {
    // Tags
    if (window.existingTags && Array.isArray(window.existingTags)) {
        window.existingTags.forEach(t => tags.add(t));
        renderTags();
    }

    // Photos
    if (window.existingMedia && window.existingMedia.photos) {
        window.existingMedia.photos.forEach(p => {
            uploadedPhotos.push({ id: p.id, src: p.src, name: p.name, isExisting: true });
        });
        renderPhotoPreviews();
    }

    // Docs
    if (window.existingMedia && window.existingMedia.docs) {
        window.existingMedia.docs.forEach(d => {
            uploadedDocs.push({ id: d.id, file: { name: d.name }, isExisting: true, download_url: d.download_url });
        });
        renderDocPreviews();
    }
}

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
        } else if (e.key === 'Backspace' && tagInput.value === '' && tags.size > 0) {
            const lastTag = Array.from(tags).pop();
            tags.delete(lastTag);
            renderTags();
        }
    });
}

function renderTags() {
    const tagInput = document.getElementById('tagInput');
    const tagsWrap = document.getElementById('tagsWrap');
    $(tagsWrap).find('.tag-item').remove();
    tags.forEach(tag => {
        const span = document.createElement('span');
        span.className = 'tag-item';
        span.innerHTML = `${tag} <button type="button" class="tag-remove" onclick="removeTag('${tag}')"><i class="bi bi-x"></i></button>`;
        tagsWrap.insertBefore(span, tagInput);
    });
}

function removeTag(tag) { tags.delete(tag); renderTags(); }

/* ════════════════════════════════════
   FILE UPLOAD LOGIC
════════════════════════════════════ */
function handleFileSelect(e) { processFiles(e.target.files); }

function processFiles(files) {
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (!file.type.startsWith('image/')) { DKA.notify({ type: 'error', title: 'File Ditolak', message: `${file.name} bukan gambar.` }); continue; }
        if (file.size > 5 * 1024 * 1024) { DKA.notify({ type: 'warning', title: 'File Terlalu Besar', message: `${file.name} > 5MB.` }); continue; }
        if (uploadedPhotos.length >= MAX_PHOTOS) { DKA.notify({ type: 'warning', title: 'Limit Tercapai', message: `Maks ${MAX_PHOTOS} foto.` }); break; }

        const reader = new FileReader();
        reader.onload = (event) => {
            uploadedPhotos.push({ file: file, src: event.target.result, id: Date.now() + Math.random() });
            renderPhotoPreviews();
        };
        reader.readAsDataURL(file);
    }
}

function renderPhotoPreviews() {
    const wrap = $('#photoPreviewWrap');
    wrap.empty();
    uploadedPhotos.forEach((photo, index) => {
        const item = `
            <div class="photo-item fade-in">
                <img src="${photo.src}" alt="preview">
                <div class="photo-item-num">${index + 1}</div>
                ${index === 0 ? '<div class="photo-main-badge">COVER</div>' : ''}
                <div class="photo-item-overlay">
                    <button type="button" class="photo-item-btn photo-btn-delete" onclick="removePhoto(${photo.id})"><i class="bi bi-trash3-fill"></i></button>
                </div>
            </div>`;
        wrap.append(item);
    });
    updatePhotoCounter();
}

function removePhoto(id) { 
    const photo = uploadedPhotos.find(p => p.id === id);
    if (photo && photo.isExisting) {
        deletedMediaIds.push(id);
    }
    uploadedPhotos = uploadedPhotos.filter(p => p.id !== id); 
    renderPhotoPreviews(); 
}

function handleDocSelect(e) {
    const files = e.target.files;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        uploadedDocs.push({ file: file, id: Date.now() + Math.random() });
    }
    renderDocPreviews();
}

function renderDocPreviews() {
    const wrap = $('#docPreview');
    wrap.empty();
    uploadedDocs.forEach(doc => {
        let icon = 'bi-file-earmark-text-fill';
        if (doc.file.name.endsWith('.pdf')) icon = 'bi-file-earmark-pdf-fill';
        
        let linkHtml = `<span style="flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${doc.file.name}</span>`;
        if (doc.isExisting && doc.download_url) {
            linkHtml = `<a href="${doc.download_url}" target="_blank" style="flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--c-primary);text-decoration:none;font-weight:700;">${doc.file.name} <i class="bi bi-download" style="font-size:.7rem;"></i></a>`;
        }

        const item = `
            <div class="doc-preview-item" style="display:flex;align-items:center;gap:10px;padding:8px 12px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;font-size:.75rem;">
                <i class="bi ${icon}" style="color:var(--c-primary);font-size:1rem;"></i>
                ${linkHtml}
                <button type="button" onclick="removeDoc(${doc.id})" style="border:none;background:none;color:var(--c-red);cursor:pointer;"><i class="bi bi-x-circle-fill"></i></button>
            </div>`;
        wrap.append(item);
    });
}

function removeDoc(id) { 
    const doc = uploadedDocs.find(d => d.id === id);
    if (doc && doc.isExisting) {
        deletedMediaIds.push(id);
    }
    uploadedDocs = uploadedDocs.filter(d => d.id !== id); 
    renderDocPreviews(); 
}

function updatePhotoCounter() {
    const count = uploadedPhotos.length;
    $('#photoCountLabel').text(`${count} / ${MAX_PHOTOS}`);
    $('#photoCounterNum').text(`${count} / ${MAX_PHOTOS}`);
    const pct = (count / MAX_PHOTOS) * 100;
    $('#photoCounterFill').css('width', `${pct}%`).css('background', pct > 90 ? '#ef4444' : (pct > 70 ? '#f59e0b' : 'linear-gradient(90deg,#4f46e5,#7c3aed)'));
}

/* ════════════════════════════════════
   SUBMIT ACTION
════════════════════════════════════ */
function submitForm(isDraft = false) {
    // 1. Validation
    $('.fgroup').removeClass('has-err');
    $('.is-invalid').removeClass('is-invalid');
    
    let hasError = false;
    const judul = $('#f-judul').val().trim();
    if (!judul) { $('#grp-judul').addClass('has-err'); hasError = true; }
    
    const tgl = $('#f-tanggal').val();
    if (!tgl) { $('#grp-tanggal').addClass('has-err'); hasError = true; }
    
    const kat = $('#f-kategori').val();
    if (!kat) { $('#grp-kategori').addClass('has-err'); hasError = true; }
    
    const uraian = editor ? editor.getData().trim() : '';
    if (!uraian && !isDraft) { $('#ck-wrap').addClass('is-invalid'); $('#grp-uraian').addClass('has-err'); hasError = true; }
    
    if (!hasError && uploadedPhotos.length === 0 && !isDraft && $('input[name="status"]:checked').val() === 'selesai') {
        DKA.notify({ type: 'warning', title: 'Foto Diperlukan', message: 'Kegiatan berstatus Selesai wajib memiliki minimal 1 foto.' });
        hasError = true;
    }

    if (hasError) {
        DKA.notify({ type: 'error', title: 'Belum Lengkap', message: 'Harap lengkapi field yang bertanda merah.' });
        const firstErr = document.querySelector('.has-err, .is-invalid');
        if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    const isEdit = $('#mainForm').data('mode') === 'edit';
    const activityId = $('#mainForm').data('id');
    const url = isEdit ? `/kegiatan/${activityId}` : '/kegiatan/store';
    
    // 2. Prepare Data
    const formData = new FormData($('#mainForm')[0]);
    formData.append('uraian', uraian);
    formData.set('tags', Array.from(tags).join(','));
    
    if (isEdit) {
        formData.append('_method', 'PUT');
        formData.append('deleted_media', deletedMediaIds.join(','));
    } else if (isDraft) {
        formData.set('status', 'draft');
    }

    // Add Photos (Only new ones)
    uploadedPhotos.filter(p => !p.isExisting).forEach((p, index) => {
        formData.append('photos[]', p.file);
    });
    
    // Add Docs (Only new ones)
    uploadedDocs.filter(d => !d.isExisting).forEach(d => {
        formData.append('attachments[]', d.file);
    });

    // 3. AJAX Submit
    const btn = isDraft ? $('.btn-draft') : $('.btn-submit');
    const oldHtml = btn.html();
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

    $.ajax({
        url: url,
        method: 'POST', // Use POST with _method PUT for multipart compatibility
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(res) {
            if (res.success) {
                DKA.notify({ type: 'success', title: 'Berhasil', message: res.message || 'Data berhasil disimpan.' });
                setTimeout(() => window.location.href = '/kegiatan', 1500);
            } else {
                DKA.notify({ type: 'error', title: 'Gagal', message: res.message || 'Terjadi kesalahan.' });
                btn.prop('disabled', false).html(oldHtml);
            }
        },
        error: function(xhr) {
            btn.prop('disabled', false).html(oldHtml);
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                Object.keys(errors).forEach(key => {
                    const group = $(`#grp-${key}`);
                    if (group.length) {
                        group.addClass('has-err');
                        group.find('.finvalid').text(errors[key][0]);
                    }
                    DKA.notify({ type: 'error', title: 'Validasi Gagal', message: errors[key][0] });
                });
            } else {
                DKA.notify({ type: 'error', title: 'Error', message: 'Gagal menghubungi server.' });
            }
        }
    });
}

function clearErr(id) { $(`#${id}`).removeClass('has-err'); }
function charCount(el, target, max) {
    const len = el.value.length;
    $(`#${target}`).text(`${len} / ${max}`).toggleClass('over', len >= max);
}

// Filter petugas list
function filterPetugas() {
    const query = $('#searchPetugas').val().toLowerCase();
    $('#petugasList .petugas-opt').each(function() {
        const name = $(this).find('.p-name').text().toLowerCase();
        if (name.includes(query)) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}

function cancelForm() {
    DKA.deleteConfirm({ title: 'Batalkan?', message: 'Data yang diisi akan hilang.', itemName: 'Formulir' }).then(res => {
        if (res) window.location.href = '/kegiatan';
    });
}
function scrollToTop() { window.scrollTo({ top: 0, behavior: 'smooth' }); }
