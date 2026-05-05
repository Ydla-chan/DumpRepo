<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        :root {
            --color-custom-teal: #4C8C86;
            --color-custom-teal-dark: #3D6F6A;
            --color-custom-teal-light: #eef7f6;
            --color-custom-teal-text: #376661;
        }
        .bg-custom-teal { background-color: var(--color-custom-teal); }
        .hover\:bg-custom-teal-dark:hover { background-color: var(--color-custom-teal-dark); }
        .text-custom-teal { color: var(--color-custom-teal); }
        .border-custom-teal { border-color: var(--color-custom-teal); }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg mx-4 sm:mx-0">
        <h2 class="text-2xl font-bold text-center mb-6">Lupa Password</h2>

        {{-- flash handled by SweetAlert --}}

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none"
                    placeholder="Masukkan email" required>
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit"
                class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-custom-teal text-white rounded-lg shadow-md hover:bg-custom-teal-dark transition-all duration-300">
                Kirim Kode OTP
            </button>
        </form>

        <p class="text-sm text-center mt-4">
            Kembali ke
            <a href="{{ route('login.form') }}" class="text-blue-600">Login</a>
        </p>
    </div>
    @include('partials.sweetalert')
</body>
</html>
