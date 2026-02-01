{{-- Modern Filter Sidebar --}}
<div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm sticky top-24 space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between pb-4 border-b border-gray-200">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                </path>
            </svg>
            <h3 class="font-bold text-lg text-gray-900">Filter Pencarian</h3>
        </div>
        <button type="button" onclick="resetFilters()" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
            Reset
        </button>
    </div>

    <form method="GET" action="{{ route('listings.index') }}" id="filterForm">

        {{-- Search Query (hidden, preserve from main search) --}}
        @if (request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        {{-- Category Filter --}}
        <div class="space-y-3">
            <label class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                    </path>
                </svg>
                Kategori
            </label>
            <select name="category"
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}"
                        {{ request('category') == $category->slug ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Price Range --}}
        <div class="space-y-3">
            <label class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
                Rentang Harga
            </label>
            <div class="grid grid-cols-2 gap-3">
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                        class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors hover:border-gray-400">
                </div>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                        class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors hover:border-gray-400">
                </div>
            </div>

            {{-- Quick Price Filters --}}
            <div class="flex flex-wrap gap-2 pt-2">
                <button type="button" onclick="setPrice(0, 100000)"
                    class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    < 100rb </button>
                        <button type="button" onclick="setPrice(100000, 500000)"
                            class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            100rb - 500rb
                        </button>
                        <button type="button" onclick="setPrice(500000, 1000000)"
                            class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            500rb - 1jt
                        </button>
                        <button type="button" onclick="setPrice(1000000, null)"
                            class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            > 1jt
                        </button>
            </div>
        </div>

        {{-- Condition Filter --}}
        <div class="space-y-3">
            <label class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Kondisi Barang
            </label>
            <div class="space-y-2">
                <label
                    class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg cursor-pointer transition-colors">
                    <input type="radio" name="condition" value=""
                        {{ request('condition') == '' ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                    <span class="ml-3 text-sm text-gray-700">Semua Kondisi</span>
                </label>
                <label
                    class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg cursor-pointer transition-colors">
                    <input type="radio" name="condition" value="new"
                        {{ request('condition') == 'new' ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                    <span class="ml-3 text-sm text-gray-700">Baru</span>
                    <span
                        class="ml-auto px-2 py-0.5 text-xs font-medium text-green-700 bg-green-50 rounded-full">New</span>
                </label>
                <label
                    class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg cursor-pointer transition-colors">
                    <input type="radio" name="condition" value="used"
                        {{ request('condition') == 'used' ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                    <span class="ml-3 text-sm text-gray-700">Bekas</span>
                    <span
                        class="ml-auto px-2 py-0.5 text-xs font-medium text-blue-700 bg-blue-50 rounded-full">Used</span>
                </label>
            </div>
        </div>

        {{-- Location Filter --}}
        <div class="space-y-3">
            <label class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Lokasi
            </label>
            <input type="text" name="location" value="{{ request('location') }}"
                placeholder="Cari kota atau wilayah..."
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors hover:border-gray-400">
        </div>

        {{-- Sort By --}}
        <div class="space-y-3">
            <label class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                </svg>
                Urutkan
            </label>
            <select name="sort"
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah
                </option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi
                </option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Paling Populer</option>
            </select>
        </div>

        {{-- Apply Button --}}
        <button type="submit"
            class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors shadow-sm hover:shadow-md flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Terapkan Filter
        </button>

    </form>

    {{-- Active Filters Display --}}
    @if (request()->hasAny(['category', 'min_price', 'max_price', 'condition', 'location', 'sort']))
        <div class="pt-4 border-t border-gray-200 space-y-2">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Filter Aktif:</p>
            <div class="flex flex-wrap gap-2">
                @if (request('category'))
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-full">
                        {{ ucfirst(request('category')) }}
                        <button type="button" onclick="removeFilter('category')"
                            class="hover:bg-blue-100 rounded-full p-0.5">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </span>
                @endif
                @if (request('min_price') || request('max_price'))
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1 bg-green-50 text-green-700 text-xs font-medium rounded-full">
                        @if (request('min_price'))
                            Rp {{ number_format(request('min_price'), 0, ',', '.') }}
                        @endif
                        @if (request('min_price') && request('max_price'))
                            -
                        @endif
                        @if (request('max_price'))
                            Rp {{ number_format(request('max_price'), 0, ',', '.') }}
                        @endif
                        <button type="button" onclick="removeFilter('price')"
                            class="hover:bg-green-100 rounded-full p-0.5">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </span>
                @endif
                @if (request('condition'))
                    @foreach (request('condition', []) as $cond)
                        <span
                            class="inline-flex items-center gap-1 px-3 py-1 bg-purple-50 text-purple-700 text-xs font-medium rounded-full">
                            {{ ucfirst($cond) }}
                        </span>
                    @endforeach
                @endif
            </div>
        </div>
    @endif

</div>

<script>
    function setPrice(min, max) {
        if (min !== null) document.querySelector('input[name="min_price"]').value = min;
        if (max !== null) document.querySelector('input[name="max_price"]').value = max;
    }

    function resetFilters() {
        window.location.href = '{{ route('listings.index') }}';
    }

    function removeFilter(type) {
        const form = document.getElementById('filterForm');
        if (type === 'category') {
            form.querySelector('select[name="category"]').value = '';
        } else if (type === 'price') {
            form.querySelector('input[name="min_price"]').value = '';
            form.querySelector('input[name="max_price"]').value = '';
        }
        form.submit();
    }
</script>
