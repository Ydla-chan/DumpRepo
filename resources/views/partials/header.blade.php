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
               
                <div class="relative">
                 <button id="profileBtn" class="flex items-center space-x-2">
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

    <span class="font-medium hidden sm:inline text-slate-700">
        {{ Auth::user()->name }}
    </span>
</button>
                    <div id="profileMenu" class="hidden absolute right-0 mt-3 w-48 bg-white shadow-xl rounded-lg overflow-hidden z-50 border border-slate-100">
  <a href={{ route('profile.show') }} class="block px-4 py-2 text-sm  border border-slate-100 text-slate-700 hover:bg-slate-100">
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
