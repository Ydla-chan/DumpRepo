<aside id="sidebar" class="bg-white border-r border-slate-100 flex flex-col fixed md:static inset-y-0 left-0 z-50 w-72 h-screen transition-transform duration-300 -translate-x-full md:translate-x-0 font-sans">
    
    {{-- 1. HEADER: BRANDING --}}
    <div class="h-20 flex items-center px-8 border-b border-slate-50 shrink-0"> {{-- shrink-0 ditambahkan agar header tidak mengecil --}}
        <div class="flex items-center gap-3">
            {{-- Logo Icon --}}
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#4C8C86] to-[#2E5350] flex items-center justify-center text-white shadow-lg shadow-[#4C8C86]/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
            </div>
            {{-- Logo Text --}}
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight leading-none">MeetLog</h1>
            </div>
        </div>

        {{-- Mobile Close Button --}}
        <button id="closeSidebar" class="md:hidden ml-auto text-slate-400 hover:text-slate-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>

    {{-- 2. NAVIGATION MENU --}}
    {{-- PERUBAHAN DI SINI: ganti 'overflow-y-auto' menjadi 'overflow-hidden' --}}
    <div class="flex-1 overflow-hidden py-6 px-3 space-y-8">
        
        {{-- Section: Main Menu --}}
        <div>
            <h3 class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Main Menu</h3>
            <div class="space-y-1">
                {{-- Dashboard --}}
                <a href="/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
                   {{ Request::is('dashboard') 
                      ? 'bg-[#4C8C86] text-white shadow-md shadow-[#4C8C86]/25' 
                      : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 {{ Request::is('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-[#4C8C86]' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>

                {{-- Rekap Rapat --}}
                <a href="/rapatrekap" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
                   {{ Request::is('rapatrekap*') 
                      ? 'bg-[#4C8C86] text-white shadow-md shadow-[#4C8C86]/25' 
                      : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 {{ Request::is('rapatrekap*') ? 'text-white' : 'text-slate-400 group-hover:text-[#4C8C86]' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium text-sm">Jadwal Rapat</span>
                </a>
            </div>
        </div>

        {{-- Section: Management --}}
        <div>
            <h3 class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Management</h3>
            <div class="space-y-1">
                {{-- Arsip Notulensi --}}
                <a href="/notulen/select" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
                   {{ Request::is('viewnotuleen*') || Request::is('notulen*')
                      ? 'bg-[#4C8C86] text-white shadow-md shadow-[#4C8C86]/25' 
                      : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 {{ Request::is('viewnotuleen*') || Request::is('notulen*') ? 'text-white' : 'text-slate-400 group-hover:text-[#4C8C86]' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="font-medium text-sm">Arsip Notulensi</span>
                </a>

                {{-- Backlog (With Badge) --}}
                <a href="/backlogs" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
                   {{ Request::is('backlogs*') 
                      ? 'bg-[#4C8C86] text-white shadow-md shadow-[#4C8C86]/25' 
                      : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 {{ Request::is('backlogs*') ? 'text-white' : 'text-slate-400 group-hover:text-[#4C8C86]' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <span class="font-medium text-sm flex-1">Backlog Tugas</span>
                    
                 
                </a>
            </div>
        </div>

        {{-- Section: Admin --}}
        @if(Auth::check() && Auth::user()->role === 'admin')
        <div>
            <h3 class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Administrator</h3>
            <div class="space-y-1">
                <a href="/groups" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group relative
                   {{ Request::is('groups*') 
                      ? 'bg-[#4C8C86] text-white shadow-md shadow-[#4C8C86]/25' 
                      : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 {{ Request::is('groups*') ? 'text-white' : 'text-slate-400 group-hover:text-[#4C8C86]' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="font-medium text-sm">Kelola Users & Groups</span>
                </a>
            </div>
        </div>
        @endif

    </div>

    {{-- 3. PROFILE CARD (FLOATING AT BOTTOM) --}}
    @if(Auth::check())
    <div class="p-4 border-t border-slate-50 shrink-0"> {{-- shrink-0 ditambahkan agar profil tidak terjepit --}}
        <div class="bg-slate-50 rounded-xl p-3 flex items-center gap-3 cursor-pointer hover:bg-slate-100 transition-colors border border-slate-100" onclick="document.getElementById('logout-form').submit();">
            <div class="relative">
                <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[#4C8C86] font-bold shadow-sm">
                  @if(Auth::user()->profile_photo)
        <img 
            src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
            alt="Profile"
            class="w-9 h-9 rounded-full ring-2 ring-offset-2 ring-[#A3D1CD]"
        >
    @else
        <div class="w-9 h-9 flex items-center justify-center rounded-full ring-2 ring-offset-2 ring-[#A3D1CD] bg-[#A3D1CD] text-slate-700 font-semibold">
            {{ strtoupper(collect(explode(' ', Auth::user()->name))->map(fn($n) => $n[0])->join('')) }}
        </div>
    @endif

                </div>
                {{-- Online Indicator --}}
                <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
            </div>
            
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-700 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-400 truncate">Tekan untuk keluar</p>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-300 hover:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
    </div>
    @endif
</aside>