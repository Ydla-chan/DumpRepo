@extends('layout.app')
@section('title', 'Rekap Rapat')
@section('content')
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
    @ddd
</div>
   <script>
    document.addEventListener('DOMContentLoaded', function () {
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
        }

    });
    </script>
</body>
@endsection()