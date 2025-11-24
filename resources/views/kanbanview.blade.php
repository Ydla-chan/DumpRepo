@if($groupedTasks->isEmpty())
    <div class="p-8 bg-white border-2 border-dashed border-slate-300 rounded-xl text-center">
         <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h3 class="mt-2 text-lg font-medium text-slate-800">Tidak Ada Tugas</h3>
        <p class="mt-1 text-sm text-slate-500">Seluruh tugas Anda sudah dome atau belum ada tugas baru.</p>
    </div>
@endif

{{-- Container untuk semua swimlane (Rapat) --}}
<div class="space-y-10">

    @foreach($groupedTasks as $rapatId => $tasks)
        @php
            $rapat = $rapats->get($rapatId);
        @endphp

        {{-- SWIMLANE per Rapat --}}
        <section class="bg-white p-6 rounded-xl shadow-md border border-slate-200">
            
            {{-- Header Swimlane (Judul Rapat) --}}
            <div class="swimlane-header">
                <h3 class="text-2xl font-bold text-custom-teal">
                    {{ $rapat->judul ?? 'Tugas Lain-lain' }}
                </h3>
                @if($rapat)
                <span class="text-sm text-slate-500">
                    {{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('l, d F Y') }}
                </span>
                @endif
            </div>

            {{-- Grid 3 Kolom Kanban --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- KOLOM 1: pending --}}
                <div class="kanban-column">
                    <h4 class="text-base font-semibold text-slate-800 border-b border-slate-300 pb-2 mb-4">
                        1. pending
                    </h4>
                    <div class="space-y-4 task-list" data-status="pending">
                        @forelse($tasks->filter(fn($t) => $t->status == 'pending' || $t->status == null) as $tindakan)
                            @include('global.partials.kanban-card', ['tindakan' => $tindakan])
                        @empty
                            <p class="text-sm text-slate-500 italic p-3">Kosong</p>
                        @endforelse
                    </div>
                </div>

                {{-- KOLOM 2: on_progress --}}
                <div class="kanban-column">
                    <h4 class="text-base font-semibold text-slate-800 border-b border-slate-300 pb-2 mb-4">
                        2. on_progress
                    </h4>
                    <div class="space-y-4 task-list" data-status="on_progress">
                        @forelse($tasks->where('status', 'on_progress') as $tindakan)
                            @include('global.partials.kanban-card', ['tindakan' => $tindakan])
                        @empty
                            <p class="text-sm text-slate-500 italic p-3">Kosong</p>
                        @endforelse
                    </div>
                </div>

                {{-- KOLOM 3: dome --}}
                <div class="kanban-column">
                    <h4 class="text-base font-semibold text-slate-800 border-b border-slate-300 pb-2 mb-4">
                        3. dome
                    </h4>
                    <div class="space-y-4 task-list" data-status="dome">
                        @forelse($tasks->where('status', 'dome') as $tindakan)
                            @include('global.partials.kanban-card', ['tindakan' => $tindakan])
                        @empty
                            <p class="text-sm text-slate-500 italic p-3">Kosong</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </section>
    @endforeach
</div>

@push('scripts')
<script>
// Skrip ini hanya akan dimuat jika viewType == 'kanban'
document.addEventListener('DOMContentLoaded', () => {
    const statusUpdaters = document.querySelectorAll('.status-updater');
    
    for (let i = 0; i < statusUpdaters.length; i++) {
        const select = statusUpdaters[i];
        if (select) {
            select.addEventListener('change', function(e) {
                const card = this.closest('.kanban-card');
                if (card) {
                    const taskId = card.dataset.taskId;
                    const newStatus = this.value;
                    if(taskId && newStatus) {
                        updateTaskStatus(taskId, newStatus, card);
                    }
                }
            });
        }
    }
});

async function updateTaskStatus(taskId, newStatus, cardElement) {
    const url = `/tugas-saya/update-status/${taskId}`;
    cardElement.style.opacity = '0.5';

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: newStatus })
        });
        const result = await response.json();
        if (response.ok && result.success) {
            const targetColumn = document.querySelector(`.task-list[data-status="${newStatus}"]`);
            if (targetColumn) {
                const emptyMsg = targetColumn.querySelector('p.italic');
                if (emptyMsg) emptyMsg.remove();
                targetColumn.appendChild(cardElement);
                
                if (newStatus === 'dome') {
                    cardElement.classList.add('kanban-card-done');
                    cardElement.querySelector('.card-description').style.textDecoration = 'line-through';
                    cardElement.querySelector('.status-updater').disabled = true;
                } else {
                    cardElement.classList.remove('kanban-card-done');
                    cardElement.querySelector('.card-description').style.textDecoration = 'none';
                    cardElement.querySelector('.status-updater').disabled = false;
                }
            } else {
                location.reload();
            }
        } else {
            alert('Gagal update status: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan jaringan.');
    } finally {
        cardElement.style.opacity = '1';
    }
}
</script>
@endpush