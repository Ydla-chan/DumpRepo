 @extends('layout.app')
@section('title', 'Rekap Rapat')

@section('content')
   <div x-data="{ activeTab: 'logbook' }" class="space-y-6">
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                    <h1 class="text-3xl font-extrabold text-slate-900 mb-4 sm:mb-0">
                        Aktivitas Proyek
                    </h1>
                    <button class="flex items-center px-4 py-2 bg-[#4C8C86] text-white rounded-lg shadow-md hover:bg-[#3D706B] transition-colors duration-200 text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Buat Entri Baru
                    </button>
                </div>


                {{-- Tab Controls --}}
                <div class="bg-white rounded-xl shadow-lg p-3">
                    <div class="flex space-x-4 border-b border-slate-200">
                        <button @click="activeTab = 'logbook'" 
                                :class="{'border-b-2 border-[#4C8C86] text-[#4C8C86] font-semibold': activeTab === 'logbook', 'text-slate-500 hover:text-slate-700': activeTab !== 'logbook'}"
                                class="px-3 py-2 text-base transition-colors duration-200 rounded-t-lg">
                            Logbook Kegiatan Harian
                        </button>
                        <button @click="activeTab = 'backlog'" 
                                :class="{'border-b-2 border-[#4C8C86] text-[#4C8C86] font-semibold': activeTab === 'backlog', 'text-slate-500 hover:text-slate-700': activeTab !== 'backlog'}"
                                class="px-3 py-2 text-base transition-colors duration-200 rounded-t-lg">
                            Backlog / Task Pending
                        </button>
                    </div>

                    {{-- Logbook Content --}}
                    <div x-show="activeTab === 'logbook'" class="mt-4 py-2 px-2">
                        <h3 class="text-xl font-bold text-slate-700 mb-6 border-b pb-2">Timeline Aktivitas Terbaru</h3>
                        
                        <div class="space-y-8">
                            
                            <!-- Log Item 1 -->
                            <div class="timeline-item">
                                <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-slate-100">
                                    <p class="text-xs text-slate-500 mb-1">25 November 2025, 09:30 AM</p>
                                    <h4 class="font-bold text-lg text-slate-800">Rapat Koordinasi Fitur Backlog</h4>
                                    <p class="text-sm text-slate-600 mt-1">
                                        Menyelesaikan desain UI/UX untuk tampilan Logbook dan Backlog. Memastikan integrasi data Firestore untuk sinkronisasi *real-time*.
                                    </p>
                                    <div class="mt-2 flex items-center space-x-3 text-sm">
                                        <span class="inline-flex items-center rounded-full bg-indigo-100 px-2 py-0.5 text-indigo-700 font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                            Rapat Internal
                                        </span>
                                        <span class="text-slate-500">Oleh: Jane Doe</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Log Item 2 -->
                            <div class="timeline-item">
                                <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-slate-100">
                                    <p class="text-xs text-slate-500 mb-1">24 November 2025, 14:00 PM</p>
                                    <h4 class="font-bold text-lg text-slate-800">Penyelesaian Modul Autentikasi</h4>
                                    <p class="text-sm text-slate-600 mt-1">
                                        Memperbaiki *bug* pada *form* *login* dan mengimplementasikan fitur "Lupa Password" menggunakan Firebase Authentication.
                                    </p>
                                    <div class="mt-2 flex items-center space-x-3 text-sm">
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-green-700 font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                            Development
                                        </span>
                                        <span class="text-slate-500">Oleh: John Doe</span>
                                    </div>
                                </div>
                            </div>

                             <!-- Log Item 3 -->
                            <div class="timeline-item">
                                <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-slate-100">
                                    <p class="text-xs text-slate-500 mb-1">23 November 2025, 10:00 AM</p>
                                    <h4 class="font-bold text-lg text-slate-800">Review *Project Proposal*</h4>
                                    <p class="text-sm text-slate-600 mt-1">
                                        Membaca dan memberikan umpan balik pada *project proposal* MeetLog versi 2.0. Fokus pada skalabilitas database.
                                    </p>
                                    <div class="mt-2 flex items-center space-x-3 text-sm">
                                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-yellow-700 font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 6h12a1 1 0 110 2H4a1 1 0 010-2zm.293 4.707a1 1 0 001.414 0L8 8.414V16a1 1 0 102 0V8.414l2.293 2.293a1 1 0 001.414-1.414l-4-4a1 1 0 00-1.414 0l-4 4a1 1 0 000 1.414z" /></svg>
                                            Administrasi
                                        </span>
                                        <span class="text-slate-500">Oleh: Admin</span>
                                    </div>
                                </div>
                            </div>

                            <p class="text-center text-slate-500 text-sm italic py-4">-- Akhir dari Logbook --</p>
                            
                        </div>
                    </div>

                    {{-- Backlog Content --}}
                    <div x-show="activeTab === 'backlog'" class="mt-4 py-2 px-2">
                        <h3 class="text-xl font-bold text-slate-700 mb-6 border-b pb-2">Daftar Task & Meeting yang Belum Selesai</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Backlog Item 1 -->
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-semibold text-lg text-red-800">Perlu Review: Notulensi Rapat Klien</h4>
                                    <span class="text-xs font-semibold text-white bg-red-500 px-2 py-0.5 rounded-full">Urgent</span>
                                </div>
                                <p class="text-sm text-red-700 mt-1 mb-3">
                                    Pastikan semua poin tindakan dari rapat 20/11 telah dicatat dan ditugaskan kepada anggota tim yang relevan.
                                </p>
                                <div class="flex justify-between items-center text-xs text-slate-600">
                                    <span>Deadline: **26 Nov 2025**</span>
                                    <button class="text-sm font-medium text-[#4C8C86] hover:text-[#3D706B]">Lihat Detail</button>
                                </div>
                            </div>

                            <!-- Backlog Item 2 -->
                            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-lg shadow-md">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-semibold text-lg text-amber-800">Pembuatan Template Laporan Bulanan</h4>
                                    <span class="text-xs font-semibold text-white bg-amber-500 px-2 py-0.5 rounded-full">High</span>
                                </div>
                                <p class="text-sm text-amber-700 mt-1 mb-3">
                                    Buat template baru untuk laporan aktivitas proyek bulanan, siap digunakan per 1 Desember.
                                </p>
                                <div class="flex justify-between items-center text-xs text-slate-600">
                                    <span>Deadline: **30 Nov 2025**</span>
                                    <button class="text-sm font-medium text-[#4C8C86] hover:text-[#3D706B]">Selesaikan</button>
                                </div>
                            </div>
                            
                            <!-- Backlog Item 3 -->
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg shadow-md">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-semibold text-lg text-blue-800">Jadwalkan Sesi Brainstorming Fitur Baru</h4>
                                    <span class="text-xs font-semibold text-white bg-blue-500 px-2 py-0.5 rounded-full">Medium</span>
                                </div>
                                <p class="text-sm text-blue-700 mt-1 mb-3">
                                    Cari waktu yang tepat untuk sesi *brainstorming* tentang integrasi Slack/Teams. Undang tim inti.
                                </p>
                                <div class="flex justify-between items-center text-xs text-slate-600">
                                    <span>Deadline: **7 Des 2025**</span>
                                    <button class="text-sm font-medium text-[#4C8C86] hover:text-[#3D706B]">Jadwalkan</button>
                                </div>
                            </div>

                            <!-- Backlog Item 4 -->
                            <div class="bg-gray-50 border-l-4 border-gray-400 p-4 rounded-lg shadow-md">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-semibold text-lg text-gray-800">Update Dokumentasi API</h4>
                                    <span class="text-xs font-semibold text-white bg-gray-500 px-2 py-0.5 rounded-full">Low</span>
                                </div>
                                <p class="text-sm text-gray-700 mt-1 mb-3">
                                    Pastikan dokumentasi API sinkron dengan perubahan terbaru pada *endpoint* `/meetings`.
                                </p>
                                <div class="flex justify-between items-center text-xs text-slate-600">
                                    <span>Deadline: **15 Des 2025**</span>
                                    <button class="text-sm font-medium text-[#4C8C86] hover:text-[#3D706B]">Selesaikan</button>
                                </div>
                            </div>
                        </div>

                         <div class="text-center pt-8">
                            <button class="text-sm font-medium text-slate-500 hover:text-slate-700 underline">Muat Task Lebih Lama...</button>
                        </div>
                    </div>
                </div>
            </div>
    
            @endsection
