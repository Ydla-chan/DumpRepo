document.addEventListener('DOMContentLoaded', function() {
    
    // =================================================================
    // LOGIKA UMUM (SIDEBAR, PROFIL, MODAL)
    // =================================================================

    // --- LOGIKA MENU PROFIL ---
    const profileBtn = document.getElementById("profileBtn");
    const profileMenu = document.getElementById("profileMenu");

    if (profileBtn && profileMenu) {
        // Tampilkan/sembunyikan menu saat tombol profil diklik
        profileBtn.addEventListener("click", () => {
            profileMenu.classList.toggle("hidden");
        });

        // Sembunyikan menu saat klik di luar area menu
        document.addEventListener("click", e => {
            if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                profileMenu.classList.add("hidden");
            }
        });
    }

    // --- LOGIKA SIDEBAR ---
    const body = document.body;
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebar-overlay");
    const openBtn = document.getElementById("openSidebar");
    const closeBtn = document.getElementById("closeSidebar");
    const minimizeBtn = document.getElementById("minimizeSidebarBtn");

    // Fungsi untuk menutup sidebar mobile
    const closeMobileSidebar = () => {
        if (sidebar) sidebar.classList.add("-translate-x-full");
        if (overlay) overlay.classList.add("hidden");
    };

    // Event listener untuk membuka sidebar mobile
    if (openBtn) {
        openBtn.addEventListener("click", () => {
            if (sidebar) sidebar.classList.remove("-translate-x-full");
            if (overlay) overlay.classList.remove("hidden");
        });
    }

    // Event listener untuk menutup sidebar mobile
    if (closeBtn) closeBtn.addEventListener("click", closeMobileSidebar);
    if (overlay) overlay.addEventListener("click", closeMobileSidebar);

    // Event listener untuk minimize/expand sidebar desktop
    if (minimizeBtn) {
        minimizeBtn.addEventListener("click", () => {
            body.classList.toggle("sidebar-minimized");
            // Simpan status sidebar ke localStorage
            const state = body.classList.contains("sidebar-minimized") ? "minimized" : "expanded";
            localStorage.setItem("sidebarState", state);
        });
    }
    
    // Terapkan status sidebar saat halaman dimuat
    if (localStorage.getItem("sidebarState") === "minimized") {
        body.classList.add("sidebar-minimized");
    }

}); // Akhir dari DOMContentLoaded