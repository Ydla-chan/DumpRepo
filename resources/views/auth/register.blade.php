<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">
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
                <input type="text" name="name" required class="w-full p-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" required class="w-full p-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" required class="w-full p-2 border rounded-lg">
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
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
