@extends('layouts.master')

@section('title', $user->name . ' - Profil Penjual')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-12">
        <div class="max-w-7xl mx-auto px-4">

            {{-- Seller Info Card --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-8">
                <div class="flex items-center gap-6">
                    {{-- Avatar --}}
                    <div class="flex-shrink-0">
                        @if ($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                class="w-24 h-24 rounded-full object-cover border-4 border-blue-100">
                        @else
                            <div
                                class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center border-4 border-blue-100">
                                <span class="text-3xl font-bold text-white">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Seller Details --}}
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">
                            {{ $user->name }}
                        </h1>
                        <p class="text-gray-600 mb-4">
                            Bergabung sejak {{ $user->created_at->locale('id')->isoFormat('MMMM Y') }}
                        </p>

                        {{-- Statistics --}}
                        <div class="flex gap-6">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                                <span class="text-gray-700">
                                    <strong class="text-gray-900">{{ $stats['total_listings'] }}</strong> Iklan Aktif
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                <span class="text-gray-700">
                                    <strong class="text-gray-900">{{ number_format($stats['total_views']) }}</strong> Total
                                    Dilihat
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Listings Header --}}
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    Iklan dari {{ $user->name }}
                </h2>
            </div>

            {{-- Listings Grid --}}
            @if ($listings->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @foreach ($listings as $listing)
                        <a href="{{ route('listings.show', $listing) }}"
                            class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-[1.02]">

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
                            </div>

                            {{-- Content --}}
                            <div class="p-4">
                                <h3
                                    class="font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                    {{ $listing->title }}
                                </h3>

                                <p class="text-2xl font-bold text-blue-600 mb-3">
                                    Rp {{ number_format($listing->price, 0, ',', '.') }}
                                </p>

                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>{{ $listing->city }}</span>
                                    </div>
                                    <span>{{ $listing->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="flex justify-center">
                    {{ $listings->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                    <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                        </path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        Belum Ada Iklan
                    </h3>
                    <p class="text-gray-600">
                        Penjual ini belum memasang iklan aktif
                    </p>
                </div>
            @endif

        </div>
    </div>
@endsection
