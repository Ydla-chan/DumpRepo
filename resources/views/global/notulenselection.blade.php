@extends('layout.app')
@section('title', 'Kelola Notulensi')

@section('content')


    {{-- HEADER HALAMAN --}}
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-[#1e293b] tracking-tight">Kelola Notulensi</h1>
        <p class="text-slate-500 mt-2 text-base">Buat notulen baru untuk rapat yang telah selesai atau tinjau arsip lama.</p>
    </div>

    {{-- BAGIAN 1: MENUNGGU NOTULENSI --}}
    <section class="mb-12">
        {{-- Header Section dengan Garis Vertikal Teal --}}
        <div class="flex items-center gap-3 mb-6 border-l-4 border-[#3a7e78] pl-3 py-1">
            <h2 class="text-xl font-bold text-slate-800">Menunggu Notulensi</h2>
            <span class="px-3 py-1 rounded-full bg-[#FFF7E6] text-[#B45309] text-xs font-bold border border-[#FDE68A]">
                Perlu Tindakan
            </span>
        </div>

        @php
            // Filter logic (sesuaikan dengan controller Anda)
            $rapatBelumNotulen = $rapats->filter(fn($r) => $r->notulen === null);
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($rapatBelumNotulen as $rapat)
                {{-- CARD MENUNGGU NOTULENSI --}}
                <div class="group bg-white rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.05)] hover:shadow-lg transition-all duration-300 relative overflow-hidden flex flex-col border border-slate-100">
                    
                    {{-- Strip Hijau di Kiri (Persis Gambar) --}}
                    <div class="absolute left-0 top-0 bottom-0 w-[6px] bg-[#4C8C86]"></div>

                    <div class="p-6 flex-1 flex flex-col pl-7"> 
                        
                        {{-- Judul Rapat --}}
                        <h3 class="font-bold text-lg text-[#334155] mb-4 group-hover:text-[#4C8C86] transition-colors">
                            {{ $rapat->judul }}
                        </h3>

                        {{-- List Info (Icon + Text) --}}
                        <div class="space-y-3 mb-6">
                            {{-- Tanggal --}}
                            <div class="flex items-center gap-3 text-sm text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4C8C86]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('d M Y') }}</span>
                            </div>

                            {{-- Jam --}}
                            <div class="flex items-center gap-3 text-sm text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4C8C86]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Pukul {{ \Carbon\Carbon::parse($rapat->jam)->format('H:i') }} WIB</span>
                            </div>

                            {{-- Lokasi --}}
                            <div class="flex items-center gap-3 text-sm text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4C8C86]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $rapat->tipe_lokasi == 'offline' ? ($rapat->ruangan ?? '-') : 'Online Meeting' }}</span>
                            </div>
                        </div>

                        {{-- Tombol Action Hijau Full --}}
                        <div class="mt-auto">
                            <a href="{{ route('notulen.create', ['rapat_id' => $rapat->id]) }}" 
                               class="flex items-center justify-center w-full gap-2 bg-[#4C8C86] hover:bg-[#3d7570] text-white py-2.5 rounded-lg text-sm font-bold transition-all shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Buat Notulen
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-10 text-center bg-slate-50 rounded-lg border border-dashed border-slate-300">
                    <p class="text-slate-500">Tidak ada rapat yang menunggu notulensi.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- BAGIAN 2: ARSIP NOTULENSI --}}
    <section>
        {{-- Header Section dengan Garis Vertikal Abu --}}
        <div class="flex items-center justify-between mb-6 border-l-4 border-slate-400 pl-3 py-1">
            <h2 class="text-xl font-bold text-slate-800">Arsip Notulensi</h2>
            
            @if ($notulens->count() > 0)
            <div class="text-sm text-slate-500">
                Total Arsip: <span class="font-bold text-slate-800">{{ $notulens->count() }}</span>
            </div>
            @endif
        </div>

        @if ($notulens->count() > 0)
            
            {{-- 
                Desktop View: TABEL (Persis Gambar) 
                Menggunakan hidden md:block agar hanya muncul di tablet/desktop
            --}}
            <div class="hidden md:block bg-white rounded-lg border border-slate-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#FAFAFA] border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                            <th class="px-6 py-4">Agenda Rapat</th>
                            <th class="px-6 py-4">Waktu Pelaksanaan</th>
                            <th class="px-6 py-4">Tempat / Media</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($notulens as $notulen)
                            <tr class="hover:bg-slate-50 transition-colors">
                                {{-- Kolom Agenda --}}
                                <td class="px-6 py-5">
                                    <div class="font-bold text-slate-900 text-sm">{{ $notulen->rapat->judul }}</div>
                                    <div class="text-xs text-slate-400 mt-1 truncate max-w-[250px]">
                                        {{ Str::limit($notulen->rapat->catatan ?? 'Tidak ada catatan tambahan', 60) }}
                                    </div>
                                </td>
                                
                                {{-- Kolom Waktu --}}
                                <td class="px-6 py-5">
                                    <div class="font-bold text-slate-700 text-sm">
                                        {{ \Carbon\Carbon::parse($notulen->rapat->tanggal)->translatedFormat('d F Y') }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1">
                                        {{ \Carbon\Carbon::parse($notulen->rapat->jam)->format('H:i') }} WIB
                                    </div>
                                </td>

                                {{-- Kolom Tempat (Link Style) --}}
                                <td class="px-6 py-5">
                                    @if ($notulen->rapat->tipe_lokasi == 'offline')
                                        <span class="text-sm text-slate-600">{{ $notulen->rapat->ruangan ?? '-' }}</span>
                                    @else
                                        <a href="{{ $notulen->rapat->link }}" target="_blank" class="text-sm font-medium text-[#4C8C86] hover:text-[#386b66] inline-flex items-center gap-1 group">
                                            Online
                                            {{-- Icon Panah Miring (External Link) --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    @endif
                                </td>

                                {{-- Kolom Aksi (Tombol Detail) --}}
                                <td class="px-6 py-5 text-right">
                                    <a href="{{ route('notulen.show', $notulen->id) }}" 
                                       class="inline-flex items-center gap-1 px-4 py-1.5 bg-white border border-slate-300 rounded text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                        Detail
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- 
                Mobile View: CARD LIST (Improvement) 
                Hanya muncul di HP (md:hidden)
            --}}
            <div class="md:hidden space-y-4">
                @foreach ($notulens as $notulen)
                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col gap-4">
                        {{-- Header Card --}}
                        <div class="flex justify-between items-start gap-3">
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm line-clamp-2">{{ $notulen->rapat->judul }}</h4>
                                <div class="text-xs text-slate-500 mt-1">
                                    {{ \Carbon\Carbon::parse($notulen->rapat->tanggal)->translatedFormat('d F Y') }} • {{ \Carbon\Carbon::parse($notulen->rapat->jam)->format('H:i') }}
                                </div>
                            </div>
                            {{-- Badge Status / Link --}}
                            @if ($notulen->rapat->tipe_lokasi == 'online')
                                <span class="shrink-0 px-2 py-1 bg-green-50 text-[#4C8C86] text-[10px] font-bold rounded uppercase tracking-wider">Online</span>
                            @else
                                <span class="shrink-0 px-2 py-1 bg-slate-100 text-slate-500 text-[10px] font-bold rounded uppercase tracking-wider">Offline</span>
                            @endif
                        </div>

                        {{-- Footer Card (Action) --}}
                        <div class="border-t border-slate-100 pt-3 flex items-center justify-between mt-auto">
                            <span class="text-xs text-slate-400 truncate max-w-[150px]">
                                {{ $notulen->rapat->catatan ?? '-' }}
                            </span>
                            <a href="{{ route('notulen.show', $notulen->id) }}" class="text-xs font-bold text-slate-700 hover:text-[#4C8C86] flex items-center gap-1">
                                Lihat Detail
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if(method_exists($notulens, 'links'))
                <div class="mt-6">
                    {{ $notulens->links() }}
                </div>
            @endif

        @else
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-16 bg-white rounded-lg border border-slate-200">
                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-700">Belum Ada Arsip</h3>
            </div>
        @endif
    </section>
</div>
@endsection