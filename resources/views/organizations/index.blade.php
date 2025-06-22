@extends('layouts.app')

@section('title', 'Daftar Organisasi')

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Daftar Organisasi
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola semua organisasi kemahasiswaan yang terdaftar dalam sistem
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('organizations.create') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Organisasi
                </a>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <form method="GET" action="{{ route('organizations.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari
                                Organisasi</label>
                            <div class="relative">
                                <input type="text" id="search" name="search" value="{{ request('search') }}"
                                    placeholder="Nama atau akronim organisasi..."
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select name="category" id="category"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Semua Kategori</option>
                                <option value="himpunan" {{ request('category') === 'himpunan' ? 'selected' : '' }}>Himpunan
                                    Mahasiswa</option>
                                <option value="ukm" {{ request('category') === 'ukm' ? 'selected' : '' }}>Unit Kegiatan
                                    Mahasiswa</option>
                                <option value="ormawa" {{ request('category') === 'ormawa' ? 'selected' : '' }}>Organisasi
                                    Kemahasiswaan</option>
                                <option value="bem" {{ request('category') === 'bem' ? 'selected' : '' }}>Badan Eksekutif
                                    Mahasiswa</option>
                                <option value="osis" {{ request('category') === 'osis' ? 'selected' : '' }}>OSIS</option>
                            </select>
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" id="status"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak
                                    Aktif</option>
                            </select>
                        </div>
                        <div class="flex items-end space-x-2">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                            <a href="{{ route('organizations.index') }}"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Organizations Grid -->
        @if ($organizations->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                @foreach ($organizations as $organization)
                    <div
                        class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition-shadow duration-200 border border-gray-200">
                        <div class="px-6 py-5">
                            <!-- Header with Logo and Status -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if ($organization->logo_path)
                                            <img class="h-12 w-12 rounded-full object-cover border-2 border-gray-200"
                                                src="{{ Storage::url($organization->logo_path) }}"
                                                alt="{{ $organization->name }}">
                                        @else
                                            <div
                                                class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                                <i class="fas fa-graduation-cap text-white text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $organization->name }}
                                        </h3>
                                        <p class="text-sm text-gray-500">{{ $organization->acronym }}</p>
                                    </div>
                                </div>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if ($organization->status === 'active') bg-green-100 text-green-800 
                                @else 
                                    bg-gray-100 text-gray-800 @endif">
                                    {{ $organization->status_label }}
                                </span>
                            </div>

                            <!-- Category Badge -->
                            <div class="mb-3">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $organization->category_label }}
                                </span>
                            </div>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit($organization->description, 120) ?: 'Tidak ada deskripsi.' }}
                            </p>

                            <!-- Statistics -->
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <div class="flex items-center">
                                    <i class="fas fa-users mr-1"></i>
                                    <span>{{ $organization->active_members_count }} anggota</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar mr-1"></i>
                                    <span>{{ $organization->events_count }} kegiatan</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-file-alt mr-1"></i>
                                    <span>{{ $organization->documents_count }} dokumen</span>
                                </div>
                            </div>

                            <!-- Contact Info -->
                            @if ($organization->email || $organization->phone)
                                <div class="border-t border-gray-200 pt-3 mb-4">
                                    @if ($organization->email)
                                        <div class="flex items-center text-sm text-gray-600 mb-1">
                                            <i class="fas fa-envelope mr-2 w-4"></i>
                                            <span class="truncate">{{ $organization->email }}</span>
                                        </div>
                                    @endif
                                    @if ($organization->phone)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <i class="fas fa-phone mr-2 w-4"></i>
                                            <span>{{ $organization->phone }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ route('organizations.show', $organization) }}"
                                    class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 text-center transition-colors">
                                    <i class="fas fa-eye mr-1"></i>
                                    Detail
                                </a>
                                <a href="{{ route('organizations.edit', $organization) }}"
                                    class="px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmDelete('{{ $organization->id }}', '{{ $organization->name }}')"
                                    class="px-3 py-2 border border-red-300 text-red-600 rounded-md text-sm font-medium hover:bg-red-50 transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($organizations->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6 rounded-lg shadow-sm">
                    {{ $organizations->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white shadow rounded-lg">
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                        <i class="fas fa-users text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        @if (request()->hasAny(['search', 'category', 'status']))
                            Tidak ada organisasi yang ditemukan
                        @else
                            Belum ada organisasi
                        @endif
                    </h3>
                    <p class="text-gray-500 mb-6">
                        @if (request()->hasAny(['search', 'category', 'status']))
                            Coba ubah filter pencarian atau hapus filter untuk melihat semua organisasi.
                        @else
                            Mulai dengan menambahkan organisasi pertama ke dalam sistem.
                        @endif
                    </p>
                    @if (request()->hasAny(['search', 'category', 'status']))
                        <a href="{{ route('organizations.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mr-3">
                            <i class="fas fa-times mr-2"></i>
                            Hapus Filter
                        </a>
                    @endif
                    <a href="{{ route('organizations.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Organisasi
                    </a>
                </div>
            </div>
        @endif
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

    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
