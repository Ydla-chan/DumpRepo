@extends('layout.app')
@section('title', 'Group Management')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f1f5f9;
    }

    /* Custom Color Variables */
    :root {
        --teal-primary: #4C8C86;
        --teal-dark: #3D6F6A;
        --teal-light: #eef7f6;
        --teal-hover: #F0FDFA;
    }

    /* Utilities */
    .text-teal-main { color: var(--teal-primary); }
    .bg-teal-main { background-color: var(--teal-primary); }
    .bg-teal-light { background-color: var(--teal-light); }
    .border-teal-main { border-color: var(--teal-primary); }
    
    .hover-trigger .hover-target { visibility: hidden; opacity: 0; transition: all 0.2s; }
    .hover-trigger:hover .hover-target { visibility: visible; opacity: 1; }

    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: #94a3b8; }

    /* Checkbox Card Styling */
    .user-checkbox:checked + div {
        border-color: var(--teal-primary);
        background-color: var(--teal-light);
    }
    .user-checkbox:checked + div .check-icon {
        opacity: 1;
        transform: scale(1);
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    {{-- Header & Stats --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">Kelompok</h1>
            <p class="text-slate-500 mt-1 text-sm md:text-base">Kelola tingkat akses dan kategorikan pengguna Anda secara efektif.</p>
        </div>
        
        {{-- Quick Stats --}}
        <div class="grid grid-cols-2 gap-3 w-full md:w-auto">
            <div class="px-4 py-3 bg-white rounded-lg shadow-sm border border-slate-200 text-center md:text-left">
                <span class="block text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-wider">Kelompok</span>
                <span class="text-lg md:text-xl font-bold text-slate-700">{{ $groups->count() }}</span>
            </div>
            <div class="px-4 py-3 bg-white rounded-lg shadow-sm border border-slate-200 text-center md:text-left">
                <span class="block text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-wider">Pengguna</span>
                <span class="text-lg md:text-xl font-bold text-teal-main">{{ $users->count() }}</span>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        {{-- Toolbar --}}
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" id="table-search" class="pl-10 w-full rounded-lg border-slate-300 focus:border-teal-main focus:ring-teal-main text-sm" placeholder="Search groups...">
            </div>

            <button onclick="openAddModal()" class="w-full sm:w-auto bg-teal-main hover:bg-[#3D6F6A] text-white font-semibold py-2.5 px-5 rounded-lg shadow-md transition-all duration-200 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                <span>Buat Kelompok</span>
            </button>
        </div>

        {{-- Table (Responsive: Cards on Mobile, Table on Desktop) --}}
        <div class="overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="hidden md:table-header-group">
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                        <th class="px-6 py-4">Detail Kelompok</th>
                        <th class="px-6 py-4">Anggota Preview</th>
                        <th class="px-6 py-4 text-center">Jumlah</th>
                        <th class="px-6 py-4 text-right">aksi</th>
                    </tr>
                </thead>
                <tbody class="block md:table-row-group space-y-4 md:space-y-0 p-4 md:p-0" id="groups-table-body">
                    @forelse ($groups as $group)
                    {{-- Row behaves as Card on Mobile --}}
                    <tr class="group search-item flex flex-col md:table-row bg-white md:bg-transparent rounded-xl shadow-sm border border-slate-200 md:border-none md:shadow-none hover:bg-slate-50/80 transition-colors duration-150">
                        
                        {{-- Group Details --}}
                        <td class="px-5 py-4 md:px-6 md:border-b border-slate-100">
                            <div class="flex items-center justify-between md:justify-start gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-teal-light flex items-center justify-center text-teal-main shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 group-name">{{ $group->name }}</p>
                                        <p class="text-xs text-slate-500">Created {{ $group->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                {{-- Mobile Count Badge (Visible only on mobile) --}}
                                <span class="md:hidden inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-light text-teal-main">
                                    {{ $group->users->count() }}
                                </span>
                            </div>
                        </td>

                        {{-- Members Preview --}}
                       <td class="hidden sm:block md:table-cell px-5 py-2 md:px-6 md:py-4 md:border-b border-slate-100">
    <div class="flex items-center md:block">
        <span class="text-xs font-bold text-slate-400 uppercase mr-3 md:hidden w-24">Members:</span>
        <div class="flex -space-x-2 overflow-hidden">

            @foreach($group->users->take(4) as $member)
                @if($member->profile_photo)
                    <img 
                        src="{{ asset('storage/' . $member->profile_photo) }}"
                        alt="{{ $member->name }}"
                        class="inline-block h-8 w-8 rounded-full ring-2 ring-white object-cover bg-white"
                        title="{{ $member->name }}"
                    >
                @else
                    <div 
                        class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600"
                        title="{{ $member->name }}"
                    >
                        {{ Str::upper(substr($member->name, 0, 1)) }}
                    </div>
                @endif
            @endforeach

            @if($group->users->count() > 4)
                <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500">
                    +{{ $group->users->count() - 4 }}
                </div>
            @endif

        </div>
    </div>
</td>
                        {{-- Count (Desktop Only) --}}
                        <td class="hidden md:table-cell px-6 py-4 text-center border-b border-slate-100">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-light text-teal-main">
                                {{ $group->users->count() }} Users
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-3 border-t border-slate-100 md:border-t-0 md:px-6 md:py-4 md:text-right md:border-b border-slate-100 bg-slate-50/50 md:bg-transparent rounded-b-xl md:rounded-none">
                            <div class="flex items-center justify-between md:justify-end gap-2">
                                <span class="text-xs text-slate-400 md:hidden">Actions</span>
                                <div class="flex gap-2">
                                    <button onclick='openEditModal("{{ $group->id }}", "{{ $group->name }}", @json($group->users->pluck("id")))' 
                                        class="p-2 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>
                                    </button>
                                    <button onclick="openDeleteModal('{{ $group->id }}','{{ $group->name }}')" 
                                        class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="bg-slate-50 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-4">
                                <svg class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                            <h3 class="text-slate-900 font-medium text-lg">Tidak ada grup yang dibuat</h3>
                            <p class="text-slate-500 mt-1 max-w-sm mx-auto">Buat grup pertama Anda</p>
                            <button onclick="openAddModal()" class="mt-4 text-teal-main font-semibold hover:underline">klik disini &rarr;</button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODALS --}}

{{-- Add Modal --}}
<div id="add-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 pointer-events-none opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('add-modal')"></div>
    <div class="relative w-full max-w-xl bg-white rounded-xl sm:rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 flex flex-col max-h-[85vh] sm:max-h-[90vh]">
        
        <div class="p-4 sm:p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg sm:text-xl font-bold text-slate-800">Buat Grup Baru</h3>
            <button onclick="closeModal('add-modal')" class="text-slate-400 hover:text-slate-600"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>

        <form id="add-form" action="{{ route('groups.store') }}" method="POST" class="flex flex-col flex-grow overflow-hidden">
            @csrf
            <div class="p-4 sm:p-6 space-y-4 sm:space-y-6 overflow-y-auto custom-scrollbar">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Grup</label>
                    <input type="text" name="name" class="w-full rounded-lg border-slate-300 focus:border-teal-main focus:ring-teal-main" placeholder="e.g. Marketing Team" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Anggota</label>
                    <div class="relative mb-3">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </span>
                        <input type="text" id="add-user-search" class="pl-9 w-full rounded-lg border-slate-300 text-sm focus:border-teal-main focus:ring-teal-main" placeholder="Cari pengguna...">
                    </div>
                    
                    <div id="add-users-container" class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3 max-h-48 sm:max-h-60 overflow-y-auto custom-scrollbar p-1">
                        @foreach ($users as $user)
                        <label class="relative cursor-pointer group user-item">
                            <input type="checkbox" name="users[]" value="{{ $user->id }}" class="peer sr-only user-checkbox">
                            <div class="p-2 sm:p-3 rounded-lg border border-slate-200 hover:border-teal-main/50 hover:bg-slate-50 transition-all flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-xs font-bold shrink-0">    {{-- ✅ Bagian ini yang kamu ubah --}}
        @if($user->profile_photo)
            <img 
                src="{{ asset('storage/' . $user->profile_photo) }}"
                alt="photo"
                class="h-8 w-8 rounded-full object-cover bg-slate-200 text-slate-600 flex items-center justify-center text-xs font-bold shrink-0"
            >
        @else
            <div class="h-8 w-8 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-xs font-bold shrink-0">
                {{ strtoupper(collect(explode(' ', $user->name))->map(fn($n) => $n[0])->join('')) }}
            </div>
        @endif</div>
                                <span class="text-sm font-medium text-slate-700 truncate select-none">{{ $user->name }}</span>
                                <svg class="h-5 w-5 text-teal-main ml-auto opacity-0 transform scale-50 transition-all check-icon shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <p id="add-no-users" class="hidden text-center text-sm text-slate-500 py-4">Tidak ada pengguna ditemukan.</p>
                </div>
            </div>

            <div class="p-4 sm:p-6 border-t border-slate-100 bg-slate-50 rounded-b-xl sm:rounded-b-2xl flex justify-end gap-3">
                <button type="button" onclick="closeModal('add-modal')" class="px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg border border-slate-300 bg-white text-slate-700 font-medium hover:bg-slate-50 transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg bg-teal-main text-white font-medium hover:bg-[#3D6F6A] transition-colors shadow-sm">Buat Grup</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="edit-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 pointer-events-none opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('edit-modal')"></div>
    <div class="relative w-full max-w-xl bg-white rounded-xl sm:rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 flex flex-col max-h-[85vh] sm:max-h-[90vh]">
        
        <div class="p-4 sm:p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg sm:text-xl font-bold text-slate-800">Perbarui grup</h3>
            <button onclick="closeModal('edit-modal')" class="text-slate-400 hover:text-slate-600"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>

        <form id="edit-form" method="POST" class="flex flex-col flex-grow overflow-hidden">
            @csrf
            @method('PUT')
            <div class="p-4 sm:p-6 space-y-4 sm:space-y-6 overflow-y-auto custom-scrollbar">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Grup</label>
                    <input type="text" id="edit-group-name" name="name" class="w-full rounded-lg border-slate-300 focus:border-teal-main focus:ring-teal-main" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Kelola Anggota</label>
                    <div class="relative mb-3">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </span>
                        <input type="text" id="edit-user-search" class="pl-9 w-full rounded-lg border-slate-300 text-sm focus:border-teal-main focus:ring-teal-main" placeholder="Cari pengguna...">
                    </div>
                    
                    <div id="edit-users-container" class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3 max-h-48 sm:max-h-60 overflow-y-auto custom-scrollbar p-1">
                        @foreach ($users as $user)
                        <label class="relative cursor-pointer group user-item">
                            <input type="checkbox" name="users[]" value="{{ $user->id }}" id="edit-user-{{ $user->id }}" class="peer sr-only user-checkbox">
                            <div class="p-2 sm:p-3 rounded-lg border border-slate-200 hover:border-teal-main/50 hover:bg-slate-50 transition-all flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-xs font-bold shrink-0">
                                        {{-- ✅ Bagian ini yang kamu ubah --}}
        @if($user->profile_photo)
            <img 
                src="{{ asset('storage/' . $user->profile_photo) }}"
                alt="photo"
                class="h-8 w-8 rounded-full object-cover bg-slate-200 text-slate-600 flex items-center justify-center text-xs font-bold shrink-0"
            >
        @else
            <div class="h-8 w-8 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-xs font-bold shrink-0">
                {{ strtoupper(collect(explode(' ', $user->name))->map(fn($n) => $n[0])->join('')) }}
            </div>
        @endif
                                </div>
                                <span class="text-sm font-medium text-slate-700 truncate select-none">{{ $user->name }}</span>
                                <svg class="h-5 w-5 text-teal-main ml-auto opacity-0 transform scale-50 transition-all check-icon shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <p id="edit-no-users" class="hidden text-center text-sm text-slate-500 py-4">Tidak ada pengguna ditemukan.</p>
                </div>
            </div>

            <div class="p-4 sm:p-6 border-t border-slate-100 bg-slate-50 rounded-b-xl sm:rounded-b-2xl flex justify-end gap-3">
                <button type="button" onclick="closeModal('edit-modal')" class="px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg border border-slate-300 bg-white text-slate-700 font-medium hover:bg-slate-50 transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg bg-teal-main text-white font-medium hover:bg-[#3D6F6A] transition-colors shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Modal --}}
<div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 pointer-events-none opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('delete-modal')"></div>
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl transform transition-all duration-300 scale-95">
        <div class="p-8 text-center">
            <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full mx-auto flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Hapus Grup?</h3>
            <p class="text-slate-500 mb-6">Apakah Anda yakin ingin menghapus <strong id="delete-group-name" class="text-slate-800"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
            
            <form id="delete-form" method="POST" class="flex flex-col sm:flex-row gap-3 justify-center">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModal('delete-modal')" class="w-full sm:w-auto px-5 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-700 font-medium hover:bg-slate-50 transition-colors">Batal</button>
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 rounded-lg bg-red-600 text-white font-medium hover:bg-red-700 transition-colors shadow-sm">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // --- Helper Functions ---
    function openModal(id) {
        const modal = document.getElementById(id);
        const panel = modal.querySelector('.transform');
        modal.classList.remove('pointer-events-none', 'opacity-0');
        setTimeout(() => panel.classList.remove('scale-95'), 50);
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        const panel = modal.querySelector('.transform');
        panel.classList.add('scale-95');
        setTimeout(() => modal.classList.add('pointer-events-none', 'opacity-0'), 200);
        document.body.classList.remove('overflow-hidden');
    }

    // --- Search Logic (Generic) ---
    function setupSearch(inputId, containerId, itemClass, emptyMsgId) {
        const input = document.getElementById(inputId);
        const container = document.getElementById(containerId);
        const items = container.querySelectorAll(itemClass);
        const emptyMsg = document.getElementById(emptyMsgId);

        if(!input) return;

        input.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            let visibleCount = 0;

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                if(text.includes(term)) {
                    item.style.display = 'block'; // Or 'flex' depending on layout
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if(emptyMsg) {
                emptyMsg.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        });
    }

    // --- Add Modal ---
    function openAddModal() {
        const form = document.getElementById('add-form');
        form.reset();
        
        // Reset Search
        const searchInput = document.getElementById('add-user-search');
        if(searchInput) {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input')); 
        }

        openModal('add-modal');
    }

    // --- Edit Modal ---
    function openEditModal(id, name, userIds) {
        const form = document.getElementById('edit-form');
        form.action = `/groups/${id}`;
        document.getElementById('edit-group-name').value = name;
        
        // Reset Search
        const searchInput = document.getElementById('edit-user-search');
        if(searchInput) {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
        }

        // Reset and check boxes
        const checkboxes = form.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(cb => {
            cb.checked = userIds.includes(parseInt(cb.value));
        });

        openModal('edit-modal');
    }

    // --- Delete Modal ---
    function openDeleteModal(id, name) {
        document.getElementById('delete-form').action = `/groups/${id}`;
        document.getElementById('delete-group-name').innerText = name;
        openModal('delete-modal');
    }

    // --- Table Search Logic ---
    function setupTableSearch() {
        const input = document.getElementById('table-search');
        const rows = document.querySelectorAll('.search-item');
        
        if(!input) return;

        input.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            rows.forEach(row => {
                const name = row.querySelector('.group-name').textContent.toLowerCase();
                // Jika layout mobile (flex), gunakan display '' (kembali ke default CSS), jika tidak block/table-row
                row.style.display = name.includes(term) ? '' : 'none';
            });
        });
    }

    // --- Initialization ---
    document.addEventListener('DOMContentLoaded', () => {
        // Init Modal Searches
        setupSearch('add-user-search', 'add-users-container', '.user-item', 'add-no-users');
        setupSearch('edit-user-search', 'edit-users-container', '.user-item', 'edit-no-users');
        
        // Init Table Search
        setupTableSearch();
    });
</script>
@endpush