@extends('layouts.master')

@section('title', 'Profil Saya')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Profile Card --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="text-center">
                        <div
                            class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mb-4">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500 mb-1">{{ $user->email }}</p>
                        @if ($user->phone)
                            <p class="text-sm text-gray-500 mb-4">{{ $user->phone }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mb-6">
                            Bergabung {{ $user->created_at->locale('id')->diffForHumans() }}
                        </p>
                        <a href="{{ route('profile.edit') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Edit Profil
                        </a>
                    </div>
                </div>

                {{-- Stats Card --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Statistik</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Iklan</span>
                            <span class="text-lg font-bold text-gray-900">{{ $stats['total_listings'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Iklan Aktif</span>
                            <span class="text-lg font-bold text-green-600">{{ $stats['active_listings'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Dilihat</span>
                            <span class="text-lg font-bold text-blue-600">{{ number_format($stats['total_views']) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Favorit Diterima</span>
                            <span class="text-lg font-bold text-red-600">{{ $stats['favorites_received'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Listings --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Iklan Terbaru Saya</h3>
                        <a href="{{ route('my-listings.index') }}"
                            class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                            Lihat Semua
                        </a>
                    </div>

                    @forelse ($user->listings as $listing)
                        <div
                            class="flex gap-4 p-4 border border-gray-200 rounded-lg mb-4 hover:border-blue-300 transition-colors">
                            <img src="{{ $listing->images->first() ? asset('storage/' . $listing->images->first()->image_path) : 'https://via.placeholder.com/100' }}"
                                alt="{{ $listing->title }}" class="w-20 h-20 object-cover rounded-lg">
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('listings.show', $listing->slug) }}"
                                    class="font-medium text-gray-900 hover:text-blue-600 line-clamp-1">
                                    {{ $listing->title }}
                                </a>
                                <p class="text-lg font-bold text-blue-600 mt-1">
                                    Rp {{ number_format($listing->price, 0, ',', '.') }}
                                </p>
                                <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        {{ $listing->views_count }}
                                    </span>
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-medium
                                        {{ $listing->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($listing->status) }}
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('my-listings.edit', $listing->slug) }}"
                                class="self-start p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                            <p class="text-gray-500 mb-4">Anda belum memiliki iklan</p>
                            <a href="{{ route('my-listings.create') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Pasang Iklan Gratis
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
