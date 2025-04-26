<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Pembudidaya</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="h-full">
    <div class="min-h-full">
        <nav class="sticky top-0 z-50 bg-gray-800" x-data="{ isOpen: false }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="shrink-0">
                            <img class="size-9"
                                src="images/logosibikanda.png"
                                alt="Your Company">
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                <a href="/"
                                    class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Beranda</a>
                                <div class="relative relative z-50">
                                    <button id="dropdownButton"
                                        class="flex items-center rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white focus:outline-none">
                                        Komoditas
                                        <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div id="dropdownMenu" class="absolute left-0 hidden w-48 bg-white shadow-md">
                                        <a href="/daftar_pembudidaya"
                                            class="block bg-gray-900 px-4 py-2 text-white">Rumput Laut</a>
                                        <a href="/daftar_pembudidaya"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Udang</a>
                                        <a href="/daftar_pembudidaya"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Ikan Gurame</a>
                                        <a href="/daftar_pembudidaya"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Ikan Bandeng</a>
                                        <a href="/daftar_pembudidaya"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Ikan Lele</a>
                                        <a href="/daftar_pembudidaya"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Ikan Nila</a>
                                    </div>
                                </div>
                                <a href="/tentangkami"
                                    class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                                    aria-current="page">Tentang
                                    Kami</a>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <!-- Profile dropdown -->
                            <div class="relative ml-3" x-data="{ isOpen: false }">
                                <div>
                                    <button @click="isOpen = !isOpen" type="button"
                                        class="relative flex items-center justify-center rounded-full bg-gray-800 p-1 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-none"
                                        id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        <i class="fas fa-user-circle text-gray-400 text-2xl transition-colors duration-200 ease-in-out hover:text-white"></i>
                                    </button>
                                </div>
                            
                                <div x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75 transform"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 ring-1 shadow-lg ring-black/5 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                    tabindex="-1">
                            
                                    @if(Auth::guard('pembudidaya')->check())
                                        <!-- Jika Pembudidaya sudah login -->
                                        <div class="block px-4 py-2 text-sm text-gray-700">
                                            <p class="font-semibold">{{ Auth::guard('pembudidaya')->user()->name }}</p>
                                            <p class="text-gray-500">{{ Auth::guard('pembudidaya')->user()->email }}</p>
                                        </div>
                                        <hr>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                role="menuitem" tabindex="-1">
                                                Logout
                                            </button>
                                        </form>
                                    @elseif(Auth::check())
                                        <!-- Jika User Umum (Pembeli) sudah login -->
                                        <div class="block px-4 py-2 text-sm text-gray-700">
                                            <p class="font-semibold">{{ Auth::user()->name }}</p>
                                            <p class="text-gray-500">{{ Auth::user()->email }}</p>
                                        </div>
                                        <hr>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                role="menuitem" tabindex="-1">
                                                Logout
                                            </button>
                                        </form>
                                    @else
                                        <!-- Jika belum login -->
                                        <a href="/login" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem" tabindex="-1">Masuk</a>
                                        <a href="/register" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem" tabindex="-1">Daftar</a>
                                        <a href="{{ route('pembudidaya.login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem" tabindex="-1">Masuk Sebagai Pembudidaya</a>
                                    @endif
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <button @click="isOpen = !isOpen" type="button"
                            class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="absolute -inset-0.5"></span>
                            <span class="sr-only">Open main menu</span>
                            <!-- Menu open: "hidden", Menu closed: "block" -->
                            <svg :class="{'hidden: isOpen, 'block ': !isOpen }"class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"stroke="currentColor" aria-hidden="true" data-slot="icon"><path stroke-linecap="round" stroke-linejoin="round"d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <!-- Menu open: "block", Menu closed: "hidden" -->
                            <svg :class="{'block: isOpen, 'hidden ': !isOpen }"class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"stroke="currentColor" aria-hidden="true" data-slot="icon"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div x-show="isOpen" class="md:hidden" id="mobile-menu">
                <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <a href="/"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Beranda</a>
                    <div class="relative">
                        <button id="mobileDropdownButton"
                            class="rounded-md flex items-center w-full rounded-md px-3 py-2 text-base font-medium text-white bg-gray-900 focus:outline-none">
                            Komoditas
                            <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="mobileDropdownMenu" class="hidden w-full bg-white shadow-md">
                            <a href="/daftar_pembudidaya"
                                class="block px-4 py-2 text-white bg-gray-900">Rumput Laut</a>
                            <a href="/daftar_pembudidaya"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Udang</a>
                            <a href="/daftar_pembudidaya"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Ikan Gurame</a>
                            <a href="/daftar_pembudidaya"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Ikan Bandeng</a>
                            <a href="/daftar_pembudidaya" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Ikan
                                Lele</a>
                            <a href="/daftar_pembudidaya" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Ikan
                                Nila</a>
                        </div>
                    </div> 
                    <a href="tentangkami"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                        aria-current="page">Tentang
                        Kami</a>
                </div>
                <script>
                    document.getElementById('dropdownButton').addEventListener('click', function() {
                        var menu = document.getElementById('dropdownMenu');
                        menu.classList.toggle('hidden');
                    });

                    document.getElementById('mobileDropdownButton').addEventListener('click', function() {
                        var menu = document.getElementById('mobileDropdownMenu');
                        menu.classList.toggle('hidden');
                    });

                    document.addEventListener('click', function(event) {
                        var dropdownButton = document.getElementById('dropdownButton');
                        var dropdownMenu = document.getElementById('dropdownMenu');
                        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                            dropdownMenu.classList.add('hidden');
                        }

                        var mobileDropdownButton = document.getElementById('mobileDropdownButton');
                        var mobileDropdownMenu = document.getElementById('mobileDropdownMenu');
                        if (!mobileDropdownButton.contains(event.target) && !mobileDropdownMenu.contains(event.target)) {
                            mobileDropdownMenu.classList.add('hidden');
                        }
                    });
                </script>
                <div class="border-t border-gray-700 pt-4 pb-3">
                    <div class="flex items-center px-5">
                        <div class="shrink-0 flex items-center justify-center">
                            <i class="fas fa-user-circle text-gray-400 text-3xl transition-colors duration-200 ease-in-out hover:text-white"></i>
                        </div>
                        <div class="ml-3">
                            @if(Auth::guard('pembudidaya')->check())
                                <!-- Jika Pembudidaya Login -->
                                <div class="text-base font-medium text-white">{{ Auth::guard('pembudidaya')->user()->name }}</div>
                                <div class="text-sm font-medium text-gray-400">{{ Auth::guard('pembudidaya')->user()->email }}</div>
                            @elseif(Auth::check())
                                <!-- Jika User Biasa Login -->
                                <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                                <div class="text-sm font-medium text-gray-400">{{ Auth::user()->email }}</div>
                            @else
                                <!-- Jika Tidak Login -->
                                <div class="text-base font-medium text-white">Guest</div>
                                <div class="text-sm font-medium text-gray-400">Silakan masuk atau daftar</div>
                            @endif
                        </div>
                    </div>
                
                    <div class="mt-3 space-y-1 px-2">
                        @if(Auth::guard('pembudidaya')->check() || Auth::check())
                            <!-- Jika sudah login, hanya tampilkan tombol Logout -->
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">
                                    Logout
                                </button>
                            </form>
                        @else
                            <!-- Jika belum login, tampilkan opsi login -->
                            <a href="/login"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">
                                Masuk
                            </a>
                            <a href="/register"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">
                                Daftar
                            </a>
                            <a href="{{ route('pembudidaya.login') }}"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">
                                Masuk Sebagai Pembudidaya
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <button onclick="window.history.back()" class="text-gray-600 hover:text-gray-800 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:w-7 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">Detail Pembudidaya</h1>
                </div>
                <div class="relative w-32 sm:w-48 md:w-64 lg:w-80">
                    <input type="text" placeholder="Cari..."
                        class="w-full border rounded-md px-3 py-1.5 text-gray-700 text-sm sm:text-base focus:ring-2 focus:ring-blue-500 focus:outline-none pr-10">
                    <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m0 0A8.5 8.5 0 1011 19a8.5 8.5 0 005.65-2.35z" />
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center relative bg-gray-100">
            <div class="bg-white shadow-lg rounded-xl p-6 max-w-5xl mx-auto flex flex-col md:flex-row gap-6">
                <!-- Kolom Kiri (Gambar & Peta) -->
                <div class="w-full md:w-1/2">
                    <!-- Slider Gambar -->
                    <div class="relative w-full overflow-hidden rounded-lg">
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><img src="/images/rumputlaut.jpg" alt="Rumput Laut" class="w-full h-64 object-cover rounded-lg"></div>
                                <div class="swiper-slide"><img src="/images/tambak.jpg" alt="Rumput Laut 2" class="w-full h-64 object-cover rounded-lg"></div>
                                <div class="swiper-slide"><img src="/images/rumputlaut.jpg" alt="Rumput Laut 3" class="w-full h-64 object-cover rounded-lg"></div>
                            </div>
                            <!-- Pagination di Luar Gambar -->
                            <div class="swiper-pagination mt-2"></div>
                            <!-- Tombol Navigasi -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
        
                <!-- Kolom Kanan (Detail) -->
                <div class="w-full md:w-1/2 text-left space-y-4">
                    <h2 class="text-2xl font-bold text-gray-800 break-words">Nama Pembudidaya</h2>
                    <p class="text-lg text-gray-600">Rp. 15.000 - Rp. 17.000 /kg</p>
                    <div class="flex items-start text-gray-600 mt-2 break-words">
                        <span class="material-icons text-gray-500 mr-2"></span> 
                        <p class="max-w-full break-words">Jl. Pantai No. 1, Kandanghaur.</p>
                    </div>
        
                    <div class="mt-4 space-y-2 border-t pt-4">
                        <p class="max-w-full break-words"><strong>Jenis Komoditas:</strong> Rumput Laut</p>
                        <p class="max-w-full break-words"><strong>Jenis Spesifik:</strong> Rumput Laut Kering</p>
                        <p class="max-w-full break-words"><strong>Produksi Bulanan:</strong> 500 kg/bulan</p>
                        <p class="max-w-full break-words"><strong>Masa Produksi Puncak:</strong> Mei - Agustus</p>
                        <p class="max-w-full break-words"><strong>Perkiraan Panen:</strong> Oktober 2025</p>
                        <p class="max-w-full break-words"><strong>Deskripsi:</strong> pH Air: 7.5 - 8.5, Salinitas: 25 - 30 ppt.</p>
                    </div>
        
                    <!-- Tombol WhatsApp -->
                    <div class="mt-6 space-y-2">
                        <a href="https://wa.me/6281234567890" class="flex items-center justify-center bg-green-600 text-white text-lg py-2 rounded-lg hover:bg-green-700 transition">
                            Hubungi via WhatsApp
                        </a>
                        
                        <!-- Tombol Kunjungi Profil -->
                        <a href="/profil_pembudidaya" class="flex items-center justify-center bg-blue-600 text-white text-lg py-2 rounded-lg hover:bg-blue-700 transition">
                            Kunjungi Profil
                        </a>
                    </div>
                </div>
            </div>
        </main>
        
                
        <!-- SwiperJS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
        <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
        <style>
            /* Custom Style untuk Pagination */
            .swiper-pagination-bullet {
                width: 12px;
                height: 12px;
                background-color: #575757 !important;
                opacity: 1;
            }
            .swiper-pagination-bullet-active {
                background-color: rgba(0, 0, 0, 0.7) !important;
                transform: scale(1.3);
            }
            
            /* Style Progressbar */
            .swiper-pagination-progressbar {
                background: rgba(0, 0, 0, 0.1);
                height: 4px;
            }
            .swiper-pagination-progressbar-fill {
                background: #4CAF50 !important;
            }
            
            /* Styling untuk Tombol Navigasi */
            .swiper-button-next, .swiper-button-prev {
                width: 40px;
                height: 40px;
                background-color: rgba(0, 0, 0, 0.5);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 16px; /* Ukuran panah dikurangi */
                line-height: 40px;
            }
            .swiper-button-next::after, .swiper-button-prev::after {
                font-size: 16px; /* Pastikan panah tidak keluar dari lingkaran */
            }
            .swiper-button-next:hover, .swiper-button-prev:hover {
                background-color: rgba(0, 0, 0, 0.7);
            }
            
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var swiper = new Swiper('.mySwiper', {
                    slidesPerView: 1,
                    loop: true,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                        type: 'bullets', // Ubah ke 'progressbar' untuk progressbar
                    },
                });
            });
        </script>
    </div>
</body>
<footer class="bg-gray-900 text-white py-10">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-8">
  
      <!-- Tentang Perusahaan (kiri) -->
      <div>
        <h3 class="font-bold text-lg mb-2">Tentang Kami</h3>
        <p class="text-gray-400 mb-4">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce euismod convallis velit, eu auctor lacus
          vehicula sit amet.
        </p>
      </div>
  
      <!-- Kontak (kanan) -->
      <div class="space-y-4">
        
        <!-- Alamat -->
        <div class="flex items-center space-x-4">
          <div class="bg-gray-800 p-2 rounded-full">
            <!-- Icon Map Baru -->
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 2C8.13 2 5 5.13 5 9c0 7 7 13 7 13s7-6 7-13c0-3.87-3.13-7-7-7z"/>
              <circle cx="12" cy="9" r="2.5" fill="currentColor"/>
            </svg>
          </div>
          <div>
            <p class="text-sm">Jl. Raya Pabean Udik, No.1</p>
            <p class="font-semibold">Pabeanudik, Kec. Indramayu, Kabupaten Indramayu, Jawa Barat</p>
          </div>
        </div>
  
        <!-- Telepon -->
        <div class="flex items-center space-x-4">
          <div class="bg-gray-800 p-2 rounded-full">
            <!-- Icon Telepon -->
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 5a2 2 0 012-2h2.586a1 1 0 01.707.293l2.828 2.828a1 1 0 010 1.414l-1.415 1.414a11.042 11.042 0 005.657 5.657l1.414-1.415a1 1 0 011.414 0l2.828 2.828a1 1 0 01.293.707V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
          </div>
          <p class="font-semibold">+62 812 3456 7890</p>
        </div>
  
        <!-- Email -->
        <div class="flex items-center space-x-4">
            <div class="bg-gray-800 p-2 rounded-full">
              <!-- Icon Email Baru -->
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                   viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
            </div>
            <p class="font-semibold">support@company.com</p>
          </div>
      </div>
    </div>
  </footer>
</html>
