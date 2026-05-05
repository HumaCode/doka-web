<header class="topbar" id="topbar">

     <!-- Hamburger -->
     <button class="btn-hamburger" id="btnHamburger" onclick="toggleSidebar()" aria-label="Toggle Sidebar Menu">
         <span class="hamburger-line"></span>
         <span class="hamburger-line"></span>
         <span class="hamburger-line"></span>
     </button>

     <!-- Search -->
     <div class="topbar-search-container">
         <form action="{{ route('search.global') }}" method="GET" class="topbar-search" id="globalSearchForm">
             <i class="bi bi-search"></i>
             <input type="text" name="q" id="topbarSearch" placeholder="Cari kegiatan..." aria-label="Cari di dashboard" value="{{ request('q') }}" autocomplete="off" />
         </form>
         <div id="searchDropdown" class="search-dropdown-menu"></div>
     </div>

     <style>
        .topbar-search-container { position: relative; flex: 1; max-width: 360px; }
        .search-dropdown-menu {
            position: absolute;
            top: calc(100% + 5px);
            left: 0;
            right: 0;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid var(--c-border);
            display: none;
            z-index: 1000;
            max-height: 350px;
            overflow-y: auto;
            animation: dropdownFade .2s ease both;
        }
        .search-dropdown-menu.show { display: block; }
        .search-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-bottom: 1px solid var(--c-border);
            transition: background .2s;
        }
        .search-item:last-child { border-bottom: none; }
        .search-item:hover { background: var(--c-surface2); }
        .s-icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(79,70,229,0.1); color: var(--c-primary); display: grid; place-items: center; flex-shrink: 0; }
        .s-info { flex: 1; min-width: 0; }
        .s-name { font-size: 0.85rem; font-weight: 700; color: var(--c-text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .s-meta { font-size: 0.7rem; color: var(--c-muted); margin-top: 2px; }
        .btn-s-detail { padding: 4px 10px; border-radius: 6px; background: var(--c-primary); color: #fff; font-size: 0.7rem; font-weight: 700; text-decoration: none; }
        
        @keyframes dropdownFade { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
     </style>

     <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('topbarSearch');
            const dropdown = document.getElementById('searchDropdown');
            let timeout = null;

            searchInput.addEventListener('input', function() {
                const q = this.value.trim();
                clearTimeout(timeout);

                if (q.length < 2) {
                    dropdown.classList.remove('show');
                    return;
                }

                timeout = setTimeout(async () => {
                    try {
                        const res = await fetch(`{{ route('search.api') }}?q=${q}`);
                        const data = await res.json();
                        
                        if (data.length > 0) {
                            let html = '';
                            data.forEach(item => {
                                html += `
                                    <div class="search-item">
                                        <div class="s-icon"><i class="bi bi-calendar-event"></i></div>
                                        <div class="s-info">
                                            <div class="s-name">${item.judul}</div>
                                            <div class="s-meta"><i class="bi bi-clock"></i> ${new Date(item.tanggal).toLocaleDateString('id-ID')}</div>
                                        </div>
                                        <a href="/kegiatan/show/${item.id}" class="btn-s-detail">Detail</a>
                                    </div>
                                `;
                            });
                            dropdown.innerHTML = html;
                            dropdown.classList.add('show');
                        } else {
                            dropdown.innerHTML = '<div style="padding:15px; text-align:center; font-size:0.8rem; color:var(--c-muted);">Tidak ada hasil.</div>';
                            dropdown.classList.add('show');
                        }
                    } catch (e) {
                        console.error('Search error:', e);
                    }
                }, 300);
            });

            document.addEventListener('click', e => {
                if (!document.querySelector('.topbar-search-container').contains(e.target)) {
                    dropdown.classList.remove('show');
                }
            });
        });
     </script>

     <!-- Right -->
     <div class="topbar-right">

         <!-- Notifications -->
         <button class="topbar-icon-btn" aria-label="Notifikasi">
             <i class="bi bi-bell-fill"></i>
             <span class="notif-dot"></span>
         </button>

         <!-- Messages -->
         <button class="topbar-icon-btn" aria-label="Pesan">
             <i class="bi bi-chat-dots-fill"></i>
         </button>

         <!-- User dropdown -->
         <div class="user-dropdown-wrap">
             <button class="user-trigger" id="userTrigger" onclick="toggleUserDropdown()" aria-label="User Menu" aria-expanded="false">
                 <div class="user-avatar">{{ auth()->user()->name[0] }}</div>
                 <div class="user-info">
                     <div class="user-name">{{ auth()->user()->name }}</div>
                     <div class="user-email">{{ auth()->user()->email }}</div>
                 </div>
                 <i class="bi bi-chevron-down"></i>
             </button>

             <div class="user-dropdown-menu" id="userDropdown">
                 <div class="dropdown-header">
                     <div class="dropdown-avatar-lg">{{ auth()->user()->name[0] }}</div>
                     <div class="dropdown-name">{{ auth()->user()->name }}</div>
                     <div class="dropdown-email">{{ auth()->user()->email }}</div>
                 </div>
                 <div class="dropdown-items">
                     <a href="{{ route('profile.index') }}" class="dropdown-item-btn" style="text-decoration: none;">
                        <i class="bi bi-person-fill"></i> Profil Saya
                    </a>
                     <a href="{{ route('profile.index') }}#settings" class="dropdown-item-btn" style="text-decoration: none;">
                         <i class="bi bi-gear-fill"></i> Pengaturan
                     </a>
                     <div class="dropdown-divider"></div>
                     <button class="dropdown-item-btn danger" onclick="showLogoutModal()">
                         <i class="bi bi-box-arrow-right"></i> Keluar
                     </button>
                 </div>
             </div>
         </div>

     </div>
 </header>
