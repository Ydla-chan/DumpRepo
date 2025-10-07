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
    
    {{-- Sidebar Detail Rapat --}}
    <aside class="w-full md:w-1/3 lg:w-1/4 bg-white p-6 border-b md:border-b-0 md:border-r border-slate-200 overflow-y-auto custom-scrollbar">
        <h2 class="text-lg font-bold text-slate-900 pb-3 border-b border-slate-200">Detail Rapat</h2>
        <div class="mt-4 space-y-4 text-sm">
            <h3 class="text-xl font-bold text-slate-800">{{ $rapat->agenda }}</h3>

            {{-- Tanggal --}}
            <div class="flex items-start gap-3 text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <span>{{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('l, d F Y') }}</span>
            </div>

            {{-- Waktu --}}
            <div class="flex items-start gap-3 text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.414L11 10.586V6z" clip-rule="evenodd" />
                </svg>
                <span>{{ \Carbon\Carbon::parse($rapat->jam)->format('H:i') }} WIB</span>
            </div>

            {{-- Lokasi --}}
            <div class="flex items-start gap-3 text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
                <span>
                    @if($rapat->tipe_lokasi == 'offline')
                        {{ $rapat->ruangan ?? '-' }}
                    @else
                        <a href="{{ $rapat->link }}" target="_blank" class="text-blue-600 underline">{{ $rapat->link }}</a>
                    @endif
                </span>
            </div>
        </div>


 <div class="mt-8 pt-6 border-t border-slate-200 space-y-3"> <button class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-custom-teal text-white rounded-lg shadow-md hover:bg-custom-teal-dark transition-all duration-300 transform hover:scale-105"> <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /> </svg> <span>Export ke PDF</span> </button> {{-- Tombol Simpan Notulen --}} <form action="{{ route('notulen.store') }}" method="POST"> @csrf <input type="hidden" name="rapat_id" value="{{ $rapat->id }}"> <input type="hidden" name="judul" value="{{ $rapat->agenda }}"> <input type="hidden" name="tanggal" value="{{ $rapat->tanggal }}"> <input type="hidden" name="pembuat_id" value="{{ auth()->id() }}"> <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg shadow-md hover:bg-emerald-700 transition-all duration-300 transform hover:scale-105"> <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /> </svg> <span>Simpan Notulen</span> </button> </form> </div>
    </aside>

    {{-- Konten Utama: Pokok Bahasan, Keputusan, Tindakan --}}
    <main class="flex-1 p-4 md:p-6 overflow-y-auto custom-scrollbar">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl md:text-2xl font-bold text-slate-900">Agenda & Hasil Rapat</h2>
            <button class="open-modal-btn flex items-center justify-center p-2.5 md:px-4 md:py-2 bg-custom-teal text-white rounded-full md:rounded-lg shadow-md hover:bg-custom-teal-dark transition-all duration-300" title="Tambah Pokok Bahasan">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span class="hidden md:inline ml-2 font-semibold text-sm">Pokok Bahasan</span>
            </button>
        </div>

        <div class="space-y-6">
            @forelse($bahasan as $b)
                <div class="bg-white p-4 md:p-5 rounded-xl shadow-md border border-slate-200">
                    <div class="flex justify-between items-start gap-4 pb-4 border-b border-slate-200">
                        <h3 class="text-base md:text-lg font-bold text-slate-800 pt-1">{{ $b->judul }}</h3>
                        <div class="flex items-center gap-2 shrink-0">
                            <button class="open-modal-btn p-1.5 text-slate-500 hover:text-custom-teal hover:bg-slate-100 rounded-md transition" title="Edit Pokok Bahasan">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            
                    blade
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl md:text-2xl font-bold text-slate-900">Agenda & Hasil Rapat</h2>
    <div class="flex gap-3">
        {{-- Tombol Simpan Notulen --}}
        <form action="{{ route('notulen.store') }}" method="POST">
            @csrf
            <input type="hidden" name="rapat_id" value="{{ $rapat->id }}">
            <input type="hidden" name="judul" value="{{ $rapat->agenda }}">
            <input type="hidden" name="tanggal" value="{{ $rapat->tanggal }}">
            <input type="hidden" name="pembuat_id" value="{{ auth()->id() }}">
            <button type="submit" class="flex items-center justify-center px-4 py-2 bg-emerald-600 text-white rounded-lg shadow-md hover:bg-emerald-700 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Simpan Notulen
            </button>
        </form>

        {{-- Tombol Tambah Pokok Bahasan --}}
        <button class="open-modal-btn flex items-center justify-center p-2.5 md:px-4 md:py-2 bg-custom-teal text-white rounded-full md:rounded-lg shadow-md hover:bg-custom-teal-dark transition-all duration-300" title="Tambah Pokok Bahasan">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span class="hidden md:inline ml-2 font-semibold text-sm">Pokok Bahasan</span>
        </button>
    </div>
</div>



                    <div class="mt-4 space-y-4">
                        @forelse($b->keputusan as $k)
                            <div class="pl-3 md:pl-4 border-l-4 border-custom-teal">
                                <div class="flex justify-between items-start gap-3">
                                    <p class="font-semibold text-slate-700 text-sm md:text-base pt-1">{{ $k->isi }}</p>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <button class="open-modal-btn p-1.5 text-slate-500 hover:text-custom-teal hover:bg-slate-100 rounded-md transition" title="Edit Keputusan">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button class="open-modal-btn flex items-center p-1.5 md:px-3 md:py-1 bg-custom-teal-light text-custom-teal-dark hover:bg-custom-teal-lighter rounded-full md:rounded-md transition" title="Tambah Tindakan">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            <span class="hidden md:inline ml-1 text-xs font-semibold">Tambah Tindakan</span>
                                        </button>
                                    </div>
                                </div>

                                {{-- Tindakan --}}
                                <div class="mt-3 space-y-2">
                                    @forelse($k->tindakan as $t)
                                        <div class="flex items-center justify-between gap-3 p-2.5 bg-slate-50 rounded-lg border border-slate-200">
                                            <p class="text-sm text-slate-600">{{ $t->deskripsi }}</p>
                                            <div class="flex items-center gap-2 shrink-0">
                                                <img src="https://i.pravatar.cc/150?u={{ urlencode($t->pic) }}" alt="{{ $t->pic }}" class="w-7 h-7 rounded-full object-cover ring-2 ring-white" title="PIC: {{ $t->pic }}">
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-sm text-slate-500 italic pl-2">Belum ada tindakan.</p>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500 italic pl-2">Belum ada keputusan untuk bahasan ini.</p>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="p-6 bg-slate-50 border border-slate-200 rounded-xl text-center text-slate-500 italic">
                    Belum ada pokok bahasan yang ditambahkan.
                </div>
            @endforelse
        </div>
    </main>
</div>
<!-- Modal Dinamis -->
<div id="itemModal" class="modal fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center p-4 hidden opacity-0">
  <div class="modal-content bg-white w-full max-w-md p-6 rounded-2xl shadow-2xl transform scale-95">
    <div class="flex items-center justify-between mb-4">
      <h3 id="modalTitle" class="text-xl font-bold text-slate-800">Tambah Data</h3>
      <button id="closeModalBtn" class="text-slate-400 hover:text-slate-600 transition text-2xl">&times;</button>
    </div>

    <form id="modalForm">
      <input type="hidden" id="modalType" name="type">
      <input type="hidden" id="targetId" name="target_id">

      <!-- Input Judul Pokok Bahasan -->
      <div id="fieldPokok" class="hidden space-y-2">
        <label class="block text-sm font-medium text-slate-600">Judul Pokok Bahasan</label>
        <input type="text" id="inputPokok" name="judul" class="w-full p-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-custom-teal focus:border-custom-teal transition" placeholder="Masukkan pokok bahasan...">
      </div>

      <!-- Input Isi Keputusan -->
      <div id="fieldKeputusan" class="hidden space-y-2">
        <label class="block text-sm font-medium text-slate-600">Isi Keputusan</label>
        <textarea id="inputKeputusan" name="isi_keputusan" rows="4" class="w-full p-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-custom-teal focus:border-custom-teal transition" placeholder="Masukkan isi keputusan..."></textarea>
      </div>

      <!-- Input Deskripsi & PIC Tindakan -->
      <div id="fieldTindakan" class="hidden space-y-4">
        <div>
          <label class="block text-sm font-medium text-slate-600">Deskripsi Tindakan</label>
          <textarea id="inputTindakan" name="deskripsi" rows="4" class="w-full p-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-custom-teal focus:border-custom-teal transition" placeholder="Masukkan deskripsi tindakan..."></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-600">Penanggung Jawab (PIC)</label>
          <select id="selectPic" name="pic_id" class="w-full p-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-custom-teal focus:border-custom-teal transition">
            @foreach(App\Models\User::all() as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
          </select>
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
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('itemModal');
  const modalTitle = document.getElementById('modalTitle');
  const modalType = document.getElementById('modalType');
  const targetId = document.getElementById('targetId');
  const notulenId = {{ $notulen->id ?? 'null' }};

  const fieldPokok = document.getElementById('fieldPokok');
  const fieldKeputusan = document.getElementById('fieldKeputusan');
  const fieldTindakan = document.getElementById('fieldTindakan');

  const inputPokok = document.getElementById('inputPokok');
  const inputKeputusan = document.getElementById('inputKeputusan');
  const inputTindakan = document.getElementById('inputTindakan');
  const selectPic = document.getElementById('selectPic');

  const modalForm = document.getElementById('modalForm');

  // Tombol pembuka modal
  document.querySelectorAll('.open-modal-btn').forEach(btn => {
    btn.addEventListener('click', e => {
      e.preventDefault();
      const title = btn.title;
      const id = btn.dataset.id || null;
      targetId.value = id;

      // Reset form dan sembunyikan semua field
      [fieldPokok, fieldKeputusan, fieldTindakan].forEach(el => el.classList.add('hidden'));

      // Tentukan mode modal
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

      // Tampilkan modal
      modal.classList.remove('hidden', 'opacity-0');
      modal.querySelector('.modal-content').classList.remove('scale-95');
    });
  });

  // Tutup modal
  document.getElementById('closeModalBtn').onclick = closeModal;
  document.getElementById('cancelModalBtn').onclick = closeModal;
  function closeModal() {
    modal.querySelector('.modal-content').classList.add('scale-95');
    modal.classList.add('opacity-0');
    setTimeout(() => modal.classList.add('hidden'), 300);
  }
  modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
  document.addEventListener('keydown', e => { if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal(); });

  // Submit modal form
  modalForm.addEventListener('submit', async e => {
    e.preventDefault();
    const type = modalType.value;
    const id = targetId.value;
    let url = '';
    let payload = {};

    if (type === 'pokok') {
      url = `/notulen/${notulenId}/pokok`;
      payload = { judul: inputPokok.value };
    } else if (type === 'keputusan') {
      url = `/notulen/pokok/${id}/keputusan`;
      payload = { isi_keputusan: inputKeputusan.value };
    } else if (type === 'tindakan') {
      url = `/notulen/keputusan/${id}/tindakan`;
      payload = { deskripsi: inputTindakan.value, pic_id: selectPic.value };
    }

    try {
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
      });

      if (response.ok) {
        location.reload();
      } else {
        const err = await response.json();
        alert('Gagal menyimpan: ' + (err.message || JSON.stringify(err.errors)));
      }
    } catch (err) {
      console.error(err);
      alert('Terjadi kesalahan koneksi ke server.');
    }
  });
});
</script>


</body>
@endsection
