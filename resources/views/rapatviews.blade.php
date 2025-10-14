@extends('layout.app')
@section('title', 'Rekap Rapat')

@section('content')
<main class="p-4 sm:p-6 flex-1">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-800">Daftar Rapat</h3>
            <p class="text-sm text-slate-500">Tinjau semua rapat yang telah dijadwalkan.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse ($rapats as $rapat)
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-5 flex flex-col">
                <div class="flex justify-between items-start mb-4">
                    <h4 class="text-lg font-bold text-slate-800 pr-4">{{ $rapat->judul }}</h4>
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
                        @if ($rapat->tipe_lokasi == 'online')
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
           <div class="md:col-span-2 xl:col-span-3 text-center rounded-2xl p-12 bg-slate-50 border-2 border-dashed border-slate-200">
    {{-- Styled Icon Container --}}
    <div class="w-20 h-20 mx-auto bg-custom-teal-light rounded-full flex items-center justify-center ">
        {{-- SVG Icon --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-custom-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
    </div>
    
    {{-- Heading --}}
    <h3 class="font-semibold text-lg text-slate-700">Tidak Ada Rapat Ditemukan</h3>
    
    {{-- Supporting Text --}}
    <p class="text-slate-500 mt-1">Saat ini belum ada data rapat yang tersedia untuk ditampilkan.</p>
</div>
        @endforelse
    </div>
</main>
{{-- Modal Detail Rapat --}}
<div id="detailRapatModal" 
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 transition-opacity duration-300">
    
    <div class="modal-panel bg-gradient-to-br from-white to-slate-50/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-slate-200/50 w-full max-w-2xl transform scale-95 opacity-0 transition-all duration-300 ease-out">
        
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100/60 bg-white/60 rounded-t-3xl backdrop-blur-sm">
            <h3 class="text-xl font-extrabold text-slate-800 flex items-center gap-2">
                <div class="w-2 h-8 bg-[#4C8C86] rounded-full"></div>
                Detail Rapat
            </h3>
            <button id="closeDetailModalBtn" 
                class="text-slate-400 hover:text-slate-700 text-3xl font-light transition-transform hover:rotate-90 hover:scale-110">&times;</button>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-6 relative overflow-hidden">
            <!-- Spinner -->
            <div id="modalSpinner" class="absolute inset-0 bg-white/60 flex flex-col items-center justify-center rounded-3xl hidden">
                <svg class="animate-spin h-9 w-9 text-[#4C8C86]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-30" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-80" fill="currentColor" 
                        d="M4 12a8 8 0 018-8V0C5.373 
                           0 0 5.373 0 12h4zm2 5.291A7.962 
                           7.962 0 014 12H0c0 3.042 1.135 
                           5.824 3 7.938l3-2.647z"/>
                </svg>
                <p class="mt-2 text-slate-500 text-sm animate-pulse">Memuat detail rapat...</p>
            </div>

            <div id="modalContent" class="hidden space-y-7">
                <!-- Bagian atas -->
                <div class="border-l-4 border-[#4C8C86] pl-5">
                    <h2 id="detailAgenda" class="text-3xl font-bold text-slate-900 tracking-tight mb-2"></h2>
                    <div id="detailStatus"></div>
                </div>

                <!-- Informasi utama -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="flex flex-col bg-white/70 rounded-xl p-4 shadow-sm border border-slate-100">
                        <p class="text-sm font-semibold text-slate-500 mb-1 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4C8C86]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 
                                21h14a2 2 0 002-2V7a2 2 0 
                                00-2-2H5a2 2 0 00-2 2v12a2 
                                2 0 002 2z"/>
                            </svg> 
                            Tanggal & Waktu
                        </p>
                        <p id="detailTanggalWaktu" class="text-slate-800 text-[15px]"></p>
                    </div>

                    <div class="flex flex-col bg-white/70 rounded-xl p-4 shadow-sm border border-slate-100">
                        <p class="text-sm font-semibold text-slate-500 mb-1 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4C8C86]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M17.657 16.657L13.414 20.9a1.998 
                                       1.998 0 01-2.827 0l-4.244-4.243a8 8 
                                       0 1111.314 0z"/>
                            </svg>
                            Lokasi
                        </p>
                        <div id="detailLokasi" class="text-slate-800 text-[15px]"></div>
                    </div>
                </div>

                <!-- Tambahan catatan -->
                <div class="pt-4 border-t border-slate-200">
                    <p class="text-sm font-semibold text-slate-500 mb-1">🗒️ Catatan Singkat</p>
                    <p class="text-slate-700 text-[15px]" id="detailCatatan">
                        Tidak ada catatan tambahan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('detailRapatModal');
    const panel = modal.querySelector('.modal-panel');
    const closeBtn = document.getElementById('closeDetailModalBtn');
    const spinner = document.getElementById('modalSpinner');
    const content = document.getElementById('modalContent');

    const openModal = () => {
        modal.classList.remove('hidden');
        setTimeout(() => panel.classList.remove('opacity-0', 'scale-95'), 10);
    };
    const closeModal = () => {
        panel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => modal.classList.add('hidden'), 200);
    };
    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });

    document.body.addEventListener('click', async (e) => {
        const btn = e.target.closest('.open-detail-modal-btn');
        if (!btn) return;

        const id = btn.dataset.id;
        openModal();
        spinner.classList.remove('hidden');
        content.classList.add('hidden');

        try {
            const res = await fetch(`/rapat/${id}/details`);
            const data = await res.json();
            populateModal(data);
        } catch (err) {
            console.error(err);
        } finally {
            spinner.classList.add('hidden');
            content.classList.remove('hidden');
        }
    });

    function populateModal(data) {
        document.getElementById('detailAgenda').textContent = data.judul;

        const rapatDate = new Date(`${data.tanggal} ${data.jam}`);
        const now = new Date();
        const rapatEnd = new Date(rapatDate.getTime() + 60 * 60 * 1000);

        let statusText = '', statusClass = '';
        if (now < rapatDate) {
            statusText = 'Terjadwal';
            statusClass = 'bg-blue-100 text-blue-800 border border-blue-200 shadow-sm';
        } else if (now >= rapatDate && now <= rapatEnd) {
            statusText = 'Sedang Berlangsung';
            statusClass = 'bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm animate-pulse';
        } else {
            statusText = 'Selesai';
            statusClass = 'bg-green-100 text-green-800 border border-green-200 shadow-sm';
        }

        document.getElementById('detailStatus').innerHTML = `
            <span class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium rounded-full ${statusClass}">
                <span class="w-2 h-2 rounded-full ${
                    now < rapatDate ? 'bg-blue-500' : 
                    now <= rapatEnd ? 'bg-yellow-500 animate-ping' : 
                    'bg-green-500'
                }"></span> ${statusText}
            </span>
        `;

        document.getElementById('detailTanggalWaktu').textContent = `${data.tanggal}, ${data.jam} WIB`;

        const lokasi = document.getElementById('detailLokasi');
        lokasi.innerHTML = data.tipe_lokasi === 'online'
            ? `<a href="${data.link}" target="_blank" class="text-[#4C8C86] hover:underline font-medium">Online Meeting Link</a>`
            : (data.ruangan ?? 'Belum ditentukan');

        document.getElementById('detailCatatan').textContent = data.catatan ?? 'Tidak ada catatan tambahan.';
    }
});
</script>
@endsection
