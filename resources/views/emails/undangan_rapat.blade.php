<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Rapat</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .container { padding: 20px; border: 1px solid #ddd; border-radius: 5px; max-width: 600px; margin: auto; }
        .header { font-size: 24px; font-weight: bold; color: #4C8C86; }
        .details-table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        .details-table td { padding: 8px; border-top: 1px solid #eee; }
        .details-table tr td:first-child { font-weight: bold; width: 100px; }
        .footer { margin-top: 20px; font-size: 12px; color: #777; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <p class="header">Undangan Rapat</p>
        <p>Dengan hormat,</p>
        <p>Anda diundang untuk menghadiri rapat berikut:</p>

        <table class="details-table">
            <tr>
                <td>Agenda</td>
                <td>: {{ $rapat->agenda }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ $rapat->tanggal->format('l, d F Y') }}</td>
            </tr>
            <tr>
                <td>Jam</td>
                <td>: {{ \Carbon\Carbon::parse($rapat->jam)->format('H:i') }} WIB</td>
            </tr>
            {{-- BLOK LOKASI YANG DIPERBARUI --}}
            @if($rapat->link)
            <tr>
                <td>Link Online</td>
                <td>: <a href="{{ $rapat->link }}">{{ $rapat->link }}</a></td>
            </tr>
            @endif
            @if($rapat->ruangan)
            <tr>
                <td>Ruangan</td>
                <td>: {{ $rapat->ruangan }}</td>
            </tr>
            @endif
            {{-- AKHIR BLOK LOKASI --}}
            @if(!empty($rapat->undangan))
            <tr>
                <td>Peserta</td>
                <td>
                    {{-- Mengubah array email menjadi string yang dipisahkan koma --}}
                    {{ implode(', ', $rapat->undangan) }}
                </td>
            </tr>
            @endif
        </table>

        <p>Mohon kehadirannya tepat waktu. Terima kasih.</p>
        <div class="footer">
            Email ini dibuat secara otomatis oleh sistem MeetLog.
        </div>
    </div>
</body>
</html>