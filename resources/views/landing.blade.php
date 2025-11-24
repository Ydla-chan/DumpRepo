<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MeetLog — Solusi Rapat Cerdas</title>
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          colors: {
            brand: {
              DEFAULT: '#4C8C86', // Warna Asli Anda
              dark: '#407872',    // Warna Hover Asli
              light: '#d5e7e6',   // Warna Aksen Ringan
              bg: '#eaf3f2',      // Warna Background
            }
          },
          animation: {
            'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
          },
          keyframes: {
            fadeInUp: {
              'from': { opacity: '0', transform: 'translateY(20px)' },
              'to': { opacity: '1', transform: 'translateY(0)' },
            }
          }
        }
      }
    }
  </script>

  <style>
    /* Custom CSS untuk Link Underline Animation (Sesuai kode asli) */
    .link-underline {
      position: relative;
      text-decoration: none;
    }
    .link-underline::after {
      content: '';
      position: absolute;
      width: 100%;
      transform: scaleX(0);
      height: 2px;
      bottom: -4px;
      left: 0;
      background-color: #4C8C86;
      transform-origin: bottom right;
      transition: transform 0.25s ease-out;
    }
    .link-underline:hover::after {
      transform: scaleX(1);
      transform-origin: bottom left;
    }
    
    /* Utility untuk delay animasi */
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

  <nav x-data="{ open: false, scrolled: false }" 
       @scroll.window="scrolled = (window.scrollY > 10)"
       :class="{ 'bg-white/90 backdrop-blur-md shadow-sm': scrolled, 'bg-transparent': !scrolled }"
       class="fixed w-full top-0 left-0 z-50 transition-all duration-300 py-2">
       
       <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
           <div class="flex items-center justify-between h-16">
               
               <a href="#" class="text-2xl font-extrabold text-brand tracking-tight">
                   MeetLog
               </a>

               <div class="hidden md:flex items-center space-x-8">
                   <a href="#features" class="link-underline text-gray-600 font-medium hover:text-brand transition duration-300">Fitur</a>
                   <a href="#about" class="link-underline text-gray-600 font-medium hover:text-brand transition duration-300">Tentang</a>
                   <a href="#pricing" class="link-underline text-gray-600 font-medium hover:text-brand transition duration-300">Harga</a>
                   
                   <div class="flex items-center gap-4 pl-4">
                     <a href="/login" class="text-gray-600 font-semibold hover:text-brand transition">Masuk</a>
                     <a href="/register" class="px-6 py-2.5 bg-brand text-white rounded-lg shadow hover:bg-brand-dark hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-semibold">
                         Daftar Gratis
                     </a>
                   </div>
               </div>

               <div class="md:hidden flex items-center">
                   <button @click="open = !open" class="p-2 rounded-md text-gray-600 hover:bg-gray-100 focus:outline-none">
                       <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                       </svg>
                   </button>
               </div>
           </div>
       </div>

       <div x-show="open" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            @click.away="open = false" 
            class="md:hidden absolute top-full left-0 w-full bg-white border-b border-gray-100 shadow-lg" style="display: none;">
           <div class="px-4 py-6 space-y-4">
               <a href="#features" @click="open = false" class="block font-medium text-gray-700 hover:text-brand">Fitur</a>
               <a href="#about" @click="open = false" class="block font-medium text-gray-700 hover:text-brand">Tentang</a>
               <a href="#pricing" @click="open = false" class="block font-medium text-gray-700 hover:text-brand">Harga</a>
               <div class="pt-4 border-t border-gray-100 flex flex-col gap-3">
                   <a href="/register" class="w-full py-3 bg-brand text-white rounded-lg text-center font-bold shadow-md">Daftar Gratis</a>
               </div>
           </div>
       </div>
  </nav>

  <main>
    <section class="relative min-h-screen flex items-center bg-gradient-to-br from-brand-bg via-white to-brand-light pt-20">
      <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
        
        <div class="text-center md:text-left opacity-0 animate-fade-in-up">
          <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight text-gray-900">
            Solusi Pintar Mengelola <br>
            <span class="text-brand">Rapat Tanpa Ribet</span>
          </h1>
          <p class="mt-6 text-lg text-gray-600 leading-relaxed opacity-0 animate-fade-in-up delay-100">
            MeetLog membantu tim Anda mengelola jadwal, notulen, dan tugas dengan efisien. Tingkatkan produktivitas kerja dengan satu platform terpadu.
          </p>
          <div class="mt-8 flex flex-col sm:flex-row justify-center md:justify-start gap-4 opacity-0 animate-fade-in-up delay-200">
            <a href="/register" class="px-8 py-3.5 bg-brand text-white font-bold rounded-lg shadow-lg hover:bg-brand-dark transform hover:scale-105 transition-all duration-300">Mulai Coba Gratis</a>
            <a href="#features" class="px-8 py-3.5 border-2 border-brand text-brand font-bold rounded-lg hover:bg-brand-light transition duration-300">Pelajari Fitur</a>
          </div>
        </div>

        <div class="hidden md:flex justify-center relative opacity-0 animate-fade-in-up delay-300">
          <div class="absolute inset-0 bg-brand-light rounded-full blur-3xl opacity-60 scale-75 translate-y-4"></div>
          <img src="https://illustrations.popsy.co/gray/remote-work.svg" alt="Ilustrasi Tim Bekerja" class="relative w-full max-w-md z-10 drop-shadow-xl">
        </div>

      </div>
    </section>

    <section id="features" class="py-24 bg-white">
      <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-base font-bold text-brand uppercase tracking-wide mb-2">Fitur Unggulan</h2>
        <h3 class="text-3xl md:text-4xl font-bold text-gray-900">Semua yang Anda Butuhkan</h3>
        <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Dari penjadwalan hingga tindak lanjut, MeetLog menyederhanakan setiap langkah proses rapat Anda.</p>
        
        <div class="mt-16 grid md:grid-cols-3 gap-8">
          
          <div class="group bg-white p-8 rounded-2xl shadow-md border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-14 h-14 rounded-xl bg-brand-light flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
              <svg class="w-7 h-7 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h4 class="text-xl font-bold text-gray-900 mb-3">Manajemen Jadwal</h4>
            <p class="text-gray-600 leading-relaxed">Atur rapat online atau offline dengan kalender terintegrasi. Kirim undangan otomatis dan hindari bentrok jadwal.</p>
          </div>
          
          <div class="group bg-white p-8 rounded-2xl shadow-md border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-14 h-14 rounded-xl bg-brand-light flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
              <svg class="w-7 h-7 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h4 class="text-xl font-bold text-gray-900 mb-3">Notulen Digital</h4>
            <p class="text-gray-600 leading-relaxed">Simpan catatan rapat, poin keputusan, dan item tindak lanjut secara rapi. Mudah diakses oleh semua peserta.</p>
          </div>

          <div class="group bg-white p-8 rounded-2xl shadow-md border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-14 h-14 rounded-xl bg-brand-light flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
              <svg class="w-7 h-7 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
            <h4 class="text-xl font-bold text-gray-900 mb-3">Monitoring Tugas</h4>
            <p class="text-gray-600 leading-relaxed">Pantau progres setiap tugas yang dihasilkan dari rapat. Pastikan semua orang bertanggung jawab.</p>
          </div>

        </div>
      </div>
    </section>
    
    <section id="about" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
            <div class="order-2 md:order-1">
                <div class="relative">
                    <div class="absolute -inset-4 bg-brand-light rounded-2xl transform rotate-3"></div>
                    <img src="https://illustrations.popsy.co/gray/success.svg" alt="Tim Sukses" class="relative w-full bg-white rounded-xl shadow-lg p-4">
                </div>
            </div>
            <div class="order-1 md:order-2 text-center md:text-left">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Misi Kami Adalah <span class="text-brand">Produktivitas Anda</span></h2>
                <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                    MeetLog dibangun dari keyakinan bahwa rapat yang baik adalah kunci kesuksesan tim. Kami menyediakan alat yang intuitif untuk menghilangkan kerumitan administratif.
                </p>
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    Fokuslah pada diskusi penting, inovasi, dan strategi. Biarkan sistem kami yang menangani pencatatan dan pengingat.
                </p>
                <a href="#pricing" class="inline-block px-8 py-3 bg-white border-2 border-brand text-brand font-bold rounded-lg shadow hover:bg-brand hover:text-white transition duration-300">Lihat Paket Harga</a>
            </div>
        </div>
    </section>

    <section id="pricing" class="py-24 bg-brand-bg">
      <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Paket Harga Fleksibel</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-16">Pilih paket yang paling sesuai dengan kebutuhan dan skala tim Anda.</p>
        
        <div class="max-w-5xl mx-auto grid md:grid-cols-3 gap-8 items-start">

          <div class="bg-white rounded-2xl shadow-lg p-8 text-left transition-all hover:shadow-xl">
            <h3 class="text-xl font-bold text-gray-900">Gratis</h3>
            <p class="text-gray-500 mt-1 text-sm">Untuk tim kecil & personal.</p>
            <div class="my-6">
                <span class="text-4xl font-extrabold text-gray-900">Rp 0</span>
            </div>
            <a href="/register" class="block w-full py-3 px-4 border-2 border-brand text-brand font-bold text-center rounded-lg hover:bg-brand-light transition mb-8">Mulai Sekarang</a>
            <ul class="space-y-4 text-gray-600">
              <li class="flex items-center"><svg class="w-5 h-5 text-brand mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>3 Pengguna</li>
              <li class="flex items-center"><svg class="w-5 h-5 text-brand mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>5 Rapat per Bulan</li>
              <li class="flex items-center"><svg class="w-5 h-5 text-brand mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Notulen Dasar</li>
            </ul>
          </div>

          <div class="bg-white rounded-2xl shadow-2xl p-8 text-left relative transform md:-translate-y-4 border-2 border-brand">
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-yellow-400 text-gray-900 text-xs font-bold px-4 py-1 rounded-full uppercase tracking-wider">Paling Populer</div>
            <h3 class="text-xl font-bold text-brand">Pro</h3>
            <p class="text-gray-500 mt-1 text-sm">Untuk tim yang berkembang.</p>
            <div class="my-6">
                <span class="text-4xl font-extrabold text-gray-900">Rp 149rb</span>
                <span class="text-gray-500 font-medium">/bln</span>
            </div>
            <a href="/register" class="block w-full py-3 px-4 bg-brand text-white font-bold text-center rounded-lg shadow hover:bg-brand-dark transition mb-8">Pilih Paket Pro</a>
            <ul class="space-y-4 text-gray-700 font-medium">
              <li class="flex items-center"><svg class="w-5 h-5 text-brand mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Hingga 25 Pengguna</li>
              <li class="flex items-center"><svg class="w-5 h-5 text-brand mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Rapat Tak Terbatas</li>
              <li class="flex items-center"><svg class="w-5 h-5 text-brand mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Notulen & Ringkasan AI</li>
              <li class="flex items-center"><svg class="w-5 h-5 text-brand mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Monitoring Tugas Lanjutan</li>
            </ul>
          </div>

          <div class="bg-white rounded-2xl shadow-lg p-8 text-left transition-all hover:shadow-xl">
            <h3 class="text-xl font-bold text-gray-900">Enterprise</h3>
            <p class="text-gray-500 mt-1 text-sm">Solusi perusahaan besar.</p>
            <div class="my-6">
                <span class="text-4xl font-extrabold text-gray-900">Kustom</span>
            </div>
            <a href="#footer" class="block w-full py-3 px-4 border-2 border-gray-200 text-gray-600 font-bold text-center rounded-lg hover:border-brand hover:text-brand transition mb-8">Hubungi Kami</a>
            <ul class="space-y-4 text-gray-600">
              <li class="flex items-center"><svg class="w-5 h-5 text-brand mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Pengguna Tak Terbatas</li>
              <li class="flex items-center"><svg class="w-5 h-5 text-brand mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Dukungan Prioritas 24/7</li>
              <li class="flex items-center"><svg class="w-5 h-5 text-brand mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Keamanan & SLA Kustom</li>
            </ul>
          </div>

        </div>
      </div>
    </section>

    <section class="py-20 bg-gradient-to-r from-brand to-brand-dark text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap Meningkatkan Produktivitas Tim?</h2>
        <p class="text-lg opacity-90 mb-8 max-w-2xl mx-auto">Bergabunglah dengan ribuan tim yang sudah merasakan kemudahan manajemen rapat bersama MeetLog.</p>
        <a href="/register" class="inline-block px-10 py-4 bg-white text-brand font-bold rounded-lg shadow-xl hover:bg-gray-50 transform hover:scale-105 transition-all duration-300">Coba Gratis Selama 14 Hari</a>
      </div>
    </section>

  </main>

  <footer id="footer" class="bg-gray-900 text-gray-400 border-t border-gray-800">
    <div class="max-w-7xl mx-auto py-16 px-6 grid grid-cols-1 md:grid-cols-4 gap-12">
      <div class="md:col-span-1">
        <h3 class="text-2xl font-extrabold text-white tracking-tight">MeetLog</h3>
        <p class="mt-4 text-sm leading-relaxed">Platform pintar untuk manajemen rapat yang efisien, teratur, dan kolaboratif.</p>
      </div>
      <div>
        <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Produk</h4>
        <ul class="space-y-3 text-sm">
          <li><a href="#features" class="hover:text-brand transition">Fitur</a></li>
          <li><a href="#pricing" class="hover:text-brand transition">Harga</a></li>
          <li><a href="#" class="hover:text-brand transition">Keamanan</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Perusahaan</h4>
        <ul class="space-y-3 text-sm">
          <li><a href="#about" class="hover:text-brand transition">Tentang Kami</a></li>
          <li><a href="#" class="hover:text-brand transition">Karir</a></li>
          <li><a href="#" class="hover:text-brand transition">Kontak</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Legal</h4>
        <ul class="space-y-3 text-sm">
          <li><a href="#" class="hover:text-brand transition">Kebijakan Privasi</a></li>
          <li><a href="#" class="hover:text-brand transition">Syarat & Ketentuan</a></li>
        </ul>
      </div>
    </div>
    <div class="bg-gray-950 py-6 border-t border-gray-800">
      <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-sm">
        <p>&copy; 2025 MeetLog By Polibatam. Semua Hak Dilindungi.</p>
        <div class="flex space-x-6 mt-4 md:mt-0">
            <a href="#" class="hover:text-white transition"><span class="sr-only">Twitter</span>Twitter</a>
            <a href="#" class="hover:text-white transition"><span class="sr-only">LinkedIn</span>LinkedIn</a>
        </div>
      </div>
    </div>
  </footer>

</body>
</html>