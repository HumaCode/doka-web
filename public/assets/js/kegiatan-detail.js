/**
 * ═══════════════════════════════════════
 * KEGIATAN DETAIL JS
 * ═══════════════════════════════════════
 */

$(document).ready(function() {
    // Reading Progress
    $(window).on('scroll', function() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        $('#readingBar').css('width', scrolled + '%');

        if (winScroll > 300) $('#fabBtn').addClass('visible');
        else $('#fabBtn').removeClass('visible');
    });

    // Word Count Approximation
    const text = $('#uraianContent').text();
    const words = text.trim().split(/\s+/).length;
    $('#wordCount').text(`~${words} kata`);
});

// Lightbox Logic
let currentPhotoIdx = 0;
const photos = window.kegiatanPhotos || [];

function openLightbox(idx) {
    if (photos.length === 0) return;
    currentPhotoIdx = idx;
    updateLightbox();
    $('#lightbox').addClass('show');
    $('body').css('overflow', 'hidden');
}

function closeLightbox() {
    $('#lightbox').removeClass('show');
    $('body').css('overflow', '');
}

function navLightbox(step) {
    currentPhotoIdx = (currentPhotoIdx + step + photos.length) % photos.length;
    updateLightbox();
}

function updateLightbox() {
    const photo = photos[currentPhotoIdx];
    $('#lightboxImg').attr('src', photo.url);
    $('#lightboxCounter').text(`${currentPhotoIdx + 1} / ${photos.length}`);
    $('#lightboxCaption').text(photo.name || 'Foto Dokumentasi');
}

// Actions
function printPage() {
    DKA.notify({ 
        type: 'info', 
        title: 'Fitur Cetak', 
        message: 'Fitur cetak laporan sedang dalam pengembangan (Segera Hadir).',
        duration: 3000 
    });
}

function exportPDF() {
    DKA.notify({ 
        type: 'info', 
        title: 'Fitur Export PDF', 
        message: 'Fitur export PDF sedang dalam pengembangan (Segera Hadir).',
        duration: 3000 
    });
}

function deleteKegiatan(id, title) {
    DKA.deleteConfirm({
        title: 'Hapus Kegiatan?',
        message: `Hapus "<strong>${title}</strong>"? Data yang dihapus tidak dapat dikembalikan.`,
        itemName: title
    }).then(res => {
        if (res) {
            const loader = DKA.loading({ title: 'Menghapus...', style: 'ring' });
            $.ajax({
                url: `/kegiatan/${id}`,
                method: 'DELETE',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    loader.close();
                    DKA.notify({ type: 'success', title: 'Berhasil', message: res.message || 'Kegiatan dihapus.' });
                    setTimeout(() => window.location.href = '/kegiatan', 1000);
                },
                error: function() {
                    loader.close();
                    DKA.notify({ type: 'error', title: 'Gagal', message: 'Gagal menghapus kegiatan.' });
                }
            });
        }
    });
}

function downloadAllPhotos() {
    DKA.toast({ type: 'info', title: 'Download', message: 'Sedang menyiapkan paket foto...' });
}
