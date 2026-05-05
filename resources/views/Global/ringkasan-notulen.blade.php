@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                📋 Ringkasan Notulen
            </h1>
            <a href="{{ route('notulen.show', $notulen) }}" class="btn btn-secondary">
                ← Kembali ke Notulen
            </a>
        </div>

        <!-- Info Notulen -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-lg border border-blue-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-gray-600 font-semibold">JUDUL</p>
                    <p class="text-lg font-bold text-gray-800">{{ $notulen->judul }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-semibold">TANGGAL</p>
                    <p class="text-lg font-bold text-gray-800">
                        {{ \Carbon\Carbon::parse($notulen->tanggal)->format('d F Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-semibold">PEMBUAT</p>
                    <p class="text-lg font-bold text-gray-800">{{ $notulen->pembuat ? $notulen->pembuat->name : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-semibold">TOTAL POKOK BAHASAN</p>
                    <p class="text-lg font-bold text-blue-600">{{ $notulen->pokokBahasans->count() }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-semibold">TOTAL KEPUTUSAN</p>
                    <p class="text-lg font-bold text-green-600">
                        {{ $notulen->pokokBahasans->sum(fn($pb) => $pb->keputusans->count()) }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-semibold">TOTAL TINDAKAN</p>
                    <p class="text-lg font-bold text-orange-600">
                        {{ $notulen->pokokBahasans->reduce(fn($total, $pb) => $total + $pb->keputusans->sum(fn($k) => $k->tindakans->count()), 0) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="flex gap-3 mb-6 flex-wrap">
        <button onclick="printRingkasan()" class="btn btn-outline">
            🖨️ Cetak Ringkasan
        </button>
        <button onclick="downloadRingkasan()" class="btn btn-outline">
            ⬇️ Download PDF (Coming Soon)
        </button>
        <button onclick="copyToClipboard()" class="btn btn-outline">
            📋 Salin Ringkasan
        </button>
    </div>

    <!-- Ringkasan Text -->
    <div class="bg-white p-8 rounded-lg shadow-md border border-gray-200 mb-8">
        <div id="ringkasan-content" class="fonts-mono text-sm leading-relaxed whitespace-pre-wrap text-gray-700 bg-gray-50 p-6 rounded border border-gray-300">
            @if($notulen->ringkasan)
                {{ $notulen->ringkasan }}
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 mb-4">Ringkasan belum dibuat</p>
                    <button onclick="generateSummary()" class="btn btn-primary">
                        ⚡ Generate Ringkasan Sekarang
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Statistik Detail -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Breakdown Pokok Bahasan -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <h3 class="text-xl font-bold text-gray-800 mb-4">📌 Breakdown Pokok Bahasan</h3>
            <div class="space-y-3">
                @forelse($notulen->pokokBahasans as $pb)
                    <div class="bg-blue-50 p-4 rounded border-l-4 border-blue-500">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-semibold text-blue-900">{{ $pb->judul }}</p>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $pb->keputusans->count() }} keputusan • 
                                    {{ $pb->keputusans->sum(fn($k) => $k->tindakans->count()) }} tindakan
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada pokok bahasan</p>
                @endforelse
            </div>
        </div>

        <!-- Tindakan PIC -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <h3 class="text-xl font-bold text-gray-800 mb-4">✓ Daftar Tindakan (PIC)</h3>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @php
                    $tindakans = $notulen->pokokBahasans->reduce(fn($carry, $pb) => 
                        $carry->merge($pb->keputusans->reduce(fn($t, $k) => $t->merge($k->tindakans), collect())), collect()
                    );
                @endphp

                @forelse($tindakans as $tindakan)
                    <div class="bg-orange-50 p-3 rounded border-l-4 border-orange-500 text-sm">
                        <div class="flex justify-between items-start gap-2">
                            <div class="flex-1">
                                <p class="font-semibold text-orange-900">{{ $tindakan->deskripsi }}</p>
                                <p class="text-xs text-gray-600 mt-1">
                                    👤 {{ $tindakan->pic ? $tindakan->pic->name : 'TBD' }}
                                </p>
                            </div>
                            <span class="badge" style="background-color: 
                                @if($tindakan->status == 'completed') rgb(34, 197, 94)
                                @elseif($tindakan->status == 'in-progress') rgb(59, 130, 246)
                                @else rgb(107, 114, 128)
                                @endif
                            ; color: white;">
                                {{ $tindakan->status ?? 'Pending' }}
                            </span>
                        </div>
                        @if($tindakan->deadline)
                            <p class="text-xs text-gray-500 mt-2">
                                📅 Deadline: {{ \Carbon\Carbon::parse($tindakan->deadline)->format('d-m-Y') }}
                            </p>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada tindakan</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Informasi Ringkasan Generated -->
    @if($notulen->ringkasan_generated_at)
        <div class="bg-green-50 border border-green-200 p-4 rounded text-sm text-green-700">
            ✅ Ringkasan terakhir diperbarui: {{ \Carbon\Carbon::parse($notulen->ringkasan_generated_at)->diffForHumans() }}
        </div>
    @endif
</div>

<!-- Scripts -->
<script>
function generateSummary() {
    const notulenId = {{ $notulen->id }};
    
    fetch(`/notulen/${notulenId}/generate-summary`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            location.reload();
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function printRingkasan() {
    const printWindow = window.open('', '_blank');
    const content = document.getElementById('ringkasan-content').innerText;
    printWindow.document.write('<pre style="font-family: monospace; white-space: pre-wrap;">' + content + '</pre>');
    printWindow.document.close();
    printWindow.print();
}

function copyToClipboard() {
    const content = document.getElementById('ringkasan-content').innerText;
    navigator.clipboard.writeText(content).then(() => {
        alert('✅ Ringkasan disalin ke clipboard!');
    }).catch(err => {
        alert('❌ Gagal menyalin.');
    });
}

function downloadRingkasan() {
    alert('⏳ Fitur download PDF sedang dalam pengembangan');
}
</script>

<style>
.badges {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}
</style>
@endsection
