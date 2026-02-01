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
                    <a href="{{ route('listings.index', ['category' => $category->id]) }}"
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
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
