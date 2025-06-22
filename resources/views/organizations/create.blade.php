@extends('layouts.app')

@section('title', 'Tambah Organisasi')

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
                            <a href="{{ route('organizations.index') }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">Organisasi</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mr-4"></i>
                            <span class="text-sm font-medium text-gray-900">Tambah Organisasi</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Tambah Organisasi Baru
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Lengkapi informasi organisasi kemahasiswaan yang akan didaftarkan
            </p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('organizations.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6 p-6">
                @csrf

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                        Informasi Dasar
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nama Organisasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('name') border-red-300 @enderror"
                                placeholder="Contoh: Himpunan Mahasiswa Teknik Informatika">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="acronym" class="block text-sm font-medium text-gray-700">
                                Akronim/Singkatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="acronym" name="acronym" value="{{ old('acronym') }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('acronym') border-red-300 @enderror"
                                placeholder="Contoh: HMTI">
                            @error('acronym')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select id="category" name="category" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('category') border-red-300 @enderror">
                                <option value="">Pilih Kategori</option>
                                <option value="himpunan" {{ old('category') === 'himpunan' ? 'selected' : '' }}>Himpunan
                                    Mahasiswa</option>
                                <option value="ukm" {{ old('category') === 'ukm' ? 'selected' : '' }}>Unit Kegiatan
                                    Mahasiswa</option>
                                <option value="ormawa" {{ old('category') === 'ormawa' ? 'selected' : '' }}>Organisasi
                                    Kemahasiswaan</option>
                                <option value="bem" {{ old('category') === 'bem' ? 'selected' : '' }}>Badan Eksekutif
                                    Mahasiswa</option>
                                <option value="osis" {{ old('category') === 'osis' ? 'selected' : '' }}>OSIS</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="established_date" class="block text-sm font-medium text-gray-700">
                                Tanggal Berdiri
                            </label>
                            <input type="date" id="established_date" name="established_date"
                                value="{{ old('established_date') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('established_date') border-red-300 @enderror">
                            @error('established_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="status" class="block text-sm font-medium text-gray-700">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" name="status" required
                                class="mt-1 block w-full md:w-1/2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('status') border-red-300 @enderror">
                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        <i class="fas fa-align-left mr-2 text-blue-600"></i>
                        Deskripsi
                    </h3>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Deskripsi Organisasi
                        </label>
                        <textarea id="description" name="description" rows="4"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('description') border-red-300 @enderror"
                            placeholder="Deskripsi singkat tentang organisasi, visi, misi, dan tujuan...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Contact Information -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        <i class="fas fa-address-book mr-2 text-blue-600"></i>
                        Informasi Kontak
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-300 @enderror"
                                placeholder="organisasi@university.ac.id">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                Nomor Telepon
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('phone') border-red-300 @enderror"
                                placeholder="021-12345678">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700">
                                Website
                            </label>
                            <input type="url" id="website" name="website" value="{{ old('website') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('website') border-red-300 @enderror"
                                placeholder="https://organisasi.university.ac.id">
                            @error('website')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="social_media" class="block text-sm font-medium text-gray-700">
                                Media Sosial
                            </label>
                            <input type="text" id="social_media" name="social_media"
                                value="{{ old('social_media') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('social_media') border-red-300 @enderror"
                                placeholder="@username_organisasi">
                            @error('social_media')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                        Alamat
                    </h3>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">
                            Alamat Sekretariat
                        </label>
                        <textarea id="address" name="address" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('address') border-red-300 @enderror"
                            placeholder="Alamat lengkap sekretariat organisasi...">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Logo Upload -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        <i class="fas fa-image mr-2 text-blue-600"></i>
                        Logo Organisasi
                    </h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Logo
                        </label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <div id="preview-container" class="hidden mb-4">
                                    <img id="preview-image"
                                        class="mx-auto h-32 w-32 object-cover rounded-lg border-2 border-gray-200"
                                        src="/placeholder.svg" alt="Preview">
                                </div>
                                <div id="upload-placeholder">
                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-3"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="logo"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload file</span>
                                            <input id="logo" name="logo" type="file" class="sr-only"
                                                accept="image/*" onchange="previewImage(this)">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                </div>
                            </div>
                        </div>
                        @error('logo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('organizations.index') }}"
                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Organisasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                    document.getElementById('upload-placeholder').classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        // Auto-generate acronym from name
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value;
            const acronymField = document.getElementById('acronym');

            if (name && !acronymField.value) {
                // Generate acronym from first letters of each word
                const words = name.split(' ');
                const acronym = words.map(word => word.charAt(0).toUpperCase()).join('');
                acronymField.value = acronym;
            }
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = ['name', 'acronym', 'category', 'status'];
            let isValid = true;

            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('border-red-300');
                } else {
                    input.classList.remove('border-red-300');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi.');
            }
        });
    </script>
@endsection
