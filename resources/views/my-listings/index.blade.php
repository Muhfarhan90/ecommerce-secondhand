@extends('layouts.master')

@section('title', 'Iklan Saya - SecondHand')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Iklan Saya</h1>
                <p class="text-gray-600">Kelola semua iklan yang Anda pasang</p>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-600 text-sm">Total Iklan</span>
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-600 text-sm">Aktif</span>
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ $stats['active'] }}</div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-600 text-sm">Nonaktif</span>
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ $stats['inactive'] }}</div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-600 text-sm">Total Views</span>
                        <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_views']) }}</div>
                </div>
            </div>

            {{-- Filters & Search --}}
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('my-listings.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari iklan Anda..."
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <select name="status"
                            class="w-full md:w-48 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif
                            </option>
                        </select>
                    </div>
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                        Filter
                    </button>
                </form>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Listings Grid --}}
            @if ($listings->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach ($listings as $listing)
                        <div
                            class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-shadow">
                            {{-- Image --}}
                            <div class="relative aspect-[4/3] bg-gray-100">
                                <img src="{{ $listing->images->first()?->image_path ?? asset('images/placeholder.jpg') }}"
                                    alt="{{ $listing->title }}" class="w-full h-full object-cover">

                                {{-- Status Badge --}}
                                <div class="absolute top-3 left-3">
                                    @if ($listing->status === 'active')
                                        <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-500 text-white text-xs font-semibold rounded-full">
                                            Nonaktif
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                    {{ $listing->title }}
                                </h3>
                                <p class="text-2xl font-bold text-blue-600 mb-3">
                                    Rp {{ number_format($listing->price, 0, ',', '.') }}
                                </p>

                                <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        {{ $listing->views_count ?? 0 }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $listing->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                {{-- Actions --}}
                                <div class="flex gap-2">
                                    <a href="{{ route('listings.show', $listing->slug) }}"
                                        class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center text-sm font-medium rounded-lg transition-colors">
                                        Lihat
                                    </a>
                                    <a href="{{ route('my-listings.edit', $listing->slug) }}"
                                        class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-center text-sm font-medium rounded-lg transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('my-listings.toggle-status', $listing->slug) }}"
                                        method="POST" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="w-full px-4 py-2 {{ $listing->status === 'active' ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white text-center text-sm font-medium rounded-lg transition-colors">
                                            {{ $listing->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    {{ $listings->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Iklan</h3>
                    <p class="text-gray-600 mb-6">Anda belum memasang iklan apapun</p>
                    <a href="{{ route('my-listings.create') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Pasang Iklan Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
