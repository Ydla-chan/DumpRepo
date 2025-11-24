@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="max-w-md mx-auto text-center">
        @if(isset($status) && $status === 'success')
            <div class="bg-white shadow rounded p-8">
                <div class="text-4xl text-green-600 mb-4">✓</div>
                <h2 class="text-2xl font-bold text-green-600 mb-2">Absensi Berhasil</h2>
                <p class="text-gray-700 mb-6">Kehadiran Anda telah tercatat</p>
                
                @if(isset($attendance))
                    <div class="bg-gray-50 p-4 rounded mb-6 text-left">
                        <p class="text-gray-700"><strong>Nama:</strong> {{ $attendance->name }}</p>
                        <p class="text-gray-700"><strong>Email:</strong> {{ $attendance->email }}</p>
                        <p class="text-gray-700"><strong>Waktu:</strong> {{ $attendance->scanned_at->format('d M Y H:i:s') }}</p>
                    </div>
                @endif

                <a href="{{ route('rapat.index') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Kembali ke Rapat
                </a>
            </div>

        @elseif(isset($status) && $status === 'already')
            <div class="bg-white shadow rounded p-8">
                <div class="text-4xl text-yellow-600 mb-4">⚠</div>
                <h2 class="text-2xl font-bold text-yellow-600 mb-2">Sudah Terdaftar</h2>
                <p class="text-gray-700 mb-6">Email Anda sudah tercatat sebagai hadir</p>
                
                @if(isset($existingAttendance))
                    <div class="bg-gray-50 p-4 rounded mb-6 text-left">
                        <p class="text-gray-700"><strong>Nama:</strong> {{ $existingAttendance->name }}</p>
                        <p class="text-gray-700"><strong>Email:</strong> {{ $existingAttendance->email }}</p>
                        <p class="text-gray-700"><strong>Waktu Pertama:</strong> {{ $existingAttendance->scanned_at->format('d M Y H:i:s') }}</p>
                    </div>
                @endif

                <a href="{{ route('rapat.index') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Kembali ke Rapat
                </a>
            </div>

        @else
            <div class="bg-white shadow rounded p-8">
                <p class="text-gray-700 text-lg">Status absensi tidak diketahui</p>
                <a href="{{ route('rapat.index') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Kembali ke Rapat
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
