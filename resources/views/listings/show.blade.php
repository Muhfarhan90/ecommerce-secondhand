@extends('layouts.master')

@section('title', $listing->title . ' - SecondHand')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('listings.index') }}" class="text-gray-600 hover:text-blue-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('listings.index', ['category' => $listing->category->slug]) }}"
                                class="ml-1 text-sm text-gray-600 hover:text-blue-600">
                                {{ $listing->category->name ?? 'Kategori' }}
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm text-gray-500 truncate max-w-xs">{{ $listing->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Column - Images & Details --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Image Gallery --}}
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                        {{-- Main Image --}}
                        <div class="relative aspect-[4/3] bg-gray-100">
                            <img id="mainImage"
                                src="{{ $listing->images->first()?->image_path ?? asset('images/placeholder.jpg') }}"
                                alt="{{ $listing->title }}" class="w-full h-full object-contain">

                            {{-- Condition Badge --}}
                            <div class="absolute top-4 left-4">
                                @if ($listing->condition === 'new')
                                    <span
                                        class="px-3 py-1.5 bg-green-500 text-white text-sm font-semibold rounded-full shadow-lg">
                                        Baru
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1.5 bg-blue-500 text-white text-sm font-semibold rounded-full shadow-lg">
                                        Bekas
                                    </span>
                                @endif
                            </div>

                            {{-- Views Counter --}}
                            <div
                                class="absolute top-4 right-4 px-3 py-1.5 bg-black bg-opacity-60 text-white text-sm rounded-full flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ number_format($listing->views_count ?? 0) }}
                            </div>
                        </div>

                        {{-- Thumbnail Gallery --}}
                        @if ($listing->images->count() > 1)
                            <div class="p-4 bg-gray-50 border-t">
                                <div class="grid grid-cols-5 gap-3">
                                    @foreach ($listing->images as $image)
                                        <button onclick="changeMainImage('{{ $image->image_path }}')"
                                            class="aspect-square rounded-lg overflow-hidden border-2 border-transparent hover:border-blue-500 transition-all focus:outline-none focus:border-blue-600">
                                            <img src="{{ $image->image_path }}" alt="Thumbnail"
                                                class="w-full h-full object-cover">
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Product Details --}}
                    <div class="bg-white rounded-2xl shadow-sm p-6 space-y-6">

                        {{-- Title & Price --}}
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-3">
                                {{ $listing->title }}
                            </h1>
                            <div class="flex items-baseline gap-3">
                                <span class="text-4xl font-bold text-blue-600">
                                    Rp {{ number_format($listing->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        {{-- Key Info Grid --}}
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-6 border-y">
                            <div class="text-center">
                                <div class="text-gray-500 text-sm mb-1">Kategori</div>
                                <div class="font-semibold text-gray-900">{{ $listing->category->name ?? '-' }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-500 text-sm mb-1">Kondisi</div>
                                <div class="font-semibold text-gray-900">
                                    {{ $listing->condition === 'new' ? 'Baru' : 'Bekas' }}
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-500 text-sm mb-1">Lokasi</div>
                                <div class="font-semibold text-gray-900">{{ $listing->city }}, {{ $listing->province }}
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-500 text-sm mb-1">Dilihat</div>
                                <div class="font-semibold text-gray-900">{{ number_format($listing->views_count ?? 0) }}x
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-3">Deskripsi</h2>
                            <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                                {{ $listing->description }}
                            </div>
                        </div>

                        {{-- Location Details --}}
                        @if ($listing->address || $listing->city)
                            <div class="pt-6 border-t">
                                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Lokasi Barang
                                </h2>
                                <div class="space-y-2 text-gray-700">
                                    <p class="flex items-start">
                                        <svg class="w-5 h-5 mr-2 mt-0.5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                        {{ $listing->city }}, {{ $listing->province }}
                                    </p>
                                    @if ($listing->address)
                                        <p class="flex items-start text-sm text-gray-600 ml-7">
                                            {{ $listing->address }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Posted Date --}}
                        <div class="pt-6 border-t text-sm text-gray-500">
                            Diposting
                            {{ $listing->published_at?->diffForHumans() ?? $listing->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

                {{-- Right Column - Seller Info & Actions --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-8 space-y-4">

                        {{-- Seller Card --}}
                        <div class="bg-white rounded-2xl shadow-sm p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Penjual</h3>

                            <a href="{{ route('sellers.show', $listing->user) }}"
                                class="block mb-6 hover:bg-gray-50 rounded-xl p-2 -m-2 transition-colors">
                                <div class="flex items-center">
                                    <div
                                        class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-2xl font-bold">
                                        {{ strtoupper(substr($listing->user->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h4
                                            class="font-semibold text-gray-900 text-lg hover:text-blue-600 transition-colors">
                                            {{ $listing->user->name }}
                                        </h4>
                                        <p class="text-sm text-gray-500">Bergabung
                                            {{ $listing->user->created_at->diffForHumans() }}</p>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </a>

                            {{-- Contact Button --}}
                            @auth
                                @if (auth()->id() !== $listing->user_id)
                                    <a href="{{ route('conversations.start', $listing) }}"
                                        class="block w-full px-6 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-center transition-all shadow-md hover:shadow-lg mb-3">
                                        <span class="flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            Hubungi Penjual
                                        </span>
                                    </a>
                                @else
                                    <div class="space-y-2">
                                        <a href="{{ route('my-listings.edit', $listing) }}"
                                            class="block w-full px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl text-center transition-colors">
                                            Edit Iklan
                                        </a>
                                        <form action="{{ route('my-listings.destroy', $listing) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus iklan ini?')"
                                                class="block w-full px-6 py-3 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-xl text-center transition-colors">
                                                Hapus Iklan
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                    class="block w-full px-6 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-center transition-all shadow-md hover:shadow-lg">
                                    Login untuk Hubungi Penjual
                                </a>
                            @endauth
                        </div>

                        {{-- Safety Tips --}}
                        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6">
                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Tips Aman Bertransaksi
                            </h4>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 text-green-600" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Bertemu di tempat umum
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 text-green-600" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Periksa barang sebelum membayar
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 text-green-600" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Jangan transfer sebelum melihat barang
                                </li>
                            </ul>
                        </div>

                        {{-- Share Button --}}
                        <button onclick="shareProduct()"
                            class="w-full px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl text-center transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            Bagikan Iklan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function changeMainImage(url) {
                document.getElementById('mainImage').src = url;
            }

            function shareProduct() {
                if (navigator.share) {
                    navigator.share({
                        title: '{{ $listing->title }}',
                        text: 'Lihat iklan ini: {{ $listing->title }}',
                        url: window.location.href
                    });
                } else {
                    navigator.clipboard.writeText(window.location.href);
                    alert('Link telah disalin ke clipboard!');
                }
            }
        </script>
    @endpush
@endsection
