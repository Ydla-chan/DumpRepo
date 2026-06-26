@extends('layout.app')


    @push('styles')
         <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        /* Custom CSS for New Color Scheme & Transitions */
        :root {
            --color-custom-teal: #4C8C86;
            --color-custom-teal-dark: #3D6F6A;
            --color-custom-teal-light: #eef7f6;
            --color-custom-teal-text: #376661;
        }
        .bg-custom-teal { background-color: var(--color-custom-teal); }
        .hover\:bg-custom-teal-dark:hover { background-color: var(--color-custom-teal-dark); }
        .bg-custom-teal-light { background-color: var(--color-custom-teal-light); }
        .hover\:bg-custom-teal-lighter:hover { background-color: #dbebe9; }
        .text-custom-teal { color: var(--color-custom-teal); }
        .text-custom-teal-dark { color: var(--color-custom-teal-text); }
        .border-custom-teal { border-color: var(--color-custom-teal); }

        .modal { transition: opacity 0.3s ease, visibility 0.3s ease; }
        .modal-content { transition: transform 0.3s ease; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 3px;}
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #64748b; }
    </style>
    @endpush

@section('content')
 <div class="flex flex-col md:flex-row flex-1 overflow-hidden">
            
            <aside class="w-full md:w-1/3 lg:w-1/4 bg-white p-6 border-b md:border-b-0 md:border-r border-slate-200 overflow-y-auto custom-scrollbar">
                <h2 class="text-lg font-bold text-slate-900 pb-3 border-b border-slate-200">Detail Rapat</h2>
                <div class="mt-4 space-y-4 text-sm">
                    <h3 class="text-xl font-bold text-slate-800">Rapat Strategi Q4 2025</h3>
                    <div class="flex items-start gap-3 text-slate-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" /></svg><span>Senin, 6 Oktober 2025</span></div>
                    <div class="flex items-start gap-3 text-slate-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.414L11 10.586V6z" clip-rule="evenodd" /></svg><span>09:00 - 11:00 WIB</span></div>
                    <div class="flex items-start gap-3 text-slate-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg><span>Ruang TA 10.3 </span></div>
                </div>

                <h2 class="text-lg font-bold text-slate-900 pb-3 border-b border-slate-200 mt-8">Peserta Rapat</h2>
                <div class="mt-4 space-y-3">
                    <div class="flex items-center gap-3"><img src="https://i.pravatar.cc/150?u=andi" alt="Andi" class="w-10 h-10 rounded-full object-cover"><div><p class="font-semibold text-sm">Amelian Hanif</p><p class="text-xs text-slate-500">Sales Manager</p></div></div>
                    <div class="flex items-center gap-3"><img src="https://i.pravatar.cc/150?u=citra" alt="Citra" class="w-10 h-10 rounded-full object-cover"><div><p class="font-semibold text-sm">Bagas Satrio</p><p class="text-xs text-slate-500">Marketing Lead</p></div></div>
                    <div class="flex items-center gap-3"><img src="https://i.pravatar.cc/150?u=dani" alt="Dani" class="w-10 h-10 rounded-full object-cover"><div><p class="font-semibold text-sm">Jessica</p><p class="text-xs text-slate-500">Tech Lead</p></div></div>
                </div>
                 <div class="mt-8 pt-6 border-t border-slate-200">
                    <button class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-custom-teal text-white rounded-lg shadow-md hover:bg-custom-teal-dark transition-all duration-300 transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        <span>Export ke PDF</span>
                    </button>
                 </div>
            </aside>

            <main class="flex-1 p-4 md:p-6 overflow-y-auto custom-scrollbar">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900"> Hasil Rapat</h2>
                    <button class="open-modal-btn flex items-center justify-center p-2.5 md:px-4 md:py-2 bg-custom-teal text-white rounded-full md:rounded-lg shadow-md hover:bg-custom-teal-dark transition-all duration-300" title="Tambah Pokok Bahasan">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        <span class="hidden md:inline ml-2 font-semibold text-sm">Pokok Bahasan</span>
                    </button>
                </div>
                
                <div class="space-y-6">
                    <div class="bg-white p-4 md:p-5 rounded-xl shadow-md border border-slate-200">
                        <div class="flex justify-between items-start gap-4 pb-4 border-b border-slate-200">
                            <h3 class="text-base md:text-lg font-bold text-slate-800 pt-1">Evaluasi Kinerja Penjualan Q3</h3>
                            <div class="flex items-center gap-2 shrink-0">
                                <button class="open-modal-btn p-1.5 text-slate-500 hover:text-custom-teal hover:bg-slate-100 rounded-md transition" title="Edit Pokok Bahasan"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg></button>
                                <button class="open-modal-btn flex items-center p-1.5 md:px-3 md:py-1 bg-custom-teal-light text-custom-teal-dark hover:bg-custom-teal-lighter rounded-full md:rounded-md transition" title="Tambah Keputusan">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                    <span class="hidden md:inline ml-1 text-xs font-semibold">Tambah Keputusan</span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mt-4 space-y-4">
                            <div class="pl-3 md:pl-4 border-l-4 border-custom-teal">
                                <div class="flex justify-between items-start gap-3">
                                    <p class="font-semibold text-slate-700 text-sm md:text-base pt-1">Meningkatkan target penjualan 15% untuk produk unggulan.</p>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <button class="open-modal-btn p-1.5 text-slate-500 hover:text-custom-teal hover:bg-slate-100 rounded-md transition" title="Edit Keputusan"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg></button>
                                        <button class="open-modal-btn flex items-center p-1.5 md:px-3 md:py-1 bg-custom-teal-light text-custom-teal-dark hover:bg-custom-teal-lighter rounded-full md:rounded-md transition" title="Tambah Tindakan">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                            <span class="hidden md:inline ml-1 text-xs font-semibold">Tambah Tindakan</span>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="mt-3 space-y-2">
                                    <div class="flex items-center justify-between gap-3 p-2.5 bg-slate-50 rounded-lg border border-slate-200">
                                        <p class="text-sm text-slate-600">Menyusun strategi marketing baru untuk media sosial.</p>
                                        <div class="flex items-center gap-2 shrink-0">
                                            <img src="https://i.pravatar.cc/150?u=citra" alt="Citra" class="w-7 h-7 rounded-full object-cover ring-2 ring-white" title="PIC: Citra Lestari">
                                            <button class="open-modal-btn p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-200 rounded-md transition" title="Edit Tindakan"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div id="itemModal" class="modal fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center p-4 hidden visibility-hidden opacity-0">
        <div class="modal-content bg-white w-full max-w-md p-6 rounded-2xl shadow-2xl transform scale-95">
            <div class="flex items-center justify-between mb-4">
                <h3 id="modalTitle" class="text-xl font-bold text-slate-800">Modal Title</h3>
                <button id="closeModalBtn" class="text-slate-400 hover:text-slate-600 transition text-2xl">&times;</button>
            </div>
            <form>
                <div class="space-y-4">
                    <div>
                        <label for="modalContentText" class="block text-sm font-medium text-slate-600 mb-1">Deskripsi</label>
                        <textarea id="modalContentText" rows="4" class="w-full p-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-custom-teal focus:border-custom-teal transition"></textarea>
                    </div>
                    <div id="modalPicContainer" class="hidden">
                        <label for="modalPicName" class="block text-sm font-medium text-slate-600 mb-1">Penanggung Jawab (PIC)</label>
                        <input type="text" id="modalPicName" class="w-full p-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-custom-teal focus:border-custom-teal transition">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" id="cancelModalBtn" class="px-4 py-2 bg-slate-200 text-slate-800 rounded-lg hover:bg-slate-300 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-custom-teal text-white rounded-lg hover:bg-custom-teal-dark transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // SCRIPT UNTUK MODAL (Sama seperti sebelumnya, tidak perlu diubah)
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('itemModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalContentText = document.getElementById('modalContentText');
            const modalPicContainer = document.getElementById('modalPicContainer');
            const openModalButtons = document.querySelectorAll('.open-modal-btn');
            const closeModalButtons = [document.getElementById('closeModalBtn'), document.getElementById('cancelModalBtn')];

            const openModal = (title) => {
                modalTitle.textContent = title;
                modalPicContainer.classList.toggle('hidden', !title.toLowerCase().includes('tindakan'));
                modal.classList.remove('hidden', 'visibility-hidden', 'opacity-0');
                modal.querySelector('.modal-content').classList.remove('scale-95');
            };

            const closeModal = () => {
                modal.querySelector('.modal-content').classList.add('scale-95');
                modal.classList.add('opacity-0');
                setTimeout(() => modal.classList.add('hidden', 'visibility-hidden'), 300);
            };
            
            openModalButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const title = button.title;
                    openModal(title);
                });
            });

            closeModalButtons.forEach(button => button.addEventListener('click', closeModal));
            modal.addEventListener('click', (event) => { if (event.target === modal) closeModal(); });
            document.addEventListener('keydown', (event) => { if (event.key === 'Escape' && !modal.classList.contains('hidden')) closeModal(); });
        });
    </script>
</body>
@endsection
