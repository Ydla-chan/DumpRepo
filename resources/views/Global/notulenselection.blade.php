@extends('layout.app')
@section('title', 'Pilih Rapat untuk Notulen')

@section('content')
<div class="space-y-12 p-6 md:p-8"> {{-- Tambahkan padding ke container utama --}}

    {{-- Bagian Pilih Rapat (Hanya Rapat yang Belum Memiliki Notulen) --}}
    <section>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 flex items-center justify-center bg-custom-teal-light rounded-full shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-800">Rapat selesai</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            {{-- Filter untuk hanya menampilkan Rapat yang notulennya BELUM ADA --}}
            @php
                $rapatBelumNotulen = $rapats->filter(fn($r) => $r->notulen === null);
            @endphp
            
            @forelse ($rapatBelumNotulen as $rapat)
                <div class="group bg-white rounded-xl shadow-lg transition-all duration-300 ease-in-out hover:shadow-2xl hover:-translate-y-1 border border-slate-200 hover:border-custom-teal relative overflow-hidden flex flex-col">
                    
                    {{-- Badge Status di Card - Dihapus karena semua adalah 'Belum Dibuat' --}}
                    
                    {{-- Header Kartu (Judul) --}}
                    <div class="p-4 border-b border-slate-100 bg-custom-teal-light/50">
                        <h3 class="text-lg font-bold text-slate-800 truncate">{{ $rapat->judul }}</h3>
                    </div>
                    
                    {{-- Konten Kartu --}}
                    <div class="p-4 flex flex-col justify-between flex-1">
                        <div class="space-y-3 text-sm">
                             {{-- Tanggal & Jam --}}
                            <p class="text-slate-600 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-custom-teal-text" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <span class="font-medium text-custom-teal-text">{{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('l, d F Y') }} ・ {{ \Carbon\Carbon::parse($rapat->jam)->format('H:i') }} WIB</span>
                            </p>

                            {{-- Lokasi / Link --}}
                            <p class="text-slate-600 flex items-start gap-2 pt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-custom-teal-text mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                @if($rapat->tipe_lokasi == 'offline')
                                    <span>Ruangan: <span class="font-semibold text-slate-800">{{ $rapat->ruangan ?? 'Tidak Ditentukan' }}</span></span>
                                @else
                                    <a href="{{ $rapat->link }}" target="_blank" class="text-blue-600 hover:underline break-all font-medium">
                                        Tautan Rapat Online
                                    </a>
                                @endif
                            </p>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="pt-5 mt-auto">
                            <a href="{{ route('notulen.create', ['rapat_id' => $rapat->id]) }}" 
                               class="inline-flex items-center justify-center w-full bg-custom-teal hover:bg-custom-teal-dark text-white text-base font-semibold px-4 py-2.5 rounded-lg transition-all duration-200 shadow-lg shadow-custom-teal/30 transform group-hover:scale-[1.02]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                                Buat Notulen 
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 lg:col-span-3 xl:col-span-4 text-center py-16 px-6 bg-slate-100 rounded-2xl border-4 border-dashed border-custom-teal/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-custom-teal/80 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2m-9 0V3h5V5m-5 0h5m-9 8l4 4 4-4" />
                    </svg>
                    <h3 class="font-bold text-xl text-slate-700">Tidak Ada Rapat Aktif</h3>
                    <p class="text-md text-slate-500 mt-2">Semua notulen untuk rapat terjadwal telah selesai dibuat. Saatnya cek kembali arsip Anda!</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Bagian Daftar Notulen (Arsip) --}}
    <section>
        <div class="flex items-center gap-3 mb-6 mt-12">
            <div class="w-10 h-10 flex items-center justify-center bg-custom-teal-light rounded-full shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-800">Arsip Notulensi</h2>
        </div>

        @if ($notulens->count() > 0)
            <div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-slate-200">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-xs tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4">Agenda Rapat</th>
                            <th class="px-6 py-4">Tanggal & Jam</th>
                            <th class="px-6 py-4">Lokasi</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($notulens as $notulen)
                            <tr class="hover:bg-custom-teal-light/50 transition-colors duration-200">
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $notulen->rapat->judul }}</td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ \Carbon\Carbon::parse($notulen->rapat->tanggal)->translatedFormat('d F Y') }}
                                    <span class="font-medium text-xs bg-slate-200 text-slate-700 px-1.5 py-0.5 rounded ml-2">{{ \Carbon\Carbon::parse($notulen->rapat->jam)->format('H:i') }} WIB</span>
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    @if ($notulen->rapat->tipe_lokasi == 'offline')
                                        <span class="font-medium text-slate-700">{{ $notulen->rapat->ruangan ?? '-' }}</span>
                                    @else
                                        <a href="{{ $notulen->rapat->link }}" target="_blank" class="text-blue-600 hover:underline font-medium">Tautan Online</a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('notulen.show', $notulen->id) }}" 
                                       class="bg-white hover:bg-slate-200 text-custom-teal-text px-4 py-2 rounded-lg text-sm font-bold transition-all duration-200 border border-slate-300 shadow-sm">
                                        Lihat Detail Notulen
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-16 px-6 bg-slate-100 rounded-2xl border-2 border-dashed border-slate-300">
                <p class="font-semibold text-slate-600">Arsip notulensi masih kosong.</p>
                <p class="text-sm text-slate-500 mt-1">Notulensi yang sudah Anda buat akan muncul di sini.</p>
            </div>
        @endif
    </section>
</div>
@endsection

<style>
    /* Tetap mempertahankan styling yang Anda berikan */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
    
    body {
        font-family: 'Inter', sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        background-color: #f8fafc;
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
    .text-custom-teal-text { color: var(--color-custom-teal-text); }
    .border-custom-teal { border-color: var(--color-custom-teal); }
</style>