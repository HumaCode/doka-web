 <header class="topbar" id="topbar">

     <!-- Hamburger -->
     <button class="btn-hamburger" id="btnHamburger" onclick="toggleSidebar()">
         <span class="hamburger-line"></span>
         <span class="hamburger-line"></span>
         <span class="hamburger-line"></span>
     </button>

     <!-- Search -->
     <div class="topbar-search">
         <i class="bi bi-search"></i>
         <input type="text" placeholder="Cari kegiatan, laporan..." />
     </div>

     <!-- Right -->
     <div class="topbar-right">

         <!-- Notifications -->
         <button class="topbar-icon-btn">
             <i class="bi bi-bell-fill"></i>
             <span class="notif-dot"></span>
         </button>

         <!-- Messages -->
         <button class="topbar-icon-btn">
             <i class="bi bi-chat-dots-fill"></i>
         </button>

         <!-- User dropdown -->
         <div class="user-dropdown-wrap">
             <button class="user-trigger" id="userTrigger" onclick="toggleUserDropdown()">
                 <div class="user-avatar">A</div>
                 <div class="user-info">
                     <div class="user-name">Admin Doka</div>
                     <div class="user-email">admin@dokaKegiatan.id</div>
                 </div>
                 <i class="bi bi-chevron-down"></i>
             </button>

             <div class="user-dropdown-menu" id="userDropdown">
                 <div class="dropdown-header">
                     <div class="dropdown-avatar-lg">A</div>
                     <div class="dropdown-name">Admin Doka</div>
                     <div class="dropdown-email">admin@dokaKegiatan.id</div>
                 </div>
                 <div class="dropdown-items">
                     <button class="dropdown-item-btn">
                         <i class="bi bi-person-fill"></i> Profil Saya
                     </button>
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
