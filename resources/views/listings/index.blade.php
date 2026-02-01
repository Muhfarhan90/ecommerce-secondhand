@extends('layouts.master')

@section('title', 'Jelajahi Iklan - SecondHand')
@section('meta_description',
    'Temukan ribuan iklan barang bekas berkualitas. Filter berdasarkan harga, kategori,
    kondisi, dan lokasi.')

    @push('styles')
        <style>
            /* Mobile filter toggle animation */
            .filter-sidebar {
                transition: transform 0.3s ease-in-out;
            }

            @media (max-width: 768px) {
                .filter-sidebar.hidden-mobile {
                    transform: translateX(-100%);
                }
            }
        </style>
    @endpush

@section('content')

    {{-- Search Bar Section --}}
    <section class="bg-gradient-to-r from-blue-600 to-blue-500 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('listings.index') }}" method="GET" class="max-w-3xl mx-auto">
                <div class="flex gap-3">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari barang yang kamu butuhkan..."
                            class="w-full px-6 py-4 pr-12 rounded-xl text-white placeholder-gray-100 focus:outline-none focus:ring-4 focus:ring-blue-200 shadow-lg">
                        <svg class="absolute right-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-100"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button type="submit"
                        class="px-8 py-3.5 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-colors shadow-lg hidden sm:block">
                        Cari
                    </button>
                    <button type="submit"
                        class="sm:hidden px-6 py-3.5 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-colors shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>

                {{-- Quick Category Pills --}}
                <div class="flex flex-wrap gap-2 mt-4 justify-center">
                    @foreach ($categories as $category)
                        <a href="{{ route('listings.index', ['category' => $category->slug]) }}"
                            class="px-4 py-2 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white text-sm font-medium rounded-full transition-colors border border-white/20">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </form>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Mobile Filter Toggle --}}
            <div class="md:hidden mb-4 flex items-center justify-between">
                <button onclick="toggleMobileFilter()"
                    class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                        </path>
                    </svg>
                    Filter & Urutkan
                </button>
                <span class="text-sm text-gray-600">
                    {{ $listings->total() }} iklan
                </span>
            </div>

            <div class="grid md:grid-cols-4 gap-6">

                {{-- Filter Sidebar --}}
                <aside class="md:col-span-1">
                    {{-- Mobile Overlay --}}
                    <div id="filterOverlay" onclick="toggleMobileFilter()"
                        class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>

                    {{-- Filter Container --}}
                    <div id="filterSidebar"
                        class="filter-sidebar fixed md:static inset-y-0 left-0 w-80 md:w-auto z-50 md:z-auto transform -translate-x-full md:translate-x-0 transition-transform bg-white md:bg-transparent overflow-y-auto md:overflow-visible h-full md:h-auto">
                        {{-- Mobile Close Button --}}
                        <div
                            class="md:hidden flex items-center justify-between p-4 border-b border-gray-200 bg-white sticky top-0 z-10">
                            <h3 class="font-bold text-lg">Filter & Urutkan</h3>
                            <button onclick="toggleMobileFilter()" class="p-2 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        {{-- Filter Content --}}
                        <div class="p-4 md:p-0">
                            @include('listings.partials.filters')
                        </div>
                    </div>
                </aside>

                {{-- Product Grid --}}
                <main class="md:col-span-3">
                    @include('listings.partials.grid', ['listings' => $listings])
                </main>

            </div>
        </div>
    </section>

    {{-- CTA Banner --}}
    @if (
        $listings->isEmpty() &&
            !request()->hasAny(['search', 'category', 'min_price', 'max_price', 'condition', 'location']))
        <section class="py-16 bg-gradient-to-br from-blue-600 to-blue-500">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    Punya Barang Bekas yang Ingin Dijual?
                </h2>
                <p class="text-xl text-blue-50 mb-8">
                    Pasang iklan gratis sekarang dan jangkau ribuan calon pembeli!
                </p>
                <a href="{{ route('listings.index') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-colors shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Jelajahi Iklan
                </a>
            </div>
        </section>
    @endif

@endsection

@push('scripts')
    <script>
        function toggleMobileFilter() {
            const sidebar = document.getElementById('filterSidebar');
            const overlay = document.getElementById('filterOverlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');

            // Prevent body scroll when filter is open
            document.body.classList.toggle('overflow-hidden');
        }

        // Close filter when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('filterSidebar');
            const overlay = document.getElementById('filterOverlay');

            if (event.target === overlay) {
                toggleMobileFilter();
            }
        });
    </script>
@endpush
