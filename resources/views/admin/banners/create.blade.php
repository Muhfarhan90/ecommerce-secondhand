@extends('admin.layouts.master')

@section('title', 'Tambah Banner')

@section('content')
    <div class="max-w-2xl">

        <div class="mb-6">
            <a href="{{ route('admin.banners.index') }}" class="text-red-600 hover:text-red-700 font-medium">
                ← Kembali
            </a>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-6">Tambah Banner</h1>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Banner</label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Banner</label>
                        <input type="file" name="image" required accept="image/*"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('image') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">JPG, PNG maksimal 2MB. Rekomendasi ukuran: 1200x400px</p>
                        @error('image')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Link ke Produk (Opsional)</label>
                        <div class="relative" x-data="productSearch()">
                            <input type="text" x-model="search" @input.debounce.500ms="searchProducts()"
                                @focus="showDropdown = true" placeholder="Cari produk..."
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500">

                            <input type="hidden" name="listing_id" x-model="selectedId">

                            <div x-show="showDropdown && results.length > 0" @click.away="showDropdown = false"
                                class="absolute z-10 w-full mt-2 bg-white border-2 border-gray-200 rounded-xl shadow-lg max-h-80 overflow-y-auto">
                                <template x-for="listing in results" :key="listing.id">
                                    <div @click="selectListing(listing)"
                                        class="flex items-center gap-3 p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-0">
                                        <img :src="listing.thumbnail" :alt="listing.title"
                                            class="w-12 h-12 object-cover rounded">
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900 text-sm" x-text="listing.title"></p>
                                            <p class="text-xs text-gray-500" x-text="'Penjual: ' + listing.seller"></p>
                                            <p class="text-xs text-blue-600 font-medium" x-text="listing.price"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div x-show="selectedListing"
                                class="mt-3 p-3 bg-green-50 border border-green-200 rounded-xl flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img :src="selectedListing?.thumbnail" class="w-12 h-12 object-cover rounded">
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm" x-text="selectedListing?.title"></p>
                                        <p class="text-xs text-gray-600" x-text="'Penjual: ' + selectedListing?.seller"></p>
                                    </div>
                                </div>
                                <button type="button" @click="clearSelection()" class="text-red-600 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('listing_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Urutan</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <p class="text-xs text-gray-500 mt-1">Angka lebih kecil akan ditampilkan lebih dulu</p>
                    </div>

                    <div>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_active" value="1" checked
                                class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            <span class="text-sm font-medium text-gray-700">Aktifkan banner</span>
                        </label>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                            class="px-6 py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition">
                            Simpan
                        </button>
                        <a href="{{ route('admin.banners.index') }}"
                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <script>
        function productSearch() {
            return {
                search: '',
                results: [],
                showDropdown: false,
                selectedId: '',
                selectedListing: null,

                async searchProducts() {
                    if (this.search.length < 2) {
                        this.results = [];
                        return;
                    }

                    try {
                        const response = await fetch(
                            `{{ route('admin.banners.search-listings') }}?q=${encodeURIComponent(this.search)}`, {
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            });
                        this.results = await response.json();
                        this.showDropdown = true;
                    } catch (error) {
                        console.error('Search error:', error);
                    }
                },

                selectListing(listing) {
                    this.selectedId = listing.id;
                    this.selectedListing = listing;
                    this.search = listing.title;
                    this.showDropdown = false;
                },

                clearSelection() {
                    this.selectedId = '';
                    this.selectedListing = null;
                    this.search = '';
                }
            }
        }
    </script>
@endsection
