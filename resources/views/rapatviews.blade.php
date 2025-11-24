@extends('layout.app')
@section('title', 'Rekap Rapat')

@section('content')
<main class="p-4 sm:p-6 flex-1">
    
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div>
            <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">Agenda Rapat </h3>
            <p class="text-base text-slate-500 mt-1">Tinjau semua rapat yang telah dijadwalkan dan statusnya.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($rapats as $rapat)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-lg hover:shadow-xl hover:scale-[1.01] transition-all duration-300 p-6 flex flex-col group">
                
                <div class="flex justify-between items-start mb-4">
                    <h4 class="text-lg font-extrabold text-slate-900 line-clamp-2 pr-4">{{ $rapat->judul }}</h4>
                    @php
                        $isFuture = $rapat->tanggal->isFuture();
                        $statusText = $isFuture ? 'Terjadwal' : 'Selesai';
                        $statusBg = $isFuture ? 'text-blue-700 bg-blue-50' : 'text-green-700 bg-green-50';
                    @endphp
                    <span class="shrink-0 px-3 py-1 text-xs font-semibold {{ $statusBg }} rounded-full border border-current">
                        {{ $statusText }}
                    </span>
                </div>
                
                <div class="space-y-4 text-sm text-slate-700 mb-6 flex-grow border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-[#4C8C86] shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" /></svg>
                        <span class="font-medium">{{ $rapat->tanggal->format('d F Y') }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-[#4C8C86] shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" /></svg>
                        <span>Pukul **{{ \Carbon\Carbon::parse($rapat->jam)->format('H:i') }} WIB**</span>
                    </div>
                    <div class="flex items-center gap-3">
                        @if ($rapat->tipe_lokasi == 'online')
                            <svg class="h-5 w-5 text-[#4C8C86] shrink-0" viewBox="0 0 20 20" fill="currentColor"><path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2V5z" /><path d="M15 7v2a1 1 0 01-1 1h-1a1 1 0 01-1-1V7a1 1 0 011-1h1a1 1 0 011 1zm-7 8a1 1 0 01-1 1H4a1 1 0 01-1-1v-1a1 1 0 011-1h3a1 1 0 011 1v1z" /><path fill-rule="evenodd" d="M10.496 11.332L9.25 10.5l-.25.5v1.75l.625 1.25H10.5v-2.5zm1.516-1.042c.162.247.332.484.502.71a1 1 0 010 1.414l-2 2a1 1 0 01-1.414 0l-2-2a1 1 0 010-1.414c.17-.226.34-.463.502-.71l.666-.967a1 1 0 111.64 1.135l-.271.415.536.72.67-.923a1 1 0 111.64 1.135l-.271.415.536.72.67-.923z" clip-rule="evenodd" /></svg>
                            <a href="{{ $rapat->link }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline truncate font-medium">Online Meeting Link</a>
                        @else
                            <svg class="h-5 w-5 text-[#4C8C86] shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                            <span class="truncate font-medium">{{ $rapat->ruangan ?? 'Ruangan Belum Ditentukan' }}</span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <button type="button" 
                        class="open-detail-modal-btn text-sm font-bold text-[#4C8C86] hover:text-[#2E5350] transition-colors duration-200 flex items-center gap-1"
                        data-id="{{ $rapat->id }}">
                        Lihat Detail &rarr;
                    </button>
                    
                    @if (!$rapat->tanggal->isFuture()) {{-- Asumsi QR hanya untuk rapat yang sudah lewat/berlangsung --}}
                        <button type="button" 
                            class="open-qr-modal-btn text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors duration-200 flex items-center gap-1 group-hover:text-[#4C8C86] group-hover:scale-105"
                            data-id="{{ $rapat->id }}" data-action="generate-qr">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.42 2.768a1.5 1.5 0 011.638-.168l4 2A1.5 1.5 0 0119 5v10a1.5 1.5 0 01-1.942 1.353l-4-2A1.5 1.5 0 0112 14v-9.586a.5.5 0 00-.814-.383L7 9.88V6.444A1.5 1.5 0 018.942 5.09L12 6.51V2.468a.5.5 0 00-.28-.423zM5.5 11a1.5 1.5 0 00-1.5 1.5v2A1.5 1.5 0 005.5 16h4a1.5 1.5 0 001.5-1.5v-2A1.5 1.5 0 009.5 11h-4z" clip-rule="evenodd" />
                            </svg>
                            Absensi QR
                        </button>
                    @endif
                </div>

            </div>
        @empty
            <div class="md:col-span-2 lg:col-span-3 xl:col-span-4 text-center rounded-3xl p-16 bg-[#F4FDFB] border-2 border-dashed border-[#A3D1CD] shadow-inner">
                {{-- Icon Container (Warna kustom lebih lembut) --}}
                <div class="w-20 h-20 mx-auto bg-[#E5F2F1] rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#4C8C86]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                
                {{-- Heading --}}
                <h3 class="font-bold text-xl text-slate-700">Tidak Ada Rapat Terdaftar</h3>
                
                {{-- Supporting Text --}}
                <p class="text-slate-500 mt-2">Semua agenda rapat akan muncul di sini. Klik "Buat Rapat Baru" untuk memulai.</p>
            </div>
        @endforelse
    </div>
</main>

{{-- Modal Detail Rapat --}}
<div id="detailRapatModal" 
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 transition-opacity duration-300">
    
    <div class="modal-panel bg-gradient-to-br from-white to-slate-50/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-slate-200/50 w-full max-w-2xl transform scale-95 opacity-0 transition-all duration-300 ease-out">
        
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100/60 bg-white/60 rounded-t-3xl backdrop-blur-sm">
            <h3 class="text-xl font-extrabold text-slate-800 flex items-center gap-2">
                <div class="w-2 h-8 bg-[#4C8C86] rounded-full"></div>
                Detail Rapat
            </h3>
            <button id="closeDetailModalBtn" 
                class="text-slate-400 hover:text-slate-700 text-3xl font-light transition-transform hover:rotate-90 hover:scale-110">&times;</button>
        </div>

        <div class="p-6 space-y-7 relative overflow-hidden">
            <div id="modalSpinner" class="absolute inset-0 bg-white/60 flex flex-col items-center justify-center rounded-3xl hidden">
                <svg class="animate-spin h-9 w-9 text-[#4C8C86]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-30" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-80" fill="currentColor" 
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                </svg>
                <p class="mt-2 text-slate-500 text-sm animate-pulse">Memuat detail rapat...</p>
            </div>

            <div id="modalContent" class="hidden space-y-7">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-l-4 border-[#4C8C86] pl-5">
                    <div>
                        <h2 id="detailAgenda" class="text-3xl font-bold text-slate-900 tracking-tight mb-1"></h2>
                        <div id="detailStatus"></div>
                    </div>
                    
                    <div id="qrCodeArea" class="shrink-0 hidden flex-col items-center p-3 bg-white border border-slate-100 rounded-lg shadow-inner">
                        <p class="text-xs font-semibold text-slate-500 mb-2">QR Absensi</p>
                        <div id="qrPlaceholder" class="w-24 h-24 bg-black flex items-center justify-center text-xs text-slate-400">
                            <!-- SVG QR Code akan dimasukkan di sini -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#4C8C86]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v.01M12 8v.01M12 12v.01M12 16v.01M12 20v.01M16 12h.01M20 12h.01M4 12h.01M8 12h.01M8 8h.01M16 8h.01M16 16h.01M8 16h.01" />
                            </svg>
                        </div>
                        <a href="#" id="qrPrintButton" class="mt-2 text-xs text-blue-600 hover:underline hidden">Cetak QR</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="flex flex-col bg-white/70 rounded-xl p-4 shadow-sm border border-slate-100">
                        <p class="text-sm font-semibold text-slate-500 mb-1 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4C8C86]" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" /></svg> 
                            Tanggal & Waktu
                        </p>
                        <p id="detailTanggalWaktu" class="text-slate-800 text-[16px] font-medium"></p>
                    </div>

                    <div class="flex flex-col bg-white/70 rounded-xl p-4 shadow-sm border border-slate-100">
                        <p class="text-sm font-semibold text-slate-500 mb-1 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4C8C86]" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                            Lokasi
                        </p>
                        <div id="detailLokasi" class="text-slate-800 text-[16px] font-medium"></div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-200">
                    <p class="text-sm font-semibold text-slate-600 mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4C8C86]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        Catatan Singkat
                    </p>
                    <p class="text-slate-700 text-[15px] p-3 bg-slate-50 rounded-lg border border-slate-100" id="detailCatatan">
                        Tidak ada catatan tambahan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // --- Elemen Modal ---
    const modal = document.getElementById('detailRapatModal');
    const panel = modal.querySelector('.modal-panel');
    const closeBtn = document.getElementById('closeDetailModalBtn');
    const spinner = document.getElementById('modalSpinner');
    const content = document.getElementById('modalContent');
    const qrCodeArea = document.getElementById('qrCodeArea');
    const qrPlaceholder = document.getElementById('qrPlaceholder');

    // --- Fungsionalitas Modal ---
    const openModal = () => {
        modal.classList.remove('hidden');
        setTimeout(() => panel.classList.remove('opacity-0', 'scale-95'), 10);
    };
    const closeModal = () => {
        panel.classList.add('opacity-0', 'scale-95');
        // Bersihkan QR Code saat modal ditutup
        qrPlaceholder.innerHTML = ''; 
        qrCodeArea.classList.add('hidden');
        setTimeout(() => modal.classList.add('hidden'), 200);
    };
    
    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });

    // --- Logika Status Rapat ---
    function getRapatStatus(tanggal, jam) {
        const rapatDate = new Date(`${tanggal}T${jam}:00`);
        const now = new Date();
        // Asumsi durasi rapat adalah 60 menit (1 jam)
        const rapatEnd = new Date(rapatDate.getTime() + 60 * 60 * 1000); 

        if (now < rapatDate) {
            return { text: 'Terjadwal', class: 'bg-blue-100 text-blue-800 border border-blue-200', dot: 'bg-blue-500' };
        } else if (now >= rapatDate && now <= rapatEnd) {
            return { text: 'Sedang Berlangsung', class: 'bg-yellow-100 text-yellow-800 border border-yellow-200 animate-pulse', dot: 'bg-yellow-500 animate-ping' };
        } else {
            return { text: 'Selesai', class: 'bg-green-100 text-green-800 border border-green-200', dot: 'bg-green-500' };
        }
    }

    // --- Logika AJAX & Populate Modal ---
    document.body.addEventListener('click', async (e) => {
        const btn = e.target.closest('.open-detail-modal-btn');
        const qrBtn = e.target.closest('.open-qr-modal-btn');
        
        if (!btn && !qrBtn) return;

        const id = (btn || qrBtn).dataset.id;
        openModal();
        spinner.classList.remove('hidden');
        content.classList.add('hidden');
        
        // Bersihkan konten lama
        qrPlaceholder.innerHTML = ''; 
        qrCodeArea.classList.add('hidden');
        
        try {
            // 1. Fetch Detail Rapat
            const res = await fetch(`/rapat/${id}/details`); 
            if (!res.ok) throw new Error('Network response was not ok');
            const data = await res.json();
            
            populateModal(data);
            
            // 2. Logika Tambahan untuk QR Code (hanya jika tombol QR diklik)
            if (qrBtn) {
                
                // Endpoint yang benar berdasarkan RapatController
                const resQr = await fetch(`/rapat/${id}/qr-code`); 
                
                if (!resQr.ok) throw new Error('Gagal mengambil data QR Code.');
                
                // **PENTING: Ambil respons sebagai teks (SVG String)**
                const svgString = await resQr.text(); 
                
                // **PENTING: Masukkan string SVG langsung ke dalam placeholder**
                qrPlaceholder.innerHTML = svgString;
                
                // Terapkan style agar SVG pas di container w-24 h-24
                const svgElement = qrPlaceholder.querySelector('svg');
                if (svgElement) {
                    svgElement.style.width = '100%';
                    svgElement.style.height = '100%';
                }

                // Tampilkan area QR
                qrCodeArea.classList.remove('hidden');
            } else {
                 // Sembunyikan QR code jika tombol Detail yang diklik
                qrCodeArea.classList.add('hidden');
                qrPlaceholder.innerHTML = '';
            }

        } catch (err) {
            console.error('Fetch error:', err);
            // Tambahkan pesan error di modal jika diperlukan
            qrPlaceholder.innerHTML = '<p class="text-xs text-red-500 text-center">Gagal memuat QR Code. Cek konsol browser untuk detail error.</p>';
            qrCodeArea.classList.remove('hidden'); // Tampilkan area error
        } finally {
            spinner.classList.add('hidden');
            content.classList.remove('hidden');
        }
    });

    function populateModal(data) {
        // 1. Judul
        document.getElementById('detailAgenda').textContent = data.judul;

        // 2. Status
        const status = getRapatStatus(data.tanggal, data.jam);
        document.getElementById('detailStatus').innerHTML = `
            <span class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium rounded-full ${status.class}">
                <span class="w-2 h-2 rounded-full ${status.dot}"></span> ${status.text}
            </span>
        `;
        
        // 3. Tanggal & Waktu
        const date = new Date(data.tanggal).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        document.getElementById('detailTanggalWaktu').textContent = `${date}, ${data.jam} WIB`;

        // 4. Lokasi
        const lokasi = document.getElementById('detailLokasi');
        if (data.tipe_lokasi === 'online') {
            lokasi.innerHTML = `
                <span class="text-sm font-medium text-blue-600">Online Meeting:</span> 
                <a href="${data.link}" target="_blank" class="text-[#4C8C86] hover:underline block font-medium mt-1 truncate">${data.link || 'Link Meeting'}</a>
            `;
        } else {
            lokasi.innerHTML = data.ruangan ? 
                `<span class="text-sm font-medium">${data.ruangan}</span>` : 
                `<span class="text-slate-500 italic">Ruangan Belum Ditentukan</span>`;
        }

        // 5. Catatan
        // Catatan: Model Rapat Anda tidak memiliki field 'catatan' yang diekspos di RapatController::showDetails, 
        // sehingga ini akan selalu menampilkan 'Tidak ada catatan tambahan.'
        document.getElementById('detailCatatan').textContent = data.catatan || 'Tidak ada catatan tambahan.';
    }
});
</script>
@endsection