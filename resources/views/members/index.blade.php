@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Daftar Anggota
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Kelola anggota organisasi kemahasiswaan
            </p>
        </div>
        @if(auth()->user()->isAdmin() || auth()->user()->isOrganizationAdmin())
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('members.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Anggota
                </a>
            </div>
        @endif
    </div>

    <!-- Search and Filter -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <form method="GET" action="{{ route('members.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Anggota</label>
                        <div class="relative">
                            <input type="text" 
                                   id="search"
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Nama, NIM, email..." 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    @if(auth()->user()->isAdmin())
                        <div>
                            <label for="organization_id" class="block text-sm font-medium text-gray-700 mb-2">Organisasi</label>
                            <select name="organization_id" 
                                    id="organization_id"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Semua Organisasi</option>
                                @foreach($organizations as $org)
                                    <option value="{{ $org->id }}" {{ request('organization_id') == $org->id ? 'selected' : '' }}>
                                        {{ $org->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" 
                                id="status"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="alumni" {{ request('status') === 'alumni' ? 'selected' : '' }}>Alumni</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                        <input type="text" 
                               id="position"
                               name="position" 
                               value="{{ request('position') }}" 
                               placeholder="Ketua, Sekretaris..." 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    
                    <div class="flex items-end space-x-2">
                        <button type="submit" 
                                class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                        <a href="{{ route('members.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Members Grid -->
    @if($members->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @foreach($members as $member)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition-shadow duration-200 border border-gray-200">
                    <div class="px-6 py-5">
                        <!-- Header with Photo and Status -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 h-12 w-12">
                                    @if($member->photo_path)
                                        <img class="h-12 w-12 rounded-full object-cover border-2 border-gray-200" 
                                             src="{{ Storage::url($member->photo_path) }}" 
                                             alt="{{ $member->name }}">
                                    @else
                                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center">
                                            <i class="fas fa-user text-white text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $member->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $member->student_id }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($member->status === 'active') 
                                    bg-green-100 text-green-800 
                                @elseif($member->status === 'alumni')
                                    bg-blue-100 text-blue-800
                                @else 
                                    bg-gray-100 text-gray-800 
                                @endif">
                                {{ $member->status_label }}
                            </span>
                        </div>

                        <!-- Position -->
                        @if($member->position)
                            <div class="mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $member->position }}
                                </span>
                            </div>
                        @endif

                        <!-- Organization -->
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-building mr-1"></i>
                                {{ $member->organization->name }}
                            </p>
                        </div>

                        <!-- Contact Info -->
                        <div class="space-y-2 mb-4">
                            @if($member->email)
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-envelope mr-2 w-4"></i>
                                    <span class="truncate">{{ $member->email }}</span>
                                </div>
                            @endif
                            @if($member->phone)
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-phone mr-2 w-4"></i>
                                    <span>{{ $member->phone }}</span>
                                </div>
                            @endif
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar mr-2 w-4"></i>
                                <span>Bergabung {{ $member->join_date->format('M Y') }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            <a href="{{ route('members.show', $member) }}" 
                               class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 text-center transition-colors">
                                <i class="fas fa-eye mr-1"></i>
                                Detail
                            </a>
                            @if(auth()->user()->isAdmin() || auth()->user()->isOrganizationAdmin())
                                <a href="{{ route('members.edit', $member) }}" 
                                   class="px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmDelete('{{ $member->id }}', '{{ $member->name }}')"
                                        class="px-3 py-2 border border-red-300 text-red-600 rounded-md text-sm font-medium hover:bg-red-50 transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($members->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6 rounded-lg shadow-sm">
                {{ $members->appends(request()->query())->links() }}
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
                    @if(request()->hasAny(['search', 'organization_id', 'status', 'position']))
                        Tidak ada anggota yang ditemukan
                    @else
                        Belum ada anggota
                    @endif
                </h3>
                <p class="text-gray-500 mb-6">
                    @if(request()->hasAny(['search', 'organization_id', 'status', 'position']))
                        Coba ubah filter pencarian atau hapus filter untuk melihat semua anggota.
                    @else
                        Mulai dengan menambahkan anggota pertama ke dalam organisasi.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'organization_id', 'status', 'position']))
                    <a href="{{ route('members.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mr-3">
                        <i class="fas fa-times mr-2"></i>
                        Hapus Filter
                    </a>
                @endif
                @if(auth()->user()->isAdmin() || auth()->user()->isOrganizationAdmin())
                    <a href="{{ route('members.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Anggota
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
@if(auth()->user()->isAdmin() || auth()->user()->isOrganizationAdmin())
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
