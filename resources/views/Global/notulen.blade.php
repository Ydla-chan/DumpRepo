@extends('layout.app')

@push('styles')
<style>
    body {
        font-family: 'Inter', sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    :root {
        --color-custom-teal: #4C8C86;
        --color-custom-teal-dark: #3D6F6A;
        --color-custom-teal-light: #eef7f6;
        --color-custom-teal-text: #376661;
    }
    .bg-custom-teal { background-color: var(--color-custom-teal); }
    .hover\:bg-custom-teal-dark:hover { background-color: var(--color-custom-teal-dark); }
    .bg-custom-teal-light { background-color: var(--color-custom-teal-light); }
    .text-custom-teal { color: var(--color-custom-teal); }
    .text-custom-teal-dark { color: var(--color-custom-teal-dark); }
    .border-custom-teal { border-color: var(--color-custom-teal); }
    .ring-custom-teal:focus { --tw-ring-color: var(--color-custom-teal); }

    .modal { transition: opacity 0.3s ease, visibility 0.3s ease; }
    .modal-content { transition: transform 0.3s ease; }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endpush

@section('content')
{{-- We add a light background to the main container to make white cards stand out --}}
<div class="flex flex-col md:flex-row flex-1 overflow-hidden bg-slate-50">

    {{-- SIDEBAR DETAIL RAPAT --}}
    <aside class="w-full md:w-1/3 lg:w-1/4 bg-white p-6 border-b md:border-r border-slate-200 overflow-y-auto custom-scrollbar">
        <h2 class="text-xl font-bold text-slate-900 pb-4 border-b border-slate-200">Detail Rapat</h2>

        <div class="mt-6 space-y-4">
            {{-- Agenda Title --}}
            <h3 class="text-2xl font-bold text-custom-teal">{{ $rapat->judul }}</h3>
            
            {{-- Meeting Details with Icons --}}
            <div class="space-y-3 text-slate-600">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" /></svg>
                    <span>{{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('l, d F Y') }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.414L11 10.586V6z" clip-rule="evenodd" /></svg>
                    <span>{{ \Carbon\Carbon::parse($rapat->jam)->format('H:i') }} WIB</span>
                </div>
                <div class="flex items-start gap-3">
                    @if($rapat->tipe_lokasi == 'offline')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                        <span>{{ $rapat->ruangan ?? 'Lokasi belum ditentukan' }}</span>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 7.172a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.86a5.002 5.002 0 00-4.954 0c.27.214.462.52.477.86h4z" /></svg>
                        <a href="{{ $rapat->link }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $rapat->link }}</a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tombol Export & Simpan --}}
        <div class="mt-8 pt-6 border-t border-slate-200 space-y-3">
            <button class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-100 hover:border-slate-400 transition-all font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                Export ke PDF
            </button>

            <form action="{{ route('notulen.store') }}" method="POST" id="saveNotulenForm">
                @csrf
                <input type="hidden" name="rapat_id" value="{{ $rapat->id }}">
                <input type="hidden" name="judul" value="{{ $rapat->judul }}">
                <input type="hidden" name="tanggal" value="{{ $rapat->tanggal }}">
                <input type="hidden" name="pembuat_id" value="{{ auth()->id() }}">
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-all font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    Simpan Notulen
                </button>
            </form>
        </div>
    </aside>

    {{-- KONTEN UTAMA --}}
    <main class="flex-1 p-6 md:p-8 overflow-y-auto custom-scrollbar">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
            <h2 class="text-3xl font-bold text-slate-900">Hasil Rapat</h2>
            <button class="open-modal-btn flex items-center justify-center gap-2 w-full sm:w-auto px-4 py-2 bg-custom-teal text-white rounded-lg hover:bg-custom-teal-dark transition-all shadow-sm hover:shadow-md font-semibold" title="Tambah Pokok Bahasan">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                <span>Pokok Bahasan</span>
            </button>
        </div>

        <div class="space-y-6">
        {{-- Loop Pokok Bahasan --}}
        @forelse($bahasan as $b)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-5">
                {{-- Header Pokok Bahasan --}}
                <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-3 border-b border-slate-200 pb-4">
                    <h3 class="text-xl font-bold text-slate-800">{{ $b->judul }}</h3>
                    <button class="open-modal-btn flex items-center gap-2 text-sm font-semibold bg-custom-teal-light text-custom-teal-dark px-3 py-1.5 rounded-md hover:bg-custom-teal hover:text-white transition-all"
                            title="Tambah Keputusan" data-id="{{ $loop->index }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                        Keputusan
                    </button>
                </div>

                {{-- Konten Keputusan --}}
                <div class="space-y-4">
                @forelse($b->keputusans as $k)
                    <div class="pl-5 border-l-4 border-custom-teal space-y-3">
                        <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-3">
                            <p class="font-semibold text-slate-700 leading-relaxed">{{ $k->isi_keputusan }}</p>
                            <button class="open-modal-btn flex items-center gap-2 text-sm font-semibold bg-custom-teal-light text-custom-teal-dark px-3 py-1.5 rounded-md hover:bg-custom-teal hover:text-white transition-all whitespace-nowrap"
                                    title="Tambah Tindakan" data-id="{{ $loop->parent->index }}-{{ $loop->index }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                                Tindakan
                            </button>
                        </div>

                        {{-- Loop Tindakan --}}
                        <div class="space-y-2 pt-2">
                        @forelse($k->tindakans as $t)
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-slate-100 border border-slate-200 p-3 rounded-lg">
                                <p class="text-sm text-slate-800 flex-1">{{ $t->deskripsi }}</p>
                                {{-- Display PIC (Person in Charge) --}}
                                @if($t->pic)
                                <div class="flex items-center gap-2 bg-white px-2.5 py-1 rounded-full border border-slate-200">
                                     <span class="text-xs font-bold text-slate-600">{{ $t->pic->name }}</span>
                                </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-slate-500 italic">Belum ada tindakan yang ditambahkan.</p>
                        @endforelse
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 italic pl-2">Belum ada keputusan yang ditambahkan.</p>
                @endforelse
                </div>
            </div>
        @empty
            <div class="p-8 bg-white border-2 border-dashed border-slate-300 rounded-xl text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                <h3 class="mt-2 text-lg font-medium text-slate-800">Mulai Buat Notulen</h3>
                <p class="mt-1 text-sm text-slate-500">Klik tombol "Tambah Pokok Bahasan" untuk memulai.</p>
            </div>
        @endforelse
        </div>
    </main>
</div>

<div id="itemModal" class="modal fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center p-4 hidden opacity-0 z-50">
  <div class="modal-content bg-white w-full max-w-lg p-8 rounded-2xl shadow-2xl transform scale-95">
    <div class="flex items-center justify-between mb-6">
      <h3 id="modalTitle" class="text-2xl font-bold text-slate-800">Tambah Data</h3>
      <button id="closeModalBtn" class="text-slate-400 hover:text-slate-600 transition text-3xl leading-none">&times;</button>
    </div>

    <form id="modalForm" class="space-y-4">
      <input type="hidden" id="modalType" name="type">
      <input type="hidden" id="targetId" name="target_id">

      {{-- Input Field: Pokok Bahasan --}}
      <div id="fieldPokok" class="hidden">
        <label for="inputPokok" class="block text-sm font-medium text-slate-700 mb-1">Judul Pokok Bahasan</label>
        <input type="text" id="inputPokok" name="pokok_bahasan" class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-2 ring-custom-teal focus:border-custom-teal transition" placeholder="Contoh: Evaluasi Kinerja Q3">
      </div>

      {{-- Input Field: Keputusan --}}
      <div id="fieldKeputusan" class="hidden">
        <label for="inputKeputusan" class="block text-sm font-medium text-slate-700 mb-1">Isi Keputusan</label>
        <textarea id="inputKeputusan" name="isi_keputusan" rows="4" class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-2 ring-custom-teal focus:border-custom-teal transition" placeholder="Tuliskan hasil diskusi atau keputusan yang diambil..."></textarea>
      </div>

      {{-- Input Fields: Tindakan --}}
      <div id="fieldTindakan" class="hidden space-y-4">
        <div>
          <label for="inputTindakan" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Tindakan</label>
          <textarea id="inputTindakan" name="deskripsi_tindakan" rows="4" class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-2 ring-custom-teal focus:border-custom-teal transition" placeholder="Jelaskan langkah atau tindakan yang perlu dilakukan..."></textarea>
        </div>
        <div>
          <label for="selectPic" class="block text-sm font-medium text-slate-700 mb-1">Penanggung Jawab (PIC)</label>
          <select id="selectPic" name="pic_id" class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-2 ring-custom-teal focus:border-custom-teal transition">
            @foreach(App\Models\User::all() as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      {{-- Modal Action Buttons --}}
      <div class="mt-8 flex justify-end gap-3">
        <button type="button" id="cancelModalBtn" class="px-5 py-2 bg-slate-200 text-slate-800 rounded-lg hover:bg-slate-300 transition font-semibold">Batal</button>
        <button type="submit" class="px-5 py-2 bg-custom-teal text-white rounded-lg hover:bg-custom-teal-dark transition font-semibold">Simpan</button>
      </div>
    </form>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('itemModal');
  const modalTitle = document.getElementById('modalTitle');
  const modalType = document.getElementById('modalType');
  const targetId = document.getElementById('targetId');
  const fieldPokok = document.getElementById('fieldPokok');
  const fieldKeputusan = document.getElementById('fieldKeputusan');
  const fieldTindakan = document.getElementById('fieldTindakan');
  const inputPokok = document.getElementById('inputPokok');
  const inputKeputusan = document.getElementById('inputKeputusan');
  const inputTindakan = document.getElementById('inputTindakan');
  const selectPic = document.getElementById('selectPic');
  const modalForm = document.getElementById('modalForm');

  // Inisialisasi draftData dengan struktur yang benar - GUNAKAN isi_keputusan
  const draftData = {
    notulen_id: {{ $notulen->id ?? 'null' }},
    rapat_id: {{ $rapat->id }},
    pembuat_id: {{ auth()->id() }},
    pokok_bahasan: {!! $bahasan->isEmpty() ? '[]' : json_encode($bahasan->map(function($b) {
        return [
            'judul' => $b->judul,
            'keputusan' => $b->keputusans->map(function($k) {
                return [
                    'isi_keputusan' => $k->isi_keputusan, // KEY YANG BENAR
                    'tindakan' => $k->tindakans->map(function($t) {
                        return [
                            'deskripsi' => $t->deskripsi,
                            'pic_id' => $t->pic_id
                        ];
                    })->toArray()
                ];
            })->toArray()
        ];
    })) !!}
  };

  // Fungsi untuk debug draft data
  function debugDraft() {
    console.log("🔍 DEBUG DRAFT DATA:", draftData);
    
    if (draftData.pokok_bahasan) {
        console.log("Jumlah pokok bahasan:", draftData.pokok_bahasan.length);
        draftData.pokok_bahasan.forEach((pokok, index) => {
            console.log(`Pokok ${index}:`, pokok.judul);
            if (pokok.keputusan) {
                console.log(`  Jumlah keputusan:`, pokok.keputusan.length);
                pokok.keputusan.forEach((kep, kIndex) => {
                    console.log(`    Keputusan ${kIndex}:`, kep.isi_keputusan);
                });
            }
        });
    }
  }

  // Open modal
  document.querySelectorAll('.open-modal-btn').forEach(btn => {
    btn.addEventListener('click', e => {
      e.preventDefault();
      const title = btn.title;
      const id = btn.dataset.id || null;
      targetId.value = id;

      [fieldPokok, fieldKeputusan, fieldTindakan].forEach(el => el.classList.add('hidden'));

      if (title.includes('Pokok')) {
        modalType.value = 'pokok';
        fieldPokok.classList.remove('hidden');
        modalTitle.textContent = 'Tambah Pokok Bahasan';
      } else if (title.includes('Keputusan')) {
        modalType.value = 'keputusan';
        fieldKeputusan.classList.remove('hidden');
        modalTitle.textContent = 'Tambah Keputusan';
      } else if (title.includes('Tindakan')) {
        modalType.value = 'tindakan';
        fieldTindakan.classList.remove('hidden');
        modalTitle.textContent = 'Tambah Tindakan';
      }

      modal.classList.remove('hidden', 'opacity-0');
      modal.querySelector('.modal-content').classList.remove('scale-95');
      
      // Debug untuk memastikan data tersedia
      debugDraft();
    });
  });

  // Close modal
  function closeModal() {
    modal.querySelector('.modal-content').classList.add('scale-95');
    modal.classList.add('opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modalForm.reset();
    }, 300);
  }
  document.getElementById('closeModalBtn').onclick = closeModal;
  document.getElementById('cancelModalBtn').onclick = closeModal;
  modal.addEventListener('click', (e) => {
      if(e.target === modal) closeModal();
  });

  // Add to draft - GUNAKAN isi_keputusan BUKAN isi
  modalForm.addEventListener('submit', e => {
    e.preventDefault();
    const type = modalType.value;
    const id = targetId.value;

    console.log("🔍 Type:", type, "ID:", id, "Draft:", draftData);

    if (type === 'pokok') {
        // Tambah pokok bahasan baru
        if (!draftData.pokok_bahasan) {
            draftData.pokok_bahasan = [];
        }
        draftData.pokok_bahasan.push({ 
            judul: inputPokok.value, 
            keputusan: [] 
        });
        console.log("✅ Pokok bahasan ditambahkan:", inputPokok.value);
        
    } else if (type === 'keputusan') {
        // Tambah keputusan ke pokok bahasan tertentu - GUNAKAN isi_keputusan
        const index = parseInt(id);
        
        // Pastikan array pokok_bahasan ada dan index valid
        if (!draftData.pokok_bahasan || !draftData.pokok_bahasan[index]) {
            console.error("❌ Pokok bahasan tidak ditemukan:", index, draftData.pokok_bahasan);
            alert("Error: Pokok bahasan tidak ditemukan. Silakan refresh halaman.");
            return;
        }
        
        // Inisialisasi array keputusan jika belum ada
        if (!draftData.pokok_bahasan[index].keputusan) {
            draftData.pokok_bahasan[index].keputusan = [];
        }
        
        draftData.pokok_bahasan[index].keputusan.push({ 
            isi_keputusan: inputKeputusan.value, // INI YANG DIPERBAIKI
            tindakan: [] 
        });
        console.log("✅ Keputusan ditambahkan ke pokok", index, ":", inputKeputusan.value);
        
    } else if (type === 'tindakan') {
        // Tambah tindakan ke keputusan tertentu
        const [pIdx, kIdx] = id.split('-').map(Number);
        
        // Validasi struktur data
        if (!draftData.pokok_bahasan || 
            !draftData.pokok_bahasan[pIdx] || 
            !draftData.pokok_bahasan[pIdx].keputusan || 
            !draftData.pokok_bahasan[pIdx].keputusan[kIdx]) {
            console.error("❌ Keputusan tidak ditemukan:", pIdx, kIdx, draftData);
            alert("Error: Keputusan tidak ditemukan. Silakan refresh halaman.");
            return;
        }
        
        // Inisialisasi array tindakan jika belum ada
        if (!draftData.pokok_bahasan[pIdx].keputusan[kIdx].tindakan) {
            draftData.pokok_bahasan[pIdx].keputusan[kIdx].tindakan = [];
        }
        
        draftData.pokok_bahasan[pIdx].keputusan[kIdx].tindakan.push({ 
            deskripsi: inputTindakan.value, 
            pic_id: parseInt(selectPic.value) 
        });
        console.log("✅ Tindakan ditambahkan:", inputTindakan.value);
    }

    console.log("📦 Draft diperbarui:", draftData);
    closeModal();
  });
// Save notulen
const formNotulen = document.querySelector('#saveNotulenForm');
formNotulen.addEventListener('submit', async e => {
    e.preventDefault();
    
    // Validasi data sebelum dikirim
    let isValid = true;
    let errorMessage = '';
    
    draftData.pokok_bahasan.forEach((pokok, pIndex) => {
        if (pokok.keputusan) {
            pokok.keputusan.forEach((keputusan, kIndex) => {
                // Pastikan key isi_keputusan ada dan tidak kosong
                if (!keputusan.hasOwnProperty('isi_keputusan') || !keputusan.isi_keputusan || keputusan.isi_keputusan.trim() === '') {
                    isValid = false;
                    errorMessage = `Keputusan kosong ditemukan di pokok bahasan "${pokok.judul}"`;
                }
            });
        }
    });
    
    if (!isValid) {
        alert('⚠️ ' + errorMessage + '. Silakan lengkapi sebelum menyimpan.');
        return;
    }

    // Siapkan payload dengan SEMUA field yang diperlukan
    const payload = {
        notulen_id: draftData.notulen_id,
        rapat_id: draftData.rapat_id,
        pembuat_id: draftData.pembuat_id,
        judul: "{{ $rapat->agenda }}", // Ambil dari rapat agenda
        tanggal: "{{ $rapat->tanggal }}", // Ambil dari rapat tanggal
        pokok_bahasan: draftData.pokok_bahasan,
        _token: "{{ csrf_token() }}"
    };

    try {
        console.log("📤 Mengirim data:", payload);
        
        const response = await fetch("{{ route('notulen.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
            body: JSON.stringify(payload)
        });

        const result = await response.json();

        if (result.success) {
            alert(result.message);
            // Update notulen_id jika ada dari response
            if (result.notulen_id) {
                draftData.notulen_id = result.notulen_id;
            }
            window.location.reload(); 
        } else {
            alert("⚠️ " + result.message);
        }
    } catch (error) {
        console.error(error);
        alert("❌ Terjadi kesalahan saat menyimpan notulen.");
    }
});
});
</script>
@endsection