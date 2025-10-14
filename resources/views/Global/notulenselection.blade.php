@extends('layout.app')
@section('title', 'Pilih Rapat untuk Notulen')

@section('content')
<div class="space-y-12">

    {{-- Bagian Pilih Rapat --}}
    <section>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 flex items-center justify-center bg-custom-teal-light rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Daftar Rapat Selesai</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($rapats as $rapat)
                <div class="group bg-white rounded-2xl shadow-md transition-all duration-300 ease-in-out hover:shadow-2xl hover:-translate-y-2 border-b-4 border-transparent hover:border-custom-teal">
                    {{-- Header Kartu dengan Status --}}
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800 truncate pr-4">{{ $rapat->agenda }}</h3>
                        @if ($rapat->notulen)
                            <span class="text-xs font-medium bg-emerald-100 text-emerald-800 px-2 py-1 rounded-full">Sudah Dibuat</span>
                        @else
                            <span class="text-xs font-medium bg-amber-100 text-amber-800 px-2 py-1 rounded-full">Belum Dibuat</span>
                        @endif
                    </div>
                    
                    {{-- Konten Kartu --}}
                    <div class="p-5">
                        <div class="space-y-3 text-sm">
                             {{-- Tanggal & Jam --}}
                            <p class="text-slate-600 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <span>{{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('l, d F Y') }} ・ {{ \Carbon\Carbon::parse($rapat->jam)->format('H:i') }} WIB</span>
                            </p>

                            {{-- Lokasi / Link --}}
                            <p class="text-slate-600 flex items-start gap-2 pt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                @if($rapat->tipe_lokasi == 'offline')
                                    <span>Ruangan: <span class="font-semibold text-slate-800">{{ $rapat->ruangan ?? '-' }}</span></span>
                                @else
                                    <a href="{{ $rapat->link }}" target="_blank" class="text-blue-600 hover:underline break-all">
                                        Tautan Rapat Online
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="p-5 mt-auto bg-slate-50/70 rounded-b-2xl">
                        @if ($rapat->notulen)
                            <a href="{{ route('notulen.show', $rapat->notulen->id) }}" 
                               class="inline-flex items-center justify-center w-full bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                Lihat Notulen
                            </a>
                        @else
                            <a href="{{ route('notulen.create', ['rapat_id' => $rapat->id]) }}" 
                               class="inline-flex items-center justify-center w-full bg-custom-teal hover:bg-custom-teal-dark text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                                Buat Notulen
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 lg:col-span-3 text-center py-16 px-6 bg-slate-50 rounded-2xl border-2 border-dashed">
                    <p class="font-semibold text-slate-600">Tidak ada jadwal rapat yang perlu dibuatkan notulen.</p>
                    <p class="text-sm text-slate-500 mt-1">Semua rapat yang telah selesai akan muncul di sini.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Bagian Daftar Notulen --}}
    <section>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 flex items-center justify-center bg-custom-teal-light rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-custom-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Arsip Notulensi</h2>
        </div>

        @if ($notulens->count() > 0)
            <div class="overflow-x-auto bg-white rounded-2xl shadow-md border border-slate-200">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-slate-100 text-slate-600 font-semibold uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Agenda Rapat</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Lokasi</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($notulens as $notulen)
                            <tr class="hover:bg-custom-teal-light/50 transition-colors duration-200">
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $notulen->rapat->agenda }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($notulen->rapat->tanggal)->translatedFormat('d F Y') }}</td>
                                <td class="px-6 py-4 text-slate-600">
                                    @if ($notulen->rapat->tipe_lokasi == 'offline')
                                        {{ $notulen->rapat->ruangan ?? '-' }}
                                    @else
                                        <a href="{{ $notulen->rapat->link }}" target="_blank" class="text-blue-600 hover:underline">Tautan Online</a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('notulen.show', $notulen->id) }}" 
                                       class="bg-white hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-xs font-semibold transition-all duration-200 border border-slate-300">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-16 px-6 bg-slate-50 rounded-2xl border-2 border-dashed">
                <p class="font-semibold text-slate-600">Arsip notulensi masih kosong.</p>
                <p class="text-sm text-slate-500 mt-1">Notulensi yang sudah Anda buat akan muncul di sini.</p>
            </div>
        @endif
    </section>
</div>
@endsection

<style>
    /* Menggunakan font Inter dari Google Fonts untuk tampilan yang lebih modern */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
    
    body {
        font-family: 'Inter', sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        background-color: #f8fafc; /* Sedikit abu-abu untuk background body */
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