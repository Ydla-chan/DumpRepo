@extends('layout.app')
@section('title', 'Pilih Rapat untuk Notulen')

@section('content')
<div class="space-y-10">
    {{-- Bagian Pilih Rapat --}}
    <section class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-2xl font-semibold text-slate-800 mb-6">📅 Pilih Rapat untuk Dibuatkan Notulen</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($rapats as $rapat)
                <div class="border border-slate-200 p-5 rounded-2xl hover:shadow-lg transition duration-200 bg-gradient-to-b from-white to-slate-50">
                    <div class="space-y-2">
                        <h3 class="text-lg font-bold text-slate-800">{{ $rapat->agenda }}</h3>
                        
                        {{-- Tanggal --}}
                        <p class="text-sm text-slate-600 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 8h12v8H4V8z" clip-rule="evenodd"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('l, d F Y') }}
                        </p>

                        {{-- Jam --}}
                        <p class="text-sm text-slate-600 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.414L11 10.586V6z" clip-rule="evenodd"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($rapat->jam)->format('H:i') }} WIB
                        </p>

                        {{-- Lokasi / Link --}}
                        <p class="text-sm text-slate-600">
                            @if($rapat->tipe_lokasi == 'offline')
                                🏢 Ruangan: <span class="font-medium">{{ $rapat->ruangan ?? '-' }}</span>
                            @else
                                🌐 Link: 
                                <a href="{{ $rapat->link }}" target="_blank" class="text-blue-600 underline break-words">
                                    {{ $rapat->link }}
                                </a>
                            @endif
                        </p>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="mt-4">
                        @if ($rapat->notulen)
                            <a href="{{ route('notulen.show', $rapat->notulen->id) }}" 
                               class="inline-flex items-center justify-center w-full bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                                📝 Lihat Notulen
                            </a>
                        @else
                            <a href="{{ route('notulen.create', ['rapat_id' => $rapat->id]) }}" 
                               class="inline-flex items-center justify-center w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                                ➕ Buat Notulen
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Bagian Daftar Notulen --}}
    <section class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-2xl font-semibold text-slate-800 mb-6">🗂️ Notulen yang Sudah Dibuat</h2>

        @if ($notulens->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border border-slate-200 rounded-lg overflow-hidden">
                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th class="px-4 py-2">Agenda</th>
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Tempat</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notulens as $notulen)
                            <tr class="border-t hover:bg-slate-50">
                                <td class="px-4 py-2">{{ $notulen->rapat->agenda }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($notulen->rapat->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="px-4 py-2">
                                    @if ($notulen->rapat->tipe_lokasi == 'offline')
                                        {{ $notulen->rapat->ruangan ?? '-' }}
                                    @else
                                        <a href="{{ $notulen->rapat->link }}" class="text-blue-600 underline">Link Online</a>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('notulen.show', $notulen->id) }}" 
                                       class="bg-custom-teal hover:bg-teal-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-6 text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="font-medium">Belum ada notulensi yang dibuat.</p>
            </div>
        @endif
    </section>
</div>
@endsection
