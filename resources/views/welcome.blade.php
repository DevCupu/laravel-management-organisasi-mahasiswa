<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SIORMAWA') }} - Sistem Informasi Organisasi Kemahasiswaan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href={{"../css/style.css"}}>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center space-x-3">
                        <!-- Logo Icon (SVG or Image) -->
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden">
                            <!-- Ganti src berikut dengan path gambar lokal Anda -->
                            <img src="{{ asset('unm.png') }}" alt="Logo SIORMAWA" class="w-full h-full object-cover" />
                        </div>
                        <!-- SIORMAWA Branding Icon -->
                        <span class="text-blue-600 text-2xl">
                            <i class="fas fa-graduation-cap"></i>
                        </span>
                        <h1 class="text-2xl font-bold text-blue-600">SIORMAWA</h1>
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#beranda"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">Beranda</a>
                        <a href="#fitur"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">Fitur</a>
                        <a href="#tentang"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">Tentang</a>
                        <a href="#kontak"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">Kontak</a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button"
                        class="text-gray-700 hover:text-blue-600 focus:outline-none focus:text-blue-600"
                        onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#beranda"
                    class="text-gray-700 hover:text-blue-600 block px-3 py-2 text-base font-medium">Beranda</a>
                <a href="#fitur"
                    class="text-gray-700 hover:text-blue-600 block px-3 py-2 text-base font-medium">Fitur</a>
                <a href="#tentang"
                    class="text-gray-700 hover:text-blue-600 block px-3 py-2 text-base font-medium">Tentang</a>
                <a href="#kontak"
                    class="text-gray-700 hover:text-blue-600 block px-3 py-2 text-base font-medium">Kontak</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="text-blue-600 block px-3 py-2 text-base font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-gray-700 hover:text-blue-600 block px-3 py-2 text-base font-medium">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-blue-600 block px-3 py-2 text-base font-medium">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="pt-16 bg-gradient-to-br from-blue-50 via-white to-purple-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-6xl font-bold text-gray-900 leading-tight">
                        Sistem Informasi
                        <span class="text-blue-600">Organisasi Kemahasiswaan</span>
                    </h1>
                    <p class="mt-6 text-xl text-gray-600 leading-relaxed">
                        Platform digital terpadu untuk mengelola organisasi kemahasiswaan dengan mudah, efisien, dan
                        terorganisir.
                        Kelola anggota, event, dokumen, dan aktivitas organisasi dalam satu sistem.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}"
                                    class="bg-blue-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-700 transition-colors text-center">
                                    <i class="fas fa-tachometer-alt mr-2"></i>
                                    Buka Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="bg-blue-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-700 transition-colors text-center">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Mulai Sekarang
                                </a>
                            @endif
                            @endif
                            <a href="#fitur"
                                class="border-2 border-blue-600 text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-600 hover:text-white transition-colors text-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                    <div class="relative">
                        <div
                            class="bg-white rounded-2xl shadow-2xl p-8 transform rotate-3 hover:rotate-0 transition-transform duration-300">
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-users text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Manajemen Anggota</h3>
                                        <p class="text-gray-600 text-sm">Kelola data anggota organisasi</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-green-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Manajemen Event</h3>
                                        <p class="text-gray-600 text-sm">Atur kegiatan dan acara organisasi</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-file-alt text-purple-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Manajemen Dokumen</h3>
                                        <p class="text-gray-600 text-sm">Simpan dan kelola dokumen penting</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="py-16 bg-blue-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-4xl md:text-5xl font-bold text-white mb-2">500+</div>
                        <div class="text-blue-100 text-lg">Organisasi Terdaftar</div>
                    </div>
                    <div>
                        <div class="text-4xl md:text-5xl font-bold text-white mb-2">10K+</div>
                        <div class="text-blue-100 text-lg">Anggota Aktif</div>
                    </div>
                    <div>
                        <div class="text-4xl md:text-5xl font-bold text-white mb-2">2K+</div>
                        <div class="text-blue-100 text-lg">Event Terselenggara</div>
                    </div>
                    <div>
                        <div class="text-4xl md:text-5xl font-bold text-white mb-2">50+</div>
                        <div class="text-blue-100 text-lg">Institusi Partner</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="fitur" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Fitur Unggulan SIORMAWA
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Dilengkapi dengan berbagai fitur canggih untuk memudahkan pengelolaan organisasi kemahasiswaan
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-users text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Manajemen Organisasi</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Kelola data organisasi, struktur kepengurusan, dan informasi lengkap organisasi kemahasiswaan
                            dengan mudah.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-user-friends text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Manajemen Anggota</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Daftarkan anggota baru, kelola data keanggotaan, dan pantau status keaktifan anggota organisasi.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-calendar-alt text-purple-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Manajemen Event</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Rencanakan, kelola, dan pantau kegiatan organisasi dari tahap persiapan hingga evaluasi.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-file-alt text-yellow-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Manajemen Dokumen</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Simpan, kelola, dan bagikan dokumen penting organisasi dengan sistem keamanan yang terjamin.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-bullhorn text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Sistem Pengumuman</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Sampaikan informasi dan pengumuman penting kepada seluruh anggota organisasi dengan efektif.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-chart-bar text-indigo-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Laporan & Analitik</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Dapatkan insight mendalam tentang aktivitas organisasi melalui dashboard dan laporan
                            komprehensif.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                            Mengapa Memilih SIORMAWA?
                        </h2>
                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div
                                    class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Mudah Digunakan</h3>
                                    <p class="text-gray-600">Interface yang intuitif dan user-friendly, mudah dipahami oleh
                                        semua kalangan.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div
                                    class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Keamanan Terjamin</h3>
                                    <p class="text-gray-600">Sistem keamanan berlapis untuk melindungi data organisasi dan
                                        anggota.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div
                                    class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Akses Real-time</h3>
                                    <p class="text-gray-600">Informasi dan data selalu ter-update secara real-time untuk
                                        semua pengguna.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div
                                    class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Support 24/7</h3>
                                    <p class="text-gray-600">Tim support yang siap membantu kapan saja untuk memastikan
                                        sistem berjalan lancar.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="bg-gradient-to-br from-blue-400 to-purple-500 rounded-2xl p-8 text-white">
                            <div class="space-y-6">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-mobile-alt text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">Responsive Design</h3>
                                        <p class="text-blue-100 text-sm">Akses dari desktop, tablet, atau smartphone</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-cloud text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">Cloud-Based</h3>
                                        <p class="text-blue-100 text-sm">Data tersimpan aman di cloud server</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-sync-alt text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">Auto Backup</h3>
                                        <p class="text-blue-100 text-sm">Backup otomatis untuk keamanan data</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="tentang" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Tentang SIORMAWA
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        SIORMAWA (Sistem Informasi Organisasi Kemahasiswaan) adalah platform digital yang dirancang khusus
                        untuk memudahkan pengelolaan organisasi kemahasiswaan di berbagai institusi pendidikan.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-lightbulb text-blue-600 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Visi</h3>
                        <p class="text-gray-600">
                            Menjadi platform terdepan dalam digitalisasi manajemen organisasi kemahasiswaan di Indonesia.
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-target text-green-600 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Misi</h3>
                        <p class="text-gray-600">
                            Menyediakan solusi teknologi yang mudah, efisien, dan terpercaya untuk mengelola organisasi
                            kemahasiswaan.
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-heart text-purple-600 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Nilai</h3>
                        <p class="text-gray-600">
                            Inovasi, integritas, dan komitmen untuk mendukung perkembangan organisasi kemahasiswaan.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
            <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    Siap Memulai Digitalisasi Organisasi Anda?
                </h2>
                <p class="text-xl text-blue-100 mb-8">
                    Bergabunglah dengan ratusan organisasi yang telah merasakan kemudahan SIORMAWA
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="bg-white text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 transition-colors">
                                <i class="fas fa-tachometer-alt mr-2"></i>
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="bg-white text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 transition-colors">
                                <i class="fas fa-rocket mr-2"></i>
                                Daftar Sekarang
                            </a>
                            <a href="{{ route('login') }}"
                                class="border-2 border-white text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Masuk
                            </a>
                        @endif
                        @endif
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section id="kontak" class="py-20 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                            Hubungi Kami
                        </h2>
                        <p class="text-xl text-gray-600">
                            Ada pertanyaan? Tim kami siap membantu Anda
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-envelope text-blue-600 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Email</h3>
                            <p class="text-gray-600">support@siormawa.ac.id</p>
                            <p class="text-gray-600">info@siormawa.ac.id</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-phone text-green-600 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Telepon</h3>
                            <p class="text-gray-600">+62 21 1234 5678</p>
                            <p class="text-gray-600">+62 812 3456 7890</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-map-marker-alt text-purple-600 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Alamat</h3>
                            <p class="text-gray-600">Jl. Pendidikan No. 123</p>
                            <p class="text-gray-600">Jakarta, Indonesia 12345</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="bg-gray-900 text-white py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div class="col-span-1 md:col-span-2">
                            <h3 class="text-2xl font-bold mb-4">SIORMAWA</h3>
                            <p class="text-gray-300 mb-4">
                                Sistem Informasi Organisasi Kemahasiswaan yang memudahkan pengelolaan organisasi
                                dengan teknologi modern dan user-friendly.
                            </p>
                            <div class="flex space-x-4">
                                <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                    <i class="fab fa-facebook-f text-xl"></i>
                                </a>
                                <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                    <i class="fab fa-twitter text-xl"></i>
                                </a>
                                <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                    <i class="fab fa-instagram text-xl"></i>
                                </a>
                                <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                    <i class="fab fa-linkedin-in text-xl"></i>
                                </a>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold mb-4">Menu</h4>
                            <ul class="space-y-2">
                                <li><a href="#beranda" class="text-gray-300 hover:text-white transition-colors">Beranda</a>
                                </li>
                                <li><a href="#fitur" class="text-gray-300 hover:text-white transition-colors">Fitur</a></li>
                                <li><a href="#tentang" class="text-gray-300 hover:text-white transition-colors">Tentang</a>
                                </li>
                                <li><a href="#kontak" class="text-gray-300 hover:text-white transition-colors">Kontak</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold mb-4">Support</h4>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Bantuan</a>
                                </li>
                                <li><a href="#" class="text-gray-300 hover:text-white transition-colors">FAQ</a></li>
                                <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Dokumentasi</a>
                                </li>
                                <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Kebijakan
                                        Privasi</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                        <p class="text-gray-300">
                            &copy; {{ date('Y') }} SIORMAWA. Semua hak dilindungi.
                            Dibuat dengan <i class="fas fa-heart text-red-500"></i> untuk kemajuan organisasi kemahasiswaan.
                        </p>
                    </div>
                </div>
            </footer>

            <!-- Scroll to Top Button -->
            <button id="scrollToTop"
                class="fixed bottom-8 right-8 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-colors hidden">
                <i class="fas fa-chevron-up"></i>
            </button>

            <script>
                // Mobile menu toggle
                function toggleMobileMenu() {
                    const menu = document.getElementById('mobile-menu');
                    menu.classList.toggle('hidden');
                }

                // Smooth scrolling for anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                        // Close mobile menu if open
                        document.getElementById('mobile-menu').classList.add('hidden');
                    });
                });

                // Scroll to top functionality
                const scrollToTopBtn = document.getElementById('scrollToTop');

                window.addEventListener('scroll', () => {
                    if (window.pageYOffset > 300) {
                        scrollToTopBtn.classList.remove('hidden');
                    } else {
                        scrollToTopBtn.classList.add('hidden');
                    }
                });

                scrollToTopBtn.addEventListener('click', () => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });

                // Add animation on scroll
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-fade-in');
                        }
                    });
                }, observerOptions);

                // Observe all sections
                document.querySelectorAll('section').forEach(section => {
                    observer.observe(section);
                });
            </script>

            <style>
                .animate-fade-in {
                    animation: fadeIn 0.6s ease-in-out;
                }

                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                html {
                    scroll-behavior: smooth;
                }
            </style>
        </body>

        </html>
