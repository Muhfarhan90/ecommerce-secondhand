@extends('layouts.master')

@section('title', 'Favorit Saya - SecondHand')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-12">
        <div class="max-w-7xl mx-auto px-4">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    Favorit Saya
                </h1>
                <p class="text-gray-600">
                    Daftar iklan yang Anda simpan
                </p>
            </div>

            {{-- Favorites Grid --}}
            @if ($favorites->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @foreach ($favorites as $favorite)
                        @php $listing = $favorite->listing; @endphp
                        <div
                            class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">

                            <a href="{{ route('listings.show', $listing) }}" class="block">
                                {{-- Image --}}
                                <div class="relative aspect-square overflow-hidden bg-gray-100">
                                    @if ($listing->images->count() > 0)
                                        <img src="{{ $listing->images->firstWhere('is_primary', true)?->image_path ?? $listing->images->first()->image_path }}"
                                            alt="{{ $listing->title }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif

                                    {{-- Condition Badge --}}
                                    <div class="absolute top-3 left-3">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $listing->condition === 'new' ? 'bg-green-500 text-white' : 'bg-blue-500 text-white' }}">
                                            {{ $listing->condition === 'new' ? 'Baru' : 'Bekas' }}
                                        </span>
                                    </div>

                                    {{-- Remove Favorite Button --}}
                                    <button type="button"
                                        onclick="event.preventDefault(); removeFavorite({{ $listing->id }})"
                                        class="absolute top-3 right-3 bg-red-600 hover:bg-red-700 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity shadow-lg"
                                        title="Hapus dari favorit">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>

                                {{-- Content --}}
                                <div class="p-4">
                                    <div class="flex items-start gap-2 mb-2">
                                        <span
                                            class="inline-block px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded">
                                            {{ $listing->category->name }}
                                        </span>
                                    </div>

                                    <h3
                                        class="font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                        {{ $listing->title }}
                                    </h3>

                                    <p class="text-2xl font-bold text-blue-600 mb-3">
                                        Rp {{ number_format($listing->price, 0, ',', '.') }}
                                    </p>

                                    <div class="space-y-2 text-sm text-gray-600">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span>{{ $listing->city }}, {{ $listing->province }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                            <span>{{ $listing->user->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="flex justify-center">
                    {{ $favorites->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                    <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        Belum Ada Favorit
                    </h3>
                    <p class="text-gray-600 mb-6">
                        Anda belum menyimpan iklan favorit
                    </p>
                    <a href="{{ route('listings.index') }}"
                        class="inline-block bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                        Jelajahi Iklan
                    </a>
                </div>
            @endif

        </div>
    </div>

    {{-- Hidden Form for Removing Favorites --}}
    <form id="favorite-form" method="POST" class="hidden">
        @csrf
    </form>
@endsection

@push('scripts')
    <script>
        function removeFavorite(listingId) {
            if (!confirm('Hapus dari favorit?')) return;

            const form = document.getElementById('favorite-form');
            form.action = `/favorites/${listingId}`;

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload page to update the list
                        window.location.reload();
                    } else {
                        alert('Gagal menghapus dari favorit');
                    }
                })
                .catch(() => alert('Terjadi kesalahan'));
        }
    </script>
@endpush
