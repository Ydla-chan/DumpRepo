@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Absensi: {{ $rapat->judul }}</h2>

    @if($status === 'already')
        <div class="p-4 bg-yellow-100 text-yellow-800">Anda sudah terdaftar hadir pada rapat ini.</div>
    @else
        <div class="p-4 bg-green-100 text-green-800">Absensi berhasil. Terima kasih, kehadiran Anda telah dicatat.</div>
    @endif

    <div class="mt-4">
        <a href="{{ route('rapat.absensi', $rapat->id) }}" class="text-blue-600">Lihat daftar kehadiran</a>
    </div>
</div>
@endsection
