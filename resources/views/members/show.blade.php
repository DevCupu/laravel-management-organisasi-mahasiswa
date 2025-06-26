@extends('layouts.app')

@section('title', 'Detail Anggota - ' . $member->name)

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
                            <a href="{{ route('members.index') }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">Anggota</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mr-4"></i>
                            <span class="text-sm font-medium text-gray-900">{{ $member->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Member Header -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            @if ($member->photo_path)
                                <img class="h-20 w-20 rounded-full object-cover border-4 border-gray-200"
                                    src="{{ Storage::url($member->photo_path) }}" alt="{{ $member->name }}">
                            @else
                                <div
                                    class="h-20 w-20 rounded-full bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center">
                                    <i class="fas fa-user text-white text-3xl"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $member->name }}</h1>
                            <p class="text-lg text-gray-600">{{ $member->student_id }}</p>
                            <div class="flex items-center space-x-4 mt-2">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if ($member->status === 'active') bg-green-100 text-green-800 
                                @elseif($member->status === 'alumni')
                                    bg-blue-100 text-blue-800
                                @else 
                                    bg-gray-100 text-gray-800 @endif">
                                    <i class="fas fa-circle mr-2 text-xs"></i>
                                    {{ $member->status_label }}
                                </span>
                                @if ($member->position)
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                        {{ $member->position }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if (auth()->user()->isAdmin() || auth()->user()->isOrganizationAdmin())
                        <div class="flex space-x-3">
                            <a href="{{ route('members.edit', $member) }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <i class="fas fa-edit mr-2"></i>
                                Edit
                            </a>
                            <button onclick="confirmDelete('{{ $member->id }}', '{{ $member->name }}')"
                                class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-600 bg-white hover:bg-red-50 transition-colors">
                                <i class="fas fa-trash mr-2"></i>
                                Hapus
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Member Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            <i class="fas fa-user mr-2 text-blue-600"></i>
                            Informasi Anggota
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $member->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">NIM/NIS</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $member->student_id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <a href="mailto:{{ $member->email }}" class="text-blue-600 hover:text-blue-500">
                                        {{ $member->email }}
                                    </a>
                                </p>
                            </div>
                            @if ($member->phone)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Telepon</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        <a href="tel:{{ $member->phone }}" class="text-blue-600 hover:text-blue-500">
                                            {{ $member->phone }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($member->position)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Jabatan</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $member->position }}</p>
                                </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Status</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    @if ($member->status === 'active') bg-green-100 text-green-800 
                                    @elseif($member->status === 'alumni')
                                        bg-blue-100 text-blue-800
                                    @else 
                                        bg-gray-100 text-gray-800 @endif">
                                        {{ $member->status_label }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Tanggal Bergabung</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $member->join_date->format('d M Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Terdaftar</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $member->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organization Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            <i class="fas fa-building mr-2 text-blue-600"></i>
                            Informasi Organisasi
                        </h3>
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                @if ($member->organization->logo_path)
                                    <img class="h-12 w-12 rounded-full object-cover"
                                        src="{{ Storage::url($member->organization->logo_path) }}"
                                        alt="{{ $member->organization->name }}">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-graduation-cap text-blue-600"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-900">{{ $member->organization->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $member->organization->acronym }} •
                                    {{ $member->organization->category_label }}</p>
                                @if ($member->organization->email)
                                    <p class="text-sm text-gray-500">{{ $member->organization->email }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('organizations.show', $member->organization) }}"
                                class="text-sm text-blue-600 hover:text-blue-500">
                                Lihat detail organisasi →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                @if (auth()->user()->isAdmin() || auth()->user()->isOrganizationAdmin())
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                <i class="fas fa-bolt mr-2 text-blue-600"></i>
                                Aksi Cepat
                            </h3>
                            <div class="space-y-2">
                                <a href="{{ route('members.edit', $member) }}"
                                    class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-50 rounded-md hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-edit mr-3 text-blue-600"></i>
                                    Edit Anggota
                                </a>
                                <a href="{{ route('organizations.show', $member->organization) }}"
                                    class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-50 rounded-md hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-building mr-3 text-purple-600"></i>
                                    Lihat Organisasi
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Member Timeline -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            <i class="fas fa-clock mr-2 text-blue-600"></i>
                            Timeline
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <i class="fas fa-user-plus text-green-600 text-sm"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Bergabung dengan organisasi</p>
                                    <p class="text-sm text-gray-500">{{ $member->join_date->format('d M Y') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-database text-blue-600 text-sm"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Terdaftar dalam sistem</p>
                                    <p class="text-sm text-gray-500">{{ $member->created_at->format('d M Y') }}</p>
                                </div>
                            </div>

                            @if ($member->updated_at != $member->created_at)
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center">
                                            <i class="fas fa-edit text-yellow-600 text-sm"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Data terakhir diperbarui</p>
                                        <p class="text-sm text-gray-500">{{ $member->updated_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Member Statistics -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                            Statistik
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar text-green-600 mr-3"></i>
                                    <span class="text-sm text-gray-600">Lama Bergabung</span>
                                </div>
                                <span class="text-lg font-semibold text-gray-900">
                                    {{ $member->join_date->diffInMonths(now()) }} bulan
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-users text-blue-600 mr-3"></i>
                                    <span class="text-sm text-gray-600">Total Anggota Organisasi</span>
                                </div>
                                <span
                                    class="text-lg font-semibold text-gray-900">{{ $member->organization->activeMembers()->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if (auth()->user()->isAdmin() || auth()->user()->isOrganizationAdmin())
        <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Hapus Anggota</h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Apakah Anda yakin ingin menghapus anggota <span id="memberName" class="font-semibold"></span>?
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
            function confirmDelete(memberId, memberName) {
                document.getElementById('memberName').textContent = memberName;
                document.getElementById('deleteForm').action = `/members/${memberId}`;
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
    @endif
@endsection
