@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="max-w-md mx-auto bg-white shadow rounded p-6">
        <h2 class="text-2xl font-bold mb-4">Form Absensi</h2>

        @if(isset($error))
            <div class="p-3 bg-red-100 text-red-800 rounded mb-4">{{ $error }}</div>
        @endif

        @if(isset($rapat))
            <div class="mb-4 pb-4 border-b">
                <p class="text-gray-700"><strong>Rapat:</strong> {{ $rapat->judul }}</p>
                <p class="text-gray-700"><strong>Jadwal:</strong> {{ $rapat->tanggal->format('d M Y') }} - {{ $rapat->jam }}</p>
            </div>

            <form method="POST" action="{{ route('absensi.scan.store') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="rapat_id" value="{{ $rapat->id }}">

                <div>
                    <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border rounded" placeholder="Masukkan nama Anda" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 border rounded" placeholder="Masukkan email Anda" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-medium">
                    ✓ Konfirmasi Absen
                </button>
            </form>
        @endif
    </div>
</div>
@endsection