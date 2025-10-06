<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk - MeetLog</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800 min-h-screen flex items-center justify-center">
  <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-2 shadow-xl rounded-2xl overflow-hidden border border-gray-200">
    
    <!-- Kiri: Form -->
    <div class="p-8 md:p-12 flex flex-col justify-center bg-white">
      <h2 class="text-3xl font-bold text-gray-900 mb-6">Selamat Datang Kembali 👋</h2>
      <p class="text-gray-600 mb-8">Masuk untuk melanjutkan ke <span class="font-semibold text-indigo-600">MeetLog</span>.</p>

      <!-- Form -->
      <form action="#" method="POST" class="space-y-5">
        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input id="email" type="email" placeholder="Masukkan email Anda" required
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
          <input id="password" type="password" placeholder="Masukkan kata sandi Anda" required
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
        </div>

        <!-- Ingat + Lupa -->
        <div class="flex items-center justify-between text-sm">
          <label class="flex items-center gap-2">
            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
            Ingat saya
          </label>
          <a href="#" class="text-indigo-600 hover:underline">Lupa kata sandi?</a>
        </div>

        <!-- Tombol -->
        <button type="submit"
          class="w-full py-3 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
          Masuk
        </button>
      </form>

      <!-- Pembatas -->
      <div class="my-6 flex items-center">
        <div class="flex-grow border-t border-gray-300"></div>
        <span class="px-4 text-gray-500 text-sm">atau lanjutkan dengan</span>
        <div class="flex-grow border-t border-gray-300"></div>
      </div>

      <!-- Login Google -->
      <div>
        <button
          class="flex items-center justify-center gap-2 border border-gray-300 rounded-lg py-3 w-full hover:bg-gray-50 transition">
          <img src="https://www.svgrepo.com/show/355037/google.svg" class="w-5 h-5" alt="Google">
          Masuk dengan Google
        </button>
      </div>

      <!-- Link daftar -->
      <p class="text-center text-gray-600 text-sm mt-8">
        Belum punya akun?
        <a href="/register" class="text-indigo-600 font-medium hover:underline">Daftar</a>
      </p>
    </div>

    <!-- Kanan: Logo -->
    <div class="hidden md:flex items-center justify-center bg-indigo-50">
      <img src="{{ asset('img/meetlog_stacked_full.png') }}"
           alt="Logo MeetLog" class="w-2/3 max-w-sm">
    </div>
  </div>
</body>
</html>
