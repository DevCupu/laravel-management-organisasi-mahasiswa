@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Edit Profile
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola informasi profil dan pengaturan akun Anda
                </p>
            </div>

            <!-- Update Profile Information -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Informasi Profil
                    </h3>
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('name') border-red-300 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-300 @enderror">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700">
                                    NIM/NIS
                                </label>
                                <input type="text" id="student_id" name="student_id"
                                    value="{{ old('student_id', $user->student_id) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('student_id') border-red-300 @enderror">
                                @error('student_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">
                                    Nomor Telepon
                                </label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('phone') border-red-300 @enderror">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Read-only fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-200">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Role</label>
                                <div class="mt-1 text-sm text-gray-900">{{ $user->role_label }}</div>
                            </div>

                            @if ($user->organization)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Organisasi</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $user->organization->name }}</div>
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Password -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Ubah Password
                    </h3>
                    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">
                                    Password Saat Ini <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="current_password" name="current_password" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('current_password', 'updatePassword') border-red-300 @enderror">
                                @error('current_password', 'updatePassword')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Password Baru <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="password" name="password" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('password', 'updatePassword') border-red-300 @enderror">
                                @error('password', 'updatePassword')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                    Konfirmasi Password Baru <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('password_confirmation', 'updatePassword') border-red-300 @enderror">
                                @error('password_confirmation', 'updatePassword')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                <i class="fas fa-key mr-2"></i>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Account -->
            @if ($user->role !== 'admin')
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-red-900 mb-4">
                            Hapus Akun
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen.
                            Sebelum menghapus akun, harap unduh data atau informasi yang ingin Anda simpan.
                        </p>
                        <button onclick="openDeleteModal()"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus Akun
                        </button>
                    </div>
                </div>

                <!-- Delete Account Modal -->
                <div id="deleteAccountModal"
                    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="mt-3 text-center">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Hapus Akun</h3>
                            <p class="text-sm text-gray-500 mb-4">
                                Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dibatalkan.
                            </p>
                            <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                                @csrf
                                @method('delete')

                                <div>
                                    <label for="delete_password"
                                        class="block text-sm font-medium text-gray-700 text-left">
                                        Masukkan password untuk konfirmasi:
                                    </label>
                                    <input type="password" id="delete_password" name="password" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm @error('password', 'userDeletion') border-red-300 @enderror"
                                        placeholder="Password Anda">
                                    @error('password', 'userDeletion')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-center space-x-3">
                                    <button type="button" onclick="closeDeleteModal()"
                                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                        Hapus Akun
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function openDeleteModal() {
            document.getElementById('deleteAccountModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteAccountModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('deleteAccountModal')?.addEventListener('click', function(e) {
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

        // Show success message
        @if (session('status') === 'profile-updated')
            // You can add a toast notification here
            console.log('Profile updated successfully');
        @endif
    </script>
@endsection
