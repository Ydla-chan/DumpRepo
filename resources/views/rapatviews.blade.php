<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Rapat - MeetLog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Semua style yang sudah ada (scrollbar, sidebar, modal) tetap dipertahankan */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
        .sidebar-minimized #sidebar { width: 5rem; }
        .sidebar-minimized #sidebar-logo, .sidebar-minimized .nav-text { display: none; }
        .sidebar-minimized #sidebar nav a { justify-content: center; }
        .sidebar-minimized #minimize-btn-icon { transform: rotate(180deg); }
        #newMeetModal.hidden .modal-panel { transform: scale(0.95); opacity: 0; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800 flex min-h-screen">

    <aside id="sidebar" class="bg-white shadow-lg flex flex-col fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 z-50 transition-all duration-300 ease-in-out w-64">
        <div class="p-4 border-b flex items-center justify-between h-16 shrink-0">
            <h1 id="sidebar-logo" class="text-2xl font-bold text-[#4C8C86] transition-all">MeetLog</h1>
            <button id="minimizeSidebarBtn" class="hidden md:block text-slate-500 hover:text-slate-800">
                <svg id="minimize-btn-icon" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            </button>
            <button id="closeSidebar" class="md:hidden text-slate-500 hover:text-slate-800">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="/home" class="flex items-center space-x-3 p-2 rounded-lg text-slate-600 hover:bg-[#E5F2F1] hover:text-[#3D706B]">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                <span class="nav-text">Dashboard</span>
            </a>
            <a href="/home" class="flex items-center space-x-3 p-2 rounded-lg bg-[#E5F2F1] text-[#4C8C86] font-semibold">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" /></svg>
                <span class="nav-text">Rekap Rapat</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-2 rounded-lg text-slate-600 hover:bg-[#E5F2F1] hover:text-[#3D706B]">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" /><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" /></svg>
                <span class="nav-text">Rekap Notulensi</span>
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out">
        <header class="flex items-center justify-between bg-white/80 backdrop-blur-sm shadow-sm px-6 py-3 sticky top-0 z-40 h-16">
            <div class="flex items-center space-x-4">
                <button id="openSidebar" class="text-slate-600 md:hidden">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
                <h2 class="text-xl font-semibold text-slate-700">Rekap Rapat</h2>
            </div>
            <div class="flex items-center space-x-3 sm:space-x-6">
                 </div>
        </header>

        <main class="p-4 sm:p-6 flex-1">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800">Daftar Rapat</h3>
                    <p class="text-sm text-slate-500">Tinjau semua rapat yang telah dijadwalkan.</p>
                </div>
                <div class="flex items-center gap-2">
                    <button id="buatRapatBtn" class="flex items-center space-x-2 px-4 py-2 border border-transparent rounded-md text-white bg-[#4C8C86] hover:bg-[#3D706B] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3D706B]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        <span>Buat Rapat Baru</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse ($rapats as $rapat)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-5 flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <h4 class="text-lg font-bold text-slate-800 pr-4">{{ $rapat->agenda }}</h4>
                            @if ($rapat->tanggal->isFuture())
                                <span class="shrink-0 px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">Terjadwal</span>
                            @else
                                <span class="shrink-0 px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Selesai</span>
                            @endif
                        </div>
                        
                        <div class="space-y-3 text-sm text-slate-600 mb-4 flex-grow">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>{{ $rapat->tanggal->format('l, d F Y') }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Pukul {{ \Carbon\Carbon::parse($rapat->jam)->format('H:i') }} WIB</span>
                            </div>
                            <div class="flex items-center gap-3">
                                @if ($rapat->tipe_lokasi == 'Online')
                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    <a href="{{ $rapat->link }}" target="_blank" class="text-blue-600 hover:underline truncate">Online Meeting Link</a>
                                @else
                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="truncate">{{ $rapat->ruangan ?? 'N/A' }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                           <button type="button" 
        class="open-detail-modal-btn text-sm font-semibold text-[#4C8C86] hover:text-[#2E5350]"
        data-id="{{ $rapat->id }}">
    Lihat Detail &rarr;
</button>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 xl:col-span-3 bg-white text-center rounded-xl p-12">
                        <p class="text-slate-500">Belum ada data rapat yang bisa ditampilkan.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{-- {{ $rapats->links() }} --}}
            </div>
        </main>
    </div>

    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>
    
    <div id="detailRapatModal" class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4 transition-opacity duration-300">
    <div id="detailRapatPanel" class="modal-panel bg-white rounded-xl shadow-2xl w-full max-w-2xl transition-all duration-300 ease-in-out transform relative">
        
        <div class="flex items-center justify-between p-5 border-b">
            <h3 class="text-xl font-semibold text-slate-800">Detail Rapat</h3>
            <button type="button" id="closeDetailModalBtn" class="text-slate-400 hover:text-slate-700 text-3xl font-light">&times;</button>
        </div>

        <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
            <div id="modalSpinner" class="hidden text-center py-10">
                <svg class="animate-spin h-8 w-8 text-[#4C8C86] mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-2 text-slate-500">Memuat data...</p>
            </div>

            <div id="modalContent" class="hidden">
                <h2 id="detailAgenda" class="text-2xl font-bold text-slate-900 mb-1"></h2>
                <div id="detailStatus" class="mb-5"></div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-slate-700">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Tanggal & Waktu</p>
                        <p id="detailTanggalWaktu"></p>
                    </div>
                     <div>
                        <p class="text-sm font-semibold text-slate-500">Lokasi</p>
                        <div id="detailLokasi"></div>
                    </div>
                </div>

                <div class="mt-5 pt-4 border-t">
                    <p class="text-sm font-semibold text-slate-500 mb-2">Peserta Diundang</p>
                    <ul id="detailPesertaList" class="space-y-1 text-sm list-disc list-inside text-slate-600">
                        </ul>
                </div>
            </div>
        </div>
    </div>
</div>
   <script>
    document.addEventListener('DOMContentLoaded', function () {

        // =================================================================
        // LOGIKA UMUM (SIDEBAR, PROFIL, MODAL)
        // =================================================================

        // --- SIDEBAR & PROFILE MENU LOGIC ---
        const profileBtn = document.getElementById("profileBtn");
        const profileMenu = document.getElementById("profileMenu");
        if (profileBtn) {
            profileBtn.addEventListener("click", () => { profileMenu.classList.toggle("hidden") });
            document.addEventListener("click", e => {
                if (profileBtn && !profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                    profileMenu.classList.add("hidden");
                }
            });
        }

        const body = document.body;
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("sidebar-overlay");
        const openBtn = document.getElementById("openSidebar");
        const closeBtn = document.getElementById("closeSidebar");
        const minimizeBtn = document.getElementById("minimizeSidebarBtn");

        if (openBtn) {
            openBtn.addEventListener("click", () => {
                if(sidebar) sidebar.classList.remove("-translate-x-full");
                if(overlay) overlay.classList.remove("hidden");
            });
        }

        const closeMobileSidebar = () => {
            if(sidebar) sidebar.classList.add("-translate-x-full");
            if(overlay) overlay.classList.add("hidden");
        };

        if (closeBtn) closeBtn.addEventListener("click", closeMobileSidebar);
        if (overlay) overlay.addEventListener("click", closeMobileSidebar);

        if (minimizeBtn) {
            minimizeBtn.addEventListener("click", () => {
                body.classList.toggle("sidebar-minimized");
                localStorage.setItem("sidebarState", body.classList.contains("sidebar-minimized") ? "minimized" : "expanded");
            });
        }
        if (localStorage.getItem("sidebarState") === "minimized") {
            body.classList.add("sidebar-minimized");
        }

        // --- MODAL "BUAT RAPAT" LOGIC ---
        const openModalBtn = document.getElementById('buatRapatBtn');
        if (openModalBtn) {
            const modal = document.getElementById('newMeetModal');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelModalBtn = document.getElementById('cancelModalBtn');
            
            if (modal) {
                 openModalBtn.addEventListener('click', () => modal.classList.remove('hidden'));
                 if(closeModalBtn) closeModalBtn.addEventListener('click', () => modal.classList.add('hidden'));
                 if(cancelModalBtn) cancelModalBtn.addEventListener('click', () => modal.classList.add('hidden'));
            }
        }

        // --- LOGIKA MODAL "DETAIL RAPAT" ---
        const detailModal = document.getElementById('detailRapatModal');
        if (detailModal) {
            const closeDetailBtn = document.getElementById('closeDetailModalBtn');
            const modalSpinner = document.getElementById('modalSpinner');
            const modalContent = document.getElementById('modalContent');
            
            const closeDetailModal = () => detailModal.classList.add('hidden');

            closeDetailBtn.addEventListener('click', closeDetailModal);
            detailModal.addEventListener('click', (e) => {
                if (e.target === detailModal) closeDetailModal();
            });

            document.body.addEventListener('click', async function(e) {
                if (e.target.closest('.open-detail-modal-btn')) {
                    const button = e.target.closest('.open-detail-modal-btn');
                    const rapatId = button.dataset.id;
                    if (!rapatId) return;

                    detailModal.classList.remove('hidden');
                    modalSpinner.style.display = 'block';
                    modalContent.style.display = 'none';

                    try {
                        const response = await fetch(`/rapat/${rapatId}/details`);
                        if (!response.ok) throw new Error('Gagal ambil data');
                        const data = await response.json();
                        populateModal(data);
                    } catch (error) {
                        console.error(error);
                        modalContent.innerHTML = '<p class="text-red-500 text-center">Terjadi kesalahan.</p>';
                    } finally {
                        modalSpinner.style.display = 'none';
                        modalContent.style.display = 'block';
                    }
                }
            });

            function populateModal(data) {
                // ... (Fungsi `populateModal` yang sudah kita buat sebelumnya)
            }
        }


        // =================================================================
        // LOGIKA KHUSUS DASHBOARD (DIJALANKAN SECARA KONDISIONAL)
        // =================================================================
        
        const calendarEl = document.getElementById('calendar');
        if (calendarEl) {
            // ... (Seluruh kode kalender dan event list dari support.js ditempelkan di sini)
            // Ini tidak akan berjalan di halaman Rekap Rapat karena `calendarEl` akan null, jadi aman.
        }
    });
    </script>
</body>
</html>