@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600 mt-2">Selamat datang di Sistem Informasi Organisasi Kemahasiswaan</p>
        </div>

        <!-- Stats Cards -->
        {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-blue-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Organisasi</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['total_organizations'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-friends text-green-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Anggota</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['total_members']) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-alt text-yellow-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Kegiatan Bulan Ini</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['total_events'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chart-line text-red-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Kegiatan Aktif</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['active_events'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Organizations -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Organisasi Terbaru</h3>
                    <div class="space-y-4">
                        @forelse($recentOrganizations as $organization)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if ($organization->logo_path)
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ Storage::url($organization->logo_path) }}"
                                                alt="{{ $organization->name }}">
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <i class="fas fa-graduation-cap text-blue-600"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $organization->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $organization->active_members_count }} anggota
                                        </div>
                                    </div>
                                </div>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if ($organization->status === 'active') bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">
                                    {{ $organization->status_label }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">Belum ada organisasi terdaftar.</p>
                        @endforelse
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('organizations.index') }}"
                            class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                            Lihat semua organisasi →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            {{-- <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Kegiatan Mendatang</h3>
                    <div class="space-y-4">
                        @forelse($upcomingEvents as $event)
                            <div class="border-l-4 border-blue-400 pl-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $event->title }}</h4>
                                        <p class="text-sm text-gray-500">{{ $event->organization->name }}</p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $event->event_date->format('d M Y') }}
                                            @if ($event->start_time)
                                                , {{ $event->start_time->format('H:i') }} WIB
                                            @endif
                                        </p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $event->status_label }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">Tidak ada kegiatan mendatang.</p>
                        @endforelse
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('events.index') }}"
                            class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                            Lihat semua kegiatan →
                        </a>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
