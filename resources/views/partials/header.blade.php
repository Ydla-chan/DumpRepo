   <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out">
        <header class="flex items-center justify-between bg-white/80 backdrop-blur-sm shadow-sm px-6 py-3 sticky top-0 z-40 h-16">
            <div class="flex items-center space-x-4">
                <button id="openSidebar" class="text-slate-600 md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
            <div class="flex items-center space-x-6">
                <button class="relative text-slate-500 hover:text-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center text-xs font-bold text-white bg-red-500 rounded-full">3</span>
                </button>
                <div class="relative">
                    <button id="profileBtn" class="flex items-center space-x-2">
                        <img src="https://i.pravatar.cc/32?u=user-xyz" alt="Profile" class="w-9 h-9 rounded-full ring-2 ring-offset-2 ring-[#A3D1CD]">
                        <span class="font-medium hidden sm:inline text-slate-700">   {{ Auth::user()->name }}</span>
                    </button>
                    <div id="profileMenu" class="hidden absolute right-0 mt-3 w-48 bg-white shadow-xl rounded-lg overflow-hidden z-50 border border-slate-100">
  <a href="#" class="block px-4 py-2 text-sm  border border-slate-100 text-slate-700 hover:bg-slate-100">
    Ubah Data Diri
  </a>
  
  <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100">
    @csrf
    <button type="submit" class="block w-full border border-slate-100   text-left px-4 py-2 text-sm text-red-600 hover:bg-slate-100">
      Keluar
    </button>
  </form>
</div>    </div>
            </div>
        </header>
