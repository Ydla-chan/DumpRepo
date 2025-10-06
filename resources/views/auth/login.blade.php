<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" required class="w-full p-2 border rounded-lg focus:outline-none" placeholder="Masukkan email Anda" >
            </div>
            <div>
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" required class="w-full p-2 border rounded-lg focus:outline-none" placeholder="Masukkan password Anda" >
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                Login
            </button>
        </form>

        <p class="text-sm text-center mt-4">
            Belum punya akun? <a href="{{ route('register.form') }}" class="text-blue-600">Daftar</a>
        </p>
    </div>
</body>
</html>
