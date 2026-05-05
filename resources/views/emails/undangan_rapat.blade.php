<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Rapat</title>
    <style>
        /* Reset & Base Styles */
        body { margin: 0; padding: 0; background-color: #f4f4f7; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; color: #555; }
        table { border-collapse: collapse; width: 100%; }
        
        /* Layout */
        .wrapper { width: 100%; background-color: #f4f4f7; padding: 40px 0; }
        .container { display: block; margin: 0 auto !important; max-width: 600px; padding: 0; width: 600px; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        
        /* Header */
        .header { background-color: #4C8C86; padding: 30px 40px; text-align: center; }
        .header h1 { margin: 0; color: #ffffff; font-size: 24px; font-weight: 600; letter-spacing: 0.5px; }
        
        /* Content */
        .content { padding: 40px; }
        .greeting { font-size: 16px; margin-bottom: 20px; color: #333; }
        
        /* Info Box */
        .info-box { background-color: #fcfcfc; border: 1px solid #eeeeee; border-radius: 6px; padding: 20px; margin-bottom: 25px; }
        .info-row { margin-bottom: 12px; display: block; }
        .info-row:last-child { margin-bottom: 0; }
        .info-label { font-weight: bold; color: #333; display: inline-block; width: 100px; vertical-align: top; }
        .info-value { display: inline-block; color: #555; max-width: 360px; vertical-align: top; }

        /* Button */
        .btn-container { text-align: center; margin: 30px 0; }
        .btn { display: inline-block; background-color: #4C8C86; color: #ffffff; text-decoration: none; padding: 12px 30px; border-radius: 5px; font-weight: bold; font-size: 16px; transition: background-color 0.3s; }
        .btn:hover { background-color: #3a6b66; }
        
        /* Footer */
        .footer { background-color: #f4f4f7; padding: 20px; text-align: center; font-size: 12px; color: #999; }
        
        /* Mobile Responsive */
        @media only screen and (max-width: 620px) {
            .container { width: 100% !important; border-radius: 0; }
            .content { padding: 20px; }
            .info-label { display: block; width: 100%; margin-bottom: 5px; color: #888; font-size: 12px; text-transform: uppercase; }
            .info-value { display: block; width: 100%; margin-bottom: 15px; font-weight: 500; }
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <div class="container">
            
            <div class="header">
                <h1>Undangan Rapat</h1>
            </div>

            <div class="content">
                <p class="greeting">Dengan hormat,</p>
                <p>Kami mengundang Anda untuk menghadiri rapat yang dijadwalkan sebagai berikut:</p>

                <div class="info-box">
                    <div class="info-row">
                        <span class="info-label">Judul Rapat</span>
                        <span class="info-value">: {{ $rapat->judul }}</span>
                    </div>
                     <div class="info-row">
                        <span class="info-label">Agenda</span>
                        <span class="info-value">: {{ $rapat->agenda }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal</span>
                        <span class="info-value">: {{ $rapat->tanggal->format('l, d F Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Waktu</span>
                        <span class="info-value">: {{ \Carbon\Carbon::parse($rapat->jam)->format('H:i') }} WIB</span>
                    </div>
                    
                    @if($rapat->ruangan)
                    <div class="info-row">
                        <span class="info-label">Ruangan</span>
                        <span class="info-value">: {{ $rapat->ruangan }}</span>
                    </div>
                    @endif

                    @if(!empty($rapat->undangan))
                    <div class="info-row">
                        <span class="info-label">Peserta</span>
                        <span class="info-value">: {{ implode(', ', $rapat->undangan) }}</span>
                    </div>
                    @endif
                </div>

                @if($rapat->link)
                <div class="btn-container">
                    <a href="{{ $rapat->link }}" class="btn " target="_blank">Gabung Rapat Sekarang</a>
                    <p style="font-size: 12px; color: #999; margin-top: 10px;">
                        Atau copy link: <a href="{{ $rapat->link }}" style="color: #4C8C86;">{{ $rapat->link }}</a>
                    </p>
                </div>
                @endif

                <p style="margin-top: 30px;">Mohon kehadirannya tepat waktu. Atas perhatiannya kami ucapkan terima kasih.</p>
            </div>

            <div class="footer">
                &copy; {{ date('Y') }} MeetLog System.<br>
                Email ini dibuat secara otomatis, mohon tidak membalas.
            </div>
        </div>
    </div>

</body>
</html>