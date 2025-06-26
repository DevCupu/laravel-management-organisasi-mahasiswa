@extends('layouts.app')

@section('title', 'Kelola Users')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Kelola Users
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Kelola admin organisasi dan anggota dalam sistem
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('users.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Tambah User
            </a>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <form method="GET" action="{{ route('users.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari User</label>
                        <div class="relative">
                            <input type="text" 
                                   id="search"
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Nama, email, atau NIM..." 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <select name="role" 
                                id="role"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Semua Role</option>
                            <option value="organization_admin" {{ request('role') === 'organization_admin' ? 'selected' : '' }}>Admin Organisasi</option>
                            <option value="member" {{ request('role') === 'member' ? 'selected' : '' }}>Member</option>
                        </select>
                    </div>
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
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" 
                                id="status"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit" 
                                class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                        <a href="{{ route('users.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    @if($users->count() > 0)
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @foreach($users as $user)
                    <li>
                        <div class="px-4 py-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        @if(!$user->is_active)
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Tidak Aktif
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    <div class="text-sm text-gray-500">
                                        {{ $user->role_label }}
                                        @if($user->organization)
                                            - {{ $user->organization->name }}
                                        @endif
                                    </div>
                                    @if($user->student_id)
                                        <div class="text-xs text-gray-400">NIM: {{ $user->student_id }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('users.show', $user) }}" 
                                   class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('users.toggle-status', $user) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="text-{{ $user->is_active ? 'yellow' : 'green' }}-600 hover:text-{{ $user->is_active ? 'yellow' : 'green' }}-900 text-sm font-medium">
                                        <i class="fas fa-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                                    </button>
                                </form>
                                <button onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')"
                                        class="text-red-600 hover:text-red-900 text-sm font-medium">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6 rounded-lg shadow-sm mt-4">
                {{ $users->appends(request()->query())->links() }}
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
                    @if(request()->hasAny(['search', 'role', 'organization_id', 'status']))
                        Tidak ada user yang ditemukan
                    @else
                        Belum ada user
                    @endif
                </h3>
                <p class="text-gray-500 mb-6">
                    @if(request()->hasAny(['search', 'role', 'organization_id', 'status']))
                        Coba ubah filter pencarian atau hapus filter untuk melihat semua user.
                    @else
                        Mulai dengan menambahkan admin organisasi atau member ke dalam sistem.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'role', 'organization_id', 'status']))
                    <a href="{{ route('users.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mr-3">
                        <i class="fas fa-times mr-2"></i>
                        Hapus Filter
                    </a>
                @endif
                <a href="{{ route('users.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah User
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
