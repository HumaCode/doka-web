 <div class="modal-overlay" id="logoutModal">
     <div class="logout-modal">
         <div class="logout-icon-wrap">
             <i class="bi bi-box-arrow-right"></i>
         </div>
         <h3>Konfirmasi Keluar</h3>
         <p>Apakah Anda yakin ingin keluar dari sistem? Sesi Anda akan diakhiri dan Anda perlu login kembali.</p>
         <div class="modal-actions">
             <button class="btn-modal-cancel" onclick="hideLogoutModal()">
                 <i class="bi bi-x-circle"></i> Batal
             </button>
             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                 @csrf
             </form>
             <button class="btn-modal-logout" onclick="event.preventDefault(); doLogout();">
                 <i class="bi bi-box-arrow-right"></i> Ya, Keluar
             </button>
         </div>
     </div>
 </div>
