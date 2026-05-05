<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
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
        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

        {{-- flash handled by SweetAlert --}}

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            
            {{-- EMAIL INPUT --}}
            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none"
                    placeholder="Masukkan email">

                {{-- ✅ ERROR EMAIL TERPISAH --}}
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- PASSWORD INPUT --}}
            <div>
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none"
                    placeholder="Masukkan password">

                {{-- ✅ ERROR PASSWORD TERPISAH --}}
                @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror

                <p class="text-sm text-right mt-2">
                    <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">Lupa Password?</a>
                </p>
            </div>

            {{-- LOGIN BUTTON --}}
            <button type="submit" 
                class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-custom-teal text-white rounded-lg shadow-md hover:bg-custom-teal-dark transition-all duration-300">

                Login
            </button>
        </form>

        <p class="text-sm text-center mt-4">
            Belum punya akun? 
            <a href="{{ route('register.form') }}" class="text-blue-600">Daftar</a>
        </p>
    </div>
    @include('partials.sweetalert')
</body>
</html>
