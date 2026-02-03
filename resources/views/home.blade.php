@extends('layouts.master')

@section('title', 'Beranda - SecondHand')
@section('meta_description',
    'Pasang iklan jual beli barang bekas gratis. Temukan ribuan iklan produk secondhand dengan
    kontak langsung penjual.')

@section('content')

    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-blue-600 via-blue-500 to-blue-600 text-white py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto fade-in">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    Pasang Iklan Jual Beli<br>
                    <span class="text-blue-100">Barang Bekas Gratis!</span>
                </h1>
                <p class="text-lg md:text-xl text-blue-50 mb-8 max-w-2xl mx-auto">
                    Ribuan iklan barang bekas menunggu Anda. Hubungi penjual langsung, negosiasi harga, dan bertemu secara
                    langsung!
                </p>

                {{-- Search Bar --}}
                <div class="max-w-2xl mx-auto">
                    <form action="{{ route('home') }}" method="GET" class="relative">
                        <div class="flex gap-2">
                            <div class="flex-1 relative">
                                <input type="text" name="search" placeholder="Cari barang yang kamu butuhkan..."
                                    class="w-full px-6 py-4 pr-12 rounded-xl text-white placeholder-gray-100 focus:outline-none focus:ring-4 focus:ring-blue-200 shadow-lg">
                                <svg class="absolute right-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-100"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <button type="submit"
                                class="px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-colors shadow-lg">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Quick Stats --}}
                <div class="mt-12 grid grid-cols-3 gap-4 md:gap-8">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold mb-1">{{ number_format($stats['total_listings']) }}+
                        </div>
                        <div class="text-sm md:text-base text-blue-100">Iklan Aktif</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold mb-1">{{ number_format($stats['total_users']) }}+</div>
                        <div class="text-sm md:text-base text-blue-100">Pengguna</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold mb-1">100%</div>
                        <div class="text-sm md:text-base text-blue-100">Gratis</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Banner Section --}}
    @if ($banners->count() > 0)
        <section class="py-8 md:py-12 bg-gray-50" x-data="bannerCarousel()">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative">
                    {{-- Banner Container --}}
                    <div class="rounded-2xl overflow-hidden shadow-xl">
                        {{-- Banner Items --}}
                        @foreach ($banners as $index => $banner)
                            <div x-show="currentSlide === {{ $index }}"
                                x-transition:enter="transition ease-out duration-500"
                                x-transition:enter-start="opacity-0 transform translate-x-full"
                                x-transition:enter-end="opacity-100 transform translate-x-0"
                                x-transition:leave="transition ease-in duration-500"
                                x-transition:leave-start="opacity-100 transform translate-x-0"
                                x-transition:leave-end="opacity-0 transform -translate-x-full">
                                <a href="{{ route('listings.show', $banner->listing) }}"
                                    class="block h-[300px] md:h-[400px] lg:h-[450px] group">
                                    <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}"
                                        class="w-full h-full object-cover group-hover:opacity-95 transition-opacity duration-300">
                                </a>
                            </div>
                        @endforeach

                        {{-- Dots Indicator --}}
                        @if ($banners->count() > 1)
                            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                                @foreach ($banners as $index => $banner)
                                    <button @click="currentSlide = {{ $index }}"
                                        :class="currentSlide === {{ $index }} ? 'bg-white w-8' : 'bg-white/50 w-3'"
                                        class="h-3 rounded-full transition-all hover:bg-white/70"></button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Navigation Arrows - Outside Banner --}}
                    @if ($banners->count() > 1)
                        <button @click="previousSlide"
                            class="absolute -left-4 md:-left-6 top-1/2 -translate-y-1/2 bg-white hover:bg-blue-600 text-gray-800 hover:text-white p-3 md:p-4 rounded-full shadow-lg transition-all hover:scale-110 z-10">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </button>

                        <button @click="nextSlide"
                            class="absolute -right-4 md:-right-6 top-1/2 -translate-y-1/2 bg-white hover:bg-blue-600 text-gray-800 hover:text-white p-3 md:p-4 rounded-full shadow-lg transition-all hover:scale-110 z-10">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- Categories Section --}}
    <section class="py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                    Jelajahi Kategori
                </h2>
                <p class="text-gray-600 text-lg">
                    Temukan barang yang kamu cari berdasarkan kategori
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('listings.index', ['category' => $category->slug]) }}"
                        class="group bg-white hover:bg-blue-50 rounded-xl p-6 text-center transition-all hover:shadow-lg hover:-translate-y-1 border border-gray-100">
                        <div
                            class="w-14 h-14 mx-auto mb-3 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                            {{ $category->name }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $category->listings_count }} iklan</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured Products --}}
    <section class="py-12 md:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                        Iklan Terbaru
                    </h2>
                    <p class="text-gray-600">
                        Barang bekas berkualitas yang baru saja diiklankan
                    </p>
                </div>
                <a href="#"
                    class="hidden md:flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold group">
                    Lihat Semua
                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($listings as $listing)
                    <a href="{{ route('listings.show', $listing) }}"
                        class="group bg-white rounded-xl overflow-hidden border border-gray-200 hover:border-blue-200 hover:shadow-xl transition-all">
                        <div class="aspect-square bg-gray-100 overflow-hidden relative">
                            <img src="{{ $listing->images->first()?->image_path ?? asset('images/placeholder.jpg') }}"
                                alt="{{ $listing->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                        <div class="p-4">
                            <h3
                                class="font-semibold text-gray-900 mb-1 group-hover:text-blue-600 transition-colors line-clamp-2">
                                {{ $listing->title }}
                            </h3>
                            <div class="flex items-center justify-between mb-3">
                                <div class="text-xl font-bold text-blue-600">
                                    Rp {{ number_format($listing->price, 0, ',', '.') }}
                                </div>
                                <div class="flex items-center gap-1 text-sm text-gray-500">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $listing->city }}
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        Belum ada iklan tersedia
                    </div>
                @endforelse
            </div>

            {{-- Mobile View All --}}
            @if ($listings->count() > 0)
                <div class="mt-8 text-center">
                    <a href="{{ route('listings.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                        Lihat Semua Iklan
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- Why Choose Us --}}
    <section class="py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                    Kenapa Pilih Kami?
                </h2>
                <p class="text-gray-600 text-lg">
                    Platform iklan baris yang mudah dan gratis
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-8 bg-white rounded-2xl border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 mx-auto mb-6 bg-blue-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">100% Gratis</h3>
                    <p class="text-gray-600">
                        Pasang iklan tanpa biaya apapun, jual barang bekas Anda dengan mudah
                    </p>
                </div>

                <div class="text-center p-8 bg-white rounded-2xl border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 mx-auto mb-6 bg-green-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Kontak Langsung</h3>
                    <p class="text-gray-600">
                        Hubungi penjual langsung via chat atau telepon untuk negosiasi
                    </p>
                </div>

                <div class="text-center p-8 bg-white rounded-2xl border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 mx-auto mb-6 bg-purple-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Mudah & Cepat</h3>
                    <p class="text-gray-600">
                        Pasang iklan dalam hitungan menit, jangkau ribuan calon pembeli
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Banner Advertisement Info --}}
    <section class="py-12 md:py-16 bg-gradient-to-br from-blue-50 to-white border-t border-blue-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 border border-blue-100">
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-500 rounded-2xl mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">
                        Ingin Pasang Banner di Homepage?
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Promosikan produk Anda dengan banner menarik di halaman utama kami dan jangkau ribuan pengunjung
                        setiap hari
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="text-center p-4">
                        <div class="text-blue-600 font-bold text-3xl mb-2">1000+</div>
                        <div class="text-gray-600 text-sm">Pengunjung Harian</div>
                    </div>
                    <div class="text-center p-4">
                        <div class="text-blue-600 font-bold text-3xl mb-2">24/7</div>
                        <div class="text-gray-600 text-sm">Tampil Terus Menerus</div>
                    </div>
                    <div class="text-center p-4">
                        <div class="text-blue-600 font-bold text-3xl mb-2">Premium</div>
                        <div class="text-gray-600 text-sm">Posisi Strategis</div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-6 text-center">
                    <p class="text-gray-700 mb-4">
                        <span class="font-semibold">Hubungi Admin untuk Info Lebih Lanjut:</span>
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="mailto:admin@secondhand.com"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-white hover:bg-blue-600 text-gray-800 hover:text-white font-semibold rounded-lg transition-all shadow hover:shadow-lg group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            admin@secondhand.com
                        </a>
                        <a href="https://wa.me/6281234567890"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-all shadow hover:shadow-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                            </svg>
                            WhatsApp Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-16 md:py-20 bg-gradient-to-r from-blue-600 to-blue-500">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Siap Pasang Iklan Gratis?
            </h2>
            <p class="text-xl text-blue-50 mb-8">
                Bergabung dengan ribuan pengguna yang sudah merasakan kemudahan jual beli dengan iklan gratis
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-colors shadow-lg">
                    Daftar Sekarang
                </a>
                <a href="{{ route('home') }}"
                    class="px-8 py-4 bg-blue-700 text-white font-semibold rounded-xl hover:bg-blue-800 transition-colors border-2 border-blue-400">
                    Jelajahi Iklan
                </a>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        function bannerCarousel() {
            return {
                currentSlide: 0,
                totalSlides: {{ $banners->count() }},
                autoplayInterval: null,

                init() {
                    // Start autoplay
                    this.startAutoplay();

                    // Pause on hover
                    this.$el.addEventListener('mouseenter', () => {
                        this.stopAutoplay();
                    });

                    // Resume on mouse leave
                    this.$el.addEventListener('mouseleave', () => {
                        this.startAutoplay();
                    });
                },

                nextSlide() {
                    this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                },

                previousSlide() {
                    this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
                },

                startAutoplay() {
                    this.autoplayInterval = setInterval(() => {
                        this.nextSlide();
                    }, 5000); // Change slide every 5 seconds
                },

                stopAutoplay() {
                    if (this.autoplayInterval) {
                        clearInterval(this.autoplayInterval);
                    }
                }
            }
        }
    </script>
@endpush
