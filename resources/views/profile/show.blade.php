@extends('layout.app')

@section('title', 'Profil Saya - MeetLog')

@section('content')
{{-- Logic Calculation --}}
@php
    $initials = collect(explode(' ', $user->name))
        ->map(fn($segment) => strtoupper(substr($segment, 0, 1)))
        ->take(2)
        ->implode('');
    
    $themeColor = 'bg-[#4C8C86]';
    $themeColorHover = 'hover:bg-[#3D706B]';
@endphp


    {{-- flash handled by SweetAlert --}}

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        {{-- LEFT COLUMN (User Card & Stats) --}}
        <div class="lg:col-span-4 space-y-6">
            
            {{-- Profile Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative group">
                {{-- Decorative Header --}}
                <div class="absolute top-0 left-0 w-full h-28 bg-gradient-to-br from-slate-100 to-slate-200 z-0"></div>

                <div class="relative z-10 px-6 pt-12 pb-6 text-center">
                    {{-- Avatar --}}
                    <div class="relative mx-auto w-32 h-32 mb-4">
                        <div class="w-full h-full rounded-full border-4 border-white shadow-lg overflow-hidden bg-white">
                            @if ($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full {{ $themeColor }} text-white flex items-center justify-center text-3xl font-bold tracking-wider">
                                    {{ $initials }}
                                </div>
                            @endif
                        </div>
                        {{-- Online Indicator --}}
                        <span class="absolute bottom-2 right-2 w-5 h-5 bg-green-500 border-4 border-white rounded-full shadow-sm" title="Status: Online"></span>
                    </div>

                    {{-- Name & Role --}}
                    <h2 class="text-xl font-bold text-slate-900 mb-1">{{ $user->name }}</h2>
                    <p class="text-slate-500 text-sm mb-4 font-mono">{{ $user->email }}</p>
                    
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200 uppercase tracking-wide mb-6">
                        {{ $user->role ?? 'Staff Member' }}
                    </div>

                    {{-- Edit Button --}}
                    <a href="{{ route('profile.edit') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 {{ $themeColor }} {{ $themeColorHover }} text-white rounded-xl font-medium transition-all duration-200 shadow-md shadow-teal-900/10 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit Profil Saya
                    </a>
                </div>
            </div>

            {{-- Account Stats --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-5">Statistik Akun</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-slate-50 rounded-lg text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-sm text-slate-600">Bergabung</span>
                        </div>
                        <span class="text-sm font-semibold text-slate-900">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                         <div class="flex items-center gap-3">
                            <div class="p-2 bg-slate-50 rounded-lg text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-sm text-slate-600">Terakhir Login</span>
                        </div>
                        <span class="text-sm font-semibold text-slate-900">
                            {{-- Check if field exists, otherwise default --}}
                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Baru saja' }}
                        </span> 
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN (Details & Bio) --}}
        <div class="lg:col-span-8 space-y-6">
            
            {{-- Personal Info Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-8 border-b border-slate-100 pb-4">
                    <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Informasi Pribadi</h3>
                        <p class="text-sm text-slate-500">Detail kontak dan informasi departemen.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Department --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2">Departemen</label>
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </span>
                            @if($user->department)
                                <span class="font-medium text-slate-700">{{ $user->department }}</span>
                            @else
                                <span class="text-slate-400 italic text-sm">Belum diatur</span>
                            @endif
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2">No. Telepon</label>
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </span>
                            @if($user->phone)
                                <span class="font-medium text-slate-700">{{ $user->phone }}</span>
                            @else
                                <span class="text-slate-400 italic text-sm">Belum diatur</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bio Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                     <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Tentang Saya</h3>
                </div>
                
                <div class="bg-slate-50/80 rounded-xl p-6 border border-slate-100 relative">
                    {{-- Quotation Mark Decoration --}}
                    <svg class="absolute top-4 left-4 w-8 h-8 text-slate-200 opacity-50 transform -scale-x-100" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.096 14.848 14.743 16.512 13.945L16.512 4.605C10.749 5.869 9.176 9.873 9.176 13.676L3.929 13.676C3.929 8.016 7.426 2.508 14.017 1L14.017 21L14.017 21ZM21 21L21 18C21 16.096 21.831 14.743 23.495 13.945L23.495 4.605C17.732 5.869 16.159 9.873 16.159 13.676L10.912 13.676C10.912 8.016 14.409 2.508 21 1L21 21L21 21Z"></path></svg>

                    @if ($user->bio)
                        <p class="text-slate-600 leading-relaxed whitespace-pre-line relative z-10 pl-2">{{ $user->bio }}</p>
                    @else
                        <div class="text-center py-4 relative z-10">
                            <p class="text-slate-400 mb-3">Belum ada informasi bio yang ditambahkan.</p>
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center text-sm font-semibold text-[#4C8C86] hover:text-[#3D706B] transition">
                                Tambahkan bio
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection