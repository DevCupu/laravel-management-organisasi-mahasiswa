@extends('layouts.app')

@section('title', 'Detail User - ' . $user->name)

@section('content')
    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
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
                            <a href="{{ route('users.index') }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">Users</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mr-4"></i>
                            <span class="text-sm font-medium text-gray-900">{{ $user->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- User Header -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                                <i class="fas fa-user text-gray-600 text-3xl"></i>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-lg text-gray-600">{{ $user->email }}</p>
                            <div class="flex items-center space-x-4 mt-2">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if ($user->is_active) bg-green-100 text-green-800 
                                @else 
                                    bg-red-100 text-red-800 @endif">
                                    <i class="fas fa-circle mr-2 text-xs"></i>
                                    {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if ($user->role === 'organization_admin') bg-blue-100 text-blue-800 
                                @else 
                                    bg-gray-100 text-gray-800 @endif">
                                    {{ $user->role_label }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('users.edit', $user) }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            <i class="fas fa-edit mr-2"></i>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('users.toggle-status', $user) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-{{ $user->is_active ? 'yellow' : 'green' }}-300 rounded-md shadow-sm text-sm font-medium text-{{ $user->is_active ? 'yellow' : 'green' }}-600 bg-white hover:bg-{{ $user->is_active ? 'yellow' : 'green' }}-50 transition-colors">
                                <i class="fas fa-{{ $user->is_active ? 'pause' : 'play' }} mr-2"></i>
                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        <button onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')"
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
                <!-- User Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            <i class="fas fa-user mr-2 text-blue-600"></i>
                            Informasi User
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <a href="mailto:{{ $user->email }}" class="text-blue-600 hover:text-blue-500">
                                        {{ $user->email }}
                                    </a>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Role</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->role_label }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Status</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    @if ($user->is_active) bg-green-100 text-green-800 
                                    @else 
                                        bg-red-100 text-red-800 @endif">
                                        {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </p>
                            </div>
                            @if ($user->student_id)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">NIM/NIS</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->student_id }}</p>
                                </div>
                            @endif
                            @if ($user->phone)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Telepon</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        <a href="tel:{{ $user->phone }}" class="text-blue-600 hover:text-blue-500">
                                            {{ $user->phone }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Terdaftar</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d M Y H:i') }}</p>
                            </div>
                            @if ($user->last_login_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Login Terakhir</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->last_login_at->diffForHumans() }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Organization Information -->
                @if ($user->organization)
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                <i class="fas fa-building mr-2 text-blue-600"></i>
                                Informasi Organisasi
                            </h3>
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if ($user->organization->logo_path)
                                        <img class="h-12 w-12 rounded-full object-cover"
                                            src="{{ Storage::url($user->organization->logo_path) }}"
                                            alt="{{ $user->organization->name }}">
                                    @else
                                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-graduation-cap text-blue-600"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">{{ $user->organization->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $user->organization->acronym }} •
                                        {{ $user->organization->category_label }}</p>
                                    @if ($user->organization->email)
                                        <p class="text-sm text-gray-500">{{ $user->organization->email }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('organizations.show', $user->organization) }}"
                                    class="text-sm text-blue-600 hover:text-blue-500">
                                    Lihat detail organisasi →
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            <i class="fas fa-bolt mr-2 text-blue-600"></i>
                            Aksi Cepat
                        </h3>
                        <div class="space-y-2">
                            <a href="{{ route('users.edit', $user) }}"
                                class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-50 rounded-md hover:bg-gray-100 transition-colors">
                                <i class="fas fa-edit mr-3 text-blue-600"></i>
                                Edit User
                            </a>
                            <form method="POST" action="{{ route('users.toggle-status', $user) }}" class="w-full">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-50 rounded-md hover:bg-gray-100 transition-colors">
                                    <i
                                        class="fas fa-{{ $user->is_active ? 'pause' : 'play' }} mr-3 text-{{ $user->is_active ? 'yellow' : 'green' }}-600"></i>
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} User
                                </button>
                            </form>
                            @if ($user->organization)
                                <a href="{{ route('organizations.show', $user->organization) }}"
                                    class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-50 rounded-md hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-building mr-3 text-purple-600"></i>
                                    Lihat Organisasi
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- User Statistics -->
                @if ($user->role === 'organization_admin' && $user->organization)
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
                                        <span class="text-sm text-gray-600">Anggota Organisasi</span>
                                    </div>
                                    <span
                                        class="text-lg font-semibold text-gray-900">{{ $user->organization->activeMembers()->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-blue-600 mr-3"></i>
                                        <span class="text-sm text-gray-600">Total Kegiatan</span>
                                    </div>
                                    <span
                                        class="text-lg font-semibold text-gray-900">{{ $user->organization->events()->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-alt text-purple-600 mr-3"></i>
                                        <span class="text-sm text-gray-600">Dokumen</span>
                                    </div>
                                    <span
                                        class="text-lg font-semibold text-gray-900">{{ $user->organization->documents()->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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
                <h3 class="text-lg font-medium text-gray-900 mb-2">Hapus User</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Apakah Anda yakin ingin menghapus user <span id="userName" class="font-semibold"></span>?
                    Tindakan ini tidak dapat dibatalkan.
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
        function confirmDelete(userId, userName) {
            document.getElementById('userName').textContent = userName;
            document.getElementById('deleteForm').action = `/users/${userId}`;
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
