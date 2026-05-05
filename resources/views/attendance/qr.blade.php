@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">QR Absensi: {{ $rapat->judul }}</h2>

    <p class="mb-4">Scan QR ini menggunakan kamera ponsel. Jika Anda sudah login di browser ponsel, membuka URL akan menandai kehadiran Anda.</p>

    <div class="mb-4">
        <img src="{{ url('/rapat/'.$rapat->id.'/qr-code') }}" alt="QR Absensi" style="width:260px; height:260px;" />
    </div>

    <p class="text-sm text-gray-600">Atau buka tautan ini di ponsel: <a class="text-blue-600" href="{{ url('/absensi/scan/auto?rapat_id=' . $rapat->id . '&key=' . $rapat->attendance_token) }}">{{ url('/absensi/scan/auto?rapat_id=' . $rapat->id . '&key=' . $rapat->attendance_token) }}</a></p>

    @auth
    <form method="POST" action="{{ route('rapat.attendance.token.regenerate', $rapat->id) }}" class="mt-4">
        @csrf
        <button type="submit" class="px-3 py-2 bg-yellow-500 text-white rounded">Regenerate Token</button>
    </form>
    @endauth
</div>
@endsection
