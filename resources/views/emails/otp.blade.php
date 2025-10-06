<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kode OTP - MeetLog</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 30px 0;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 520px; background-color: #ffffff; border-radius: 14px; overflow: hidden; box-shadow: 0 3px 12px rgba(0,0,0,0.08);">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background-color: #0ea5e9; padding: 25px;">
                            <h1 style="margin: 0; font-size: 22px; font-weight: bold; color: #ffffff; letter-spacing: 1px;">
                                MeetLog • Kode OTP
                            </h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px; color: #1f2937; font-size: 16px; line-height: 1.6;">
                            <p style="margin: 0 0 15px;">Hai,</p>
                            <p style="margin: 0 0 20px;">
                                Anda baru saja melakukan permintaan verifikasi akun di <strong>MeetLog</strong>.
                                Gunakan kode OTP berikut untuk melanjutkan proses:
                            </p>

                            <p style="text-align: center; margin: 25px 0;">
                                <span style="display: inline-block; font-size: 30px; font-weight: bold; letter-spacing: 10px; background-color: #e0f2fe; color: #0369a1; padding: 15px 25px; border-radius: 10px;">
                                    {{ $otp }}
                                </span>
                            </p>

                            <p style="font-size: 14px; color: #4b5563; margin-top: 20px;">
                                ⏳ <strong>Kode ini hanya berlaku 5 menit.</strong><br>
                                Demi keamanan, jangan bagikan kode ini kepada siapapun.
                            </p>

                            <p style="margin-top: 25px; font-size: 15px;">
                                Salam hangat,<br><strong>Tim MeetLog</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #f9fafb; padding: 15px; font-size: 12px; color: #6b7280;">
                            Email ini dikirim secara otomatis oleh sistem MeetLog.<br>
                            Jika Anda tidak meminta OTP, abaikan email ini.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body> 
</html>
