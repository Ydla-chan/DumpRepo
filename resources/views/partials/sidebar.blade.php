    <aside id="sidebar" class="bg-white shadow-lg flex flex-col fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 z-50 transition-all duration-300 ease-in-out w-64">
        <div class="p-4 border border-slate-100 flex items-center justify-between h-16 shrink-0">
            <h1 id="sidebar-logo" class="text-2xl font-bold text-[#4C8C86] transition-all">MeetLog</h1>
            <button id="minimizeSidebarBtn" class="hidden md:block text-slate-500 hover:text-slate-800">
                <svg id="minimize-btn-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button id="closeSidebar" class="md:hidden text-slate-500 hover:text-slate-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
     <nav class="flex-1 p-4 space-y-2">
    <!-- Dashboard -->
    <a href="/dashboard"
       class="flex items-center space-x-3 p-2 rounded-lg transition-colors duration-200
       {{ Request::is('dashboard') ? 'bg-[#E5F2F1] text-[#4C8C86] font-semibold' : 'text-slate-600 hover:bg-[#E5F2F1] hover:text-[#3D706B]' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
        </svg>
        <span class="nav-text">Dashboard</span>
    </a>

    <!-- Rekap Rapat -->
    <a href="/rapatrekap"
       class="flex items-center space-x-3 p-2 rounded-lg transition-colors duration-200
       {{ Request::is('rapatrekap*') ? 'bg-[#E5F2F1] text-[#4C8C86] font-semibold' : 'text-slate-600 hover:bg-[#E5F2F1] hover:text-[#3D706B]' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
        </svg>
        <span class="nav-text">Rekap Rapat</span>
    </a>

    <!-- Rekap Notulensi -->
    <a href="/notulen/select"
       class="flex items-center space-x-3 p-2 rounded-lg transition-colors duration-200
       {{ Request::is('viewnotuleen*') ? 'bg-[#E5F2F1] text-[#4C8C86] font-semibold' : 'text-slate-600 hover:bg-[#E5F2F1] hover:text-[#3D706B]' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
        </svg>
        <span class="nav-text">Rekap Notulensi</span>
    </a>

    
    <!-- Rekap Notulensi -->
    <a href="/backlogs"
    class="flex items-center space-x-3 p-2 rounded-lg transition-colors duration-200
    {{ Request::is('backlogs*') ? 'bg-[#E5F2F1] text-[#4C8C86] font-semibold' : 'text-slate-600 hover:bg-[#E5F2F1] hover:text-[#3D706B]' }}">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
    </svg>
    <span class="nav-text">Backlog</span>
</a>
{{-- Menu khusus admin --}}
@if(Auth::check() && Auth::user()->role === 'admin')
    <a href="/groups"
       class="flex items-center space-x-3 p-2 rounded-lg transition-colors duration-200
       {{ Request::is('groups*') ? 'bg-[#E5F2F1] text-[#4C8C86] font-semibold' : 'text-slate-600 hover:bg-[#E5F2F1] hover:text-[#3D706B]' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 
                     2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 
                     3.5V20h14v-3.5C15 14.17 10.33 13 8 13zm8 
                     0c-.29 0-.62.02-.97.05 1.16.84 1.97 2.07 
                     1.97 3.45V20h6v-3.5c0-2.33-4.67-3.5-7-3.5z"/>
        </svg>
        <span class="nav-text">User Management</span>
    </a>
@endif
</nav>

    </aside>
