/* Role & Permission JS */

const ROLE_GRADS = [
    'linear-gradient(135deg,#4f46e5,#7c3aed)',
    'linear-gradient(135deg,#10b981,#06b6d4)',
    'linear-gradient(135deg,#f59e0b,#f97316)',
    'linear-gradient(135deg,#ec4899,#f472b6)',
    'linear-gradient(135deg,#8b5cf6,#a78bfa)',
    'linear-gradient(135deg,#ef4444,#f87171)',
    'linear-gradient(135deg,#0891b2,#22d3ee)',
    'linear-gradient(135deg,#059669,#34d399)',
    'linear-gradient(135deg,#d97706,#fbbf24)',
    'linear-gradient(135deg,#1d4ed8,#38bdf8)',
];

const ROLE_ICONS = [
    'bi-shield-fill', 'bi-shield-lock-fill', 'bi-person-fill', 'bi-person-badge-fill',
    'bi-person-workspace', 'bi-people-fill', 'bi-eye-fill', 'bi-pencil-fill',
    'bi-camera-fill', 'bi-images', 'bi-building-fill', 'bi-gear-fill',
    'bi-star-fill', 'bi-trophy-fill', 'bi-clipboard-fill', 'bi-lock-fill',
];

/**
 * Simple HTML Escape Function for Security
 */
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

let ROLES = [];
let PERM_MODULES = [];
let permState = {};
let activeRoleId = null;
let editingRoleId = null;
let copyFromRoleId = null; // New state for copying
let selIcon = 'bi-person-badge-fill';
let selColor = 1;

/**
 * Initialize with data from PHP
 */
function initRolePermission(rolesData, permissionsData) {
    ROLES = rolesData;
    PERM_MODULES = permissionsData;
    
    // Initialize permState
    ROLES.forEach(r => {
        permState[r.id] = new Set(r.permissions ? r.permissions.map(p => p.id) : []);
    });

    if (ROLES.length > 0) {
        activeRoleId = ROLES[0].id;
    }

    updateStats();
    renderRoleCards();
}

function animC(id, t) {
    const el = document.getElementById(id);
    if (!el) return;
    let c = 0, inc = t / 50;
    if (t === 0) {
        el.textContent = '0';
        return;
    }
    const tm = setInterval(() => {
        c += inc;
        if (c >= t) {
            c = t;
            clearInterval(tm);
        }
        el.textContent = Math.floor(c).toLocaleString('id-ID');
    }, 16);
}

function updateStats() {
    animC('sc1', ROLES.length);
    let totalPerms = 0;
    Object.keys(PERM_MODULES).forEach(group => {
        totalPerms += PERM_MODULES[group].length;
    });
    animC('sc2', totalPerms);
    animC('sc3', ROLES.reduce((s, r) => s + (r.users_count || 0), 0));
}

function renderRoleCards() {
    const grid = document.getElementById('roleGrid');
    if (!grid) return;

    grid.innerHTML = ROLES.map(r => {
        const grad = ROLE_GRADS[r.grad_id] || ROLE_GRADS[0];
        const permCount = (permState[r.id] || new Set()).size;
        const isSelected = r.id == activeRoleId;
        
        return `
            <div class="role-card ${isSelected ? 'selected' : ''}" onclick="selectRole('${r.id}')">
                <div class="role-card-bar" style="background:${grad};"></div>
                <div class="role-card-top">
                    <div class="role-icon-wrap" style="background:${grad};"><i class="bi ${r.icon || 'bi-shield-fill'}"></i></div>
                    <div class="role-name">
                        ${escapeHtml(r.name)}
                        ${isSelected ? '<span class="selected-badge" style="margin-left:6px;">Aktif</span>' : ''}
                    </div>
                    <div class="role-desc">${escapeHtml(r.description) || '-'}</div>
                </div>
                <div class="role-card-stats">
                    <div class="role-stat"><div class="role-stat-val">${r.users_count || 0}</div><div class="role-stat-lbl">Pengguna</div></div>
                    <div class="role-stat"><div class="role-stat-val">${permCount}</div><div class="role-stat-lbl">Permission</div></div>
                    <div class="role-stat"><div class="role-stat-val">${r.login_count || 0}</div><div class="role-stat-lbl">Login/hari</div></div>
                </div>
                <div class="role-card-footer">
                    <div style="display:flex;align-items:center;gap:5px;">
                        <div class="role-status-dot"></div>
                        <span style="font-size:.72rem;font-weight:600;color:var(--c-muted);">Aktif</span>
                    </div>
                    <div class="role-actions">
                        <button class="role-btn rb-edit" onclick="event.stopPropagation();openEditRoleModal('${r.id}')" title="Edit"><i class="bi bi-pencil-fill"></i></button>
                        <button class="role-btn rb-copy" onclick="event.stopPropagation();copyRole('${r.id}')" title="Duplikat"><i class="bi bi-copy"></i></button>
                        ${r.name === 'super-admin' || r.name === 'dev' ? '' : `<button class="role-btn rb-delete" onclick="event.stopPropagation();deleteRole('${r.id}')" title="Hapus"><i class="bi bi-trash3-fill"></i></button>`}
                    </div>
                </div>
            </div>`;
    }).join('');

    renderMatrixTabs();
    renderMatrix();
}

function renderMatrixTabs() {
    const tabs = document.getElementById('matrixRoleTabs');
    if (!tabs) return;

    tabs.innerHTML = ROLES.map(r => `
        <button class="matrix-tab ${r.id == activeRoleId ? 'active' : ''}" onclick="selectRole('${r.id}')">
            <div class="tab-dot" style="background:${ROLE_GRADS[r.grad_id] || ROLE_GRADS[0]};border-radius:50%;width:8px;height:8px;"></div>
            ${escapeHtml(r.name)}
        </button>`).join('');
}

function selectRole(id) {
    activeRoleId = id;
    renderRoleCards();
}

function renderMatrix() {
    const thead = document.getElementById('permHead');
    const tbody = document.getElementById('permBody');
    if (!thead || !tbody) return;

    thead.innerHTML = `<tr>
        <th style="min-width:280px;">Permission / Fitur</th>
        ${ROLES.map(r => `
            <th>
                <div class="role-th">
                    <div class="role-th-icon" style="background:${ROLE_GRADS[r.grad_id] || ROLE_GRADS[0]};"><i class="bi ${r.icon || 'bi-shield-fill'}" style="font-size:.8rem;"></i></div>
                    <div class="role-th-name">${escapeHtml(r.name)}</div>
                </div>
            </th>`).join('')}
    </tr>`;

    const rows = [];
    Object.keys(PERM_MODULES).forEach(group => {
        // Group header
        rows.push(`
            <tr class="module-group-row">
                <td colspan="${ROLES.length + 1}">
                    <div class="module-group-label"><i class="bi bi-grid-3x3-gap-fill"></i> ${escapeHtml(group)}</div>
                </td>
            </tr>`);

        // Permissions
        PERM_MODULES[group].forEach(perm => {
            rows.push(`
                <tr>
                    <td>
                        <div class="perm-name">
                            <code class="perm-code">${escapeHtml(perm.name)}</code>
                            ${escapeHtml(perm.name.split('.').pop().replace(/_/g, ' '))}
                        </div>
                        <div class="perm-name-sub">${escapeHtml(perm.description) || 'Hak akses ' + escapeHtml(perm.name)}</div>
                    </td>
                    ${ROLES.map(r => {
                        const has = (permState[r.id] || new Set()).has(perm.id);
                        const locked = r.name === 'super-admin' || r.name === 'dev';
                        if (locked) {
                            return `<td><div class="perm-toggle"><i class="bi bi-check-circle-fill perm-check-yes"></i></div></td>`;
                        }
                        return `<td>
                            <div class="perm-toggle">
                                <label class="ts-wrap" title="${r.name}">
                                    <input type="checkbox" ${has ? 'checked' : ''} onchange="togglePerm('${r.id}','${perm.id}',this.checked)" />
                                    <div class="ts-track"><div class="ts-thumb"></div></div>
                                </label>
                            </div>
                        </td>`;
                    }).join('')}
                </tr>`);
        });
    });

    tbody.innerHTML = rows.join('');
}

function togglePerm(roleId, permId, checked) {
    if (!permState[roleId]) permState[roleId] = new Set();
    checked ? permState[roleId].add(permId) : permState[roleId].delete(permId);
}

async function savePermissions() {
    const btn = document.querySelector('.btn-save-perm');
    const orig = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';

    try {
        const response = await fetch(window.ROUTES.sync, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window.ROUTES.csrf
            },
            body: JSON.stringify({
                role_id: activeRoleId,
                permissions: Array.from(permState[activeRoleId])
            })
        });

        if (!response.ok) {
            const errorRes = await response.json().catch(() => ({ message: 'Terjadi kesalahan sistem.' }));
            throw new Error(errorRes.message || 'Gagal menyimpan hak akses.');
        }

        const res = await response.json();
        DKA.notify({ type: 'success', title: 'Berhasil', message: res.message });
        renderRoleCards();
    } catch (err) {
        DKA.notify({ type: 'danger', title: 'Gagal', message: err.message });
    } finally {
        btn.disabled = false;
        btn.innerHTML = orig;
    }
}

function resetPermissions() {
    DKA.dialog({ type: 'warning', title: 'Reset Permission?', message: 'Semua perubahan yang belum disimpan akan dikembalikan.', confirm: 'Ya, Reset' })
        .then(r => {
            if (r) location.reload();
        });
}

/* Modal & Role Actions */
function buildIconGrid() {
    const grid = document.getElementById('roleIconGrid');
    if (!grid) return;
    grid.innerHTML = ROLE_ICONS.map(ic => `
        <button type="button" class="icon-btn-mini ${ic === selIcon ? 'selected' : ''}" onclick="pickRoleIcon('${ic}')">
            <i class="bi ${ic}"></i>
        </button>`).join('');
}

function pickRoleIcon(ic) {
    selIcon = ic;
    buildIconGrid();
    document.getElementById('rpIconI').className = `bi ${ic}`;
    document.getElementById('mHeadIconI').className = `bi ${ic}`;
}

function buildColorGrid() {
    const grid = document.getElementById('roleColorGrid');
    if (!grid) return;
    grid.innerHTML = ROLE_GRADS.map((g, i) => `
        <div class="c-sw ${i === selColor ? 'selected' : ''}" style="background:${g};" onclick="pickRoleColor(${i})"></div>`).join('');
}

function pickRoleColor(id) {
    selColor = id;
    buildColorGrid();
    const g = ROLE_GRADS[id];
    document.getElementById('rpIcon').style.background = g;
    document.getElementById('mHeadIcon').style.background = g;
}

function openAddRoleModal() {
    editingRoleId = null; copyFromRoleId = null; selIcon = 'bi-person-badge-fill'; selColor = 1;
    document.getElementById('mTitleText').textContent = 'Tambah Role Baru';
    document.getElementById('btnSaveRole').innerHTML = '<i class="bi bi-check2-circle"></i> Simpan';
    
    document.getElementById('f-rname').value = '';
    document.getElementById('f-rslug').value = '';
    document.getElementById('f-rdesc').value = '';
    document.getElementById('rpName').textContent = 'Nama Role';
    document.getElementById('rpDesc').textContent = 'Deskripsi singkat role';

    buildIconGrid(); buildColorGrid();
    pickRoleIcon(selIcon); pickRoleColor(selColor);

    document.getElementById('modalRole').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function openEditRoleModal(id) {
    const r = ROLES.find(x => x.id == id);
    if (!r) return;

    editingRoleId = id; copyFromRoleId = null; selIcon = r.icon || 'bi-shield-fill'; selColor = r.grad_id || 0;
    document.getElementById('mTitleText').textContent = 'Edit Role';
    document.getElementById('btnSaveRole').innerHTML = '<i class="bi bi-check2-circle"></i> Perbarui';
    
    document.getElementById('f-rname').value = r.name;
    document.getElementById('f-rslug').value = r.slug || '';
    document.getElementById('f-rdesc').value = r.description || '';
    document.getElementById('rpName').textContent = r.name;
    document.getElementById('rpDesc').textContent = r.description || '-';

    buildIconGrid(); buildColorGrid();
    pickRoleIcon(selIcon); pickRoleColor(selColor);

    document.getElementById('modalRole').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('modalRole').classList.remove('show');
    document.body.style.overflow = '';
}

async function saveRole() {
    const name = document.getElementById('f-rname').value;
    const slug = document.getElementById('f-rslug').value;
    const description = document.getElementById('f-rdesc').value;

    if (!name || !slug) {
        DKA.toast({ type: 'danger', title: 'Error', message: 'Nama dan Kode role wajib diisi.' });
        return;
    }

    const btn = document.getElementById('btnSaveRole');
    const orig = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';

    const url = editingRoleId ? window.ROUTES.update.replace(':id', editingRoleId) : window.ROUTES.store;
    const method = editingRoleId ? 'PUT' : 'POST';

    const payload = {
        name, slug, description,
        icon: selIcon,
        grad_id: selColor
    };

    if (copyFromRoleId && !editingRoleId) {
        payload.copy_from = copyFromRoleId;
    }

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window.ROUTES.csrf
            },
            body: JSON.stringify(payload)
        });

        const res = await response.json().catch(() => ({ message: 'Terjadi kesalahan pada server.' }));
        
        if (response.ok && res.status !== 'error') {
            DKA.toast({ type: 'success', title: 'Berhasil', message: res.message });
            location.reload();
        } else {
            let errMsg = res.message || 'Gagal menyimpan role.';
            if (res.errors) {
                errMsg = Object.values(res.errors).flat().join('<br>');
            }
            throw new Error(errMsg);
        }
    } catch (err) {
        DKA.toast({ type: 'danger', title: 'Gagal', message: err.message });
    } finally {
        btn.disabled = false;
        btn.innerHTML = orig;
    }
}

async function deleteRole(id) {
    const r = ROLES.find(x => x.id == id);
    if (!r) return;

    const confirm = await DKA.deleteConfirm({ title: 'Hapus Role?', message: 'Data yang dihapus tidak dapat dikembalikan.', itemName: r.name });
    if (!confirm) return;

    const loader = DKA.loading({ title: 'Menghapus Role', message: 'Mohon tunggu sebentar...', style: 'dots' });

    try {
        const response = await fetch(window.ROUTES.destroy.replace(':id', id), {
            method: 'DELETE',
            headers: { 
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window.ROUTES.csrf 
            }
        });
        const res = await response.json().catch(() => ({ message: 'Terjadi kesalahan sistem.' }));
        loader.close();

        if (response.ok && res.status === 'success') {
            DKA.toast({ type: 'success', title: 'Berhasil', message: res.message });
            location.reload();
        } else {
            throw new Error(res.message || 'Gagal menghapus role.');
        }
    } catch (err) {
        if (typeof loader !== 'undefined') loader.close();
        DKA.toast({ type: 'danger', title: 'Gagal', message: err.message });
    }
}

async function copyRole(id) {
    const r = ROLES.find(x => x.id == id);
    if (!r) return;
    
    openAddRoleModal();
    copyFromRoleId = id; // Set copy from ID AFTER modal is initialized
    
    // Override Title & Values for Copy
    document.getElementById('mTitleText').textContent = 'Duplikat Role';
    document.getElementById('f-rname').value = r.name + ' (Copy)';
    document.getElementById('f-rslug').value = r.slug + '-copy';
    document.getElementById('f-rdesc').value = r.description || '';
    document.getElementById('rpName').textContent = r.name + ' (Copy)';
    document.getElementById('rpDesc').textContent = r.description || '-';
    
    pickRoleIcon(r.icon || 'bi-shield-fill');
    pickRoleColor(r.grad_id || 0);
}
