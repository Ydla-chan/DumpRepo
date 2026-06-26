@extends('layout.app')
@yield('content')
@section('content')
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
@endsection