<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tentang Kami</title>
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
                                        class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white focus:outline-none">
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
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Rumput Laut</a>
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
                                    class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white"
                                    aria-current="page">Tentang
                                    Kami</a>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <button type="button" onclick="window.location.href='/favorit'"
                                class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">Favorite</span>
                                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 21l-1.45-1.318C5.4 15.363 2 12.274 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.774-3.4 6.863-8.55 11.182L12 21z" />
                                </svg>
                            </button>

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
                        <!-- Favorite Button -->
                        <button type="button" onclick="window.location.href='/favorit'"
                            class="relative flex items-center justify-center w-10 h-10 rounded-full bg-gray-800 text-gray-400 hover:text-white hover:bg-gray-700 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-none">
                            <span class="sr-only">Favorite</span>
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 21l-1.45-1.318C5.4 15.363 2 12.274 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.774-3.4 6.863-8.55 11.182L12 21z" />
                            </svg>
                        </button>
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
                            class="flex items-center w-full rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white focus:outline-none">
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
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Rumput Laut</a>
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
                        class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white"
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
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">Tentang Kami</h1>
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
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <!-- Section Tentang Kami -->
                <section class="relative text-gray-900 py-20 bg-gradient-to-r from-blue-400 to-teal-500 text-white rounded-lg shadow-xl"
                style="z-index: 0; position: relative; overflow: visible;">
                <div class="absolute inset-0 bg-cover bg-center opacity-30"></div>
                <div class="relative container mx-auto flex flex-col md:flex-row items-center gap-12 px-6 sm:px-12">
                    <!-- Judul (hanya muncul di mobile) -->
                    <h2 class="text-4xl font-extrabold mb-6 text-center md:hidden">Tentang Kami</h2>
                    <!-- Gambar (di bawah judul untuk mobile, tetap di kiri untuk desktop) -->
                    <div class="w-full md:w-1/2 flex justify-center order-2 md:order-1">
                        <img src="/images/tambak.jpg" alt="Tentang Kami" class="rounded-lg shadow-xl border-4 border-white">
                    </div>
                    <!-- Teks Keterangan -->
                    <div class="w-full md:w-1/2 text-center md:text-left md:pl-10 order-3">
                        <!-- Judul (hanya muncul di desktop) -->
                        <h2 class="hidden md:block text-5xl font-extrabold mb-6">Tentang Kami</h2>
                        <p class="text-lg opacity-90 leading-relaxed">
                            Aplikasi Inkubator Bisnis Komoditas Unggulan Ikan di Indramayu hadir untuk mendukung pertumbuhan bisnis perikanan dengan menyediakan informasi lengkap tentang berbagai Komoditas unggulan seperti Udang, Rumput Laut, Bandeng, Gurame, Lele, dan Nila. Kami menghubungkan pembudidaya dengan calon mitra bisnis, membantu dalam penyebaran informasi, serta mendorong inovasi dalam sektor perikanan lokal.
                        </p>
                    </div>
                </div>
            </section>
                
                <!-- Section Kontak Kami -->
                <section class="text-gray-900 py-16 bg-blue-50">
                    <div class="container mx-auto text-center">
                        <h2 class="text-4xl font-extrabold mb-6 text-gray-900">Kontak Kami</h2>
                        <p class="text-lg text-gray-600 mb-8">Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami. Kami siap membantu Anda dalam mengembangkan bisnis perikanan yang lebih maju dan berkelanjutan.</p>
                        <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg border border-blue-300">
                            <form class="space-y-6">
                                <div>
                                    <label class="block text-left text-gray-700 font-semibold" for="name">Nama</label>
                                    <input type="text" id="name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none" placeholder="Masukkan nama Anda">
                                </div>
                                <div>
                                    <label class="block text-left text-gray-700 font-semibold" for="email">Email</label>
                                    <input type="email" id="email" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none" placeholder="Masukkan email Anda">
                                </div>
                                <div>
                                    <label class="block text-left text-gray-700 font-semibold" for="message">Pesan</label>
                                    <textarea id="message" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none" rows="4" placeholder="Tulis pesan Anda"></textarea>
                                </div>
                                <button type="submit" class="w-full bg-teal-600 text-white p-3 rounded-lg hover:bg-teal-700 transition-all duration-300 font-semibold shadow-md">Kirim</button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </main>
        
        

    </div>

</body>

</html>
