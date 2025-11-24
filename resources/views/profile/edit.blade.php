@extends('layout.app')

@section('title', 'Edit Profil - MeetLog')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-[#4C8C86]">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="{{ route('profile.show') }}" class="ml-1 text-sm font-medium text-slate-500 hover:text-[#4C8C86] md:ml-2">Profil Saya</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-sm font-medium text-slate-800 md:ml-2">Edit</span>
                </div>
            </li>
        </ol>
    </nav>

    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 flex justify-between items-start">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="text-sm text-red-700">
                    <p class="font-medium">Terdapat kesalahan pada input Anda:</p>
                    <ul class="list-disc list-inside mt-1 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button @click="show = false" class="text-red-500 hover:text-red-700">&times;</button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-20 bg-slate-50 border-b border-slate-100 z-0"></div>

                <div class="relative z-10 flex flex-col items-center text-center">
                    <h3 class="text-lg font-bold text-slate-800 mb-6">Foto Profil</h3>

                    <div class="relative w-32 h-32 mb-6 group">
                         @if ($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover border-4 border-white shadow-md bg-white">
                        @else
                            <div class="w-full h-full rounded-full bg-[#4C8C86] text-white flex items-center justify-center text-4xl font-bold border-4 border-white shadow-md">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        
                        <div class="absolute bottom-1 right-1 bg-white rounded-full p-1.5 shadow border border-slate-200 text-slate-500">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                    </div>

                    <form action="{{ route('profile.upload-photo') }}" method="POST" enctype="multipart/form-data" class="w-full">
                        @csrf
                        <label class="block mb-4">
                            <span class="sr-only">Choose profile photo</span>
                            <input type="file" name="profile_photo" class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-xs file:font-semibold
                                file:bg-[#4C8C86] file:text-white
                                hover:file:bg-[#3D706B]
                                cursor-pointer focus:outline-none
                            "/>
                        </label>
                        <p class="text-xs text-slate-400 mb-4">JPG, PNG atau GIF (Max. 2MB)</p>
                        
                        <button type="submit" class="w-full px-4 py-2 bg-white border border-slate-300 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-50 transition shadow-sm">
                            Upload Foto Baru
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-5 pb-3 border-b border-slate-50">
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Informasi Dasar</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#4C8C86] focus:border-transparent outline-none transition text-slate-800 placeholder-slate-400">
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Alamat Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#4C8C86] focus:border-transparent outline-none transition text-slate-800 placeholder-slate-400">
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-5 pb-3 border-b border-slate-50">
                            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Detail Pekerjaan & Kontak</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="department" class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Departemen</label>
                                <input type="text" id="department" name="department" value="{{ old('department', $user->department) }}" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#4C8C86] focus:border-transparent outline-none transition text-slate-800 placeholder-slate-400"
                                    placeholder="Contoh: IT, HRD, Keuangan">
                            </div>

                            <div>
                                <label for="phone" class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Nomor Telepon</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#4C8C86] focus:border-transparent outline-none transition text-slate-800 placeholder-slate-400"
                                    placeholder="+62 8xx xxxx xxxx">
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-5 pb-3 border-b border-slate-50">
                            <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Bio</h3>
                        </div>

                        <div>
                            <label for="bio" class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Tentang Saya</label>
                            <textarea id="bio" name="bio" rows="4" 
                                class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#4C8C86] focus:border-transparent outline-none transition text-slate-800 placeholder-slate-400 resize-none"
                                placeholder="Tuliskan sedikit tentang diri Anda, peran di perusahaan, atau keahlian...">{{ old('bio', $user->bio) }}</textarea>
                             <p class="text-xs text-slate-400 mt-2 text-right">Maksimal 250 karakter</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-100">
                        <a href="{{ route('profile.show') }}" class="px-6 py-2.5 rounded-xl border border-slate-300 text-slate-600 font-medium hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-[#4C8C86] hover:bg-[#3D706B] text-white rounded-xl font-medium shadow-sm shadow-teal-200 transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection