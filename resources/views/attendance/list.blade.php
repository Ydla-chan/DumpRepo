@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Daftar Kehadiran: {{ $rapat->judul }}</h2>

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Waktu Scan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $index => $att)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $index + 1 }}</td>
                <td class="px-4 py-2">{{ $att->user->name ?? '-' }}</td>
                <td class="px-4 py-2">{{ $att->user->email ?? '-' }}</td>
                <td class="px-4 py-2">{{ $att->scanned_at ? $att->scanned_at->format('Y-m-d H:i:s') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
