<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MeetLog </title>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    html { scroll-behavior: smooth; }
    /* Animasi sederhana untuk fade-in */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .fade-in-up {
      animation: fadeInUp 0.8s ease-out forwards;
      opacity: 0; /* Mulai dari transparan */
    }
    /* Menerapkan animasi dengan delay berbeda untuk efek berurutan */
    .delay-1 { animation-delay: 0.2s; }
    .delay-2 { animation-delay: 0.4s; }
    .delay-3 { animation-delay: 0.6s; }

     @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
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
  </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

 <nav x-data="{ open: false, scrolled: false }" 
         @scroll.window="scrolled = (window.scrollY > 10)"
         x-init="scrolled = (window.scrollY > 10)"
         class="fixed w-full top-0 left-0 z-50 transition-all duration-300"
         :class="{ 'bg-white shadow-md': scrolled, 'bg-transparent': !scrolled }">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo -->
                <a href="#" class="text-2xl font-extrabold text-[#4C8C86]">
                    MeetLog
                </a>

                <!-- Menu + Button di kanan -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="#features" class="link-underline text-gray-700 font-medium transition duration-300">Fitur</a>
                    <a href="#about" class="link-underline text-gray-700 font-medium transition duration-300">Tentang</a>
                    <a href="#pricing" class="link-underline text-gray-700 font-medium transition duration-300">Harga</a>
                    <a href="/register" class="px-5 py-2.5 bg-[#4C8C86] text-white rounded-lg shadow-sm hover:bg-[#407872] hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-semibold">
                        Daftar Gratis
                    </a>
                </div>

                <!-- Mobile Button -->
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             @click.away="open = false" 
             class="md:hidden absolute top-0 inset-x-0 p-2 transition transform origin-top" 
             style="display: none;">
            
            <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
                <div class="pt-5 pb-6 px-5">
                    <div class="flex items-center justify-between">
                        <a href="#" class="text-2xl font-extrabold text-[#4C8C86]">MeetLog</a>
                        <button @click="open = false" type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-6">
                        <nav class="grid gap-y-4">
                            <a href="#features" @click="open = false" class="p-3 rounded-md hover:bg-gray-50 font-medium">Fitur</a>
                            <a href="#about" @click="open = false" class="p-3 rounded-md hover:bg-gray-50 font-medium">Tentang</a>
                            <a href="#pricing" @click="open = false" class="p-3 rounded-md hover:bg-gray-50 font-medium">Harga</a>
                            <a href="/register" @click="open = false" class="p-3 bg-[#4C8C86] text-white rounded-md hover:bg-[#407872] text-center font-semibold">Daftar Gratis</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </nav>


  <main>
    <section class="min-h-screen flex items-center bg-gradient-to-br from-[#eaf3f2] via-white to-[#d5e7e6]">
      <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center pt-20 md:pt-0">
        <div class="text-center md:text-left">
          <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight text-gray-900 fade-in-up">
            Solusi Pintar untuk Mengelola Rapat Tanpa Ribet
          </h1>
          <p class="mt-6 text-lg text-gray-600 fade-in-up delay-1">
            MeetLog membantu tim Anda mengelola jadwal, notulen, dan tugas dengan efisien. Tingkatkan produktivitas kerja dengan satu platform terpadu.
          </p>
          <div class="mt-8 flex flex-col sm:flex-row justify-center md:justify-start gap-4 fade-in-up delay-2">
            <a href="/register" class="px-8 py-3 bg-[#4C8C86] text-white font-semibold rounded-lg shadow-lg hover:bg-[#407872] transform hover:scale-105 transition-all duration-300">Mulai Coba Gratis</a>
            <a href="#features" class="px-8 py-3 border border-[#4C8C86] text-[#4C8C86] font-semibold rounded-lg hover:bg-[#d5e7e6] transition duration-300">Pelajari Fitur</a>
          </div>
        </div>
        <div class="hidden md:flex justify-center fade-in-up delay-3">
          <img src="https://illustrations.popsy.co/gray/remote-work.svg" alt="Ilustrasi Tim Bekerja" class="w-full max-w-md">
        </div>
      </div>
    </section>

    <section id="features" class="py-20">
      <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Semua yang Anda Butuhkan</h2>
        <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">Dari penjadwalan hingga tindak lanjut, MeetLog menyederhanakan setiap langkah.</p>
        <div class="mt-14 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          
          <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-[#d5e7e6] mx-auto mb-6">
              <svg class="w-8 h-8 text-[#4C8C86]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900">Manajemen Jadwal</h3>
            <p class="mt-2 text-gray-600 flex-grow">Atur rapat online atau offline dengan kalender terintegrasi, kirim undangan otomatis, dan hindari konflik jadwal.</p>
          </div>
          
          <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-[#d5e7e6] mx-auto mb-6">
              <svg class="w-8 h-8 text-[#4C8C86]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900">Notulen Digital</h3>
            <p class="mt-2 text-gray-600 flex-grow">Simpan catatan rapat, poin keputusan, dan item tindak lanjut secara rapi dan mudah diakses oleh semua peserta.</p>
          </div>

          <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-[#d5e7e6] mx-auto mb-6">
              <svg class="w-8 h-8 text-[#4C8C86]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900">Monitoring Tugas</h3>
            <p class="mt-2 text-gray-600 flex-grow">Pantau progres setiap tugas yang dihasilkan dari rapat. Pastikan semua orang menyelesaikan tanggung jawabnya tepat waktu.</p>
          </div>

          {{-- <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-[#d5e7e6] mx-auto mb-6">
              <svg class="w-8 h-8 text-[#4C8C86]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900">Ringkasan AI</h3>
            <p class="mt-2 text-gray-600 flex-grow">Dapatkan ringkasan otomatis dari transkrip rapat, menghemat waktu dan memastikan poin-poin kunci tidak terlewat.</p>
          </div> --}}
        </div>
      </div>
    </section>
    
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div class="flex justify-center md:order-last">
                <img src="https://illustrations.popsy.co/gray/success.svg" alt="Tim Sukses" class="w-full max-w-md">
            </div>
            <div class="text-center md:text-left">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Misi Kami Adalah Produktivitas Anda</h2>
                <p class="mt-6 text-lg text-gray-600">
                    MeetLog dibangun dari keyakinan bahwa rapat yang baik adalah kunci kesuksesan tim. Kami menyediakan alat yang intuitif untuk menghilangkan kerumitan administratif, sehingga Anda bisa fokus pada diskusi yang paling penting: inovasi, strategi, dan pertumbuhan.
                </p>
                <a href="#pricing" class="mt-8 inline-block px-8 py-3 bg-[#4C8C86] text-white font-semibold rounded-lg shadow-lg hover:bg-[#407872] transition duration-300">Lihat Paket Harga</a>
            </div>
        </div>
    </section>

    <section id="pricing" class="py-20 bg-[#eaf3f2]">
      <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Paket Harga yang Fleksibel</h2>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto mb-12">Pilih paket yang paling sesuai dengan kebutuhan dan skala tim Anda.</p>
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 lg:grid-cols-3 gap-8 items-start">

          <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col h-full">
            <h3 class="text-2xl font-semibold">Gratis</h3>
            <p class="text-gray-500 mt-2 flex-grow">Cocok untuk tim kecil & personal.</p>
            <p class="text-4xl font-bold my-6">Rp 0<span class="text-lg font-medium text-gray-500">/bln</span></p>
            <ul class="text-left space-y-3 text-gray-600 mb-8">
              <li class="flex items-center"><svg class="w-5 h-5 text-[#4C8C86] mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>3 Pengguna</li>
              <li class="flex items-center"><svg class="w-5 h-5 text-[#4C8C86] mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>5 Rapat per Bulan</li>
              <li class="flex items-center"><svg class="w-5 h-5 text-[#4C8C86] mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Notulen Dasar</li>
            </ul>
            <a href="/register" class="mt-auto w-full inline-block px-6 py-3 border border-[#4C8C86] text-[#4C8C86] rounded-lg font-semibold hover:bg-[#d5e7e6] transition duration-300">Mulai Sekarang</a>
          </div>

          <div class="bg-[#4C8C86] text-white rounded-xl shadow-2xl p-8 text-center scale-105 relative flex flex-col h-full">
            <span class="absolute top-0 right-6 -mt-3 bg-yellow-400 text-gray-800 text-sm font-bold px-3 py-1 rounded-full">Paling Populer</span>
            <h3 class="text-2xl font-semibold">Pro</h3>
            <p class="opacity-80 mt-2 flex-grow">Fitur lengkap untuk tim yang berkembang.</p>
            <p class="text-4xl font-bold my-6">Rp 149rb<span class="text-lg font-medium opacity-80">/bln</span></p>
            <ul class="text-left space-y-3 opacity-90 mb-8">
              <li class="flex items-center"><svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Hingga 25 Pengguna</li>
              <li class="flex items-center"><svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Rapat Tak Terbatas</li>
              <li class="flex items-center"><svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Notulen & Ringkasan AI</li>
              <li class="flex items-center"><svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Monitoring Tugas Lanjutan</li>
            </ul>
            <a href="/register" class="mt-auto w-full inline-block px-6 py-3 bg-white text-[#4C8C86] rounded-lg font-semibold hover:bg-gray-100 transition duration-300">Pilih Paket Pro</a>
          </div>

          <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col h-full md:col-span-2 lg:col-span-1">
            <h3 class="text-2xl font-semibold">Enterprise</h3>
            <p class="text-gray-500 mt-2 flex-grow">Solusi kustom untuk perusahaan besar.</p>
            <p class="text-4xl font-bold my-6">Kustom</p>
            <ul class="text-left space-y-3 text-gray-600 mb-8">
              <li class="flex items-center"><svg class="w-5 h-5 text-[#4C8C86] mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Pengguna Tak Terbatas</li>
              <li class="flex items-center"><svg class="w-5 h-5 text-[#4C8C86] mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Dukungan Prioritas 24/7</li>
              <li class="flex items-center"><svg class="w-5 h-5 text-[#4C8C86] mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Keamanan & SLA Kustom</li>
            </ul>
            <a href="#footer" class="mt-auto w-full inline-block px-6 py-3 border border-[#4C8C86] text-[#4C8C86] rounded-lg font-semibold hover:bg-[#d5e7e6] transition duration-300">Hubungi Kami</a>
          </div>
        </div>
      </div>
    </section>
    {{-- <section class="py-20 bg-white overflow-hidden">
        <div class="max-w-4xl mx-auto px-6 text-center" 
             x-data="{
                activeIndex: 0,
                testimonials: [
                    {
                        quote: 'Sejak menggunakan MeetLog, rapat tim kami menjadi 2x lebih produktif. Semua terdokumentasi dengan baik dan tidak ada lagi tugas yang terlewat.',
                        name: 'Anya Lestari',
                        title: 'Project Manager di TechCorp',
                        img: 'https://randomuser.me/api/portraits/women/44.jpg'
                    },
                    {
                        quote: 'Fitur notulen AI-nya luar biasa! Menghemat banyak waktu dan memastikan semua poin penting terekam dengan akurat. Sangat direkomendasikan!',
                        name: 'Budi Santoso',
                        title: 'Head of Product di Inovasi Digital',
                        img: 'https://randomuser.me/api/portraits/men/32.jpg'
                    },
                    {
                        quote: 'Manajemen tugas setelah rapat jadi sangat mudah. Tim kami lebih akuntabel dan semua orang tahu apa yang harus dikerjakan selanjutnya.',
                        name: 'Citra Dewi',
                        title: 'Scrum Master di Agile Solutions',
                        img: 'https://randomuser.me/api/portraits/women/68.jpg'
                    }
                ],
                init() {
                    setInterval(() => {
                        this.activeIndex = (this.activeIndex + 1) % this.testimonials.length;
                    }, 2000);
                }
             }"
             x-init="init()">
            
            <h2 class="text-3xl font-bold text-gray-900">Dipercaya oleh Tim Hebat</h2>
            
            <div class="mt-10 relative h-64">
                <template x-for="(testimonial, index) in testimonials" :key="index">
                    <div x-show="activeIndex === index"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform translate-x-10"
                         x-transition:enter-end="opacity-100 transform translate-x-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 transform translate-x-0"
                         x-transition:leave-end="opacity-0 transform -translate-x-10"
                         class="absolute inset-0">
                        
                        <img :src="testimonial.img" alt="Foto Pengguna" class="w-20 h-20 mx-auto rounded-full shadow-lg">
                        <blockquote class="mt-6 text-xl text-gray-700 italic">
                            <p x-text="`&quot;${testimonial.quote}&quot;`"></p>
                        </blockquote>
                        <p class="mt-4 font-semibold text-gray-900" x-text="testimonial.name"></p>
                        <p class="text-sm text-gray-500" x-text="testimonial.title"></p>
                    </div>
                </template>
            </div>

            <div class="mt-8 flex justify-center space-x-3">
                <template x-for="(testimonial, index) in testimonials" :key="index">
                    <button @click="activeIndex = index" 
                            class="w-3 h-3 rounded-full transition-colors duration-300"
                            :class="{'bg-[#4C8C86]': activeIndex === index, 'bg-gray-300 hover:bg-gray-400': activeIndex !== index}">
                    </button>
                </template>
            </div>
        </div>
    </section> --}}

    <section class="py-20 bg-gradient-to-r from-[#4C8C86] to-[#407872] text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Siap Meningkatkan Produktivitas Tim Anda?</h2>
        <p class="text-lg opacity-90 mb-8">Bergabunglah dengan ribuan tim yang sudah merasakan kemudahan manajemen rapat bersama MeetLog.</p>
        <a href="/register" class="px-10 py-4 bg-white text-[#4C8C86] font-bold rounded-lg shadow-xl hover:bg-gray-100 transform hover:scale-105 transition-all duration-300">Coba Gratis Selama 14 Hari</a>
      </div>
    </section>

  </main>

  <footer id="footer" class="bg-gray-900 text-gray-300">
    <div class="max-w-7xl mx-auto py-12 px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
      <div class="md:col-span-1">
        <h3 class="text-xl font-extrabold text-white">MeetLog</h3>
        <p class="mt-4 text-gray-400">Platform pintar untuk manajemen rapat yang efisien, teratur, dan kolaboratif.</p>
      </div>
      <div>
        <h4 class="text-sm font-semibold tracking-wider uppercase text-gray-400">Produk</h4>
        <ul class="mt-4 space-y-2">
          <li><a href="#features" class="hover:text-white transition">Fitur</a></li>
          <li><a href="#pricing" class="hover:text-white transition">Harga</a></li>
          <li><a href="#" class="hover:text-white transition">Keamanan</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-sm font-semibold tracking-wider uppercase text-gray-400">Perusahaan</h4>
        <ul class="mt-4 space-y-2">
          <li><a href="#about" class="hover:text-white transition">Tentang Kami</a></li>
          <li><a href="#" class="hover:text-white transition">Karir</a></li>
          <li><a href="#" class="hover:text-white transition">Kontak</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-sm font-semibold tracking-wider uppercase text-gray-400">Legal</h4>
        <ul class="mt-4 space-y-2">
          <li><a href="#" class="hover:text-white transition">Kebijakan Privasi</a></li>
          <li><a href="#" class="hover:text-white transition">Syarat & Ketentuan</a></li>
        </ul>
      </div>
    </div>
    <div class="bg-gray-800 py-4">
      <p class="text-center text-sm text-gray-500">&copy; 2025 MeetLog. Semua Hak Dilindungi.</p>
    </div>
  </footer>

</body>
</html>