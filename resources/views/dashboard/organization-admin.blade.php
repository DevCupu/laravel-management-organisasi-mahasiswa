@extends('layouts.app')

@section('title', 'Dashboard Admin Organisasi')

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard {{ $organization->name }}</h1>
                    <p class="text-gray-600 mt-2">Kelola organisasi Anda dengan mudah dan efisien</p>
                </div>
                <div class="flex items-center space-x-3">
                    @if ($organization->logo_path)
                        <img class="h-12 w-12 rounded-full object-cover" src="{{ Storage::url($organization->logo_path) }}"
                            alt="{{ $organization->name }}">
                    @else
                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-blue-600 text-xl"></i>
                        </div>
                    @endif
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    @if ($organization->status === 'active') bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">
                        {{ $organization->status_label }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-blue-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Anggota</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['total_members'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('members.index', ['organization_id' => $organization->id]) }}"
                            class="font-medium text-blue-600 hover:text-blue-500">
                            Kelola anggota
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-alt text-green-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Kegiatan</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['total_events'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('events.index', ['organization_id' => $organization->id]) }}"
                            class="font-medium text-green-600 hover:text-green-500">
                            Kelola kegiatan
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-check text-yellow-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Kegiatan Mendatang</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['upcoming_events'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('events.create', ['organization_id' => $organization->id]) }}"
                            class="font-medium text-yellow-600 hover:text-yellow-500">
                            Buat kegiatan
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-file-alt text-purple-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Dokumen</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['total_documents'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('documents.index', ['organization_id' => $organization->id]) }}"
                            class="font-medium text-purple-600 hover:text-purple-500">
                            Kelola dokumen
                        </a>
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
                    <a href="{{ route('members.create', ['organization_id' => $organization->id]) }}"
                        class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <i class="fas fa-user-plus text-blue-600 text-xl mr-3"></i>
                        <div>
                            <div class="font-medium text-blue-900">Tambah Anggota</div>
                            <div class="text-sm text-blue-600">Daftarkan anggota baru</div>
                        </div>
                    </a>

                    <a href="{{ route('events.create', ['organization_id' => $organization->id]) }}"
                        class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <i class="fas fa-calendar-plus text-green-600 text-xl mr-3"></i>
                        <div>
                            <div class="font-medium text-green-900">Buat Kegiatan</div>
                            <div class="text-sm text-green-600">Rencanakan kegiatan baru</div>
                        </div>
                    </a>

                    <a href="{{ route('documents.create', ['organization_id' => $organization->id]) }}"
                        class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                        <i class="fas fa-file-upload text-purple-600 text-xl mr-3"></i>
                        <div>
                            <div class="font-medium text-purple-900">Upload Dokumen</div>
                            <div class="text-sm text-purple-600">Tambah dokumen baru</div>
                        </div>
                    </a>

                    <a href="{{ route('announcements.create', ['organization_id' => $organization->id]) }}"
                        class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                        <i class="fas fa-bullhorn text-yellow-600 text-xl mr-3"></i>
                        <div>
                            <div class="font-medium text-yellow-900">Buat Pengumuman</div>
                            <div class="text-sm text-yellow-600">Sampaikan informasi</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Members -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            <i class="fas fa-users mr-2 text-blue-600"></i>
                            Anggota Terbaru
                        </h3>
                        <a href="{{ route('members.index', ['organization_id' => $organization->id]) }}"
                            class="text-sm text-blue-600 hover:text-blue-500">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentMembers as $member)
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @if ($member->photo_path)
                                        <img class="h-10 w-10 rounded-full object-cover"
                                            src="{{ Storage::url($member->photo_path) }}" alt="{{ $member->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-600"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $member->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $member->position ?: 'Anggota' }}</p>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $member->student_id }}
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm text-center py-4">Belum ada anggota terdaftar.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            <i class="fas fa-calendar-alt mr-2 text-green-600"></i>
                            Kegiatan Mendatang
                        </h3>
                        <a href="{{ route('events.index', ['organization_id' => $organization->id]) }}"
                            class="text-sm text-green-600 hover:text-green-500">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse($upcomingEvents as $event)
                            <div class="border-l-4 border-green-400 pl-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $event->title }}</h4>
                                        <p class="text-sm text-gray-500 mt-1">
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}

                                            @if ($event->start_time)
                                                <i class="fas fa-clock ml-3 mr-1"></i>
                                                {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB
                                            @endif
                                        </p>

                                        @if ($event->location)
                                            <p class="text-sm text-gray-500">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                {{ $event->location }}
                                            </p>
                                        @endif
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $event->status_label }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm text-center py-4">Tidak ada kegiatan mendatang.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
