@extends('layouts.app')

@section('title', 'Dashboard Member')

@section('content')
    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Member</h1>
            <p class="text-gray-600 mt-2">Selamat datang, {{ auth()->user()->name }}</p>
        </div>

        <!-- No Organization State -->
        <div class="bg-white shadow rounded-lg">
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400 mb-6">
                    <i class="fas fa-users text-6xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-4">
                    Anda Belum Terdaftar dalam Organisasi
                </h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    Untuk mengakses fitur-fitur sistem, Anda perlu terdaftar sebagai anggota dalam salah satu organisasi
                    kemahasiswaan.
                </p>

                <div class="space-y-4">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 max-w-md mx-auto">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-400 text-lg mt-1"></i>
                            </div>
                            <div class="ml-3 text-left">
                                <h4 class="text-sm font-medium text-blue-800">Cara Bergabung:</h4>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ol class="list-decimal list-inside space-y-1">
                                        <li>Hubungi admin organisasi yang ingin Anda ikuti</li>
                                        <li>Atau hubungi admin sistem untuk bantuan</li>
                                        <li>Setelah terdaftar, Anda dapat mengakses semua fitur</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('organizations.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                            <i class="fas fa-search mr-2"></i>
                            Lihat Daftar Organisasi
                        </a>
                        <a href="mailto:admin@siormawa.ac.id"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            <i class="fas fa-envelope mr-2"></i>
                            Hubungi Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Organizations -->
        <div class="mt-8">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        <i class="fas fa-building mr-2 text-blue-600"></i>
                        Organisasi yang Tersedia
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $availableOrganizations = \App\Models\Organization::where('status', 'active')
                                ->take(6)
                                ->get();
                        @endphp

                        @forelse($availableOrganizations as $org)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        @if ($org->logo_path)
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ Storage::url($org->logo_path) }}" alt="{{ $org->name }}">
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <i class="fas fa-graduation-cap text-blue-600"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $org->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $org->category_label }}</p>
                                        @if ($org->email)
                                            <p class="text-xs text-gray-400">{{ $org->email }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-4">
                                <p class="text-gray-500 text-sm">Tidak ada organisasi yang tersedia saat ini.</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($availableOrganizations->count() > 0)
                        <div class="mt-4 text-center">
                            <a href="{{ route('organizations.index') }}" class="text-sm text-blue-600 hover:text-blue-500">
                                Lihat semua organisasi →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
