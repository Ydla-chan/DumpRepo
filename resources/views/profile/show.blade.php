@extends('layout.app')

@section('title', 'Profil Saya - MeetLog')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-lg bg-emerald-50 border border-emerald-200 flex justify-between items-center">
            <div class="flex items-center gap-3 text-emerald-700">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-24 bg-slate-50 z-0"></div>

                <div class="relative z-10 mx-auto w-32 h-32 mb-4 group">
                    @if ($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover border-4 border-white shadow-md">
                    @else
                        <div class="w-full h-full rounded-full bg-[#4C8C86] text-white flex items-center justify-center text-4xl font-bold border-4 border-white shadow-md">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <span class="absolute bottom-1 right-1 w-5 h-5 bg-green-500 border-4 border-white rounded-full" title="Online"></span>
                </div>

                <div class="relative z-10">
                    <h2 class="text-xl font-bold text-slate-900">{{ $user->name }}</h2>
                    <p class="text-slate-500 text-sm mb-4">{{ $user->email }}</p>
                    
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200 capitalize mb-6">
                        {{ $user->role ?? 'Staff Member' }}
                    </div>

                    <a href="{{ route('profile.edit') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-[#4C8C86] hover:bg-[#3D706B] text-white rounded-xl font-medium transition shadow-sm shadow-teal-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit Profil
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Aktivitas Akun</h3>
                <div class="flex items-center justify-between py-2 border-b border-slate-50 last:border-0">
                    <span class="text-sm text-slate-600">Bergabung</span>
                    <span class="text-sm font-medium text-slate-900">{{ $user->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-slate-50 last:border-0">
                    <span class="text-sm text-slate-600">Terakhir Login</span>
                    <span class="text-sm font-medium text-slate-900">Hari ini</span> 
                    {{-- Ganti "Hari ini" dengan dynamic variable jika ada --}}
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Informasi Pribadi</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="group">
                        <label class="block text-xs font-medium text-slate-400 uppercase tracking-wide mb-1.5">Departemen</label>
                        <div class="flex items-center gap-2 text-slate-800 font-medium">
                            <span class="bg-slate-50 p-1.5 rounded text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </span>
                            {{ $user->department ?? '-' }}
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-xs font-medium text-slate-400 uppercase tracking-wide mb-1.5">No. Telepon</label>
                        <div class="flex items-center gap-2 text-slate-800 font-medium">
                            <span class="bg-slate-50 p-1.5 rounded text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </span>
                            {{ $user->phone ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 flex flex-col h-auto">
                <div class="flex items-center gap-3 mb-4">
                     <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Tentang Saya</h3>
                </div>
                
                <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 h-full">
                    @if ($user->bio)
                        <p class="text-slate-600 leading-relaxed whitespace-pre-line">{{ $user->bio }}</p>
                    @else
                        <div class="text-center py-6">
                            <p class="text-slate-400 italic mb-2">Belum ada informasi bio.</p>
                            <a href="{{ route('profile.edit') }}" class="text-sm text-[#4C8C86] font-medium hover:underline">Tambahkan sekarang &rarr;</a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection