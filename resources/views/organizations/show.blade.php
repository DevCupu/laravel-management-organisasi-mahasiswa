@extends('layouts.app')

@section('title', $organization->name)

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-500 transition-colors">
                                <i class="fas fa-home"></i>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mr-4"></i>
                            <a href="{{ route('organizations.index') }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">Organisasi</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mr-4"></i>
                            <span class="text-sm font-medium text-gray-900">{{ $organization->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Organization Header -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            @if ($organization->logo_path)
                                <img class="h-20 w-20 rounded-full object-cover border-4 border-gray-200"
                                    src="{{ Storage::url($organization->logo_path) }}" alt="{{ $organization->name }}">
                            @else
                                <div
                                    class="h-20 w-20 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                    <i class="fas fa-graduation-cap text-white text-3xl"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $organization->name }}</h1>
                            <p class="text-lg text-gray-600">{{ $organization->acronym }}</p>
                            <div class="flex items-center space-x-4 mt-2">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if ($organization->status === 'active') bg-green-100 text-green-800 
                                @else 
                                    bg-gray-100 text-gray-800 @endif">
                                    <i class="fas fa-circle mr-2 text-xs"></i>
                                    {{ $organization->status_label }}
                                </span>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $organization->category_label }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('organizations.edit', $organization) }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            <i class="fas fa-edit mr-2"></i>
                            Edit
                        </a>
                        <button onclick="confirmDelete('{{ $organization->id }}', '{{ $organization->name }}')"
                            class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-600 bg-white hover:bg-red-50 transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Description -->
                @if ($organization->description)
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                <i class="fas fa-align-left mr-2 text-blue-600"></i>
                                Deskripsi
                            </h3>
                            <p class="text-gray-700 leading-relaxed">{{ $organization->description }}</p>
                        </div>
                    </div>
                @endif

                <!-- Recent Members -->
                @if ($organization->activeMembers->count() > 0)
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-5">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    <i class="fas fa-users mr-2 text-blue-600"></i>
                                    Anggota Terbaru
                                </h3>
                                <a href="{{ route('organizations.members', $organization) }}"
                                    class="text-sm text-blue-600 hover:text-blue-500">
                                    Lihat Semua
                                </a>
                            </div>
                            <div class="space-y-3">
                                @foreach ($organization->activeMembers->take(5) as $member)
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            @if ($member->photo_path)
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                    src="{{ Storage::url($member->photo_path) }}"
                                                    alt="{{ $member->name }}">
                                            @else
                                                <div
                                                    class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
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
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Upcoming Events -->
                @if ($organization->upcomingEvents->count() > 0)
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
                                @foreach ($organization->upcomingEvents->take(3) as $event)
                                    <div class="border-l-4 border-blue-400 pl-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900">{{ $event->title }}</h4>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ $event->event_date->format('d M Y') }}
                                                    @if ($event->start_time)
                                                        <i class="fas fa-clock ml-3 mr-1"></i>
                                                        {{ $event->start_time->format('H:i') }} WIB
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
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $event->status_label }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Statistics -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                            Statistik
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-users text-green-600 mr-3"></i>
                                    <span class="text-sm text-gray-600">Anggota Aktif</span>
                                </div>
                                <span
                                    class="text-lg font-semibold text-gray-900">{{ $organization->active_members_count }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-blue-600 mr-3"></i>
                                    <span class="text-sm text-gray-600">Total Kegiatan</span>
                                </div>
                                <span class="text-lg font-semibold text-gray-900">{{ $organization->events_count }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-file-alt text-purple-600 mr-3"></i>
                                    <span class="text-sm text-gray-600">Dokumen</span>
                                </div>
                                <span
                                    class="text-lg font-semibold text-gray-900">{{ $organization->documents_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organization Info -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                            Informasi Organisasi
                        </h3>
                        <div class="space-y-3">
                            @if ($organization->established_date)
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-plus text-gray-400 mr-3 w-4"></i>
                                    <div>
                                        <span class="text-sm text-gray-600">Tanggal Berdiri</span>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $organization->established_date->format('d M Y') }}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($organization->email)
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-gray-400 mr-3 w-4"></i>
                                    <div>
                                        <span class="text-sm text-gray-600">Email</span>
                                        <p class="text-sm font-medium text-gray-900">
                                            <a href="mailto:{{ $organization->email }}"
                                                class="text-blue-600 hover:text-blue-500">
                                                {{ $organization->email }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if ($organization->phone)
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-gray-400 mr-3 w-4"></i>
                                    <div>
                                        <span class="text-sm text-gray-600">Telepon</span>
                                        <p class="text-sm font-medium text-gray-900">
                                            <a href="tel:{{ $organization->phone }}"
                                                class="text-blue-600 hover:text-blue-500">
                                                {{ $organization->phone }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if ($organization->website)
                                <div class="flex items-center">
                                    <i class="fas fa-globe text-gray-400 mr-3 w-4"></i>
                                    <div>
                                        <span class="text-sm text-gray-600">Website</span>
                                        <p class="text-sm font-medium text-gray-900">
                                            <a href="{{ $organization->website }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-500">
                                                {{ $organization->website }}
                                                <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if ($organization->social_media)
                                <div class="flex items-center">
                                    <i class="fas fa-hashtag text-gray-400 mr-3 w-4"></i>
                                    <div>
                                        <span class="text-sm text-gray-600">Media Sosial</span>
                                        <p class="text-sm font-medium text-gray-900">{{ $organization->social_media }}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($organization->address)
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-gray-400 mr-3 w-4 mt-1"></i>
                                    <div>
                                        <span class="text-sm text-gray-600">Alamat Sekretariat</span>
                                        <p class="text-sm font-medium text-gray-900">{{ $organization->address }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            <i class="fas fa-bolt mr-2 text-blue-600"></i>
                            Aksi Cepat
                        </h3>
                        <div class="space-y-2">
                            <a href="{{ route('members.create', ['organization_id' => $organization->id]) }}"
                                class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-50 rounded-md hover:bg-gray-100 transition-colors">
                                <i class="fas fa-user-plus mr-3 text-green-600"></i>
                                Tambah Anggota
                            </a>
                            <a href="{{ route('events.create', ['organization_id' => $organization->id]) }}"
                                class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-50 rounded-md hover:bg-gray-100 transition-colors">
                                <i class="fas fa-calendar-plus mr-3 text-blue-600"></i>
                                Buat Kegiatan
                            </a>
                            <a href="{{ route('documents.create', ['organization_id' => $organization->id]) }}"
                                class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-50 rounded-md hover:bg-gray-100 transition-colors">
                                <i class="fas fa-file-upload mr-3 text-purple-600"></i>
                                Upload Dokumen
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Hapus Organisasi</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Apakah Anda yakin ingin menghapus organisasi <span id="orgName" class="font-semibold"></span>?
                    Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait.
                </p>
                <div class="flex justify-center space-x-3">
                    <button onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(orgId, orgName) {
            document.getElementById('orgName').textContent = orgName;
            document.getElementById('deleteForm').action = `/organizations/${orgId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
@endsection
