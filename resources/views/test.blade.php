<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeetLog - Pengaturan Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <style>
        :root { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-slate-800 flex min-h-screen">

    <aside class="bg-white/95 backdrop-blur-sm shadow-lg flex-col fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 z-50 transition-all duration-300 ease-in-out w-64 shrink-0 hidden md:flex">
        <div class="p-4 border-b border-gray-200/80 flex items-center justify-between h-16 shrink-0">
            <h1 class="text-2xl font-bold text-teal-600 transition-all">MeetLog</h1>
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="#" class="flex items-center space-x-3 p-2 rounded-lg text-slate-600 hover:bg-gray-100 hover:text-teal-700 transition-colors duration-200">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-2 rounded-lg text-slate-600 hover:bg-gray-100 hover:text-teal-700 transition-colors duration-200">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" /></svg>
                <span>Rekap Rapat</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-2 rounded-lg text-slate-600 hover:bg-gray-100 hover:text-teal-700 transition-colors duration-200">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" /><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" /></svg>
                <span>Rekap Notulensi</span>
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col max-h-screen overflow-hidden relative">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[150%] h-[150%] bg-gradient-to-br from-teal-50/50 via-gray-50 to-sky-50/50 -z-10"></div>
        
        <header class="flex items-center justify-between bg-white/80 backdrop-blur-sm border-b border-gray-200/80 px-4 md:px-6 z-30 h-16 shrink-0">
            <h2 class="text-xl font-semibold text-slate-800">Pengaturan</h2>
            <div class="flex items-center space-x-6">
                <button class="flex items-center space-x-2">
                    <img src="https://i.pravatar.cc/32?u=user-xyz" alt="Profile" class="w-9 h-9 rounded-full ring-2 ring-offset-2 ring-teal-400">
                    <span class="font-medium hidden sm:inline text-slate-700">Aldy J. Hutasoit</span>
                </button>
            </div>
        </header>

        <main class="flex-1 flex flex-col overflow-y-auto">
            <div class="p-4 sm:p-6 lg:p-8 flex-1 flex flex-col bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg border border-gray-200/80 ">
                     <div class="px-6 sm:px-8 py-6">
                        <h1 class="text-2xl font-bold text-slate-900">Pengaturan Akun</h1>
                        <p class="mt-1 text-slate-500 text-sm">Kelola informasi profil, email, dan kata sandi Anda.</p>
                    </div>

                    <div class="flex-1 overflow-y-auto">
                        <div class="px-6 sm:px-8 pb-8 space-y-10">
                            
                            <section>
                                <div class="space-y-6">
                                    <div class="flex items-center gap-6">
                                        <img class="w-20 h-20 rounded-full object-cover" src="https://i.pravatar.cc/150?u=user-xyz" alt="Profile picture">
                                        <div class="flex items-center gap-3">
                                            <button type="button" class="flex items-center gap-2 bg-white hover:bg-gray-100 py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-semibold text-slate-700 transition-all">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
                                                Unggah Foto
                                            </button>
                                            <button type="button" class="text-sm font-semibold text-slate-500 hover:text-red-600 transition-colors">Hapus</button>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-3 gap-4 items-center pt-6 border-t border-gray-200">
                                        <label for="fullName" class="text-sm font-medium text-slate-700">Nama Lengkap</label>
                                        <input type="text" name="fullName" id="fullName" value="Aldy J. Hutasoit" class="md:col-span-2 block w-full bg-gray-50 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-400 focus:border-teal-500 sm:text-sm transition">
                                    </div>
                                    <div class="grid md:grid-cols-3 gap-4 items-center">
                                        <label for="email" class="text-sm font-medium text-slate-700">Alamat Email</label>
                                        <input type="email" name="email" id="email" value="aldy.j.h@example.com" class="md:col-span-2 block w-full border-gray-300 rounded-lg shadow-sm sm:text-sm bg-gray-100 text-slate-500 cursor-not-allowed" readonly>
                                    </div>
                                </div>
                            </section>

                            <section class="pt-8">
                                <div class="border-t border-gray-200 mb-6"></div>
                                <h2 class="text-lg font-semibold text-slate-800">Ganti Kata Sandi</h2>
                                <div class="mt-6 space-y-6">
                                    <div class="grid md:grid-cols-3 gap-4 items-start">
                                        <label for="current-password" class="text-sm font-medium text-slate-700 pt-2">Kata Sandi Saat Ini</label>
                                        <input type="password" name="current-password" id="current-password" placeholder="••••••••" class="md:col-span-2 block w-full bg-gray-50 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-400 focus:border-teal-500 sm:text-sm transition">
                                    </div>
                                    <div class="grid md:grid-cols-3 gap-4 items-start">
                                        <label for="new-password" class="text-sm font-medium text-slate-700 pt-2">Kata Sandi Baru</label>
                                        <div class="md:col-span-2">
                                            <input type="password" name="new-password" id="new-password" class="block w-full bg-gray-50 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-400 focus:border-teal-500 sm:text-sm transition">
                                            <p class="text-xs text-slate-400 mt-2">Gunakan minimal 8 karakter dengan kombinasi huruf dan angka.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                        </div>
                    </div>
                    <div class="p-4 px-6 sm:px-8 bg-gray-50/70 flex justify-end gap-3 rounded-b-2xl border-t border-gray-200/80">
                        <button type="button" class="bg-white hover:bg-gray-100 py-2 px-5 border border-gray-300 rounded-lg shadow-sm text-sm font-semibold text-slate-700 transition-colors">Batal</button>
                        <button type="submit" class="flex items-center gap-2 bg-gradient-to-br from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-600 py-2 px-5 text-white rounded-lg text-sm font-semibold shadow-lg shadow-teal-500/20 transform hover:-translate-y-0.5 transition-all">
                             <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>