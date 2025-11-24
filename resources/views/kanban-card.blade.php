{{-- resources/views/global/partials/kanban-card.blade.php --}}
@php
    // PERBAIKAN: Menggunakan optional() untuk akses relasi berantai yang aman.
    $notulen = optional(optional($tindakan->keputusan)->pokokBahasan)->notulen;
    
    $isDone = $tindakan->status === 'done';
    $isOverdue = $tindakan->deadline && !$isDone && \Carbon\Carbon::parse($tindakan->deadline)->isPast();

    // Mapping status untuk badge warna
    $statusClasses = [
        'pending' => 'bg-red-100 text-red-800',
        'in_progress' => 'bg-blue-100 text-blue-800',
        'done' => 'bg-green-100 text-green-800',
    ];
    $statusLabels = [
        'pending' => 'Belum Selesai',
        'in_progress' => 'Sedang Dikerjakan',
        'done' => 'Selesai',
    ];

    $currentStatusCode = $tindakan->status ?? 'pending';
    $currentStatusClass = $statusClasses[$currentStatusCode] ?? 'bg-gray-100 text-gray-800';
    $currentStatusLabel = $statusLabels[$currentStatusCode] ?? 'Belum Selesai';
@endphp

<div class="kanban-card bg-white shadow-lg rounded-xl p-5 border-l-4 border-custom-teal {{ $isDone ? 'opacity-70' : '' }}" data-task-id="{{ $tindakan->id }}">
    <div class="space-y-4">
        
        {{-- Status Badge & ID Tugas --}}
        <div class="flex justify-between items-center">
            <span class="text-xs font-medium px-2.5 py-0.5 rounded-full {{ $currentStatusClass }}">
                {{ $currentStatusLabel }}
            </span>
            <span class="text-xs text-slate-400">#{{ $tindakan->id }}</span>
        </div>

        {{-- Deskripsi Tugas --}}
        <p class="font-bold text-lg text-slate-800 card-description {{ $isDone ? 'line-through text-slate-500' : '' }}">
            {{ $tindakan->deskripsi }}
        </p>

        {{-- Deadline & Peringatan --}}
        <div class="card-deadline flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            @if($tindakan->deadline)
                <span class="text-sm font-semibold {{ $isOverdue ? 'text-red-600' : 'text-slate-600' }}">
                    Batas Waktu: {{ \Carbon\Carbon::parse($tindakan->deadline)->translatedFormat('d M Y') }}
                </span>
                @if($isOverdue)
                    <span class="text-xs font-bold text-red-600 bg-red-50 rounded-full px-2 py-0.5 ml-1">TERLAMBAT</span>
                @endif
            @else
                <span class="text-sm text-slate-500 italic">Tidak ada batas waktu</span>
            @endif
        </div>

        <hr class="border-t border-slate-200">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3 pt-2">
            {{-- Link Notulen --}}
            <div class="flex-grow">
                @if($notulen)
                    <a href="{{ route('notulen.show', $notulen->id) }}" title="Lihat Notulen Asal"
                       class="text-sm font-bold text-custom-teal hover:text-custom-teal-dark transition flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                        Notulen Sumber
                    </a>
                @else
                    <span class="text-xs text-slate-500 italic">Tidak ada notulen terkait</span>
                @endif
            </div>

            {{-- Status Updater --}}
            <div class="w-full sm:w-auto">
                <select class="status-updater text-sm border-slate-300 rounded-lg focus:ring-custom-teal focus:border-custom-teal hover:border-slate-400" 
                        data-old-status="{{ $currentStatusLabel }}" {{ $isDone ? 'disabled' : '' }}>
                    <option value="Belum Selesai" {{ $tindakan->status == 'pending' ? 'selected' : '' }}>
                        🔴 Belum Selesai
                    </option>
                    <option value="Sedang Dikerjakan" {{ $tindakan->status == 'in_progress' ? 'selected' : '' }}>
                        🟡 Dikerjakan
                    </option>
                    <option value="Selesai" {{ $tindakan->status == 'done' ? 'selected' : '' }}>
                        🟢 Selesai
                    </option>
                </select>
            </div>
        </div>
    </div>
</div>