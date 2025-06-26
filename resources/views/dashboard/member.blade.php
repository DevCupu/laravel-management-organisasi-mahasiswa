@extends('layouts.app')

@section('title', 'Dashboard Member')

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard {{ $organization->name }}</h1>
                    <p class="text-gray-600 mt-2">Selamat datang, {{ auth()->user()->name }}</p>
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
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-user mr-2"></i>
                        Member
                    </span>
                </div>
            </div>
        </div>

        <!-- Organization Info Card -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-lg mb-8">
            <div class="px-6 py-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold mb-2">{{ $organization->name }}</h2>
                        <p class="text-blue-100 mb-4">
                            {{ $organization->description ?: 'Organisasi kemahasiswaan yang aktif dan dinamis' }}</p>
                        <div class="flex items-center space-x-6 text-sm">
                            @if ($organization->established_date)
                                <div class="flex items-center">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <span>Berdiri {{ $organization->established_date->format('Y') }}</span>
                                </div>
                            @endif
                            <div class="flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                <span>{{ $organization->activeMembers()->count() }} Anggota</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-tag mr-2"></i>
                                <span>{{ $organization->category_label }}</span>
                            </div>
                        </div>
                    </div>
                    @if ($organization->logo_path)
                        <div class="hidden md:block">
                            <img class="h-20 w-20 rounded-full object-cover border-4 border-white/20"
                                src="{{ Storage::url($organization->logo_path) }}" alt="{{ $organization->name }}">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-alt text-blue-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Kegiatan Mendatang</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $upcomingEvents->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-bullhorn text-green-500 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pengumuman Aktif</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $recentAnnouncements->count() }}</dd>
                            </dl>
                        </div>
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
                                <dt class="text-sm font-medium text-gray-500 truncate">Dokumen Tersedia</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $recentDocuments->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Upcoming Events -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>
                            Kegiatan Mendatang
                        </h3>
                        <a href="{{ route('events.index', ['organization_id' => $organization->id]) }}"
                            class="text-sm text-blue-600 hover:text-blue-500">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse($upcomingEvents as $event)
                            <div
                                class="border-l-4 border-blue-400 pl-4 hover:bg-gray-50 p-3 rounded-r-lg transition-colors">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
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
                                                {{ Str::limit($event->location, 50) }}
                                            </p>
                                        @endif
                                        @if ($event->max_participants)
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $event->current_participants }}/{{ $event->max_participants }} peserta
                                            </p>
                                        @endif
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $event->status_label }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fas fa-calendar-times text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500 text-sm">Tidak ada kegiatan mendatang saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Announcements -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            <i class="fas fa-bullhorn mr-2 text-green-600"></i>
                            Pengumuman Terbaru
                        </h3>
                        <a href="{{ route('announcements.index') }}" class="text-sm text-green-600 hover:text-green-500">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recentAnnouncements as $announcement)
                            <div
                                class="border-l-4 border-green-400 pl-4 hover:bg-gray-50 p-3 rounded-r-lg transition-colors">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $announcement->title }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($announcement->content, 100) }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-2">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $announcement->publish_date->diffForHumans() }}
                                            @if ($announcement->organization)
                                                <span class="ml-2">• {{ $announcement->organization->acronym }}</span>
                                            @else
                                                <span class="ml-2">• Sistem</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        @if ($announcement->type === 'urgent') bg-red-100 text-red-800
                                        @elseif($announcement->type === 'event') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($announcement->type) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fas fa-bullhorn text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500 text-sm">Tidak ada pengumuman terbaru.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Section -->
        @if ($recentDocuments->count() > 0)
            <div class="mt-6">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                <i class="fas fa-file-alt mr-2 text-purple-600"></i>
                                Dokumen Terbaru
                            </h3>
                            <a href="{{ route('documents.index', ['organization_id' => $organization->id]) }}"
                                class="text-sm text-purple-600 hover:text-purple-500">
                                Lihat Semua
                            </a>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($recentDocuments as $document)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ $document->title }}
                                            </h4>
                                            <p class="text-sm text-gray-500 mt-1">{{ $document->category ?: 'Dokumen' }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $document->file_size_formatted }} •
                                                {{ $document->created_at->format('d M Y') }}
                                            </p>
                                            <div class="mt-2">
                                                <a href="{{ route('documents.download', $document) }}"
                                                    class="inline-flex items-center text-xs text-blue-600 hover:text-blue-500">
                                                    <i class="fas fa-download mr-1"></i>
                                                    Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Contact Information -->
        @if ($organization->email || $organization->phone || $organization->website)
            <div class="mt-6">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            <i class="fas fa-address-book mr-2 text-blue-600"></i>
                            Kontak Organisasi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if ($organization->email)
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Email</p>
                                        <a href="mailto:{{ $organization->email }}"
                                            class="text-sm text-blue-600 hover:text-blue-500">
                                            {{ $organization->email }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if ($organization->phone)
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-phone text-gray-400"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Telepon</p>
                                        <a href="tel:{{ $organization->phone }}"
                                            class="text-sm text-blue-600 hover:text-blue-500">
                                            {{ $organization->phone }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if ($organization->website)
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-globe text-gray-400"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Website</p>
                                        <a href="{{ $organization->website }}" target="_blank"
                                            class="text-sm text-blue-600 hover:text-blue-500">
                                            {{ $organization->website }}
                                            <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
