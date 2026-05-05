{{-- resources/views/global/my-backlog-kanban.blade.php --}}
@extends('layout.app')

@push('styles')
<style>
    /* 🎨 Styling dasar untuk Kanban Column */
    .kanban-column {
        background-color: #f8fafc; /* slate-50 */
        border-radius: 0.75rem;
        padding: 1rem;
        height: 100%;
        min-height: 200px;
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
    }
    
    .kanban-column-header {
        flex-shrink: 0;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
    }
    
    .task-list-container {
        flex-grow: 1;
        overflow-y: auto;
        padding-right: 0.5rem;
        margin-right: -0.5rem;
    }
    
    /* Warna untuk border header kolom */
    .header-belum-selesai { border-color: #fca5a5; }
    .header-sedang-dikerjakan { border-color: #60a5fa; }
    /* BARU: Kolom Selesai di-style di sini */
    .header-selesai { border-color: #34d399; }
    
    /* Custom Scrollbar Styling (Webkit only) */
    .custom-scrollbar::-webkit-scrollbar,
    .task-list-container::-webkit-scrollbar {
        width: 8px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb,
    .task-list-container::-webkit-scrollbar-thumb {
        background-color: #cbd5e1; /* slate-300 */
        border-radius: 4px;
    }

    /* 🆕 Styling untuk konten yang di-toggle */
    .swimlane-content {
        max-height: 2000px; /* Nilai besar agar transisi terlihat */
        overflow: hidden;
        transition: max-height 0.5s ease-in-out, opacity 0.5s ease-in-out;
    }
    .swimlane-content.collapsed {
        max-height: 0;
        opacity: 0;
        padding-top: 0; /* Hapus padding agar lebih rapat saat tertutup */
    }
    .rotate-icon {
        transition: transform 0.3s ease;
    }
    /* Mengubah: Jika swimlane-card yang collapsed, putar icon */
    .swimlane-card.collapsed .rotate-icon { 
        transform: rotate(-90deg);
    }
    /* Mengatur style teal untuk variabel kustom */
    :root {
        --color-custom-teal: #4C8C86;
        --color-custom-teal-dark: #3D6F6A;
        --color-custom-teal-light: #eef7f6;
        --color-custom-teal-text: #376661;
    }
    .text-custom-teal { color: var(--color-custom-teal); }
    .bg-custom-teal { background-color: var(--color-custom-teal); }
</style>
@endpush

@section('content')
<main class="flex-1 p-6 md:p-8 overflow-y-auto custom-scrollbar">
    <header class="mb-8">
        <h1 class="text-xl font-extrabold text-slate-900 flex items-center gap-3">
            <svg class="w-8 h-8 text-custom-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-8v8m-4-8v8m9-5a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Kanban Backlog 
        </h1>
        <p class="text-slate-500 mt-1">Tugas yang ditugaskan berdasarkan sumber rapat.</p>
    </header>

    {{-- Cek apakah ada tugas yang BELUM Selesai di semua grup --}}
    @php
        $totalActiveTasksCount = 0;
        foreach ($groupedTasks as $tasks) {
            if ($tasks->contains(function ($t) {
                return $t->status !== 'done';
            })) {
                $totalActiveTasksCount++;
            }
        }
        $hasActiveTasks = $totalActiveTasksCount > 0;
    @endphp

    @if(!$groupedTasks->count() || !$hasActiveTasks && $groupedTasks->count() > 0)
        {{-- Empty State Global (jika semua tugas sudah done / atau tidak ada tugas sama sekali) --}}
        <div class="p-12 bg-white border-4 border-dashed border-custom-teal/30 rounded-xl text-center mt-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-custom-teal/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-4 text-xl font-medium text-slate-800">
                🎉 Semua Beres!
            </h3>
            <p class="mt-2 text-md text-slate-500">Anda tidak memiliki tugas (tindakan) yang sedang aktif atau tertunda.</p>
        </div>
        <br>
    @endif

    {{-- Container untuk semua swimlane (Rapat) --}}
    <div class="space-y-12 swimlane-container">

        @php
            // Kolom ditampilkan (untuk fungsionalitas arsip)
            $columnStatuses = [
                'Belum Selesai' => 'pending',
                'Sedang Dikerjakan' => 'in_progress',
                'Selesai' => 'done', // Kolom ini akan diisi dan disembunyikan di swimlane yang collapsed
            ];
        @endphp

        @foreach($groupedTasks as $rapatId => $tasks)
            @php
                // Pisahkan tugas berdasarkan status
                $pendingTasks = $tasks->where('status', 'pending');
                $onProgressTasks = $tasks->where('status', 'in_progress');
                $doneTasks = $tasks->where('status', 'done');
                
                // Cek apakah ada tugas aktif (pending atau on_progress)
                $hasActiveTasksInSwimlane = $pendingTasks->count() > 0 || $onProgressTasks->count() > 0;
                
                // Tentukan apakah swimlane harus tertutup (diarsipkan)
                $isArchived = !$hasActiveTasksInSwimlane && $doneTasks->count() > 0;
                
                $rapat = $rapats->get($rapatId);
                // Hitung total TUGAS AKTIF di swimlane ini untuk display header
                $totalActiveTasksInSwimlane = $pendingTasks->count() + $onProgressTasks->count();
                $displayClass = $isArchived ? 'collapsed' : '';
            @endphp

            {{-- SWIMLANE per Rapat --}}
            <section class="bg-white p-6 rounded-2xl shadow-xl border border-slate-200 swimlane-card {{ $displayClass }}" id="swimlane-{{ $rapatId }}">
                
                {{-- Header Swimlane (Judul Rapat) dengan Toggle --}}
                <div class="mb-4 pb-2 border-b border-custom-teal/30 cursor-pointer swimlane-header-toggle flex justify-between items-center" data-target="content-{{ $rapatId }}">
                    <h3 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                        <svg class="w-6 h-6 text-custom-teal rotate-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        <span class="hover:text-custom-teal transition duration-150">{{ $rapat->judul ?? 'Tugas Lain-lain' }}</span>
                    </h3>
                    <div class="text-right">
                        <span class="text-sm font-medium text-slate-500 mt-1 block">
                            @if($isArchived)
                                Status: **Diarsipkan** ({{ $doneTasks->count() }} selesai)
                            @else
                                Total Tugas Aktif: **{{ $totalActiveTasksInSwimlane }}**
                            @endif
                        </span>
                        @if($rapat)
                        <span class="text-xs font-medium text-slate-400 mt-1 block">
                            Rapat: {{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('d F Y') }}
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Konten yang bisa di-toggle --}}
                <div class="swimlane-content {{ $displayClass }}" id="content-{{ $rapatId }}">
                    {{-- Grid 3 Kolom Kanban --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">

                        {{-- Kolom Mapping --}}
                        @foreach($columnStatuses as $statusLabel => $statusCode)
                            @php
                                $tasksInColumn = $tasks->where('status', $statusCode);
                                $columnHeaderClass = 'header-' . str_replace(' ', '-', strtolower($statusLabel));
                                $count = $tasksInColumn->count();
                            @endphp

                            <div class="kanban-column task-column-{{ $statusCode }}">
                                
                                {{-- Header Kolom --}}
                                <div class="kanban-column-header border-b-2 {{ $columnHeaderClass }}">
                                    <h4 class="text-xl font-extrabold text-slate-700 flex justify-between items-center">
                                        <span>{{ $statusLabel }}</span>
                                        <span class="text-sm font-extrabold text-white bg-custom-teal rounded-full w-7 h-7 flex items-center justify-center shadow-md column-count" data-count="{{ $count }}">{{ $count }}</span>
                                    </h4>
                                </div>

                                {{-- List Tugas --}}
                                <div class="space-y-4 task-list-container">
                                    <div class="space-y-4 task-list" data-status-label="{{ $statusLabel }}" data-status-code="{{ $statusCode }}">
                                        @forelse($tasksInColumn as $tindakan)
                                            @include('kanban-card', ['tindakan' => $tindakan, 'currentStatusLabel' => $statusLabel])
                                        @empty
                                            <div class="empty-state-column text-center p-8 bg-slate-100 rounded-lg border-2 border-dashed border-slate-300 transition duration-300">
                                                <p class="text-sm text-slate-500 italic">Kolom ini kosong. Pindahkan tugas ke sini!</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </section>
        @endforeach

    </div>
</main>
@endsection

@push('scripts')
<script>
// PENTING: Status label/code harus diselaraskan
const STATUS_PENDING_LABEL = 'Belum Selesai';
const STATUS_IN_PROGRESS_LABEL = 'Sedang Dikerjakan';
const STATUS_DONE_LABEL = 'Selesai';
const STATUS_PENDING_CODE = 'pending';
const STATUS_IN_PROGRESS_CODE = 'in_progress';
const STATUS_DONE_CODE = 'done';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Inisialisasi Event Listener untuk Dropdown Status
    document.querySelectorAll('.status-updater').forEach(select => {
        select.addEventListener('change', function(e) {
            const newStatusLabel = this.value;
            const newStatusCode = getStatusCode(newStatusLabel); 
            const card = this.closest('.kanban-card');
            const taskId = card.dataset.taskId;
            
            // Konfirmasi untuk Done
            if (newStatusLabel === STATUS_DONE_LABEL && !confirm("Apakah Anda yakin tugas ini sudah Selesai? Tugas akan dipindahkan ke kolom arsip (Selesai).")) {
                // Kembalikan ke status lama. Menggunakan dataset status code kolom asal.
                const oldColumnList = card.closest('.task-list');
                const oldStatusCode = oldColumnList ? oldColumnList.dataset.statusCode : STATUS_PENDING_CODE;
                this.value = getStatusLabel(oldStatusCode);
                return;
            }

            updateTaskStatus(taskId, newStatusCode, newStatusLabel, card, this);
        });
    });

    // 2. Inisialisasi Event Listener untuk Toggle Swimlane
    document.querySelectorAll('.swimlane-header-toggle').forEach(header => {
        const targetId = header.dataset.target;
        const cardElement = header.closest('.swimlane-card');

        header.addEventListener('click', function() {
            toggleSwimlane(targetId, cardElement);
        });
    });
});

// --- Utility Functions ---

function getStatusCode(label) {
    switch(label) {
        case STATUS_PENDING_LABEL: return STATUS_PENDING_CODE;
        case STATUS_IN_PROGRESS_LABEL: return STATUS_IN_PROGRESS_CODE;
        case STATUS_DONE_LABEL: return STATUS_DONE_CODE;
        default: return STATUS_PENDING_CODE;
    }
}

function getStatusLabel(code) {
    switch(code) {
        case STATUS_PENDING_CODE: return STATUS_PENDING_LABEL;
        case STATUS_IN_PROGRESS_CODE: return STATUS_IN_PROGRESS_LABEL;
        case STATUS_DONE_CODE: return STATUS_DONE_LABEL;
        default: return STATUS_PENDING_LABEL;
    }
}

// --- Toggle Swimlane ---
function toggleSwimlane(contentId, cardElement) {
    const content = document.getElementById(contentId);
    if (content) {
        content.classList.toggle('collapsed');
        cardElement.classList.toggle('collapsed');
    }
}

// --- AJAX Update Status ---
async function updateTaskStatus(taskId, newStatusCode, newStatusLabel, cardElement, selectElement) {
    const url = `/tugas-saya/update-status/${taskId}`;
    const oldStatusLabel = getStatusLabel(cardElement.closest('.task-list').dataset.statusCode);
    const oldColumnList = cardElement.closest('.task-list');
    
    // Set visual loading state
    cardElement.classList.add('opacity-50', 'pointer-events-none', 'transition-all');
    selectElement.disabled = true;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: newStatusCode })
        });

        if (!response.ok) {
            const errorData = await response.json();
            const errorMsg = errorData.message || errorData.error_details || `HTTP Error: ${response.status}`;
            throw new Error(errorMsg);
        }

        const result = await response.json();

        if (result.success) {
            
            const targetColumnList = document.querySelector(`.task-list[data-status-code="${newStatusCode}"]`);
            
            if (targetColumnList) {
                if (oldColumnList.dataset.statusCode !== newStatusCode) {
                    // Pindahkan card dan update counts
                    targetColumnList.prepend(cardElement); 
                    updateColumnCounts(oldColumnList, targetColumnList);

                    // Logic Arsip/Unarsip
                    const swimlaneCard = oldColumnList.closest('.swimlane-card');
                    if (newStatusCode === STATUS_DONE_CODE) {
                        checkAndArchiveSwimlane(swimlaneCard);
                    } else if (oldColumnList.dataset.statusCode === STATUS_DONE_CODE) {
                        checkAndUnarchiveSwimlane(swimlaneCard);
                    }
                }

                updateCardStyling(cardElement, newStatusLabel, selectElement);
                selectElement.value = newStatusLabel;
                
            } else {
                throw new Error('Kolom tujuan tidak ditemukan secara visual. Status dikembalikan.');
            }

        } else {
            throw new Error(result.message || 'Gagal update status.');
        }

    } catch (error) {
        console.error('Error:', error);
        if (typeof Swal !== 'undefined') Swal.fire({ icon: 'error', title: 'Kesalahan', text: `Terjadi kesalahan: ${error.message}. Status dikembalikan.` }); else alert(`Terjadi kesalahan: ${error.message}. Status dikembalikan.`);
        
        // Kembalikan status visual pada dropdown
        selectElement.value = oldStatusLabel;
        
    } finally {
        // Hapus loading visual 
        if (cardElement.isConnected) {
            cardElement.classList.remove('opacity-50', 'pointer-events-none');
            selectElement.disabled = false;
        }
    }
}

// --- Utility: Update Column Counts ---
function updateColumnCounts(oldList, newList) {
    const isMove = newList !== null;

    // Update Kolom Lama (Kurangi)
    if (oldList) {
        const oldKanbanColumn = oldList.closest('.kanban-column');
        const oldStatusCountSpan = oldKanbanColumn.querySelector('.column-count');
        
        let old_count = parseInt(oldStatusCountSpan?.textContent ?? '1') - 1;
        oldStatusCountSpan.textContent = Math.max(0, old_count);
        
        // Tampilkan/sembunyikan empty state kolom lama
        if (old_count === 0) {
            oldList.innerHTML = '<div class="empty-state-column text-center p-8 bg-slate-100 rounded-lg border-2 border-dashed border-slate-300 transition duration-300"><p class="text-sm text-slate-500 italic">Kolom ini kosong. Pindahkan tugas ke sini!</p></div>';
        } else {
            oldList.querySelector('.empty-state-column')?.remove();
        }
    }

    // Update Kolom Baru (Tambah)
    if (isMove) {
        const newKanbanColumn = newList.closest('.kanban-column');
        const newStatusCountSpan = newKanbanColumn.querySelector('.column-count');
        
        // Ambil nilai count atau 0 jika elemen tidak ditemukan, lalu tambah 1
        let new_count = parseInt(newStatusCountSpan?.textContent ?? '0') + 1;
        newStatusCountSpan.textContent = new_count;
        
        // Hapus empty state di kolom baru
        newList.querySelector('.empty-state-column')?.remove();
    }
}


// --- Utility: Check and Archive Swimlane (NULL SAFE) ---
function checkAndArchiveSwimlane(swimlaneCard) {
    if (!swimlaneCard) return;

    // Hanya mencari card yang aktif di kolom PENDING dan ON_PROGRESS
    const activeTasks = swimlaneCard.querySelectorAll(`.task-list[data-status-code="${STATUS_PENDING_CODE}"] .kanban-card, .task-list[data-status-code="${STATUS_IN_PROGRESS_CODE}"] .kanban-card`);

    if (activeTasks.length === 0) {
        const content = swimlaneCard.querySelector('.swimlane-content');
        if (content && !swimlaneCard.classList.contains('collapsed')) {
            content.classList.add('collapsed');
            swimlaneCard.classList.add('collapsed');
            
            // Ambil count Selesai (NULL SAFE)
            const doneCountElement = swimlaneCard.querySelector(`.task-list[data-status-code="${STATUS_DONE_CODE}"] .column-count`);
            const doneCount = doneCountElement?.textContent ?? '0'; 

            const headerSpan = swimlaneCard.querySelector('.swimlane-header-toggle .text-right span:first-child');
            if (headerSpan) {
                headerSpan.innerHTML = `Status: **Diarsipkan** (${doneCount} selesai)`;
            }
            
            swimlaneCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
}

// --- Utility: Check and Unarchive Swimlane (NULL SAFE) ---
function checkAndUnarchiveSwimlane(swimlaneCard) {
    if (!swimlaneCard) return;

    if (swimlaneCard.classList.contains('collapsed')) {
        const content = swimlaneCard.querySelector('.swimlane-content');
        content.classList.remove('collapsed');
        swimlaneCard.classList.remove('collapsed');

        // Ambil count aktif (NULL SAFE)
        const pendingCountElement = swimlaneCard.querySelector(`.task-list[data-status-code="${STATUS_PENDING_CODE}"] .column-count`);
        const inProgressCountElement = swimlaneCard.querySelector(`.task-list[data-status-code="${STATUS_IN_PROGRESS_CODE}"] .column-count`);
        
        const activeCount = parseInt(pendingCountElement?.textContent ?? '0');
        const inProgressCount = parseInt(inProgressCountElement?.textContent ?? '0');
        const totalActive = activeCount + inProgressCount;
        
        const headerSpan = swimlaneCard.querySelector('.swimlane-header-toggle .text-right span:first-child');
        
        if (headerSpan) {
            headerSpan.innerHTML = `Total Tugas Aktif: **${totalActive}**`;
        }
    }
}

// --- Utility: Update Card Styling ---
function updateCardStyling(cardElement, newStatusLabel, selectElement) {
    const cardDescription = cardElement.querySelector('.card-description');
    
    cardElement.classList.remove('opacity-70');
    cardDescription.classList.remove('line-through', 'text-slate-500');
    
    if (newStatusLabel === STATUS_DONE_LABEL) {
        cardElement.classList.add('opacity-70');
        cardDescription.classList.add('line-through', 'text-slate-500'); 
        selectElement.setAttribute('disabled', 'disabled'); 
    } else {
        selectElement.removeAttribute('disabled');
    }
}
</script>
@endpush