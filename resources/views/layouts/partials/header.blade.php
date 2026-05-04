<header class="topbar" id="topbar">

     <!-- Hamburger -->
     <button class="btn-hamburger" id="btnHamburger" onclick="toggleSidebar()" aria-label="Toggle Sidebar Menu">
         <span class="hamburger-line"></span>
         <span class="hamburger-line"></span>
         <span class="hamburger-line"></span>
     </button>

     <!-- Search -->
     <div class="topbar-search">
         <label for="topbarSearch" class="visually-hidden">Cari di dashboard</label>
         <i class="bi bi-search"></i>
         <input type="text" id="topbarSearch" placeholder="Cari kegiatan, laporan..." aria-label="Cari di dashboard" />
     </div>

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
                     <button class="dropdown-item-btn">
                         <i class="bi bi-gear-fill"></i> Pengaturan
                     </button>
                     <button class="dropdown-item-btn">
                         <i class="bi bi-shield-lock-fill"></i> Keamanan Akun
                     </button>
                     <button class="dropdown-item-btn">
                         <i class="bi bi-question-circle-fill"></i> Bantuan
                     </button>
                     <div class="dropdown-divider"></div>
                     <button class="dropdown-item-btn danger" onclick="showLogoutModal()">
                         <i class="bi bi-box-arrow-right"></i> Keluar
                     </button>
                 </div>
             </div>
         </div>

     </div>
 </header>
