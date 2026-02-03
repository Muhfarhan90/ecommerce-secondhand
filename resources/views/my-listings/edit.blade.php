@extends('layouts.master')

@section('title', 'Edit Iklan - SecondHand')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-12">
        <div class="max-w-4xl mx-auto px-4">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    Edit Iklan
                </h1>
                <p class="text-gray-600">
                    Perbarui informasi produk Anda
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-xl border-2 border-red-200 bg-red-50 p-5">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="font-semibold text-red-800 mb-2">
                                Terjadi kesalahan:
                            </p>
                            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('my-listings.update', $listing) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Main Card --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-6">

                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Produk
                    </h2>

                    <div class="space-y-6">
                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Judul Iklan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title', $listing->title) }}"
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('title') border-red-500 @enderror"
                                required>
                            @error('title')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id"
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('category_id') border-red-500 @enderror"
                                required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected($category->id == $listing->category_id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Price & Condition --}}
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Harga <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                                    <input type="number" name="price" value="{{ old('price', $listing->price) }}"
                                        class="w-full border-2 border-gray-200 rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('price') border-red-500 @enderror"
                                        required>
                                </div>
                                @error('price')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kondisi <span class="text-red-500">*</span>
                                </label>
                                <select name="condition"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('condition') border-red-500 @enderror"
                                    required>
                                    <option value="used" @selected($listing->condition === 'used')>Bekas</option>
                                    <option value="new" @selected($listing->condition === 'new')>Baru</option>
                                </select>
                                @error('condition')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Deskripsi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" rows="5"
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none @error('description') border-red-500 @enderror"
                                required>{{ old('description', $listing->description) }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Location Card --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-6">

                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Lokasi
                    </h2>

                    <div class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kota <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="city" value="{{ old('city', $listing->city) }}"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('city') border-red-500 @enderror"
                                    required>
                                @error('city')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Provinsi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="province" value="{{ old('province', $listing->province) }}"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('province') border-red-500 @enderror"
                                    required>
                                @error('province')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat Lengkap
                            </label>
                            <input type="text" name="address" value="{{ old('address', $listing->address) }}"
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('address') border-red-500 @enderror">
                            @error('address')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Images Card --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-6">

                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Foto Produk
                    </h2>

                    @if ($listing->images->count() > 0)
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Foto Saat Ini
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="current-images">
                                @foreach ($listing->images as $image)
                                    <div class="relative group" id="image-{{ $image->id }}">
                                        <img src="{{ $image->image_path }}" alt="Listing Image"
                                            class="w-full h-32 object-cover rounded-xl border-2 border-gray-200">
                                        <button type="button" onclick="deleteImage({{ $image->id }})"
                                            class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        @if ($image->is_primary)
                                            <span
                                                class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded-lg font-medium">Utama</span>
                                        @endif>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Tambah Foto Baru (Opsional)
                        </label>
                        <label class="block w-full cursor-pointer">
                            <div
                                class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                                <p class="text-gray-700 font-medium mb-1">Klik untuk upload foto</p>
                                <p class="text-xs text-gray-400">PNG, JPG hingga 2MB</p>
                            </div>
                            <input id="edit-images-input" type="file" name="images[]" class="sr-only" multiple
                                accept="image/*">
                        </label>
                        <div id="edit-images-list" class="mt-3 text-sm text-gray-600"></div>
                        @error('images')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex gap-4 mb-6">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-blue-600 to-blue-500 text-white py-4 rounded-xl font-semibold hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('my-listings.index') }}"
                        class="px-8 py-4 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                </div>
            </form>

            {{-- Delete Section --}}
            <form method="POST" action="{{ route('my-listings.destroy', $listing) }}"
                onsubmit="return confirm('Yakin hapus iklan ini? Data tidak dapat dikembalikan.');"
                class="bg-white rounded-2xl shadow-lg border border-red-200 p-6">
                @csrf
                @method('DELETE')
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Zona Bahaya</h3>
                        <p class="text-sm text-gray-600">Hapus iklan ini secara permanen</p>
                    </div>
                    <button type="submit"
                        class="px-6 py-2.5 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-colors">
                        Hapus Iklan
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function deleteImage(imageId) {
            if (!confirm('Hapus foto ini?')) return;

            fetch(`/my-listings/images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`image-${imageId}`).remove();
                        if (document.querySelectorAll('#current-images > div').length === 0) {
                            document.getElementById('current-images').parentElement.remove();
                        }
                    } else {
                        alert(data.message || 'Gagal menghapus foto');
                    }
                })
                .catch(() => alert('Terjadi kesalahan'));
        }

        // Show selected filenames for new images
        const editImagesInput = document.getElementById('edit-images-input');
        const editImagesList = document.getElementById('edit-images-list');
        if (editImagesInput) {
            editImagesInput.addEventListener('change', function() {
                if (!editImagesInput.files || editImagesInput.files.length === 0) {
                    editImagesList.textContent = '';
                    return;
                }
                const names = Array.from(editImagesInput.files).map(f => f.name + ' (' + Math.round(f.size / 1024) +
                    ' KB)');
                editImagesList.textContent = 'Foto baru: ' + names.join(', ');
            });
        }
    </script>
@endpush
