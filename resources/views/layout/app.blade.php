<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MeetLog')</title>
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
     <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/2.1.1/trix.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/2.1.1/trix.umd.min.js"></script>
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }

        /* FullCalendar custom styles */
        .fc .fc-toolbar.fc-header-toolbar { margin-bottom: 1em; font-size: 0.9em; }
        .fc .fc-toolbar-title { font-size: 1.25em; color: #334155; }
        .fc .fc-daygrid-day.fc-day-today { background-color: #f0f9ff; }
        .fc .fc-button { background-color: #4C8C86; border-color: #4C8C86; }
        .fc .fc-button:hover { background-color: #3D706B; }

        /* Minimized Sidebar styles */
        .sidebar-minimized #sidebar { width: 5rem; }
        .sidebar-minimized #sidebar-logo, .sidebar-minimized .nav-text { display: none; }
        .sidebar-minimized #sidebar nav a { justify-content: center; }
        .sidebar-minimized #minimize-btn-icon { transform: rotate(180deg); }

        /* Modal transition */
        #newMeetModal.hidden .modal-panel { transform: scale(0.95); opacity: 0; }

        /* Custom styles for filter buttons */
        .event-filter-btn {
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem; /* rounded-md */
            font-size: 0.875rem; /* text-sm */
            font-weight: 500; /* font-medium */
            color: #475569; /* text-slate-600 */
            transition: all 0.2s ease-in-out;
        }
        .event-filter-btn.active {
            background-color: #ffffff; /* bg-white */
            color: #334155; /* text-slate-800 */
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1); /* shadow */
        }

        
    </style>
        @stack('styles')

</head>
<body class="bg-slate-50 font-sans text-slate-800 flex min-h-screen">

    {{-- Sidebar --}}
    @include('partials.sidebar')
       @include('partials.header')
        <main class="p-4 sm:p-6 flex-1 overflow-y-auto">
               @yield('content')
            {{-- <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-5 rounded-xl shadow-md flex items-center space-x-4">
                    <div class="bg-[#E5F2F1] text-[#4C8C86] p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">Rapat Bulan Ini</p>
                        <p class="text-2xl font-bold text-slate-800">8</p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-md flex items-center space-x-4">
                    <div class="bg-green-100 text-green-500 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">Acara Minggu Ini</p>
                        <p class="text-2xl font-bold text-slate-800">4</p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-md flex items-center space-x-4">
                    <div class="bg-amber-100 text-amber-500 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">Notulensi Tertunda</p>
                        <p class="text-2xl font-bold text-slate-800">2</p>
                    </div>
                </div>
                <button id="buatRapatBtn" class="bg-[#E5F2F1] border-2 border-dashed border-[#A3D1CD] p-5 rounded-xl shadow-sm flex items-center justify-center space-x-3 hover:bg-[#D4E9E7] hover:border-[#73B4AD] transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#4C8C86]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <p class="text-[#4C8C86] font-semibold">Buat Rapat Baru</p>
                </button>
            </div>

            <div class="grid grid-cols-1">
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-6">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800 mb-2">Kalender</h3>
                        <div id="calendar" class="text-xs"></div>
                    </div>
                    <hr class="my-6 border-slate-200">
                    <div>
                        <div id="event-list-header" class="mb-4 flex flex-wrap items-center justify-between gap-y-2">
                            <div>
                                <h3 id="event-list-title" class="text-lg font-semibold text-slate-800">Acara Terdekat</h3>
                                <p id="event-list-subtitle" class="text-sm text-slate-500"></p>
                            </div>
                            <div id="event-filter-buttons" class="flex items-center rounded-lg bg-slate-100 p-1">
                                <button class="event-filter-btn" data-filter="today">Hari Ini</button>
                                <button class="event-filter-btn" data-filter="3days">3 Hari</button>
                                <button class="event-filter-btn active" data-filter="7days">7 Hari</button>
                            </div>
                            <button id="back-to-upcoming" class="hidden text-sm font-semibold text-[#4C8C86] hover:text-[#2E5350]">&larr; Kembali</button>
                        </div>
                        <div id="event-list-container" class="space-y-3">
                        </div>
                    </div>
                </div>
            </div> --}}
        </main>
    </div>

    
    
    {{-- <div id="newMeetModal" class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4 transition-opacity duration-300">
        <div class="modal-panel bg-white rounded-xl shadow-2xl w-full max-w-lg transition-all duration-300 ease-in-out transform">
            <form id="newMeetForm" action="{{ route('rapat.store') }}" method="POST">
                @csrf
                <div class="flex items-center justify-between p-5 border-b">
                    <h3 class="text-xl font-semibold text-slate-800">Buat Rapat Baru</h3>
                    <button type="button" id="closeModalBtn" class="text-slate-400 hover:text-slate-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                    <div>
                        <label for="agenda" class="block text-sm font-medium text-slate-700">Agenda Rapat</label>
                        <input type="text" id="agenda" name="agenda" class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:outline-none " required>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-slate-700">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:outline-none" required>
                        </div>
                        <div>
                            <label for="jam" class="block text-sm font-medium text-slate-700">Jam</label>
                            <input type="time" id="jam" name="jam" class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:outline-none" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Undang via Email / Kelompok</label>
                        <div class="relative mt-1">
                            <div id="anggota-container" class="flex flex-wrap gap-2 items-center w-full border border-slate-300 rounded-md shadow-sm p-2">
                                <div id="anggota-tags" class="flex flex-wrap gap-1"></div>
                                <input type="text" id="anggota-search" class="flex-1 border-none  text-sm focus:outline-none" placeholder="Cari kelompok atau tambah email...">
                            </div>
                            <div id="anggota-dropdown" class="hidden absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md border max-h-40 overflow-y-auto"></div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Lokasi</label>
                        <div class="mt-2 grid grid-cols-2 gap-2 rounded-lg bg-slate-100 p-1">
                            <button type="button" id="OnlineBtn" class="location-btn bg-white text-slate-900 shadow rounded-md py-2 text-sm font-medium">Online</button>
                            <button type="button" id="OfflineBtn" class="location-btn text-slate-600 rounded-md py-2 text-sm font-medium">Offline</button>
                        </div>
                    </div>
                    <div id="OnlineFields">
                        <div class="space-y-3">
                            <fieldset class="mt-2">
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input id="attachLinkRadio" name="Online_option" type="radio" checked class="h-4 w-4 text-[#4C8C86] border-slate-300">
                                        <label for="attachLinkRadio" class="ml-3 block text-sm font-medium text-slate-700">Attach Link</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="generateZoomRadio" name="Online_option" type="radio" class="h-4 w-4 text-[#4C8C86] border-slate-300 focus:outline-none">
                                        <label for="generateZoomRadio" class="ml-3 block text-sm font-medium text-slate-700">Generate Link Zoom</label>
                                    </div>
                                </div>
                            </fieldset>
                            <div id="attachLinkContainer">
                                <label for="link" class="block text-sm font-medium text-slate-700 sr-only">Link Meeting</label>
                                <input type="url" id="link" name="link" class="block w-full rounded-md border-slate-300 focus:outline-none focus:border-[#4C8C86]" placeholder="https://meet.google.com/xyz-abcd-efg">
                            </div>
                            <div id="generateZoomContainer" class="hidden">
                                <button type="button" class="w-full flex justify-center items-center gap-2 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M15.92,10.26C15.54,9.88 15.06,9.68 14.5,9.75L12.5,10L10.5,9.75C9.94,9.68 9.46,9.88 9.08,10.26C8.7,10.64 8.5,11.12 8.5,11.67V12.25L10.5,12.5V11.75L12.5,12V14.5L14.5,14.25V12.25L16.5,11.75V11.67C16.5,11.12 16.3,10.64 15.92,10.26Z" /></svg>
                                    Generate with Zoom
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="OfflineFields" class="hidden">
                        <label for="ruangan" class="block text-sm font-medium text-slate-700">Ruangan / Tempat</label>
                        <input type="text" id="ruangan" name="ruangan" class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:outline-none" placeholder="Contoh: Ruang Rapat Lt. 3">
                    </div>
                </div>

                <div class="flex items-center justify-end p-5 border-t space-x-3">
                    <button type="button" id="cancelModalBtn" class="bg-white py-2 px-4 border border-slate-300 rounded-md shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="bg-[#4C8C86] hover:bg-[#3D706B] py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white">
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div> --}}

   {{-- Events dari controller --}}
    {{-- @isset($events)
        <script>const events = @json($events);</script>
    @endisset

    @vite('resources/js/layout.js')
    @vite('resources/js/support.js')
    @stack('scripts') --}}

    @isset($events)
    <script>const events = @json($events);</script>
@endisset

@include('partials.sweetalert')

<script src="{{ asset('js/layout.js') }}"></script>
<script src="{{ asset('js/support.js') }}"></script>

@stack('scripts')

</body>
</html>