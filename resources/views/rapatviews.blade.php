@extends('layout.app')
@section('title', 'Agenda Rapat')

@section('content')

    
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Agenda Rapat</h1>
            <p class="text-slate-500 mt-1 text-base">Kelola jadwal, akses link meeting, dan pantau kehadiran.</p>
        </div>
        
        {{-- Statistik Ringkas (Opsional, pemanis UI) --}}
        <div class="hidden md:flex gap-3">
            <div class="px-4 py-2 bg-white rounded-lg shadow-sm border border-slate-200 text-sm">
                <span class="text-slate-500">Total:</span> 
                <span class="font-bold text-slate-800 ml-1">{{ $rapats->count() }}</span>
            </div>
        </div>
    </div>

    {{-- Grid Rapat --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($rapats as $rapat)
            @php
                $now = \Carbon\Carbon::now();
                // Pastikan $rapat->tanggal dan $rapat->jam digabung untuk akurasi
                $startDateTime = \Carbon\Carbon::parse($rapat->tanggal->format('Y-m-d') . ' ' . $rapat->jam);
                $endDateTime = $startDateTime->copy()->addHour(); // Asumsi durasi 1 jam
                
                $startThreshold = $startDateTime->copy()->subMinutes(15); 
                
                if ($now->lessThan($startThreshold)) {
                    $status = 'Dijadwalkan';
                    $badgeClass = 'bg-blue-50 text-blue-700 border-blue-100';
                    $iconStatus = '<span class="flex w-2 h-2 bg-blue-500 rounded-full mr-1.5"></span>';
                } elseif ($now->between($startThreshold, $endDateTime)) {
                    $status = 'Berlangsung';
                    $badgeClass = 'bg-amber-50 text-amber-700 border-amber-100 animate-pulse';
                    $iconStatus = '<span class="relative flex h-2 w-2 mr-1.5"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span></span>';
                } else {
                    $status = 'Selesai';
                    $badgeClass = 'bg-slate-100 text-slate-600 border-slate-200';
                    $iconStatus = '<span class="flex w-2 h-2 bg-slate-400 rounded-full mr-1.5"></span>';
                }
            @endphp

            <div class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col relative overflow-hidden">
                
                {{-- Decorative Top Bar --}}
                <div class="h-1.5 w-full {{ $status == 'Berlangsung' ? 'bg-amber-500' : ($status == 'Dijadwalkan' ? 'bg-blue-500' : 'bg-slate-300') }}"></div>

                <div class="p-6 flex flex-col flex-grow">
                    {{-- Header Card --}}
                    <div class="flex justify-between items-start mb-4 gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $badgeClass }}">
                            {!! $iconStatus !!} {{ $status }}
                        </span>
                        @if($rapat->tipe_lokasi == 'online')
                            <span class="text-xs font-bold text-[#4C8C86] bg-[#4C8C86]/10 px-2 py-1 rounded-md uppercase tracking-wider">Online</span>
                        @else
                            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md uppercase tracking-wider">Offline</span>
                        @endif
                    </div>

                    {{-- Judul --}}
                    <h4 class="text-lg font-bold text-slate-900 line-clamp-2 leading-snug mb-4 group-hover:text-[#4C8C86] transition-colors">
                        {{ $rapat->judul }}
                    </h4>
                    
                    {{-- Informasi Detail --}}
                    <div class="space-y-3 text-sm text-slate-600 mb-6 flex-grow">
                        {{-- Tanggal --}}
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center shrink-0 text-[#4C8C86]">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <span class="font-medium">{{ $rapat->tanggal->format('d M Y') }}</span>
                        </div>
                        
                        {{-- Jam --}}
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center shrink-0 text-[#4C8C86]">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span>{{ \Carbon\Carbon::parse($rapat->jam)->format('H:i') }} WIB</span>
                        </div>

                        {{-- Lokasi --}}
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center shrink-0 text-[#4C8C86]">
                                @if ($rapat->tipe_lokasi == 'online')
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                @else
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                @endif
                            </div>
                            @if ($rapat->tipe_lokasi == 'online')
                                <a href="{{ $rapat->link }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline truncate font-medium max-w-[150px]">Link Meeting</a>
                            @else
                                <span class="truncate font-medium max-w-[150px]" title="{{ $rapat->ruangan }}">{{ $rapat->ruangan ?? '-' }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Footer Action --}}
                <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex items-center justify-between flex-wrap gap-2">
                    <button type="button" 
                        class="open-detail-modal-btn text-sm font-bold text-slate-600 hover:text-[#4C8C86] transition-colors flex items-center gap-1.5"
                        data-id="{{ $rapat->id }}">
                        Detail
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>

                    {{-- Tombol Ringkasan (Jika rapat sudah selesai & notulen ada) --}}
                    @php
                        $now = \Carbon\Carbon::now();
                        $startDateTime = \Carbon\Carbon::parse($rapat->tanggal->format('Y-m-d') . ' ' . $rapat->jam);
                        $endDateTime = $startDateTime->copy()->addHour();
                        $isFinished = $now->greaterThan($endDateTime);
                        $hasNotulen = $rapat->notulen !== null;
                    @endphp

                    {{-- @if($isFinished && $hasNotulen)
                        <a href="{{ route('notulen.showSummary', $rapat->notulen->id) }}" 
                            class="text-sm font-semibold text-green-600 hover:text-green-700 transition-all flex items-center gap-1.5 hover:bg-green-50 hover:shadow-sm px-3 py-1.5 rounded-lg border border-transparent hover:border-green-200"
                            title="Lihat ringkasan notulen">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            📋 Ringkasan
                        </a>
                    @endif --}}

                    {{-- Tombol QR Absensi --}}
                    <button type="button" 
                        class="open-qr-modal-btn text-sm font-semibold text-slate-500 hover:text-slate-800 transition-all flex items-center gap-1.5 hover:bg-white hover:shadow-sm px-3 py-1.5 rounded-lg border border-transparent hover:border-slate-200"
                        data-id="{{ $rapat->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        QR Absen
                    </button>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 lg:col-span-3 xl:col-span-4 py-20 px-6 text-center">
                <div class="bg-white p-10 rounded-3xl border-2 border-dashed border-slate-200 shadow-sm max-w-lg mx-auto">
                    <div class="w-20 h-20 mx-auto bg-slate-50 rounded-full flex items-center justify-center mb-6 ring-8 ring-slate-50/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-extrabold text-2xl text-slate-800 mb-2">Belum Ada Agenda Rapat</h3>
                    <p class="text-slate-500">Jadwal rapat Anda masih kosong. Silakan buat rapat baru melalui menu admin.</p>
                </div>
            </div>
        @endforelse
    </div>
</main>

{{-- Modal Detail Rapat --}}
<div id="detailRapatModal" 
    class="hidden fixed inset-0 z-[100] flex items-center justify-center transition-all duration-300">
    
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
    
    {{-- Modal Panel --}}
    <div class="modal-panel bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 relative z-10 overflow-hidden flex flex-col max-h-[90vh]">
        
        {{-- Header Modal --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                <span class="flex h-3 w-3 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#4C8C86] opacity-75 hidden" id="modalPing"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-[#4C8C86]"></span>
                </span>
                Detail Agenda
            </h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{-- Content Modal --}}
        <div class="p-6 overflow-y-auto relative min-h-[300px]">
            
            {{-- Loading Spinner --}}
            <div id="modalSpinner" class="absolute inset-0 bg-white z-20 flex flex-col items-center justify-center">
                <svg class="animate-spin h-10 w-10 text-[#4C8C86] mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-slate-400 text-sm font-medium">Memuat Data...</span>
            </div>

            <div id="modalContent" class="hidden space-y-6">
                {{-- Top Section: Judul & QR --}}
                <div class="flex flex-col-reverse sm:flex-row justify-between gap-6">
                    <div class="flex-1 space-y-2">
                        <div id="detailStatus" class="mb-2"></div>
                        <h2 id="detailAgenda" class="text-2xl sm:text-3xl font-extrabold text-slate-800 leading-tight"></h2>
                    </div>
                    
                    {{-- QR Code Container --}}
                    <div id="qrCodeArea" class="hidden shrink-0 flex flex-col items-center gap-2 p-3 bg-white border border-slate-200 rounded-xl shadow-[0_2px_10px_-2px_rgba(0,0,0,0.1)]">
                        <div id="qrPlaceholder" class="w-28 h-28 bg-slate-50 flex items-center justify-center rounded-lg border border-slate-100 overflow-hidden p-1">
                            {{-- SVG injected here --}}
                        </div>
                        <button onclick="printQR()" class="text-xs font-semibold text-[#4C8C86] hover:text-[#2E5350] hover:underline flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                            Cetak QR
                        </button>
                    </div>
                </div>

                <div class="h-px bg-slate-100 w-full"></div>

                {{-- Grid Info --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Waktu --}}
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Waktu Pelaksanaan</p>
                        <p id="detailTanggalWaktu" class="text-slate-800 font-medium text-lg"></p>
                    </div>

                    {{-- Lokasi --}}
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Lokasi / Link</p>
                        <div id="detailLokasi" class="text-slate-800 font-medium text-base"></div>
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        Catatan Tambahan
                    </p>
                    <p id="detailCatatan" class="text-slate-600 text-sm leading-relaxed whitespace-pre-line"></p>
                </div>

                {{-- Section Ringkasan Notulen (Jika ada) --}}
                <div id="ringkasanSection" class="hidden bg-green-50 p-4 rounded-xl border border-green-200">
                    <p class="text-xs font-bold text-green-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Notulen Tersedia
                    </p>
                    <p id="ringkasanPreview" class="text-slate-700 text-sm mb-4 line-clamp-4 leading-relaxed"></p>
                    <a id="ringkasanLink" href="#" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Lihat Ringkasan Lengkap
                    </a>
                </div>
                
            </div>
            
        </div>

        {{-- Footer Modal --}}
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
            <button onclick="closeModal()" class="px-5 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 font-medium hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- Toast Notification (untuk Copy Link) --}}
<div id="toast" class="fixed bottom-5 right-5 transform translate-y-20 opacity-0 transition-all duration-300 bg-slate-800 text-white px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 z-[110]">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
    </svg>
    <span class="text-sm font-medium">Link berhasil disalin!</span>
</div>

<script>
    // --- Global Variables ---
    const modal = document.getElementById('detailRapatModal');
    const panel = modal.querySelector('.modal-panel');
    const spinner = document.getElementById('modalSpinner');
    const content = document.getElementById('modalContent');
    const qrCodeArea = document.getElementById('qrCodeArea');
    const qrPlaceholder = document.getElementById('qrPlaceholder');
    const modalPing = document.getElementById('modalPing');

    // --- Modal Functions ---
    function openModal() {
        modal.classList.remove('hidden');
        // Trigger reflow
        void modal.offsetWidth; 
        panel.classList.remove('opacity-0', 'scale-95');
    }

    function closeModal() {
        panel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            // Reset state
            qrPlaceholder.innerHTML = '';
            qrCodeArea.classList.add('hidden');
            spinner.classList.remove('hidden');
            content.classList.add('hidden');
        }, 200);
    }

    // --- Helper: Copy to Clipboard ---
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            const toast = document.getElementById('toast');
            toast.classList.remove('translate-y-20', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3000);
        });
    }

    // --- Helper: Print QR ---
    function printQR() {
        const svgContent = qrPlaceholder.innerHTML;
        const printWindow = window.open('', '', 'height=500, width=500');
        printWindow.document.write('<html><head><title>Print QR Code</title>');
        printWindow.document.write('<style>body{display:flex; justify-content:center; align-items:center; height:100vh; margin:0;}</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(svgContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }

    // --- Helper: Get Status Styling ---
    function getRapatStatusDisplay(tanggal, jam) {
        const start = new Date(`${tanggal}T${jam}`);
        const end = new Date(start.getTime() + 60 * 60 * 1000); // +1 Jam
        const now = new Date();

        if (now < start) {
            return { 
                html: `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100 uppercase tracking-wide">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> Dijadwalkan
                       </span>`,
                ping: false
            };
        } else if (now >= start && now <= end) {
            return { 
                html: `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 text-xs font-bold border border-amber-100 uppercase tracking-wide">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                        </span> Berlangsung
                       </span>`,
                ping: true
            };
        } else {
            return { 
                html: `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-500 text-xs font-bold border border-slate-200 uppercase tracking-wide">
                        <span class="w-2 h-2 rounded-full bg-slate-400"></span> Selesai
                       </span>`,
                ping: false
            };
        }
    }

    // --- Main Event Listener ---
    document.addEventListener('DOMContentLoaded', () => {
        document.body.addEventListener('click', async (e) => {
            // Deteksi tombol trigger
            const btnDetail = e.target.closest('.open-detail-modal-btn');
            const btnQr = e.target.closest('.open-qr-modal-btn');
            const targetBtn = btnDetail || btnQr;

            if (!targetBtn) return;

            const id = targetBtn.dataset.id;
            const isQrRequest = !!btnQr;

            openModal();

            try {
                // 1. Fetch Detail
                const res = await fetch(`/rapat/${id}/details`);
                if (!res.ok) throw new Error('Gagal mengambil data rapat');
                const data = await res.json();

                // Populate Data
                document.getElementById('detailAgenda').textContent = data.judul;
                
                // Status
                const statusInfo = getRapatStatusDisplay(data.tanggal, data.jam);
                document.getElementById('detailStatus').innerHTML = statusInfo.html;
                if(statusInfo.ping) modalPing.classList.remove('hidden'); 
                else modalPing.classList.add('hidden');

                // Tanggal
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const dateStr = new Date(data.tanggal).toLocaleDateString('id-ID', options);
                document.getElementById('detailTanggalWaktu').innerHTML = `
                    ${dateStr}<br>
                    <span class="text-[#4C8C86]">Pukul ${data.jam.substring(0, 5)} WIB</span>
                `;

                // Lokasi / Link
                const lokasiEl = document.getElementById('detailLokasi');
                if (data.tipe_lokasi === 'online') {
                    lokasiEl.innerHTML = `
                        <div class="flex items-center gap-2 p-2 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="p-1.5 bg-white rounded-md text-blue-600 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-blue-600 font-semibold uppercase">Online Meeting</p>
                                <a href="${data.link}" target="_blank" class="text-sm font-medium text-slate-800 hover:text-blue-600 hover:underline truncate block">${data.link}</a>
                            </div>
                            <button onclick="copyToClipboard('${data.link}')" class="p-1.5 text-slate-400 hover:text-slate-600 transition-colors" title="Salin Link">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg>
                            </button>
                        </div>
                    `;
                } else {
                    lokasiEl.innerHTML = `
                        <div class="flex items-center gap-2">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                             <span>${data.ruangan || 'Ruangan Belum Ditentukan'}</span>
                        </div>`;
                }

                // Catatan
                document.getElementById('detailCatatan').textContent = data.agenda;

                // Handle Ringkasan Notulen (Jika ada)
                const ringkasanSection = document.getElementById('ringkasanSection');
                if (data.notulen_ada && data.ringkasan) {
                    // Tampilkan section ringkasan
                    ringkasanSection.classList.remove('hidden');
                    
                    // Set preview ringkasan (ambil 200 karakter pertama)
                    const preview = data.ringkasan.substring(0, 200) + (data.ringkasan.length > 200 ? '...' : '');
                    document.getElementById('ringkasanPreview').textContent = preview;
                    
                    // Set link ke halaman ringkasan lengkap
                    const summaryUrl = `/notulen/${data.notulen_id}/summary`;
                    document.getElementById('ringkasanLink').href = summaryUrl;
                } else {
                    ringkasanSection.classList.add('hidden');
                }

                // 2. Handle QR Code (Jika diminta atau jika tombol QR diklik)
                if (isQrRequest) {
                    const resQr = await fetch(`/rapat/${id}/qr-code`);
                    if (resQr.ok) {
                        const svgString = await resQr.text();
                        qrPlaceholder.innerHTML = svgString;
                        // Styling SVG
                        const svgElement = qrPlaceholder.querySelector('svg');
                        if(svgElement) {
                            svgElement.setAttribute('width', '100%');
                            svgElement.setAttribute('height', '100%');
                        }
                        qrCodeArea.classList.remove('hidden');
                    }
                }

            } catch (error) {
                console.error(error);
                if (typeof Swal !== 'undefined') Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan saat memuat data rapat.' }); else alert('Terjadi kesalahan saat memuat data rapat.');
                closeModal();
            } finally {
                spinner.classList.add('hidden');
                content.classList.remove('hidden');
            }
        });
    });
</script>
@endsection