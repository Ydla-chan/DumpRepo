<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg mx-4 sm:mx-0"    >
        <h2 class="text-2xl font-bold text-center mb-6">Register</h2>

        {{-- Pesan Error --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium">Nama</label>
                <input type="text" name="name" required class="w-full p-2 border border-gray-300 rounded-lg appearance-none focus:outline-none" placeholder="Masukkan Nama Lengkap">
            </div>
            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" required class="w-full p-2 border border-gray-300 rounded-lg appearance-none focus:outline-none" placeholder="Masukkan Alamat Email">
            </div>
            <div>
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" required class="w-full p-2 border border-gray-300 rounded-lg appearance-none focus:outline-none" placeholder="Masukkan Password">
            </div>
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 px-4 py-2   bg-custom-teal text-white rounded-lg md:rounded-lg shadow-md hover:bg-custom-teal-dark transition-all duration-300">
                Daftar
            </button>
        </form>

        <p class="text-center text-sm mt-4">
            Sudah punya akun?
            <a href="{{ route('login.form') }}" class="text-blue-600 hover:underline">Login</a>
        </p>
    </div>
</body>
</html>
