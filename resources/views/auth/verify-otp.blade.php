<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        /* Custom CSS for New Color Scheme & Transitions */
        :root {
            --color-custom-teal: #4C8C86;
            --color-custom-teal-dark: #3D6F6A;
            --color-custom-teal-light: #eef7f6;
            --color-custom-teal-text: #376661;
        }
        .bg-custom-teal { background-color: var(--color-custom-teal); }
        .hover\:bg-custom-teal-dark:hover { background-color: var(--color-custom-teal-dark); }
        .bg-custom-teal-light { background-color: var(--color-custom-teal-light); }
        .hover\:bg-custom-teal-lighter:hover { background-color: #dbebe9; }
        .text-custom-teal { color: var(--color-custom-teal); }
        .text-custom-teal-dark { color: var(--color-custom-teal-text); }
        .border-custom-teal { border-color: var(--color-custom-teal); }

        .modal { transition: opacity 0.3s ease, visibility 0.3s ease; }
        .modal-content { transition: transform 0.3s ease; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 3px;}
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #64748b; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Verifikasi OTP</h2>

        {{-- flash handled by SweetAlert --}}

        <form method="POST" action="{{ $action }}" class="space-y-4">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div>
                <label class="block text-sm font-medium mb-1">Masukkan Kode OTP</label>
                <input type="number" name="otp" required maxlength="6"
                    oninput="if(this.value.length > 6) this.value=this.value.slice(0,6)"
                    class="w-full p-3 border rounded-lg text-center text-xl tracking-widest focus:ring focus:ring-blue-200" placeholder="Masukkan Kode OTP">
            </div>
            
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 px-4 py-2   bg-custom-teal text-white rounded-lg md:rounded-lg shadow-md hover:bg-custom-teal-dark transition-all duration-300">
                Verifikasi
            </button>
        </form>

        {{-- Resend OTP --}}
        <div class="text-center mt-4">
            <form method="POST" action="{{ url()->current() }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" name="resend" value="1"
                    class="text-blue-600 hover:underline text-sm">
                    Kirim Ulang OTP
                </button>
            </form>
        </div>
    </div>
    @include('partials.sweetalert')
</body>
</html>