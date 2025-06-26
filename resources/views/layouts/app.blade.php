<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIORMAWA') }} - @yield('title', 'Sistem Informasi Organisasi Kemahasiswaan')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">
                            SIORMAWA
                        </a>
                    </div>
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="{{ route('dashboard') }}"
                            class="@if (request()->routeIs('dashboard')) text-gray-900 @else text-gray-500 hover:text-blue-600 @endif px-3 py-2 text-sm font-medium">
                            Dashboard
                        </a>

                        @if (auth()->user()->canManageAllOrganizations())
                            <!-- Admin Menu -->
                            <a href="{{ route('organizations.index') }}"
                                class="@if (request()->routeIs('organizations.*')) text-gray-900 @else text-gray-500 hover:text-blue-600 @endif px-3 py-2 text-sm font-medium">
                                Organisasi
                            </a>
                            <a href="{{ route('users.index') }}"
                                class="@if (request()->routeIs('users.*')) text-gray-900 @else text-gray-500 hover:text-blue-600 @endif px-3 py-2 text-sm font-medium">
                                Users
                            </a>
                        @endif

                        @if (auth()->user()->isOrganizationAdmin() || auth()->user()->canManageAllOrganizations())
                            <!-- Organization Admin Menu -->
                            <a href="{{ route('members.index') }}"
                                class="@if (request()->routeIs('members.*')) text-gray-900 @else text-gray-500 hover:text-blue-600 @endif px-3 py-2 text-sm font-medium">
                                Anggota
                            </a>
                            <a href="{{ route('events.index') }}"
                                class="@if (request()->routeIs('events.*')) text-gray-900 @else text-gray-500 hover:text-blue-600 @endif px-3 py-2 text-sm font-medium">
                                Kegiatan
                            </a>
                            <a href="{{ route('documents.index') }}"
                                class="@if (request()->routeIs('documents.*')) text-gray-900 @else text-gray-500 hover:text-blue-600 @endif px-3 py-2 text-sm font-medium">
                                Dokumen
                            </a>
                        @endif

                        @if (auth()->user()->isMember())
                            <!-- Member Menu -->
                            @if (auth()->user()->organization)
                                <a href="{{ route('organizations.show', auth()->user()->organization) }}"
                                    class="@if (request()->routeIs('organizations.show')) text-gray-900 @else text-gray-500 hover:text-blue-600 @endif px-3 py-2 text-sm font-medium">
                                    Organisasi Saya
                                </a>
                                <a href="{{ route('events.index', ['organization_id' => auth()->user()->organization_id]) }}"
                                    class="@if (request()->routeIs('events.*')) text-gray-900 @else text-gray-500 hover:text-blue-600 @endif px-3 py-2 text-sm font-medium">
                                    Kegiatan
                                </a>
                                <a href="{{ route('documents.index', ['organization_id' => auth()->user()->organization_id]) }}"
                                    class="@if (request()->routeIs('documents.*')) text-gray-900 @else text-gray-500 hover:text-blue-600 @endif px-3 py-2 text-sm font-medium">
                                    Dokumen
                                </a>
                            @else
                                <a href="{{ route('organizations.index') }}"
                                    class="@if (request()->routeIs('organizations.*')) text-gray-900 @else text-gray-500 hover:text-blue-600 @endif px-3 py-2 text-sm font-medium">
                                    Organisasi
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="text-gray-500 hover:text-gray-700 relative">
                        <i class="fas fa-bell"></i>
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                    </button>

                    <!-- User Menu -->
                    <div class="relative">
                        <button
                            class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                            onclick="toggleDropdown()">
                            <img class="h-8 w-8 rounded-full"
                                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff"
                                alt="{{ Auth::user()->name }}">
                            <span class="ml-2 text-gray-700 hidden md:block">{{ Auth::user()->name }}</span>
                            <span
                                class="ml-1 text-xs text-gray-500 hidden md:block">({{ Auth::user()->role_label }})</span>
                        </button>

                        <div id="userDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <div class="px-4 py-2 text-xs text-gray-500 border-b">
                                {{ Auth::user()->role_label }}
                                @if (Auth::user()->organization)
                                    <br>{{ Auth::user()->organization->acronym }}
                                @endif
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>Profil
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3"
                    onclick="this.parentElement.style.display='none'">
                    <i class="fas fa-times cursor-pointer"></i>
                </span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3"
                    onclick="this.parentElement.style.display='none'">
                    <i class="fas fa-times cursor-pointer"></i>
                </span>
            </div>
        </div>
    @endif

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.rounded-full') && !event.target.closest('.relative')) {
                var dropdown = document.getElementById('userDropdown');
                if (!dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            }
        }
    </script>
</body>

</html>
