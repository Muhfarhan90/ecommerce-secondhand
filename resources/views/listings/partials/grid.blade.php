{{-- Product Grid with Modern Cards --}}
<div class="space-y-6">

    {{-- Results Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                @if (request('search'))
                    Hasil untuk "{{ request('search') }}"
                @else
                    Semua Iklan
                @endif
            </h2>
            <p class="text-sm text-gray-600 mt-1">
                Ditemukan {{ $listings->total() }} iklan
            </p>
        </div>

        {{-- View Toggle (Optional) --}}
        <div class="hidden md:flex items-center gap-2 bg-gray-100 rounded-lg p-1">
            <button class="px-3 py-2 bg-white text-gray-700 rounded-md shadow-sm text-sm font-medium">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
            </button>
            <button class="px-3 py-2 text-gray-500 hover:text-gray-700 text-sm font-medium">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    </div>

    {{-- Product Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @forelse ($listings as $listing)
            <a href="{{ route('listings.show', $listing) }}"
                class="group bg-white border border-gray-200 rounded-xl overflow-hidden hover:border-blue-200 hover:shadow-xl transition-all duration-300">

                {{-- Image Container --}}
                <div class="aspect-square bg-gray-100 overflow-hidden relative">
                    @if ($listing->images->first())
                        <img src="{{ $listing->images->first()->image_path }}" alt="{{ $listing->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div
                            class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                            <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    @endif

                    {{-- Favorite Button --}}
                    @auth
                        <button type="button" onclick="event.preventDefault(); toggleFavorite({{ $listing->id }}, this)"
                            data-listing-id="{{ $listing->id }}"
                            class="favorite-btn absolute top-3 right-3 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center transition-all shadow-md hover:scale-110 {{ auth()->user()->favorites->contains($listing->id) ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}">
                            <svg class="w-5 h-5"
                                fill="{{ auth()->user()->favorites->contains($listing->id) ? 'currentColor' : 'none' }}"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </button>
                    @endauth
                </div>

                {{-- Card Content --}}
                <div class="p-4 space-y-2">
                    {{-- Title --}}
                    <h3
                        class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2 leading-tight text-base">
                        {{ $listing->title }}
                    </h3>

                    {{-- Price --}}
                    <div class="flex items-baseline gap-2">
                        <p class="text-xl font-bold text-blue-600">
                            Rp {{ number_format($listing->price, 0, ',', '.') }}
                        </p>
                        @if ($listing->is_negotiable)
                            <span class="text-xs text-gray-500 font-medium">(Nego)</span>
                        @endif
                    </div>

                    {{-- Meta Info --}}
                    <div class="flex items-center justify-between text-xs text-gray-500 pt-2 border-t border-gray-100">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="truncate">{{ $listing->city ?? 'Lokasi' }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $listing->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    {{-- Contact Button --}}
                    <button
                        onclick="event.preventDefault(); window.location.href='{{ route('listings.show', $listing) }}'"
                        class="w-full mt-3 py-2.5 bg-blue-50 text-blue-600 text-sm font-semibold rounded-lg hover:bg-blue-100 transition-colors flex items-center justify-center gap-2 group/btn">
                        <svg class="w-4 h-4 group-hover/btn:scale-110 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        Hubungi Penjual
                    </button>
                </div>
            </a>
        @empty
            {{-- Empty State --}}
            <div class="col-span-full">
                <div class="flex flex-col items-center justify-center py-20 px-4 text-center">

                    {{-- Icon --}}
                    <div
                        class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    {{-- Message --}}
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        Tidak Ada Iklan Ditemukan
                    </h3>
                    <p class="text-gray-600 mb-6 max-w-md">
                        Maaf, tidak ada iklan yang sesuai dengan pencarian Anda.
                        Coba ubah kata kunci atau filter pencarian.
                    </p>

                    {{-- Actions --}}
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('home') }}"
                            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            Lihat Semua Iklan
                        </a>
                        <button onclick="resetFilters()"
                            class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                            Reset Filter
                        </button>
                    </div>

                    {{-- Popular Suggestions --}}
                    <div class="mt-8 pt-8 border-t border-gray-200 w-full max-w-lg">
                        <p class="text-sm font-medium text-gray-900 mb-3">Kategori Populer:</p>
                        <div class="flex flex-wrap gap-2 justify-center">
                            <a href="{{ route('home', ['category' => 'elektronik']) }}"
                                class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-colors">
                                Elektronik
                            </a>
                            <a href="{{ route('home', ['category' => 'fashion']) }}"
                                class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-colors">
                                Fashion
                            </a>
                            <a href="{{ route('home', ['category' => 'furniture']) }}"
                                class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-colors">
                                Furniture
                            </a>
                            <a href="{{ route('home', ['category' => 'otomotif']) }}"
                                class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-colors">
                                Otomotif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($listings->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $listings->links() }}
        </div>
    @endif

</div>

<script>
    @auth

    function toggleFavorite(listingId, button) {
        fetch(`/favorites/${listingId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const svg = button.querySelector('svg');
                    if (data.favorited) {
                        button.classList.remove('text-gray-400');
                        button.classList.add('text-red-500');
                        svg.setAttribute('fill', 'currentColor');
                    } else {
                        button.classList.remove('text-red-500');
                        button.classList.add('text-gray-400');
                        svg.setAttribute('fill', 'none');
                    }
                }
            })
            .catch(() => alert('Terjadi kesalahan'));
    }
    @endauth
</script>
