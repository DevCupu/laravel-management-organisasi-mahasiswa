@extends('layouts.app')

@section('title', 'Edit User - ' . $user->name)

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
                            <a href="{{ route('users.show', $user) }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">{{ $user->name }}</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mr-4"></i>
                            <span class="text-sm font-medium text-gray-900">Edit</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Edit User
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Perbarui informasi user {{ $user->name }}
            </p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6 p-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        <i class="fas fa-user mr-2 text-blue-600"></i>
                        Informasi Dasar
                    </h3>
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
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Password Baru
                            </label>
                            <input type="password" id="password" name="password"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('password') border-red-300 @enderror"
                                placeholder="Kosongkan jika tidak ingin mengubah">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter jika diisi</p>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                Konfirmasi Password
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>

                <!-- Role & Organization -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        <i class="fas fa-user-tag mr-2 text-blue-600"></i>
                        Role & Organisasi
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select id="role" name="role" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('role') border-red-300 @enderror">
                                <option value="">Pilih Role</option>
                                <option value="organization_admin"
                                    {{ old('role', $user->role) === 'organization_admin' ? 'selected' : '' }}>Admin
                                    Organisasi</option>
                                <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>Member
                                </option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="organization_id" class="block text-sm font-medium text-gray-700">
                                Organisasi <span class="text-red-500">*</span>
                            </label>
                            <select id="organization_id" name="organization_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('organization_id') border-red-300 @enderror">
                                <option value="">Pilih Organisasi</option>
                                @foreach ($organizations as $org)
                                    <option value="{{ $org->id }}"
                                        {{ old('organization_id', $user->organization_id) == $org->id ? 'selected' : '' }}>
                                        {{ $org->name }} ({{ $org->acronym }})
                                    </option>
                                @endforeach
                            </select>
                            @error('organization_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                        Informasi Tambahan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                        <div>
                            <label for="is_active" class="block text-sm font-medium text-gray-700">
                                Status
                            </label>
                            <select id="is_active" name="is_active"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="1" {{ old('is_active', $user->is_active) ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="0" {{ !old('is_active', $user->is_active) ? 'selected' : '' }}>Tidak
                                    Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('users.show', $user) }}"
                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Perbarui User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            if (password && password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok.');
                return;
            }

            if (password && password.length < 8) {
                e.preventDefault();
                alert('Password minimal 8 karakter.');
                return;
            }
        });
    </script>
@endsection
