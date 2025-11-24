{{-- resources/views/logbooks/index.blade.php --}}
@extends('layout.app')

@push('styles')
<style>
    /* Styling kustom jika diperlukan, contoh warna teal */
    :root {
        --color-custom-teal: #4C8C86;
        --color-custom-teal-dark: #3D6F6A;
    }
    .bg-custom-teal-light { background-color: #eef7f6; }
    .text-custom-teal { color: var(--color-custom-teal); }
    .hover\:bg-custom-teal-dark:hover { background-color: var(--color-custom-teal-dark); }
</style>
@endpush

@section('content')
<main class="flex-1 p-6 md:p-8 overflow-y-auto">
    
    <header class="flex justify-between items-center mb-8 pb-4 border-b border-slate-200">
        <h1 class="text-3xl font-extrabold text-slate-900 flex items-center gap-3">
            <svg class="w-8 h-8 text-custom-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Jurnal Kegiatan (Logbook)
        </h1>
        <a href=" class="bg-custom-teal text-white font-bold py-2 px-4 rounded-lg shadow-md hover:bg-custom-teal-dark transition duration-150">
            + Catat Kegiatan Baru
        </a>
    </header>

    {{-- Pesan Success (Placeholder) --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @php
        // DATA DUMMY UNTUK DEMONSTRASI TAMPILAN
        $logbooksDummy = [
            (object)['id' => 1, 'tanggal_kegiatan' => '2025-11-17', 'judul_kegiatan' => 'Review Laporan Bulanan Q4', 'tindakan_terkait' => 'Revisi bab 3 dan data keuangan.', 'durasi_jam' => 4.5, 'status' => 'completed'],
            (object)['id' => 2, 'tanggal_kegiatan' => '2025-11-17', 'judul_kegiatan' => 'Riset Kebutuhan User Interface V2', 'tindakan_terkait' => 'Membuat wireframe dan flow user baru.', 'durasi_jam' => 2.0, 'status' => 'on_progress'],
            (object)['id' => 3, 'tanggal_kegiatan' => '2025-11-16', 'judul_kegiatan' => 'Meeting Harian Tim (Daily Scrum)', 'tindakan_terkait' => 'Tidak ada tugas spesifik, kegiatan rutin.', 'durasi_jam' => 0.5, 'status' => 'completed'],
            (object)['id' => 4, 'tanggal_kegiatan' => '2025-11-16', 'judul_kegiatan' => 'Debugging API Endpoint Rapat', 'tindakan_terkait' => 'Perbaikan bug pada endpoint /api/rapat/list.', 'durasi_jam' => 3.75, 'status' => 'on_progress'],
            (object)['id' => 5, 'tanggal_kegiatan' => '2025-11-15', 'judul_kegiatan' => 'Setup Environment Lokal Baru', 'tindakan_terkait' => 'Instalasi Docker dan dependensi proyek.', 'durasi_jam' => 1.5, 'status' => 'new'],
        ];
    @endphp

    {{-- Kontainer Tabel Logbook --}}
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-custom-teal-light">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-custom-teal uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-custom-teal uppercase tracking-wider">Kegiatan Utama</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-custom-teal uppercase tracking-wider">Tugas Terkait</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-custom-teal uppercase tracking-wider">Durasi (Jam)</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-custom-teal uppercase tracking-wider">Status</th>
                        <th class="relative px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    
                    {{-- Loop Menggunakan Data Dummy --}}
                    @forelse ($logbooksDummy as $logbook) 
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                {{ \Carbon\Carbon::parse($logbook->tanggal_kegiatan)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-normal text-sm text-slate-600 font-semibold max-w-sm">
                                {{ $logbook->judul_kegiatan }}
                            </td>
                            <td class="px-6 py-4 whitespace-normal text-xs text-slate-500 italic max-w-xs">
                                {{ $logbook->tindakan_terkait }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{ number_format($logbook->durasi_jam, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClass = [
                                        'completed' => 'bg-green-100 text-green-800',
                                        'on_progress' => 'bg-blue-100 text-blue-800',
                                        'new' => 'bg-yellow-100 text-yellow-800',
                                    ][$logbook->status] ?? 'bg-slate-100 text-slate-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $logbook->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                {{-- Placeholder Aksi --}}
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <button type="button" class="text-red-600 hover:text-red-900" onclick="alert('Hapus Logbook ID: {{ $logbook->id }}')">Hapus</button>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-sm text-slate-500 bg-slate-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2-2H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-2 text-md font-medium text-slate-700">Tidak ada kegiatan yang tercatat</p>
                            <p class="text-slate-500">Mulai catat kegiatan Anda hari ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination (Placeholder) --}}
    <div class="mt-6 text-center">
        <p class="text-slate-500 text-sm italic">Menampilkan 5 dari 5 total kegiatan (Placeholder Pagination)</p>
    </div>
</main>
@endsection