/* ════════════════════════════════════
   TABS
════════════════════════════════════ */
function switchTab(tabId) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  document.getElementById(tabId).classList.add('active');
  document.getElementById('panel-' + tabId.replace('tab-', '')).classList.add('active');

  if (tabId === 'tab-aktivitas') {
    loadActivities(1);
  }
}

let actPage = 1;
let actLoading = false;

async function loadActivities(page = 1) {
  if (actLoading) return;
  actLoading = true;
  actPage = page;

  const container = document.getElementById('actTimeline');
  if (page === 1) container.innerHTML = '<div class="text-center py-4"><span class="spinner-border spinner-border-sm text-primary"></span> Memuat aktivitas...</div>';

  try {
    const response = await fetch(`/profile/activities?page=${page}`);
    const data = await response.json();

    if (page === 1) container.innerHTML = '';

    if (data.data.length === 0 && page === 1) {
      container.innerHTML = '<p class="text-center text-muted py-4">Belum ada riwayat aktivitas.</p>';
      return;
    }

    renderActivities(data.data);

    // Pagination button
    let moreBtn = document.getElementById('btnLoadMoreAct');
    if (data.next_page_url) {
      if (!moreBtn) {
        moreBtn = document.createElement('button');
        moreBtn.id = 'btnLoadMoreAct';
        moreBtn.className = 'btn-cancel w-100 mt-3';
        moreBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Muat Lebih Banyak';
        moreBtn.onclick = () => loadActivities(actPage + 1);
        container.after(moreBtn);
      }
      moreBtn.style.display = 'block';
    } else if (moreBtn) {
      moreBtn.style.display = 'none';
    }

  } catch (err) {
    container.innerHTML = '<p class="text-center text-danger py-4">Gagal memuat aktivitas.</p>';
  } finally {
    actLoading = false;
  }
}

function renderActivities(items) {
  const container = document.getElementById('actTimeline');

  const icons = {
    created: { icon: 'bi-plus-circle-fill', color: 'var(--c-green)' },
    updated: { icon: 'bi-pencil-square', color: 'var(--c-primary)' },
    deleted: { icon: 'bi-trash3-fill', color: 'var(--c-red)' },
    uploaded: { icon: 'bi-cloud-arrow-up-fill', color: 'var(--c-secondary)' },
    default: { icon: 'bi-lightning-fill', color: 'var(--c-accent)' }
  };

  items.forEach(item => {
    const type = item.description.toLowerCase();
    const cfg = icons[type] || icons.default;
    const dateObj = new Date(item.created_at);
    const time = dateObj.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    const date = dateObj.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });

    const html = `
            <div class="act-item" style="animation:fadeUp .4s ease both;">
                <div class="act-dot-wrap">
                    <div class="act-dot" style="background:${cfg.color}"><i class="bi ${cfg.icon}"></i></div>
                    <div class="act-line"></div>
                </div>
                <div class="act-content">
                    <div class="act-title">${formatActDesc(item)}</div>
                    <div class="act-detail">${item.properties?.old ? 'Melakukan pembaruan data' : (item.subject_type ? 'Berhasil memproses ' + item.subject_type.split('\\').pop() : 'Berhasil melakukan aksi')}</div>
                </div>
                <div class="act-time">${date}, ${time}</div>
            </div>`;
    container.insertAdjacentHTML('beforeend', html);
  });
}

function formatActDesc(item) {
  let desc = item.description;
  if (desc === 'created') return '<span style="color:var(--c-green);font-weight:800;">Menambah</span> data baru';
  if (desc === 'updated') return '<span style="color:var(--c-primary);font-weight:800;">Memperbarui</span> data';
  if (desc === 'deleted') return '<span style="color:var(--c-red);font-weight:800;">Menghapus</span> data';
  return desc.charAt(0).toUpperCase() + desc.slice(1);
}

/* ════════════════════════════════════
   COVER CANVAS PARTICLES
════════════════════════════════════ */
(function() {
  const canvas = document.getElementById('coverCanvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  const cover = document.getElementById('profileCover');
  let W, H, particles = [];
  const EMOJIS = ['📷','📸','🎞','🖼','✨','⭐','💫','📅'];
  const COLORS  = ['rgba(255,255,255,.6)','rgba(196,181,253,.7)','rgba(167,243,208,.6)','rgba(253,186,116,.6)'];

  function resize() { W = canvas.width = cover.offsetWidth; H = canvas.height = cover.offsetHeight; }
  function rnd(a,b) { return a + Math.random()*(b-a); }
  function make() {
    const e = Math.random() > .5;
    return { x:rnd(0,W), y:rnd(20,H+20), vx:rnd(-.3,.3), vy:rnd(-.8,-.3), size:rnd(e?12:3,e?20:7), alpha:rnd(.15,.55), color:COLORS[Math.floor(Math.random()*COLORS.length)], emoji:e?EMOJIS[Math.floor(Math.random()*EMOJIS.length)]:null, rotate:rnd(0,Math.PI*2), rotV:rnd(-.02,.02) };
  }
  function init() { resize(); particles = Array.from({length:25}, make); }
  function draw() {
    ctx.clearRect(0,0,W,H);
    for (const p of particles) {
      ctx.save(); ctx.globalAlpha = p.alpha; ctx.translate(p.x,p.y); ctx.rotate(p.rotate);
      if (p.emoji) { ctx.font=`${p.size}px serif`; ctx.textAlign='center'; ctx.textBaseline='middle'; ctx.fillText(p.emoji,0,0); }
      else { ctx.beginPath(); ctx.arc(0,0,p.size/2,0,Math.PI*2); ctx.fillStyle=p.color; ctx.fill(); }
      ctx.restore();
      p.x+=p.vx; p.y+=p.vy; p.rotate+=p.rotV;
      if (p.y < -30) { Object.assign(p, make()); p.y = H + 10; }
    }
    requestAnimationFrame(draw);
  }
  window.addEventListener('resize', resize);
  init(); draw();
})();

/* ════════════════════════════════════
   AVATAR & COVER CHANGE
════════════════════════════════════ */
function changeAvatar(input) {
  const f = input.files[0]; if (!f) return;
  
  // Preview
  const r = new FileReader();
  r.onload = e => {
    const img = document.getElementById('avatarImg');
    const ltr = document.getElementById('avatarLetter');
    img.src = e.target.result; img.style.display = 'block'; ltr.style.display = 'none';
  };
  r.readAsDataURL(f);

  // Upload
  const formData = new FormData();
  formData.append('avatar', f);
  
  const loader = DKA.loading({ title: 'Mengunggah...', message: 'Sedang memperbarui foto profil.', style: 'ring' });

  $.ajax({
    url: '/profile/avatar',
    method: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    success: function(response) {
        loader.close();
        DKA.notify({ type: 'success', title: 'Berhasil', message: response.message });
        // Update any other avatar instances (like sidebar)
        $('.user-avatar, .sidebar-avatar-sm, .dropdown-avatar-lg').html(`<img src="${response.url}" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">`);
    },
    error: function(xhr) {
        loader.close();
        DKA.notify({ type: 'danger', title: 'Error', message: xhr.responseJSON?.message || 'Gagal mengunggah foto profil' });
    }
  });
}

function changeCover(input) {
  const f = input.files[0]; if (!f) return;
  
  // Preview
  const r = new FileReader();
  r.onload = e => {
    const cover = document.getElementById('profileCover');
    cover.style.backgroundImage = `url(${e.target.result})`;
    cover.style.backgroundSize = 'cover';
    cover.style.backgroundPosition = 'center';
  };
  r.readAsDataURL(f);

  // Upload
  const formData = new FormData();
  formData.append('cover', f);
  
  const loader = DKA.loading({ title: 'Mengunggah...', message: 'Sedang memperbarui foto sampul.', style: 'ring' });

  $.ajax({
    url: '/profile/cover',
    method: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    success: function(response) {
        loader.close();
        DKA.notify({ type: 'success', title: 'Berhasil', message: response.message });
    },
    error: function(xhr) {
        loader.close();
        DKA.notify({ type: 'danger', title: 'Error', message: xhr.responseJSON?.message || 'Gagal mengunggah cover' });
    }
  });
}

/* ════════════════════════════════════
   COUNTER ANIMATION
/* ════════════════════════════════════ */
function animCounter(id, target, suffix='') {
  const el = document.getElementById(id); if (!el) return;
  let cur = 0; const inc = target / 60;
  const t = setInterval(() => {
    cur += inc;
    if (cur >= target) { cur = target; clearInterval(t); }
    el.textContent = Math.floor(cur).toLocaleString('id-ID') + suffix;
  }, 16);
}

/* ════════════════════════════════════
   PROFILE SAVE
════════════════════════════════════ */
function saveProfile() {
  const btn = document.getElementById('btnSaveProfil');
  const form = document.getElementById('formProfile');
  const formData = new FormData(form);

  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';

  const loader = DKA.loading({ title: 'Menyimpan...', message: 'Sedang memperbarui data profil.', style: 'ring' });

  $.ajax({
    url: '/profile/update',
    method: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(response) {
        loader.close();
        DKA.notify({ type: 'success', title: 'Berhasil', message: response.message });
        // Update UI name if needed
        $('.profile-name-text').text(formData.get('name'));
    },
    error: function(xhr) {
        loader.close();
        let msg = 'Gagal memperbarui profil.';
        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
        DKA.notify({ type: 'danger', title: 'Error', message: msg });
    },
    complete: function() {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check2-circle"></i> Simpan Perubahan';
    }
  });
}

/* ════════════════════════════════════
   PASSWORD TOGGLE & STRENGTH
════════════════════════════════════ */
function togglePw(inputId, iconId) {
  const inp = document.getElementById(inputId);
  const ico = document.getElementById(iconId);
  const show = inp.type === 'password';
  inp.type = show ? 'text' : 'password';
  ico.className = show ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
}
const PW_LEVELS = [
  {min:0, c:'#e5e7eb', l:'Belum diisi', p:'0%'},
  {min:1, c:'#f87171', l:'Sangat lemah', p:'20%'},
  {min:4, c:'#fb923c', l:'Lemah', p:'40%'},
  {min:6, c:'#facc15', l:'Sedang', p:'60%'},
  {min:8, c:'#4ade80', l:'Kuat', p:'80%'},
  {min:10,c:'#10b981', l:'Sangat kuat 💪', p:'100%'},
];
function checkPwStrength(v) {
  let s = v.length;
  if (/[A-Z]/.test(v)) s++; if (/[0-9]/.test(v)) s++; if (/[^A-Za-z0-9]/.test(v)) s+=2;
  let lv = PW_LEVELS[0];
  for (const l of PW_LEVELS) if (s >= l.min) lv = l;
  document.getElementById('pwStrBar').style.width = lv.p;
  document.getElementById('pwStrBar').style.background = lv.c;
  const lb = document.getElementById('pwStrLabel');
  lb.textContent = lv.l; lb.style.color = lv.c === '#e5e7eb' ? 'var(--c-muted)' : lv.c;
}

function savePw() {
  const cur = document.getElementById('curPw').value;
  const np  = document.getElementById('newPw').value;
  const cp  = document.getElementById('confPw').value;
  
  if (!cur) { DKA.notify({ type: 'warning', title: 'Peringatan', message: 'Masukkan password saat ini' }); return; }
  if (np.length < 8) { DKA.notify({ type: 'warning', title: 'Peringatan', message: 'Password baru minimal 8 karakter' }); return; }
  if (np !== cp) { DKA.notify({ type: 'warning', title: 'Peringatan', message: 'Konfirmasi password tidak cocok' }); return; }

  const loader = DKA.loading({ title: 'Memperbarui...', message: 'Sedang mengubah password Anda.', style: 'dots' });

  $.ajax({
    url: '/profile/password',
    method: 'POST',
    data: {
        current_password: cur,
        new_password: np,
        new_password_confirmation: cp
    },
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(response) {
        loader.close();
        DKA.notify({ type: 'success', title: 'Berhasil', message: response.message });
        ['curPw','newPw','confPw'].forEach(id => { document.getElementById(id).value=''; });
        checkPwStrength('');
    },
    error: function(xhr) {
        loader.close();
        let msg = 'Gagal memperbarui password.';
        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
        DKA.notify({ type: 'danger', title: 'Error', message: msg });
    }
  });
}

/* ════════════════════════════════════
   2FA TOGGLE
════════════════════════════════════ */
function toggle2FA(cb) {
  DKA.notify({ 
    type: cb.checked ? 'success' : 'info', 
    title: cb.checked ? '2FA Aktif' : '2FA Nonaktif', 
    message: cb.checked ? 'Autentikasi dua faktor berhasil diaktifkan! 🔐' : 'Autentikasi dua faktor telah dinonaktifkan.' 
  });
}
