<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Verifikasi OTP</h2>

        {{-- Flash Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- Flash Error Message --}}
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ $action }}" class="space-y-4">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div>
                <label class="block text-sm font-medium mb-1">Masukkan Kode OTP</label>
                <input type="number" name="otp" required maxlength="6"
                    oninput="if(this.value.length > 6) this.value=this.value.slice(0,6)"
                    class="w-full p-3 border rounded-lg text-center text-xl tracking-widest focus:ring focus:ring-blue-200">
            </div>
            
            <button type="submit"
                class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                ✅ Verifikasi
            </button>
        </form>

        {{-- Resend OTP --}}
        <div class="text-center mt-4">
            <form method="POST" action="{{ url()->current() }}">
                @csrf
                <button type="submit" name="resend" value="1"
                    class="text-blue-600 hover:underline text-sm">
                    Kirim Ulang OTP
                </button>
            </form>
        </div>
    </div>
</body>
</html>
