@extends('layouts.app')

@section('title', 'Edit Anggota - ' . $member->name)

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
                            <a href="{{ route('members.show', $member) }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">{{ $member->name }}</a>
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
                Edit Anggota
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Perbarui informasi anggota {{ $member->name }}
            </p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('members.update', $member) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6 p-6">
                @csrf
                @method('PUT')

                <!-- Organization Selection -->
                @if (auth()->user()->role === 'admin')
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                            <i class="fas fa-building mr-2 text-blue-600"></i>
                            Organisasi
                        </h3>
                        <div>
                            <label for="organization_id" class="block text-sm font-medium text-gray-700">
                                Pilih Organisasi <span class="text-red-500">*</span>
                            </label>
                            <select id="organization_id" name="organization_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('organization_id') border-red-300 @enderror">
                                <option value="">Pilih Organisasi</option>
                                @foreach ($organizations as $org)
                                    <option value="{{ $org->id }}"
                                        {{ old('organization_id', $member->organization_id) == $org->id ? 'selected' : '' }}>
                                        {{ $org->name }} ({{ $org->acronym }})
                                    </option>
                                @endforeach
                            </select>
                            @error('organization_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @else
                    <input type="hidden" name="organization_id" value="{{ $member->organization_id }}">
                @endif

                <!-- Current Photo -->
                @if ($member->photo)
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                            <i class="fas fa-image mr-2 text-blue-600"></i>
                            Foto Saat Ini
                        </h3>
                        <div class="flex items-center space-x-4">
                            <img class="h-20 w-20 rounded-full object-cover" src="{{ Storage::url($member->photo) }}"
                                alt="{{ $member->name }}">
                            <div>
                                <p class="text-sm text-gray-600">Foto profil saat ini</p>
                                <p class="text-xs text-gray-500">Upload foto baru untuk mengganti</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        <i class="fas fa-user mr-2 text-blue-600"></i>
                        Informasi Dasar
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="student_id" class="block text-sm font-medium text-gray-700">
                                NIM/NIS <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="student_id" name="student_id"
                                value="{{ old('student_id', $member->student_id) }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('student_id') border-red-300 @enderror">
                            @error('student_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $member->name) }}"
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
                            <input type="email" id="email" name="email" value="{{ old('email', $member->email) }}"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-300 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                Nomor Telepon
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $member->phone) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('phone') border-red-300 @enderror">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Organization Information -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        <i class="fas fa-id-badge mr-2 text-blue-600"></i>
                        Informasi Organisasi
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700">
                                Posisi/Jabatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="position" name="position"
                                value="{{ old('position', $member->position) }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('position') border-red-300 @enderror">
                            @error('position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="join_date" class="block text-sm font-medium text-gray-700">
                                Tanggal Bergabung <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="join_date" name="join_date"
                                value="{{ old('join_date', $member->join_date->format('Y-m-d')) }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('join_date') border-red-300 @enderror">
                            @error('join_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" name="status" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('status') border-red-300 @enderror">
                                <option value="">Pilih Status</option>
                                <option value="active"
                                    {{ old('status', $member->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive"
                                    {{ old('status', $member->status) === 'inactive' ? 'selected' : '' }}>Tidak Aktif
                                </option>
                                <option value="alumni"
                                    {{ old('status', $member->status) === 'alumni' ? 'selected' : '' }}>Alumni</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Photo Upload -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        <i class="fas fa-camera mr-2 text-blue-600"></i>
                        Update Foto Profil
                    </h3>
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700">
                            Upload Foto Baru
                        </label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="photo"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload foto baru</span>
                                        <input id="photo" name="photo" type="file" class="sr-only"
                                            accept="image/*">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                                <p class="text-xs text-gray-400">Kosongkan jika tidak ingin mengubah foto</p>
                            </div>
                        </div>
                        @error('photo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('members.show', $member) }}"
                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Perbarui Anggota
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Photo preview
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Create preview image
                    const preview = document.createElement('img');
                    preview.src = e.target.result;
                    preview.className = 'mt-2 h-20 w-20 object-cover rounded-full';

                    // Remove existing preview
                    const existingPreview = document.querySelector('.photo-preview');
                    if (existingPreview) {
                        existingPreview.remove();
                    }

                    // Add new preview
                    preview.className += ' photo-preview';
                    document.querySelector('input[type="file"]').parentNode.parentNode.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
