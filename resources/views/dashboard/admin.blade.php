@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin Sistem</h1>
                <p class="text-gray-600 mt-2">Kelola seluruh sistem organisasi kemahasiswaan</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <i class="fas fa-crown mr-2"></i>
                    Admin Sistem
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-building text-blue-500 text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Organisasi</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['total_organizations'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('organizations.index') }}" 
                       class="font-medium text-blue-600 hover:text-blue-500">
                        Kelola organisasi
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-users text-green-500 text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['total_users'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('users.index') }}" 
                       class="font-medium text-green-600 hover:text-green-500">
                        Kelola users
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-user-tie text-purple-500 text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Admin Organisasi</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['organization_admins'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('users.index', ['role' => 'organization_admin']) }}" 
                       class="font-medium text-purple-600 hover:text-purple-500">
                        Lihat admin org
                    </a>
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Kegiatan Aktif</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['active_events'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('events.index') }}" 
                       class="font-medium text-yellow-600 hover:text-yellow-500">
                        Lihat kegiatan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- System Activity -->
    <div class="bg-white shadow rounded-lg mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                Aktivitas Sistem
            </h3>
        </div>
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $systemActivity['new_users_today'] }}</div>
                    <div class="text-sm text-gray-500">User Baru Hari Ini</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $systemActivity['new_organizations_week'] }}</div>
                    <div class="text-sm text-gray-500">Organisasi Baru Minggu Ini</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $systemActivity['events_this_month'] }}</div>
                    <div class="text-sm text-gray-500">Kegiatan Bulan Ini</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white shadow rounded-lg mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                <i class="fas fa-bolt mr-2 text-blue-600"></i>
                Aksi Cepat
            </h3>
        </div>
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('organizations.create') }}" 
                   class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <i class="fas fa-plus-circle text-blue-600 text-xl mr-3"></i>
                    <div>
                        <div class="font-medium text-blue-900">Tambah Organisasi</div>
                        <div class="text-sm text-blue-600">Daftarkan organisasi baru</div>
                    </div>
                </a>
                
                <a href="{{ route('users.create') }}" 
                   class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <i class="fas fa-user-plus text-green-600 text-xl mr-3"></i>
                    <div>
                        <div class="font-medium text-green-900">Tambah User</div>
                        <div class="text-sm text-green-600">Buat akun admin organisasi</div>
                    </div>
                </a>
                
                <a href="{{ route('announcements.create') }}" 
                   class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <i class="fas fa-bullhorn text-purple-600 text-xl mr-3"></i>
                    <div>
                        <div class="font-medium text-purple-900">Pengumuman Global</div>
                        <div class="text-sm text-purple-600">Buat pengumuman sistem</div>
                    </div>
                </a>
                
                <a href="{{ route('events.index') }}" 
                   class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                    <i class="fas fa-calendar-check text-yellow-600 text-xl mr-3"></i>
                    <div>
                        <div class="font-medium text-yellow-900">Monitor Kegiatan</div>
                        <div class="text-sm text-yellow-600">Pantau semua kegiatan</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Organizations -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <i class="fas fa-building mr-2 text-blue-600"></i>
                        Organisasi Terbaru
                    </h3>
                    <a href="{{ route('organizations.index') }}" 
                       class="text-sm text-blue-600 hover:text-blue-500">
                        Lihat Semua
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($recentOrganizations as $organization)
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                @if($organization->logo_path)
                                    <img class="h-10 w-10 rounded-full object-cover" 
                                         src="{{ Storage::url($organization->logo_path) }}" 
                                         alt="{{ $organization->name }}">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-graduation-cap text-blue-600"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $organization->name }}</p>
                                <p class="text-sm text-gray-500">{{ $organization->active_members_count }} anggota</p>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $organization->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-4">Belum ada organisasi terdaftar.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <i class="fas fa-users mr-2 text-green-600"></i>
                        User Terbaru
                    </h3>
                    <a href="{{ route('users.index') }}" 
                       class="text-sm text-green-600 hover:text-green-500">
                        Lihat Semua
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($recentUsers as $user)
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $user->role_label }}
                                    @if($user->organization)
                                        - {{ $user->organization->acronym }}
                                    @endif
                                </p>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $user->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-4">Belum ada user terdaftar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
